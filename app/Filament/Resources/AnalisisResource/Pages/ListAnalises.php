<?php

namespace App\Filament\Resources\AnalisisResource\Pages;

use App\Filament\Resources\AnalisisResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAnalises extends ListRecords
{
    protected static string $resource = AnalisisResource::class;
    protected static ?string $navigationLabel   = 'Analisis ';
    protected ?string $heading      = 'Analisis';    
    protected ?string $subheading   = 'Data Analisis';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Analisis')
                ->createAnother(false)
                ->modalSubmitActionLabel('SIMPAN')
                ->modalHeading('Tambah Analisis.'),
        ];
    }
}
