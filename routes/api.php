<?php

use App\Http\Controllers\Api\Public\UrlShortenerController;
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

Route::get('/api/documentation', function () {
    return view('swagger-l5::index');
});
Route::group(['prefix' => 'admin/url-shortener'], function () {
    Route::get('/', [UrlShortenerController::class,'index']);
    Route::post('/', [UrlShortenerController::class,'store']);
    Route::get('/{id}', [UrlShortenerController::class,'show']);
    Route::delete('/{id}', [UrlShortenerController::class,'destroy']);
});
