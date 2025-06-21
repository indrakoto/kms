<?php
// app/Filament/Pages/Login.php
namespace App\Filament\Pages;

use Filament\Http\Livewire\Auth\Login as BaseLogin;

class Login extends BaseLogin
{
    protected function getHeaderLogo(): ?string
    {
        // Kembalikan null agar logo tidak tampil di halaman login
        return null;
    }
}
