<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\Blade;
use Filament\Facades\Filament;
//use function Laravel\Vite\vite;
use App\Filament\Pages\CustomDashboard;
use App\Filament\Widgets\TopNavigation;
use Filament\Navigation\MenuItem;
use App\Filament\Pages\Auth\CustomLogin;
use App\Filament\Pages\Auth\CustomRegister;
use Illuminate\Support\Facades\Auth;

class AdministratorPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('administrator')
            ->path('administrator')
            ->login(CustomLogin::class)
            ->passwordReset()
            ->registration(CustomRegister::class) 
            ->emailVerification()
            //->brandName('KMS')
            ->brandLogo(asset('img/KMS-Logo-White.png'))
            //->brandLogoHeight('150px')
            ->favicon(asset('img/logo-esdm.png'))
            ->darkMode(false)
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->globalSearch(false)
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                //Widgets\AccountWidget::class,
                //Widgets\FilamentInfoWidget::class,
                \App\Filament\Widgets\KmsStatsWidget::class,
                //TopNavigation::class,
            ])
            /*->userMenuItems([
                // Item custom akan muncul SEBELUM menu default (Profile, Logout)
                MenuItem::make()
                    ->label('Analisis')
                    ->url('/analisis')
                    ->icon('heroicon-o-chart-bar'),
                    
                MenuItem::make()
                    ->label('Knowledge')
                    ->url('/knowledge')
                    ->icon('heroicon-o-book-open'),
                    
                MenuItem::make()
                    ->label('Forum')
                    ->url('/forum')
                    ->icon('heroicon-o-chat-bubble-left-ellipsis'),
            ])*/
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
                \Hasnayeen\Themes\Http\Middleware\SetTheme::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            //->sidebarCollapsibleOnDesktop()
            ->sidebarWidth('15rem')
            //->darkMode(false)
            ->colors([
                'danger' => Color::Rose,
                'gray' => Color::Gray,
                'info' => Color::Blue,
                'primary' =>  Color::hex('#3c5589'), // Warna custom '#3c5589',
                'success' => Color::Emerald,
                'warning' => Color::Orange,
            ])
            ->renderHook(PanelsRenderHook::SIMPLE_PAGE_START, function () {
                return Blade::render('
                    <img src="{{ $url }}" class="mb-5" style="display: block; margin-left: auto; margin-right: auto; width:20%">
                    ', [
                    'url' => asset('img/logo-esdm.png'),
                ]);
            })
            ->renderHook(PanelsRenderHook::SIMPLE_PAGE_END, function () {
                return Blade::render('
                    <p class="mt-2 text-center text-sm text-gray-500 dark:text-gray-400" >
                    <a href="/" style="fi-link group/link relative inline-flex items-center justify-center outline-none fi-size-md fi-link-size-md gap-1.5 fi-color-custom fi-color-primary fi-ac-action fi-ac-link-action">
                    <span class="font-semibold text-sm text-custom-600 dark:text-custom-400 group-hover/link:underline group-focus-visible/link:underline" style="--c-400:var(--primary-400);--c-600:var(--primary-600);">
                        {{ $text }}
                    </span>  
                    </a>
                    </p>
                    ', [
                    'text' => 'Ke Beranda',
                ]);
            })
            /*->renderHook(PanelsRenderHook::TOPBAR_START, function () {
                return Blade::render('
                    <img src="{{ $url }}" style="height:32px;">
                    ', [
                    'url' => asset('img/logo-esdm.png'),
                ]);
            })*/
            ->renderHook(PanelsRenderHook::USER_MENU_BEFORE, function () {
                return Blade::render(
                    '
                        <div class="flex items-center gap-6">
                            <!-- Menu Analisis -->
                            <a 
                                href="/analisis" 
                                class="text-white hover:text-[#ffc541] transition-colors duration-200 text-sm font-medium"
                                wire:navigate
                            >
                                Analisis
                            </a>
                            <!-- Menu Knowledge -->
                            <a 
                                href="/knowledge" 
                                class="text-white hover:text-[#ffc541] transition-colors duration-200 text-sm font-medium"
                                wire:navigate
                            >
                                Knowledge
                            </a>
                            <!-- Menu Forum -->
                            <a 
                                href="/forum" 
                                class="text-white hover:text-[#ffc541] transition-colors duration-200 text-sm font-medium"
                                wire:navigate
                            >
                                Forum
                            </a>
                        </div>
                    '
                );
            })
            //->plugin(
                //\Hasnayeen\Themes\ThemesPlugin::make()
            //)
            //->viteTheme('resources/css/filament/admin/theme.css')
            ->viteTheme([
                'resources/css/filament/admin/theme.css',
                'resources/css/filament/admin/custom-sidebar.css',
            ])
            ;
    }


//    public function boot(): void
//    {
//        Filament::registerTheme(
//            vite('build/assets/filament-theme.css'),
//        );
//    }
}
