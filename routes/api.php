<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SerieController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\VideoSerieController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/videos', [VideoController::class, 'getAllVideos']);
Route::get('/video/{video}', [VideoController::class, 'getVideo']);

Route::get('/series', [SerieController::class, 'getAllSeries']);
Route::get('/series/{serie}/videos', [VideoSerieController::class, 'getRelationshipVideoSerie']);
