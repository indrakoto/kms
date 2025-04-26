<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class KnowledgeController extends Controller
{

    public function index()
    {
        $knowledges = Article::latest()->take(8)->get(); // Mengambil 8 artikel terbaru
        return view('knowledges.index', compact('knowledges'));
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
        // Menemukan artikel berdasarkan ID
        $knowledge = Article::findOrFail($id);

        // Mengirim artikel ke view
        return view('knowledges.show', compact('knowledge'));
    }
}
