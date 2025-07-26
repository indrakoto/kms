<?php

namespace App\Http\Controllers;

use App\Models\Analisis;
use App\Models\Institusi;
use App\Models\Neraca;
use App\Models\Article;
use Illuminate\Http\Request;
use App\Services\TableauEmbedService;

class AnalisisController extends Controller
{
    // Menampilkan SEMUA neraca (dengan pagination)

    public function index()
    {
        $breadcrumbs = [
            ['title' => 'Beranda', 'url' => route('beranda.index')],
            ['title' => 'Knowledge', 'url' => route('knowledge.list')],
            //['title' => $product->name, 'url' => route('product.show', $product)],
        ];

        $analisis       = Article::where('category_id', '=', 1)->get();
        $analisisList   = Article::where([
                                ['category_id', '=', 1],
                                ['is_published', '=', 1]
                            ])->get();
        $layanan_publik = Article::where([
                                ['category_id', '=', 3],
                                ['is_published', '=', 1]
                            ])->get();
        
        return view('analisis.index', [
            'analisis' => $analisis,
            'analisisList' => $analisisList,
            'layananList' => $layanan_publik,
            'activeAnalisis' => null,
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    public function showAnalisis(Analisis $analisis)
    {
        $neracas = $analisis->neracas()->latest()->paginate(9);
        $analisisList = Analisis::withCount('neracas')->get();
        $layanan_publik = Article::where('category_id', '=', 3)->get();
        
        return view('analisis.analisis-show', [
            'analisis' => $analisis,
            'neracas' => $neracas,
            'analisisList' => $analisisList,
            'activeAnalisis' => $analisis->id,
            'layananList' => $layanan_publik
        ]);
    }

    // Menampilkan detail neraca
    public function showNeraca(Neraca $neraca)
    {
        $analisisList = Analisis::withCount('neracas')->get();
        $layanan_publik = Article::where('category_id', '=', 3)->get();
        
        return view('neraca.show', [
            'neraca' => $neraca,
            'analisisList' => $analisisList,
            'activeAnalisis' => $neraca->analisis_id,
            'layananList' => $layanan_publik
        ]);
    }

    public function showDetail($article_slug, $id)
    {
       
        

        //$analisisList = Analisis::withCount('neracas')->get();
        $analisisList   = Article::where([
                                ['category_id', '=', 1],
                                ['is_published', '=', 1]
                            ])->get();
        $layanan_publik = Article::where([
                                ['category_id', '=', 3],
                                ['is_published', '=', 1]
                            ])->get();
        $analisis = Article::with(['institusi', 'category', 'tags'])
            ->whereIn('category_id',[1,3])
            ->findOrFail($id);
    
            //dd($analisis->embed_code);

        if($analisis->source->name=="TABLEAU")
        {
            $embedConfig = TableauEmbedService::getEmbedConfig($analisis->embed_code);
            $url = $embedConfig['url'];
            $token = $embedConfig['token'];
            //$token = TableauEmbedService::generateToken($analisis->embed_code);
        } else {
            $url = "";
            $token = "";
        }
        
        
        return view('analisis.detail', [
            'analisis' => $analisis,
            'analisisList' => $analisisList,
            'activeAnalisis' => null,
            'layananList' => $layanan_publik,
            'url' => $url,
            'token' => $token,
        ]);
    }


}
