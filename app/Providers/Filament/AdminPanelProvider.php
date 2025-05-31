<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Dashboard;
use App\Filament\Resources\AgendaResource;
use App\Filament\Resources\WaarnemingResource;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Support\Facades\Log;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel

         
            ->id('admin')
            ->path('admin')
            ->login()
            ->authGuard('web') 
            ->brandLogo(asset('images/logo/logo pad en co 1500x600.jpg'))
            ->brandLogoHeight('3rem')
            ->colors([
                'primary' => Color::Emerald,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
            ])
            ->authMiddleware([
                Authenticate::class,
                AuthenticateSession::class,
            ])
                    ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
->bootUsing(function () {
    Log::info('Filament panel is geladen!');
})
            ->pages([
                Dashboard::class,
            ])
            ->resources([
                AgendaResource::class,
                WaarnemingResource::class,
            ])
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
            ]);
    }
}
