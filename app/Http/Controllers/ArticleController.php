<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    // Method untuk menampilkan 8 artikel pertama
    public function index()
    {
        $articles = Article::latest()->take(8)->get(); // Mengambil 8 artikel terbaru
        return view('articles.index', compact('articles'));
    }

    // Method untuk menangani AJAX request dan mengembalikan 8 artikel berikutnya
    public function loadMoreArticles(Request $request)
    {
        if ($request->ajax()) {
            $offset = $request->input('offset'); // Mendapatkan offset dari request
            $articles = Article::latest()->skip($offset)->take(8)->get(); // Ambil 8 artikel setelah offset

            return response()->json([
                'articles' => $articles, // Mengembalikan artikel dalam format JSON
            ]);
        }
    }
    
    // Method untuk menampilkan artikel berdasarkan ID
    public function show($id)
    {
        // Menemukan artikel berdasarkan ID
        $article = Article::findOrFail($id);

        // Mengirim artikel ke view
        return view('article.show', compact('article'));
    }
}
