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

        $knowledges = $articlesQuery->paginate(6); // <--- paginate 8 artikel per halaman
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
        // Cari artikel dengan relasi category, source, dan institusi
        $article = Article::with(['category', 'source', 'institusi'])
                    ->findOrFail($id);
    
        // Ambil semua institusi untuk menu sidebar
        $institusi = Institusi::all();
        
        // Ambil 10 artikel terkait (kecuali artikel saat ini)
        $relatedArticles = Article::where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->with('category') // Eager loading untuk optimasi
            ->latest()
            ->take(10)
            ->get();
            
        return view('knowledges.show', [
            'article' => $article,
            'relatedArticles' => $relatedArticles,
            'institusi' => $institusi,
            'currentInstitusi' => $article->institusi_id // Untuk highlight menu aktif
        ]);
    }
}
