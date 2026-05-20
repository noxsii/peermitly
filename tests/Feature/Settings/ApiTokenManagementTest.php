<?php

declare(strict_types=1);

use App\Models\User;
use App\Support\TokenAbility;
use Laravel\Sanctum\PersonalAccessToken;

test('settings page exposes token abilities catalogue', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get('/settings')
        ->assertOk();
});

test('store creates personal access token with selected abilities', function (): void {
    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->postJson('/settings/api-tokens', [
            'name' => 'OfficeEfficient prod',
            'abilities' => [TokenAbility::LICENSE_KEYS_CHECK],
        ]);

    $response->assertCreated()
        ->assertJsonPath('name', 'OfficeEfficient prod')
        ->assertJsonStructure(['id', 'name', 'abilities', 'plain_text_token']);

    expect(PersonalAccessToken::query()->where('tokenable_id', $user->id)->count())->toBe(1);
});

test('store rejects unknown ability', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->postJson('/settings/api-tokens', [
            'name' => 'bad',
            'abilities' => ['foo:bar'],
        ])->assertStatus(422)
        ->assertJsonValidationErrors('abilities.0');
});

test('destroy removes token owned by user', function (): void {
    $user = User::factory()->create();
    $token = $user->createToken('test', [TokenAbility::LICENSE_KEYS_CHECK])->accessToken;

    $this->actingAs($user)
        ->delete('/settings/api-tokens/'.$token->id)
        ->assertRedirect();

    expect(PersonalAccessToken::query()->find($token->id))->toBeNull();
});

test('destroy returns 404 for foreign token', function (): void {
    $user = User::factory()->create();
    $other = User::factory()->create();
    $token = $other->createToken('test', [TokenAbility::LICENSE_KEYS_CHECK])->accessToken;

    $this->actingAs($user)
        ->delete('/settings/api-tokens/'.$token->id)
        ->assertNotFound();

    expect(PersonalAccessToken::query()->find($token->id))->not->toBeNull();
});
