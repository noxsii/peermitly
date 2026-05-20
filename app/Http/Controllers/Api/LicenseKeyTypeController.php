<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Enums\LicenseKeyGeneratorType;
use App\Http\Requests\LicenseKeys\StoreLicenseKeyTypeRequest;
use App\Http\Requests\LicenseKeys\UpdateLicenseKeyTypeRequest;
use App\Http\Resources\LicenseKeys\LicenseKeyTypeResource;
use App\Models\LicenseKeyType;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

final class LicenseKeyTypeController
{
    public function index(): AnonymousResourceCollection
    {
        $teamId = (int) auth()->user()?->current_team_id;

        return LicenseKeyTypeResource::collection(
            LicenseKeyType::query()
                ->where('team_id', $teamId)
                ->withCount('licenseKeys')
                ->orderBy('name')
                ->paginate(25)
                ->withQueryString(),
        );
    }

    public function show(LicenseKeyType $licenseKeyType): JsonResource
    {
        abort_unless($licenseKeyType->team_id === (int) auth()->user()?->current_team_id, 404);

        return LicenseKeyTypeResource::make($licenseKeyType);
    }

    public function store(StoreLicenseKeyTypeRequest $request): JsonResource
    {
        $teamId = (int) auth()->user()?->current_team_id;

        $type = LicenseKeyType::query()->create([
            'team_id' => $teamId,
            'name' => $request->string('name'),
            'description' => $request->filled('description') ? $request->string('description') : null,
            'generator_type' => LicenseKeyGeneratorType::from($request->string('generator_type')->toString())->value,
            'configuration' => $request->array('configuration'),
            'is_active' => $request->boolean('is_active'),
        ]);

        return LicenseKeyTypeResource::make($type);
    }

    public function update(UpdateLicenseKeyTypeRequest $request, LicenseKeyType $licenseKeyType): JsonResource
    {
        abort_unless($licenseKeyType->team_id === (int) auth()->user()?->current_team_id, 404);

        $licenseKeyType->forceFill([
            'name' => $request->string('name'),
            'description' => $request->filled('description') ? $request->string('description') : null,
            'generator_type' => LicenseKeyGeneratorType::from($request->string('generator_type')->toString())->value,
            'configuration' => $request->array('configuration'),
            'is_active' => $request->boolean('is_active'),
        ])->save();

        return LicenseKeyTypeResource::make($licenseKeyType->fresh());
    }

    public function destroy(LicenseKeyType $licenseKeyType): JsonResource
    {
        abort_unless($licenseKeyType->team_id === (int) auth()->user()?->current_team_id, 404);

        $licenseKeyType->delete();

        return LicenseKeyTypeResource::make($licenseKeyType);
    }
}
