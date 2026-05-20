<?php

declare(strict_types=1);

namespace App\Http\Controllers\LicenseKeys;

use App\Models\LicenseKey;
use Symfony\Component\HttpFoundation\StreamedResponse;

final class LicenseKeyExportController
{
    public function export(): StreamedResponse
    {
        $teamId = (int) auth()->user()?->current_team_id;
        $filename = 'license-keys-'.now()->format('Y-m-d-His').'.csv';

        return response()->streamDownload(static function () use ($teamId): void {
            $handle = fopen('php://output', 'w');

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
            ]);

            LicenseKey::query()
                ->where('team_id', $teamId)
                ->with(['product', 'customer'])
                ->chunkById(500, static function ($keys) use ($handle): void {
                    foreach ($keys as $key) {
                        fputcsv($handle, [
                            $key->key,
                            $key->product?->slug,
                            $key->customer?->email,
                            $key->status->value,
                            $key->validity_amount,
                            $key->validity_unit->value,
                            $key->requires_hwid_check ? 'yes' : 'no',
                            $key->max_activations,
                            $key->activated_at?->toIso8601String(),
                            $key->expires_at?->toIso8601String(),
                            $key->created_at?->toIso8601String(),
                        ]);
                    }
                });

            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv']);
    }
}
