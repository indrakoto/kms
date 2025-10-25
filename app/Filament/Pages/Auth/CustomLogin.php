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

    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getEmailFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getCaptchaFormComponent(),
                        $this->getRememberFormComponent(),
                    ])
                    ->statePath('data'),
            ),
        ];
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

    protected function getCaptchaFormComponent(): Component
    {
        return Captcha::make('captcha')
                ->rules(['captcha'])
                ->required()
                ->validationMessages([
                    'captcha'  =>  __('Captcha does not match the image'),
                ])
                ->extraInputAttributes(['tabindex' =>4])
                ->view('vendor.filament-captcha.form.components.captcha');
    }
}
