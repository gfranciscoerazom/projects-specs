<?php

use App\Providers\AppServiceProvider;
use App\Providers\Filament\AdminPanelProvider;
use App\Providers\Filament\BasePanelProvider;
use App\Providers\Filament\FilamentUiServiceProvider;

return [
    AppServiceProvider::class,
    AdminPanelProvider::class,
    BasePanelProvider::class,
    FilamentUiServiceProvider::class,
];
