<?php
namespace App\Filament\Pages;

use Filament\Pages\Page;

class TopNavigation extends Page
{
    protected static string $view = 'filament.pages.top-navigation';
    
    protected static ?string $navigationLabel = null;
    
    protected static bool $shouldRegisterNavigation = false;
}