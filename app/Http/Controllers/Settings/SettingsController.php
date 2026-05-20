<?php

declare(strict_types=1);

namespace App\Http\Controllers\Settings;

use App\Http\Resources\ApiTokenResource;
use App\Models\User;
use App\Support\TokenAbility;
use Inertia\Inertia;
use Inertia\Response;
use Laravel\Sanctum\PersonalAccessToken;

final class SettingsController
{
    public function edit(): Response
    {
        $userId = (int) auth()->id();

        return Inertia::render('Settings', [
            'tokens' => Inertia::defer(static fn () => ApiTokenResource::collection(
                PersonalAccessToken::query()
                    ->where('tokenable_type', User::class)
                    ->where('tokenable_id', $userId)
                    ->latest()
                    ->get(),
            )),
            'tokenAbilities' => array_map(
                static fn (string $ability) => ['value' => $ability, 'label' => $ability],
                TokenAbility::all(),
            ),
        ]);
    }
}
