<?php

namespace App\Filament\Resources\BasisdataAlphabyteResource\Pages;

use App\Filament\Resources\BasisdataAlphabyteResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateBasisdataAlphabyte extends CreateRecord
{
    protected static string $resource = BasisdataAlphabyteResource::class;
    protected ?string $heading      = 'Basis Data Alphabyte';
    protected ?string $subheading   = 'Tambah Data';

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('kembali')
                ->label('Kembali ke List')
                ->url($this->getResource()::getUrl())
        ];
    }

    // 1. Redirect ke list artikel setelah simpan (Pilihan 1)
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index'); 
    }

    // 2. Notifikasi sukses setelah simpan
    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Konten disimpan')
            ->body('Perubahan berhasil diperbarui.');
    }

    protected function getFormActions(): array
    {
        return [
            $this->getSubmitFormAction()->label('SIMPAN'),
            $this->getCancelFormAction()->label('BATAL'),
        ];
    }
}
