<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Institusi;
use Illuminate\Http\Request;

class KnowledgeController extends Controller
{

    public function index(Request $request)
    {
        $institusi_id = $request->query('institusi');

        $articlesQuery = Article::latest();
    
        if ($institusi_id) {
            $articlesQuery->where('institusi_id', $institusi_id);
        }

        $knowledges = $articlesQuery->paginate(8); // <--- paginate 8 artikel per halaman
        //$knowledges = Article::latest()->take(8)->get(); // Mengambil 8 artikel terbaru
        $institusi = Institusi::all();

        return view('knowledges.index', compact('knowledges','institusi'));
    }

    // Method untuk menangani AJAX request dan mengembalikan 8 artikel berikutnya
    public function loadMoreArticles(Request $request)
    {
        if ($request->ajax()) {
            $offset = $request->input('offset'); // Mendapatkan offset dari request
            $knowledges = Article::latest()->skip($offset)->take(8)->get(); // Ambil 8 artikel setelah offset

            return response()->json([
                'knowledges' => $knowledges, // Mengembalikan artikel dalam format JSON
            ]);
        }
    }

    // Method untuk menampilkan artikel berdasarkan ID
    public function show($id)
    {
        // Cari artikel berdasarkan ID
        $article = Article::findOrFail($id);

        // Ambil semua institusi buat daftar menu
        $institusi = Institusi::all();
        
        // Ambil 10 artikel terakhir dengan kategori yang sama (kecuali artikel saat ini)
        $relatedArticles = Article::where('category_id', $article->category_id)
            ->where('id', '!=', $article->id) // Exclude current article
            ->latest() // Urutkan dari yang terbaru
            ->take(10) // Ambil 10 artikel
            ->get();
            
        return view('knowledges.show', compact('article',  'relatedArticles', 'institusi'));
    }
}
