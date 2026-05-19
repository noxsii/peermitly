<?php

declare(strict_types=1);

use Inertia\Testing\AssertableInertia;

test('login route responds with 200', function (): void {
    $this->get('/login')->assertOk();
});

test('login route renders auth/Login inertia component', function (): void {
    $this->get('/login')
        ->assertInertia(fn (AssertableInertia $page): AssertableInertia => $page->component('auth/Login'));
});

test('login route is named login', function (): void {
    expect(route('login', absolute: false))->toBe('/login');
});

test('login post requires email and password', function (): void {
    $this->from('/login')
        ->post('/login', [])
        ->assertRedirect('/login')
        ->assertSessionHasErrors(['email', 'password']);
});

test('login post rejects invalid email format', function (): void {
    $this->from('/login')
        ->post('/login', ['email' => 'not-an-email', 'password' => 'secret'])
        ->assertSessionHasErrors('email');
});

test('login post returns not-implemented error when validation passes', function (): void {
    $this->from('/login')
        ->post('/login', ['email' => 'test@example.com', 'password' => 'secret'])
        ->assertRedirect('/login')
        ->assertSessionHasErrors('email');
});
