<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\LicenseKeys\CheckLicenseKeyAction;
use App\Data\LicenseKeys\LicenseKeyCheckRequest as CheckRequestData;
use App\Http\Requests\Api\CheckLicenseKeyRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

final class LicenseKeyCheckController
{
    public function check(CheckLicenseKeyRequest $request, CheckLicenseKeyAction $check): JsonResponse
    {
        $user = $request->user();
        $teamId = (int) $user?->current_team_id;

        $product = Product::query()
            ->where('team_id', $teamId)
            ->where('slug', $request->string('product')->toString())
            ->first();

        if ($product === null) {
            return new JsonResponse([
                'valid' => false,
                'status' => 'invalid',
                'message' => 'License key is invalid.',
            ], 200);
        }

        $data = CheckRequestData::fromHttpRequest(
            rawKey: $request->string('key')->toString(),
            product: $product,
            hwid: $request->filled('hwid') ? $request->string('hwid')->toString() : null,
            teamId: $teamId,
            request: $request,
        );

        $result = $check->handle($data);

        $status = match (true) {
            $result->status->value === 'hwid_required' => 422,
            $result->valid => 200,
            $result->status->value === 'expired' => 200,
            $result->status->value === 'revoked', $result->status->value === 'blocked' => 200,
            default => 200,
        };

        return new JsonResponse($result->toArray(), $status);
    }
}
