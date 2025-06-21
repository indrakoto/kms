<?php

namespace App\Filament\Pages\Auth;

//use Filament\Pages\Auth\Register;
use Filament\Pages\Auth\Register as BaseRegister;
use Illuminate\Contracts\Support\Htmlable;

class CustomRegister extends BaseRegister
{

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

}