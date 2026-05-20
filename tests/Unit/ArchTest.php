<?php

declare(strict_types=1);

use App\Data\LicenseKeys\LicenseKeyConfiguration;

arch()->preset()->php();
arch()->preset()->strict()->ignoring(LicenseKeyConfiguration::class);
arch()->preset()->security();

arch('controllers')
    ->expect('App\Http\Controllers')
    ->not->toBeUsed();

//
