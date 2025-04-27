<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Article;
use App\Models\Analisis;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\KnowledgeController;
use App\Http\Controllers\AnalisisController;

Route::get('/', function () {
    //return view('beranda');
    return redirect('/home');
});

Route::get('/beranda', function () {
    return view('beranda');
    //return redirect('/home');
});

Route::get('/home', function () {
    // Mengambil 5 analisis terbaru
    $latestAnalisis = Analisis::latest()->take(5)->get();

    // Mengambil 3 artikel terbaru
    $latestArticles = Article::latest()->take(4)->get();

    // Mengirim data ke view home
    return view('home', compact('latestAnalisis', 'latestArticles'));    
    //return view('home');
});

// Route untuk halaman utama artikel
Route::get('/article', [ArticleController::class, 'index'])->name('articles.index');

// Route untuk halaman artikel
Route::get('/article/{id}', [ArticleController::class, 'show'])->name('articles.show');

// Route untuk memuat lebih banyak artikel via AJAX
Route::get('/article/load-more', [ArticleController::class, 'loadMoreArticles'])->name('articles.loadMore');


Route::get('/store', function () {
    return view('store');
});

//Route::get('/analisis', function () {
//    return view('analisis');
//});
// Route untuk halaman utama analisis
Route::get('/analisis', [AnalisisController::class, 'index'])->name('analisis.index');
// Route untuk halaman artikel
Route::get('/analisis/{id}', [AnalisisController::class, 'show'])->name('analisis.show');

//Route::get('/knowledge', function () {
//    return view('knowledge');
    //return redirect('/article');
//});

// Route untuk halaman utama knowledge
Route::get('/knowledge', [KnowledgeController::class, 'index'])->name('knowledges.index');
// Route untuk halaman artikel
Route::get('/knowledge/{id}', [KnowledgeController::class, 'show'])->name('knowledges.show');

// Route untuk memuat lebih banyak knowledge via AJAX
Route::get('/knowledge/load-more', [KnowledgeController::class, 'loadMoreArticles'])->name('knowledges.loadMore');




Route::get('/chatbot', function () {
    return view('chatbot');
});

// Menambahkan Route untuk Proxy API
Route::post('/proxy-chatbot', function (Request $request) {
    // Validasi input dari frontend
    $validated = $request->validate([
        'model' => 'required|string',
        'prompt' => 'required|string',
        'stream' => 'required|boolean',
    ]);

    // Kirim request ke API Ollama
    $response = Http::post('http://localhost:11434/api/generate', $validated);

    // Kembalikan response API Ollama ke frontend
    return response()->json($response->json(), $response->status());
});