<?php

namespace App\Filament\Resources\ArticleResource\Pages;

use App\Filament\Resources\ArticleResource;
use Filament\Actions;
use Filament\Infolists\Components\ViewEntry;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Infolist;

class ViewArticle extends ViewRecord
{
    protected static string $resource = ArticleResource::class;
    protected ?string $heading      = 'Artikel Knowledge';
    protected ?string $subheading   = 'View Knowledge';
    
    
    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                
                Section::make('')->schema([
                    Infolists\Components\TextEntry::make('title')->label(''),
                    ViewEntry::make('description')->view('filament.resources.article.pages.show_embed')
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
