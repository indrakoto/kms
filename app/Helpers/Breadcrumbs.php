<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Route;
use App\Models\{Article, Institusi, Category, Tag, Analisis, Neraca};

class Breadcrumbs {
    public static function generate() {
        $route = Route::current();
        $routeName = $route->getName();
        $params = $route->parameters();
        $breadcrumbs = ['Beranda' => route('beranda.index')]; // Sesuaikan route home Anda

        switch ($routeName) {
            // --- Knowledge Routes ---
            case 'knowledge.index':
                $breadcrumbs['Knowledge'] = '#';
                break;

            case 'knowledge.search':
                $breadcrumbs['Knowledge'] = route('knowledge.index');
                $breadcrumbs['Search'] = '#';
                break;

            case 'knowledge.institusi':
                $institusi = Institusi::where('slug', $params['institusi_slug'])->first();
                $breadcrumbs['Knowledge'] = route('knowledge.index');
                $breadcrumbs[$institusi->name ?? 'Institusi'] = '#';
                break;

            case 'knowledge.category':
                $category = Category::where('slug', $params['category_slug'])->first();
                $breadcrumbs['Knowledge'] = route('knowledge.index');
                $breadcrumbs['Kategori'] = '#';
                $breadcrumbs[$category->name ?? 'Category'] = '#';
                break;

            case 'knowledge.show':
                $article = Article::find($params['id']);
                $breadcrumbs['Knowledge'] = route('knowledge.index');
                $breadcrumbs[$article->title ?? 'Article'] = '#';
                break;

            case 'knowledge.tag':
                $breadcrumbs['Knowledge'] = route('knowledge.index');
                $breadcrumbs['Tag'] = '#';
                $breadcrumbs[ucwords($params['tag_name'])] = '#';
                break;

            // --- Analisis Routes ---
            case 'analisis.index':
                $breadcrumbs['Analisis'] = '#';
                break;

            case 'analisis.show':
                $breadcrumbs['Analisis'] = route('analisis.index');
                $breadcrumbs[$params['analisis']->judul ?? 'Detail'] = '#';
                break;

            case 'neraca.show':
                $breadcrumbs['Analisis'] = route('analisis.index');
                $breadcrumbs['Neraca'] = '#';
                $breadcrumbs[$params['neraca']->judul ?? 'Detail'] = '#';
                break;

            // --- Special Routes ---
            case 'geo-portal':
                $breadcrumbs['Geo Portal'] = '#';
                break;

            case 'ai':
                $breadcrumbs['AI Tools'] = '#';
                break;
        }

        return $breadcrumbs;
    }
}