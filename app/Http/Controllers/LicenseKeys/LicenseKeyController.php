<?php

declare(strict_types=1);

namespace App\Http\Controllers\LicenseKeys;

use Inertia\Inertia;
use Inertia\Response;

final class LicenseKeyController
{
    public function index(): Response
    {
        return Inertia::render('license-keys/Index');
    }
}
