<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

final class LoginController
{
    public function index(): Response
    {
        return Inertia::render('auth/Login');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        // TODO: LoginAction (Auth) — Auth::attempt + Session-Handling. Eigene Spec.
        return back()->withErrors(['email' => 'Sign in is not implemented yet.']);
    }
}
