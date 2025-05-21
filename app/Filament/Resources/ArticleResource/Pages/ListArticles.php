<?php

namespace App\Filament\Resources\ArticleResource\Pages;

use App\Filament\Resources\ArticleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListArticles extends ListRecords
{
    protected static string $resource = ArticleResource::class;
    protected ?string $heading      = 'Konten';    
    protected ?string $subheading   = 'Analisis, Knowledge, Layanan Publil, Artikel, Video, link Website, dll';

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
