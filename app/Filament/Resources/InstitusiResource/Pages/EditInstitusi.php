<?php

namespace App\Filament\Resources\InstitusiResource\Pages;

use App\Filament\Resources\InstitusiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInstitusi extends EditRecord
{
    protected static string $resource = InstitusiResource::class;

    protected ?string $heading      = 'Institusi';

    protected ?string $subheading   = 'Edit Institusi';

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
