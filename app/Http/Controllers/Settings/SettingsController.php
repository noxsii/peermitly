<?php

declare(strict_types=1);

namespace App\Http\Controllers\Settings;

use Inertia\Inertia;
use Inertia\Response;

final class SettingsController
{
    public function edit(): Response
    {
        return Inertia::render('Settings');
    }
}
