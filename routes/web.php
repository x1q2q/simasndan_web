<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SantriController;
use App\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('dashboard');
});
Route::get('/login',[LoginController::class,'index'])->name('login');
Route::post('/login',[LoginController::class,'authenticate'])->name('loginAuth');
Route::post('/logout',[LoginController::class,'logout'])->name('logout');

Route::middleware(['is-auth'])->group(function () {
    Route::get('/dashboard',[HomeController::class, 'dashboard'])->name('dashboard');
    Route::get('/data-santri',[SantriController::class, 'index'])->name('santri');
    Route::post('/data-santri/lists',[SantriController::class, 'lists'])->name('santri.lists');
    Route::delete('/data-santri/delete/{id}',[SantriController::class, 'delete'])->name('santri.delete');
    Route::get('/data-santri/detail/{id}',[SantriController::class, 'detail'])->name('santri.detail');
    Route::post('/data-santri/insert',[SantriController::class, 'insert'])->name('santri.insert');
    Route::post('/data-santri/update',[SantriController::class, 'update'])->name('santri.update');
});
