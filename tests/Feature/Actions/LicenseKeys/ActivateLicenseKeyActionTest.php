<?php

declare(strict_types=1);

use App\Actions\LicenseKeys\ActivateLicenseKeyAction;
use App\Models\LicenseKey;
use Illuminate\Support\Facades\DB;

test('activate sets status to active and computes expires_at', function (): void {
    $key = LicenseKey::factory()->create([
        'status' => 'pending',
        'validity_amount' => 12,
        'validity_unit' => 'months',
    ]);

    $activated = (new ActivateLicenseKeyAction())->handle($key);

    expect($activated->status->value)->toBe('active');
    expect($activated->activated_at)->not->toBeNull();
    expect($activated->expires_at->format('Y-m-d H:i:s'))->toBe(now()->addMonths(12)->format('Y-m-d H:i:s'));
});

test('lifetime key sets expires_at to null on activate', function (): void {
    $key = LicenseKey::factory()->lifetime()->create([
        'status' => 'pending',
        'activated_at' => null,
        'expires_at' => null,
    ]);

    $activated = (new ActivateLicenseKeyAction())->handle($key);

    expect($activated->status->value)->toBe('active');
    expect($activated->expires_at)->toBeNull();
});

test('second activate call does not change activated_at', function (): void {
    $key = LicenseKey::factory()->create([
        'status' => 'pending',
        'validity_amount' => 12,
        'validity_unit' => 'months',
    ]);

    $action = new ActivateLicenseKeyAction();
    $first = $action->handle($key);
    $originalActivated = $first->activated_at;

    $second = $action->handle($key->fresh());

    expect($second->activated_at->equalTo($originalActivated))->toBeTrue();
});

test('activate with hwid creates activation row', function (): void {
    $key = LicenseKey::factory()->create([
        'status' => 'pending',
        'validity_amount' => 12,
        'validity_unit' => 'months',
        'requires_hwid_check' => true,
    ]);

    (new ActivateLicenseKeyAction())->handle($key, 'machine-abc-123');

    expect(DB::table('license_key_activations')
        ->where('license_key_id', $key->id)
        ->where('machine_id', 'machine-abc-123')
        ->exists())->toBeTrue();
});
