<?php

namespace App\Providers\Filament;

use Filament\Auth\Pages\EditProfile;
use Filament\Panel;
use Filament\PanelProvider;

abstract class BasePanelProvider extends PanelProvider
{
    public function basePanel(Panel $panel): Panel
    {
        return $panel
            // ->viteTheme('resources/css/filament/admin/theme.css')
            ->passwordReset()
            ->emailVerification()
            ->emailChangeVerification()
            ->unsavedChangesAlerts(app()->isProduction())
            ->databaseTransactions()
            ->sidebarCollapsibleOnDesktop()
            ->brandName('Projects Specs')
            // ->brandLogo('/images/logo.png')
            // ->brandLogoHeight('2.4rem')
            // ->favicon('/images/favicon.ico')
            // ->strictAuthorization()
            // ->font('')
            ->profile(EditProfile::class, isSimple: false);
    }
}
