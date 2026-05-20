<?php

declare(strict_types=1);

namespace App\Http\Controllers\Settings;

use App\Actions\Auth\LogoutAction;
use App\Actions\Auth\UpdatePasswordAction;
use App\Http\Requests\Auth\UpdatePasswordRequest;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

final class PasswordController
{
    public function edit(): Response
    {
        return Inertia::render('settings/Password');
    }

    public function update(
        UpdatePasswordRequest $request,
        UpdatePasswordAction $update,
        LogoutAction $logout,
    ): RedirectResponse {
        $update->handle(
            $request->user(),
            $request->string('password')->toString(),
        );

        $logout->handle($request);

        return redirect()->route('login')->with('status', 'password-updated');
    }
}
