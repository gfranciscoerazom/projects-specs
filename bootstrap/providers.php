<?php

use App\Providers\AppServiceProvider;
use App\Providers\Filament\AdminPanelProvider;
use App\Providers\FilamentUiServiceProvider;

return [
    AppServiceProvider::class,
    FilamentUiServiceProvider::class,
    AdminPanelProvider::class,
    App\Providers\Filament\FilamentUiServiceProvider::class,
];
