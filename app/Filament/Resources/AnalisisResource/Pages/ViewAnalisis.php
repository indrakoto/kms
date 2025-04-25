<?php

namespace App\Filament\Resources\AnalisisResource\Pages;

use App\Filament\Resources\AnalisisResource;
use Filament\Actions;
use Filament\Infolists\Components\ViewEntry;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Infolist;

class ViewAnalisis extends ViewRecord
{
    protected static string $resource = AnalisisResource::class;
    protected ?string $heading      = 'Analisis';
    protected ?string $subheading   = 'View Analisis';
    
    
    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\TextEntry::make('name'),
                Infolists\Components\TextEntry::make('institusi.name'),
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
