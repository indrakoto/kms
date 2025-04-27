<?php

namespace App\Filament\Resources\NeracaResource\Pages;

use App\Filament\Resources\NeracaResource;
use Filament\Actions;
use Filament\Infolists\Components\ViewEntry;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists;
use Filament\Infolists\Components\Group;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Infolist;

class ViewNeraca extends ViewRecord
{
    protected static string $resource = NeracaResource::class;
    protected ?string $heading      = 'Neraca Analisis';
    //protected ?string $subheading   = 'View Neraca Analisis';
    
    
    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make([
                    Infolists\Components\TextEntry::make('analisis.name'),
                    Infolists\Components\TextEntry::make('institusi.name'),
                    Infolists\Components\TextEntry::make('name')->label('Nama Neraca Analisis'),
                ])->columns(3),

                
                
                
                Section::make('Description')->schema([
                    ViewEntry::make('description')->view('filament.resources.analisis.pages.show_embed')
                ]),
                
                //Infolists\Components\TextEntry::make('description')
                  //  ->columnSpanFull(),
            ]);
    }

   protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('kembali')
                ->label('Kembali ke List')
                ->url($this->getResource()::getUrl()),
            Actions\EditAction::make(),
            
        ];
    }
}
