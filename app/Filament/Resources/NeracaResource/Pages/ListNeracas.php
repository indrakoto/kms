<?php

namespace App\Filament\Resources\NeracaResource\Pages;

use App\Filament\Resources\NeracaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNeracas extends ListRecords
{
    protected static string $resource = NeracaResource::class;
    protected static ?string $navigationLabel   = 'Neraca Analisis ';
    protected ?string $heading      = 'Neraca Analisis';    
    protected ?string $subheading   = 'Data Neraca';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Neraca Analisis')
                ->createAnother(false)
                ->modalSubmitActionLabel('SIMPAN')
                ->modalHeading('Tambah Neraca Analisis'),
        ];
    }
}
