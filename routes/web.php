<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Article;
use App\Models\Analisis;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\KnowledgeController;
use App\Http\Controllers\AnalisisController;
//use App\Http\Controllers\NeracaController;

Route::get('/', function () {
    //return view('beranda');
    return redirect('/beranda');
});

Route::get('/login', function () {
    return redirect('/administrator');
});

Route::get('/beranda', function () {
    // Mengambil 5 analisis terbaru
    $latestAnalisis = Analisis::latest()->take(5)->get();

    // Mengambil 3 artikel terbaru
    $latestArticles = Article::latest()->take(4)->get();  

    return view('index', compact('latestAnalisis', 'latestArticles'));
});

Route::prefix('analisis')->group(function () {
    Route::get('/', [AnalisisController::class, 'index'])->name('analisis.index');
    Route::get('/{analisis:slug}', [AnalisisController::class, 'show'])->name('analisis.show');
    Route::get('/read/{neraca:slug}', [AnalisisController::class, 'showNeraca'])->name('neraca.show');
});

/*
Route::prefix('knowledge')->group(function () {
    Route::get('/{institution:slug}', [KnowledgeController::class, 'institution'])
        ->name('institution');
    
    Route::get('/kategori/{category:slug}', [KnowledgeController::class, 'category'])
        ->name('category');
    
    Route::get('/tags/{tag:name}', [KnowledgeController::class, 'tag'])
        ->name('tag');
});
*/

Route::prefix('knowledge')->group(function() {
    // Display all articles
    Route::get('/', [KnowledgeController::class, 'index'])
        ->name('knowledge.index');
    
    // Display articles by Institusi
    Route::get('/{institusi_slug}', [KnowledgeController::class, 'byInstitusi'])
        ->name('knowledge.institusi');
    
    // Display articles by Category
    Route::get('/kategori/{category_slug}', [KnowledgeController::class, 'byCategory'])
        ->name('knowledge.category');
    
    // Display a single article
    Route::get('/read/{article_slug}/{id}', [KnowledgeController::class, 'showArticle'])
        ->name('knowledge.show');
    
    // Display articles by Tag
    Route::get('/tags/{tag_name}', [KnowledgeController::class, 'byTag'])
        ->name('knowledge.tag');
});

/*
// Route untuk halaman utama knowledge
Route::get('/knowledge', [KnowledgeController::class, 'index'])->name('knowledges.index');
// Route untuk halaman artikel
Route::get('/knowledge/{id}', [KnowledgeController::class, 'show'])->name('knowledges.show');
*/

Route::get('/geoportal', function () {
    return view('geo-portal');
});

Route::get('/geo-portal', function () {
    return view('geo-portal');
});


Route::get('/ai', function () {
    return redirect('/aplhabyte');
});
Route::get('/aplhabyte', function () {
    return view('ai');
});

Route::get('/chat', function () {
    return view('chat');
});

// Menambahkan Route untuk Proxy API
Route::post('/ai-api', function (Request $request) {
    // Validasi input dari frontend
    /*$validated = $request->validate([
        'model' => 'required|string',
        'prompt' => 'required|string',
        'stream' => 'required|boolean',
    ]);*/

    $validated = $request->validate([
        'message' => 'required|string',
    ]);

    // Kirim request ke API Ollama
    //$response = Http::post('http://localhost:11434/api/generate', $validated);
    //$response = Http::timeout(60)->post('http://localhost:11434/api/generate', $validated);
    $response = Http::timeout(60)->post('http://127.0.0.1:5000/chat', $validated);


    // Kembalikan response API Ollama ke frontend
    return response()->json($response->json(), $response->status());
});

// Menambahkan Route untuk API General
Route::post('/chat-api', function (Request $request) {
    // Validasi input dari frontend
    $validated = $request->validate([
        'model' => 'required|string',
        'prompt' => 'required|string',
        'stream' => 'required|boolean',
    ]);

    // Kirim request ke API Ollama (General)
    //$response = Http::post('http://localhost:11434/api/generate', $validated);
    $response = Http::timeout(60)->post('http://localhost:11434/api/generate', $validated);


    // Kembalikan response API Ollama ke frontend
    return response()->json($response->json(), $response->status());
});

