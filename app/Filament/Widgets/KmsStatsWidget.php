<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Article;
use App\Models\Thread;

class KmsStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make("Analisis Stats", $this->getCategoryAnalisis())
                ->icon('heroicon-o-document-text')
                ->description("Kategori Analisis")
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('warning')
                ->url(route('analisis.index')),
            Stat::make("Knowledge Stats", $this->getCategoryKnowledge())
                ->icon('heroicon-o-document-text')
                ->description("Kategori Knowledge")
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success')
                ->url(route('knowledge.index')),
            Stat::make('Total Thread Forum', Thread::count())
                ->icon('heroicon-o-chat-bubble-left-right')
                ->description('Diskusi forum yang aktif')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('primary')
                ->url(route('forum.index')),
        ];
    }

    protected function getCategoryAnalisis()
    {
        return Article::where('category_id', 1)->count();
    }

    protected function getCategoryKnowledge()
    {
        return Article::where('category_id', 2)->count();
    }
}
