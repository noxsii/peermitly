<?php

declare(strict_types=1);

namespace App\Http\Controllers\LicenseKeys;

use App\Enums\LicenseKeyStatus;
use App\Models\LicenseKey;
use App\Models\Product;
use Illuminate\Http\Request;
use RuntimeException;
use Symfony\Component\HttpFoundation\StreamedResponse;

final class LicenseKeyExportController
{
    public function export(Request $request): StreamedResponse
    {
        $teamId = (int) auth()->user()?->current_team_id;
        $filename = 'license-keys-'.now()->format('Y-m-d-His').'.csv';

        $status = LicenseKeyStatus::tryFrom($request->string('status')->toString());

        $productId = null;
        $productUuid = $request->string('product_uuid')->toString();
        if ($productUuid !== '') {
            $product = Product::query()->where('team_id', $teamId)->where('uuid', $productUuid)->first();
            $productId = $product?->id ?? -1;
        }

        $delimiterInput = $request->string('delimiter')->toString();
        $delimiter = match ($delimiterInput) {
            ';' => ';',
            "\t", 'tab' => "\t",
            default => ',',
        };

        return response()->streamDownload(static function () use ($teamId, $status, $productId, $delimiter): void {
            $handle = fopen('php://output', 'w');
            throw_if($handle === false, RuntimeException::class, 'Unable to open php://output for CSV export.');

            fputcsv($handle, [
                'key',
                'product',
                'customer',
                'status',
                'validity_amount',
                'validity_unit',
                'requires_hwid_check',
                'max_activations',
                'activated_at',
                'expires_at',
                'created_at',
            ], separator: $delimiter, escape: '\\');

            LicenseKey::query()
                ->where('team_id', $teamId)
                ->when($status !== null, fn ($q) => $q->where('status', $status->value))
                ->when($productId !== null, fn ($q) => $q->where('product_id', $productId))
                ->with(['product', 'customer'])
                ->chunkById(500, static function ($keys) use ($handle, $delimiter): void {
                    foreach ($keys as $key) {
                        fputcsv($handle, [
                            $key->key,
                            $key->product->slug,
                            $key->customer?->email,
                            $key->status->value,
                            $key->validity_amount,
                            $key->validity_unit->value,
                            $key->requires_hwid_check ? 'yes' : 'no',
                            $key->max_activations,
                            $key->activated_at?->toIso8601String(),
                            $key->expires_at?->toIso8601String(),
                            $key->created_at?->toIso8601String(),
                        ], separator: $delimiter, escape: '\\');
                    }
                });

            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv']);
    }
}
