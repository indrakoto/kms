<?php

namespace App\Filament\Widgets;

use App\Models\Article;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ArticleStatsWidget_X extends BaseWidget
{
    protected static ?string $maxHeight = '300px';
    protected int | string | array $columnSpan = 'full';
    
    public int $categoryId = 2;
    public string $categoryName = 'Knowledge';

    protected function getStats(): array
    {
        return [
            Stat::make("Artikel {$this->categoryName}", $this->getCategoryArticleCount())
                ->icon('heroicon-o-document-text')
                ->description("Kategori {$this->categoryName} (ID: {$this->categoryId})")
                ->color('success')
                ->url(route('knowledge.index', [
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
