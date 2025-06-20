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
use App\Http\Livewire\KnowledgeSearch;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;

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
})->name('beranda.index');

Route::prefix('analisis')->group(function () {
    Route::get('/', [AnalisisController::class, 'index'])->name('analisis.index');
    Route::get('/{analisis:slug}', [AnalisisController::class, 'showAnalisis'])->name('analisis.show');
    Route::get('/read/{neraca:slug}', [AnalisisController::class, 'showNeraca'])->name('neraca.show');
    Route::get('/detail/{article_slug}/{id}', [AnalisisController::class, 'showDetail'])
        ->name('detail.show');
});

    // Route Livewire
Route::get('/knowledge/search-live', function () {
    return view('knowledges.knowledge-search-live');
})->name('knowledge.search-live');


Route::prefix('knowledge')->group(function() {
    // Display all knowledge
    Route::get('/', [KnowledgeController::class, 'index'])
        ->name('knowledge.index');

    Route::get('/search', [KnowledgeController::class, 'search'])
        ->name('knowledge.search');
    
    // Tampilkan halaman search (GET)
    Route::get('/search', [KnowledgeController::class, 'showSearchPage'])
        ->name('knowledge.search');
    
    // Proses pencarian (POST)
    Route::post('/search', [KnowledgeController::class, 'handleSearch'])
        ->name('knowledge.search.post');

    // Display knowledge by Institusi
    Route::get('/{institusi_slug}', [KnowledgeController::class, 'byInstitusi'])
        ->name('knowledge.institusi');
    
    // Display knowledge by Category
    Route::get('/kategori/{category_slug}', [KnowledgeController::class, 'byCategory'])
        ->name('knowledge.category');
    
    // Display a single knowledge
    Route::get('/read/{article_slug}/{id}', [KnowledgeController::class, 'showArticle'])
        ->name('knowledge.show');
    
    // Display knowledge by Tag
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
    //$response = Http::timeout(60)->post('http://127.0.0.1:5000/chat', $validated);
    $response = Http::timeout(60)->post('http://93.127.135.59:5000/chat', $validated);


    // Kembalikan response API Ollama ke frontend
    return response()->json($response->json(), $response->status());
});

// Menambahkan Route untuk API General
Route::post('/chat-api', function (Request $request) {
    // Validasi input dari frontend
    $validated = $request->validate([
        'message' => 'required|string',
    ]);
    // Tambahkan data tetap
    $payload = array_merge($validated, [
        'model' => 'gemma:2b',
        'prompt' => $validated['message'],
        'stream' => false,
    ]);

    //print_r($payload); die();
    // Kirim request ke API Ollama (General)
    //$response = Http::post('http://localhost:11434/api/generate', $payload);
    $response = Http::timeout(60)->post('http://localhost:11434/api/generate', $payload);


    // Kembalikan response API Ollama ke frontend
    return response()->json($response->json(), $response->status());
});

Route::prefix('forum')->group(function() {
    // List threads
    Route::get('/', [ForumController::class, 'index'])->name('forum.index');
    
    // Show single thread
    Route::get('/{thread}', [ForumController::class, 'show'])->name('forum.threads.show');
    
    // Store reply
    Route::post('/{thread}/replies', [ForumController::class, 'storeReply'])
         ->name('forum.threads.replies.store')
         ->middleware('auth');

       // Tambah artikel/thread (form tambah artikel)
    Route::get('/tambah', [ForumController::class, 'tambah'])
        ->name('forum.tambah')
        ->middleware('auth'); // biasanya form tambah hanya untuk yang sudah login
});



Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.post');
Route::post('logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/registrasi', [RegisterController::class, 'showRegistrationForm'])->name('register.form');
Route::post('/registrasi', [RegisterController::class, 'register'])->name('register.submit');