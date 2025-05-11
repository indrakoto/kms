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

// Route untuk halaman utama knowledge
Route::get('/knowledge', [KnowledgeController::class, 'index'])->name('knowledges.index');
// Route untuk halaman artikel
Route::get('/knowledge/{id}', [KnowledgeController::class, 'show'])->name('knowledges.show');

// Route untuk memuat lebih banyak knowledge via AJAX
Route::get('/knowledge/load-more', [KnowledgeController::class, 'loadMoreArticles'])->name('knowledges.loadMore');


Route::get('/chatbot', function () {
    return view('ai');
});

// Menambahkan Route untuk Proxy API
Route::post('/proxy-chatbot', function (Request $request) {
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
Route::post('/general-chatbot', function (Request $request) {
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


/* Route Article tidak digunakan */
// Route untuk halaman utama artikel
Route::get('/article', [ArticleController::class, 'index'])->name('articles.index');

// Route untuk halaman artikel
Route::get('/article/{id}', [ArticleController::class, 'show'])->name('articles.show');

// Route untuk memuat lebih banyak artikel via AJAX
Route::get('/article/load-more', [ArticleController::class, 'loadMoreArticles'])->name('articles.loadMore');


Route::get('/geoportal', function () {
    return view('geo-portal');
});
