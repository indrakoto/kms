<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        
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
