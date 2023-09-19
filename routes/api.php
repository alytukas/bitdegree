<?php

use App\Http\Controllers\CoinmarketcapController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('/crypto')->group(function() {
    Route::get('/list', [CoinmarketcapController::class, 'getList'])->name('api.crypto.list');
    Route::post('/store', [CoinmarketcapController::class, 'storeCoinMarketCapData'])->name('api.crypto.store');
});