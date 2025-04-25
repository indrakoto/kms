<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

/*
Route::post('/proxy-chatbot', function (Request $request) {
    $validated = $request->validate([
        'model' => 'required|string',
        'prompt' => 'required|string',
        'stream' => 'required|boolean',
    ]);

    // Kirim ke API Ollama
    $response = Http::post('http://localhost:11434/api/generate', $validated);

    // Kembalikan respon JSON dari Ollama ke frontend
    return response()->json($response->json(), $response->status());
});
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

