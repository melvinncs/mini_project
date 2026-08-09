<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\DramaAPIController;

Route::get('/dramas', [DramaAPIController::class, 'fetchDramas']);
Route::get('/dramas/{id}', [DramaAPIController::class, 'getDramaDetail']);

Route::get('/test', function () {
    return response()->json([
        'message' => 'API is working!',
        'version' => '1.0.0'
    ]);
});