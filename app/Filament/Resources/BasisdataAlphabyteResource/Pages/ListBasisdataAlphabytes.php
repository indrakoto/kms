<?php

namespace App\Filament\Resources\BasisdataAlphabyteResource\Pages;

use App\Filament\Resources\BasisdataAlphabyteResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBasisdataAlphabytes extends ListRecords
{
    protected static string $resource = BasisdataAlphabyteResource::class;

    protected ?string $heading      = 'Basis Data Alphabyte';
    protected ?string $subheading   = 'Sumber data latih Alphabyte';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Data')
                ->createAnother(false)
                ->modalSubmitActionLabel('Simpan')
                ->modalHeading('Konten'),
        ];
    }
}
