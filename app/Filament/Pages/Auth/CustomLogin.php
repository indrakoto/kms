<?php

namespace App\Filament\Pages\Auth;

use Filament\Pages\Auth\Login as BaseLogin;;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use Illuminate\Validation\ValidationException;
use Filament\Forms\Form;
use Illuminate\Auth\EloquentUserProvider;
use DominionSolutions\FilamentCaptcha\Forms\Components\Captcha;

class CustomLogin extends BaseLogin
{
    protected static string $view = 'filament.pages.auth.login';

    public function getTitle(): string|Htmlable
    {
        return __('Panel Admin');
        //return 'false';
    }
    
    public function hasLogo(): bool
    {
        return false;
    }

    public function getHeading(): string | Htmlable
    {
        return false;
    }


    protected function throwFailureValidationException(): never
    {
        throw ValidationException::withMessages([
            'data.login' => __('filament-panels::pages/auth/login.messages.failed'),
        ]);
    }

}
