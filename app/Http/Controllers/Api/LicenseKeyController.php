<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\LicenseKeys\CreateLicenseKeyAction;
use App\Actions\LicenseKeys\ExtendLicenseKeyAction;
use App\Actions\LicenseKeys\RestoreLicenseKeyAction;
use App\Actions\LicenseKeys\RevokeLicenseKeyAction;
use App\Enums\LicenseValidityUnit;
use App\Http\Requests\LicenseKeys\ExtendLicenseKeyRequest;
use App\Http\Requests\LicenseKeys\RevokeLicenseKeyRequest;
use App\Http\Requests\LicenseKeys\StoreLicenseKeyRequest;
use App\Http\Resources\LicenseKeys\LicenseKeyResource;
use App\Models\Customer;
use App\Models\LicenseKey;
use App\Models\LicenseKeyType;
use App\Models\Product;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

final class LicenseKeyController
{
    public function index(): AnonymousResourceCollection
    {
        $teamId = (int) auth()->user()?->current_team_id;

        return LicenseKeyResource::collection(
            LicenseKey::query()
                ->where('team_id', $teamId)
                ->with(['type', 'product', 'customer'])
                ->latest()
                ->paginate(25)
                ->withQueryString(),
        );
    }

    public function show(LicenseKey $licenseKey): JsonResource
    {
        abort_unless($licenseKey->team_id === (int) auth()->user()?->current_team_id, 404);

        return LicenseKeyResource::make($licenseKey->load(['type', 'product', 'customer', 'activations']));
    }

    public function store(StoreLicenseKeyRequest $request, CreateLicenseKeyAction $create): JsonResource
    {
        $teamId = (int) auth()->user()?->current_team_id;

        $type = LicenseKeyType::query()->where('team_id', $teamId)->where('uuid', $request->string('license_key_type_uuid'))->firstOrFail();
        $product = Product::query()->where('team_id', $teamId)->where('uuid', $request->string('product_uuid'))->firstOrFail();
        $customer = $request->filled('customer_uuid')
            ? Customer::query()->where('team_id', $teamId)->where('uuid', $request->string('customer_uuid'))->first()
            : null;

        $licenseKey = $create->handle(
            $type,
            $product,
            $customer,
            $request->integer('validity_amount'),
            LicenseValidityUnit::from($request->string('validity_unit')->toString()),
            $request->filled('max_activations') ? $request->integer('max_activations') : null,
            $request->boolean('requires_hwid_check'),
            $request->array('metadata') ?: null,
            $request->user(),
        );

        return LicenseKeyResource::make($licenseKey->load(['type', 'product', 'customer']));
    }

    public function destroy(LicenseKey $licenseKey): JsonResource
    {
        abort_unless($licenseKey->team_id === (int) auth()->user()?->current_team_id, 404);

        $licenseKey->delete();

        return LicenseKeyResource::make($licenseKey);
    }

    public function revoke(RevokeLicenseKeyRequest $request, LicenseKey $licenseKey, RevokeLicenseKeyAction $revoke): JsonResource
    {
        abort_unless($licenseKey->team_id === (int) auth()->user()?->current_team_id, 404);

        $revoke->handle($licenseKey, $request->string('reason')->toString());

        return LicenseKeyResource::make($licenseKey->fresh());
    }

    public function restore(LicenseKey $licenseKey, RestoreLicenseKeyAction $restore): JsonResource
    {
        abort_unless($licenseKey->team_id === (int) auth()->user()?->current_team_id, 404);

        $restore->handle($licenseKey);

        return LicenseKeyResource::make($licenseKey->fresh());
    }

    public function extend(ExtendLicenseKeyRequest $request, LicenseKey $licenseKey, ExtendLicenseKeyAction $extend): JsonResource
    {
        abort_unless($licenseKey->team_id === (int) auth()->user()?->current_team_id, 404);

        $extend->handle(
            $licenseKey,
            $request->integer('amount'),
            LicenseValidityUnit::from($request->string('unit')->toString()),
        );

        return LicenseKeyResource::make($licenseKey->fresh());
    }
}
