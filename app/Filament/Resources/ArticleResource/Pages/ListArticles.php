<?php

namespace App\Filament\Resources\ArticleResource\Pages;

use App\Filament\Resources\ArticleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListArticles extends ListRecords
{
    protected static string $resource = ArticleResource::class;
    protected ?string $heading      = 'Konten Knowledge';    
    protected ?string $subheading   = 'Pengetahuan, Artikel, Video, Dll';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Data')
                ->createAnother(false)
                ->modalSubmitActionLabel('Simpan')
                ->modalHeading('Knowledge.'),
        ];
    }
}
