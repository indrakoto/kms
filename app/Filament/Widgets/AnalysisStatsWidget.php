<?php

namespace App\Filament\Widgets;

use App\Models\Article;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AnalysisStatsWidget_X extends BaseWidget
{
    protected static ?string $maxHeight = '300px';
    protected int | string | array $columnSpan = 'full';
    
    public int $categoryId = 1;
    public string $categoryName = 'Analisis';

    protected function getStats(): array
    {
        return [
            Stat::make("Artikel {$this->categoryName}", $this->getCategoryArticleCount())
                ->icon('heroicon-o-document-text')
                ->description("Kategori {$this->categoryName} (ID: {$this->categoryId})")
                ->color('success')
                ->url(route('analisis.index', [
                    'tableFilters' => [
                        'category_id' => [
                            'value' => $this->categoryId
                        ]
                    ]
                ])),
        ];
    }

    protected function getCategoryArticleCount(): int
    {
        return Article::where('category_id', $this->categoryId)->count();
    }
}
