<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UpdateDataAlphabyteController;

Route::prefix('alphabyte')->group(function () {
    Route::post('/process/{id}', [UpdateDataAlphabyteController::class, 'processPdf'])
         ->name('alphabyte.process');
    
    Route::post('/update-status/{id}', [UpdateDataAlphabyteController::class, 'updateStatus'])
         ->name('alphabyte.update-status');
});