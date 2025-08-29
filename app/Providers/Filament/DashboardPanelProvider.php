<?php

namespace App\Providers\Filament;

use App\Filament\Widgets\CashFlowStatsWidget;
use App\Filament\Widgets\IncomeChartWidget;
use App\Filament\Widgets\IncomeTableWidget;
use App\Filament\Widgets\OutcomeChartWidget;
use App\Models\UserAllowed;
use DutchCodingCompany\FilamentSocialite\FilamentSocialitePlugin;
use DutchCodingCompany\FilamentSocialite\Provider;
use Laravel\Socialite\Contracts\User as SocialiteUserContract;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class DashboardPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('dashboard')
            ->path('dashboard')
            ->login()
            ->colors([
                'primary' => Color::Fuchsia,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
//                CashFlowStatsWidget::class,
//                IncomeChartWidget::class,
//                OutcomeChartWidget::class,
//                IncomeTableWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->navigationGroups([
                'Cash Flows',
                'Settings'
            ])
            ->plugins([
                FilamentSocialitePlugin::make()
                ->registration(false)
                ->domainAllowList(['localhost'])
                ->resolveUserUsing(function (string $provider, SocialiteUserContract $oauthUser, FilamentSocialitePlugin $plugin) {
                    $email = $oauthUser->getEmail();

                    $user = UserAllowed::where('email', $email)->first();

                    if (!$user) {
                        return null;
                    } else {
                        return $user;
                    }
                })
                ->providers([
                   Provider::make('google')
                    ->label('Google')
                    ->icon('fab-google')
                    ->with([
                        'hd' => 'student.unsika.ac.id'
                    ])
                ]),
            ]);
    }
}
