<?php

declare(strict_types=1);

use Inertia\Testing\AssertableInertia;

test('login route responds with 200', function (): void {
    $this->get('/login')->assertOk();
});

test('login route renders Auth/Login inertia component', function (): void {
    $this->get('/login')
        ->assertInertia(fn (AssertableInertia $page): AssertableInertia => $page->component('Auth/Login'));
});

test('login route is named login', function (): void {
    expect(route('login', absolute: false))->toBe('/login');
});
