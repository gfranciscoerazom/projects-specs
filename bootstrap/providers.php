<?php

use App\Providers\AppServiceProvider;
use App\Providers\Filament\AdminPanelProvider;
use App\Providers\Filament\FilamentUiServiceProvider;

return [
    AppServiceProvider::class,
    AdminPanelProvider::class,
    FilamentUiServiceProvider::class,
];
