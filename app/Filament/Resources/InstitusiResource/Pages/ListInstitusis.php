<?php

namespace App\Filament\Resources\InstitusiResource\Pages;

use App\Filament\Resources\InstitusiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInstitusis extends ListRecords
{
    protected static string $resource = InstitusiResource::class;
    protected static ?string $navigationLabel   = 'Institusi ';
    protected ?string $heading      = 'Institusi';    
    protected ?string $subheading   = 'Daftar Institusi';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Institusi')
                ->createAnother(false)
                ->modalSubmitActionLabel('SIMPAN')
                ->modalHeading('Tambah Institusi.'),
        ];
    }
}
