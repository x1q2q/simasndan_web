<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\api\ApiSantriController;
use App\Http\Controllers\api\ApiMateriController;
use App\Http\Controllers\api\ApiBeritaController;
use App\Http\Controllers\api\ApiRekapController;
use App\Http\Controllers\api\AuthController;

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
Route::fallback(function(){
    return response()->json([
        'message' => 'Page Not Found. Mohon maaf :)'], 404);
});

Route::group(['middleware' => 'cors'], function(){
    Route::post('santri/login',[AuthController::class,'login']);
    Route::apiResource('santri', ApiSantriController::class);
    Route::apiResource('materi', ApiMateriController::class);
    Route::apiResource('berita', ApiBeritaController::class);
    Route::get('berita/filter/{any}',[ApiBeritaController::class, 'filter']);
    Route::get('berita/headlines/{any}',[ApiBeritaController::class, 'getHeadlines']);
    Route::get('semester/{id}',[ApiRekapController::class, 'semester']);
    Route::get('penilaian/{santriId}/{semtId}',[ApiRekapController::class, 'penilaian']);
    Route::get('santri/checkuuid/{any}',[ApiSantriController::class, 'checkUUID']);
    Route::post('santri/updateuuid/{idSantri}',[ApiSantriController::class, 'updateUUID']);
    Route::get('santri/getnotif/{any}',[ApiSantriController::class, 'getNotifikasi']);
});

