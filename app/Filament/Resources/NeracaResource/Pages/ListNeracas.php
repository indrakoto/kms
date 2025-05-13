<?php

namespace App\Filament\Resources\NeracaResource\Pages;

use App\Filament\Resources\NeracaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNeracas extends ListRecords
{
    protected static string $resource = NeracaResource::class;
    protected static ?string $navigationLabel   = 'Data Analisis ';
    protected ?string $heading      = 'Data Analisis';    

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Data')
                ->createAnother(false)
                ->modalSubmitActionLabel('SIMPAN')
                ->modalHeading('Tambah Data'),
        ];
    }
}
