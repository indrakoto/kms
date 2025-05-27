<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\CreateAction;
use Filament\Actions;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;
    protected ?string $heading      = 'Data User'; 

    public function getTitle(): string
    {
        return trans('filament-users::user.resource.title.list');
    }

    protected function getActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah User')
                ->createAnother(false)
                ->modalSubmitActionLabel('Simpan')
                ->modalHeading('Tambah User'),
        ];
    }

}
