<?php

namespace App\Http\Controllers;

use App\Models\Analisis;
use App\Models\Institusi;
use App\Models\Neraca;

use Illuminate\Http\Request;

class AnalisisController extends Controller
{
    public function index(Request $request)
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

    public function show($id)
    {
        // Cari artikel berdasarkan ID
        $neraca = Neraca::findOrFail($id);

        // Ambil semua institusi buat daftar menu
        $analisis = Analisis::all();

        return view('analisis.show', compact('neraca', 'analisis'));
    }
}
