<?php

namespace App\Filament\Widgets;

use App\Models\Thread;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ThreadStatsWidget_X extends BaseWidget
{
    protected static ?string $maxHeight = '300px';
    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        return [
            Stat::make('Total Thread pada Forum', Thread::count())
                ->icon('heroicon-o-chat-bubble-left-right')
                ->description('Diskusi forum yang aktif')
                ->color('primary')
                ->url(route('forum.index')),
        ];
    }
}
