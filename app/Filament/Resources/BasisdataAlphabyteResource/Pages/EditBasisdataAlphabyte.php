<?php

namespace App\Filament\Resources\BasisdataAlphabyteResource\Pages;

use App\Filament\Resources\BasisdataAlphabyteResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditBasisdataAlphabyte extends EditRecord
{
    protected static string $resource = BasisdataAlphabyteResource::class;

    protected ?string $heading      = 'Basis Data Alphabyte';
    protected ?string $subheading   = 'Edit Data';
    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('kembali')
                ->label('Kembali ke List')
                ->url($this->getResource()::getUrl()),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index'); 
    }

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
