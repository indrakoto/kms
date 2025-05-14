<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Institusi;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;

class KnowledgeController extends Controller
{

        // Menampilkan semua artikel dengan pagination
    public function index()
    {
        // Ambil 10 artikel terbaru
        $knowledges = Article::with(['institusi', 'category', 'tags'])
            ->latest() // Mengurutkan berdasarkan tanggal terbaru
            ->paginate(9); // Mengambil 10 artikel per halaman
        
        $institusis = Institusi::all();

        return view('knowledges.index', compact('knowledges','institusis'));
    }

    // Show articles by Institusi
    public function byInstitusi($institusi_slug)
    {
        $institusi = Institusi::where('slug', $institusi_slug)->firstOrFail();
        $institusis = Institusi::all();
        $knowledges = $institusi->articles()->with(['category', 'tags'])->paginate(10);
        
        return view('knowledges.institusi', compact('knowledges', 'institusi', 'institusis'));
    }

    // Show articles by Category
    public function byCategory($category_slug)
    {
        $category = Category::where('slug', $category_slug)->firstOrFail();
        $knowledges = $category->articles()->with(['institusi', 'tags'])->paginate(10);
        $institusis = Institusi::all();

        return view('knowledges.category', compact('knowledges', 'category', 'institusis'));
    }

    // Show articles by Tag
    public function byTag($tag_name)
    {
        $tag = Tag::where('name', $tag_name)->firstOrFail();
        $knowledges = $tag->articles()->with(['institusi', 'category'])->paginate(10);
        $institusis = Institusi::all();

        return view('knowledges.tag', compact('knowledges', 'tag', 'institusis'));
    }

    // Menampilkan satu artikel berdasarkan slug
    public function showArticle($article_slug, $id)
    {
        $article = Article::with(['institusi', 'category', 'tags'])->findOrFail($id);
        $institusis = Institusi::all();

        //return view('knowledges.show', compact('article', 'institusis'));

        
        // Ambil 10 artikel terkait (kecuali artikel saat ini)
        $relatedArticles = Article::with(['institusi', 'category', 'tags'])
            ->where('category_id', $article->category_id) // Cari artikel dengan kategori yang sama
            ->where('id', '!=', $id) // Mengecualikan artikel yang sedang dilihat
            ->latest() // Mengurutkan berdasarkan tanggal terbaru
            ->take(6) // Ambil 10 artikel terkait
            ->get();
            
        return view('knowledges.show', [
            'article' => $article,
            'relatedArticles' => $relatedArticles,
            'institusi' => $institusis,
            'currentInstitusi' => $article->institusi_id // Untuk highlight menu aktif
        ]);

    }



    public function indexxx(Request $request)
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
