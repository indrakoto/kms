<?php

namespace App\Filament\Resources\SourceResource\Pages;

use App\Filament\Resources\SourceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSources extends ListRecords
{
    protected static string $resource = SourceResource::class;
    protected static ?string $navigationLabel   = 'Master Tipe Konten ';
    protected ?string $heading      = 'Master Tipe Konten';    
    protected ?string $subheading   = 'Data Jenis-Jenis Konten';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah')
                ->createAnother(false)
                ->modalSubmitActionLabel('SIMPAN')
                ->modalHeading('Tambah Jenis File'),
        ];
    }
}
