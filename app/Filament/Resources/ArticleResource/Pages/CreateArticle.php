<?php

namespace App\Filament\Resources\ArticleResource\Pages;

use App\Filament\Resources\ArticleResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateArticle extends CreateRecord
{
    protected static string $resource = ArticleResource::class;
    protected ?string $heading      = 'Knowledge';
    protected ?string $subheading   = 'Tambah Data';
    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('kembali')
                ->label('Kembali ke List')
                ->url($this->getResource()::getUrl()) // Mengarahkan ke halaman List resource
                //->color('secondary'), // Opsional: memberi warna pada tombol
        ];
    }

    protected function getFormActions(): array
    {
        return [
            $this->getSubmitFormAction()->label('SIMPAN'),
            $this->getCancelFormAction()->label('BATAL'),
        ];
    }
}
