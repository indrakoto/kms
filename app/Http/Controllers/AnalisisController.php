<?php

namespace App\Http\Controllers;

use App\Models\Analisis;
use App\Models\Institusi;
use App\Models\Neraca;
use App\Models\Article;

use Illuminate\Http\Request;

class AnalisisController extends Controller
{
    // Menampilkan SEMUA neraca (dengan pagination)

    public function index()
    {
        $neracas = Neraca::with('analisis')->latest()->paginate(9);
        $analisisList = Analisis::withCount('neracas')->get();
        $layanan_publik = Article::where('category_id', '=', 3)->get();
        
        return view('analisis.index', [
            'neracas' => $neracas,
            'analisisList' => $analisisList,
            'activeAnalisis' => null,
            'layananList' => $layanan_publik
        ]);
    }



    public function indexxx()
    {
        $neracas = Neraca::latest()->paginate(6);
        $analisisList = Analisis::all();
        $activeAnalisis = null; // Tidak ada analisis aktif di halaman awal
        
        return view('analisis.index', compact('neracas', 'analisisList', 'activeAnalisis'));
    }

    public function indexx(Request $request)
    {
        $analisis_id = $request->query('id');

        $neracaQuery = Neraca::latest();
    
        if ($analisis_id) {
            $neracaQuery->where('analisis_id', $analisis_id);
        }

        $neracas = $neracaQuery->paginate(8); // <--- paginate 8 artikel per halaman
        $analisis = Analisis::all();

        return view('analisis.index', compact('analisis','neracas'));
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

    // Menampilkan neraca berdasarkan analisis
    public function showAnalisisX(Analisis $analisis)
    {
        $neracas = $analisis->neracas()->latest()->paginate(6);
        $analisisList = Analisis::all();
        
        return view('analisis.show', [
            'analisis' => $analisis,
            'neracas' => $neracas,
            'analisisList' => $analisisList,
            'activeAnalisis' => $analisis->id
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
}
