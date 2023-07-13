<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SantriController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\BeritaController;
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
Route::get('/restricted/{slug}',[HomeController::class,'restricted']);
Route::middleware(['is-auth'])->group(function () {
    Route::get('/dashboard',[HomeController::class, 'dashboard'])->name('dashboard');
    Route::get('/data-santri',[SantriController::class, 'index'])->name('santri');
    Route::post('/data-santri/lists',[SantriController::class, 'lists'])->name('santri.lists');
    Route::get('/data-santri/detail/{id}',[SantriController::class, 'detail'])->name('santri.detail');
    Route::post('/data-santri/insert',[SantriController::class, 'insert'])->name('santri.insert');
    Route::post('/data-santri/update',[SantriController::class, 'update'])->name('santri.update');


    Route::get('/data-admin',[AdminController::class, 'index'])->name('admin');
    Route::post('/data-admin/lists',[AdminController::class, 'lists'])->name('admin.lists');
    Route::get('/data-admin/detail/{id}',[AdminController::class, 'detail'])->name('admin.detail');
    Route::post('/data-admin/insert',[AdminController::class, 'insert'])->name('admin.insert');
    Route::post('/data-admin/update',[AdminController::class, 'update'])->name('admin.update');
    Route::delete('/data-admin/delete/{id}',[AdminController::class, 'delete'])->name('admin.delete');


    Route::get('/data-guru',[GuruController::class, 'index'])->name('guru');
    Route::post('/data-guru/lists',[GuruController::class, 'lists'])->name('guru.lists');
    Route::get('/data-guru/detail/{id}',[GuruController::class, 'detail'])->name('guru.detail');
    Route::post('/data-guru/insert',[GuruController::class, 'insert'])->name('guru.insert');
    Route::post('/data-guru/update',[GuruController::class, 'update'])->name('guru.update');
    Route::delete('/data-guru/delete/{id}',[GuruController::class, 'delete'])->name('guru.delete');

    Route::get('/data-materi',[MateriController::class, 'index'])->name('materi');
    Route::post('/data-materi/lists',[MateriController::class, 'lists'])->name('materi.lists');
    Route::get('/data-materi/detail/{id}',[MateriController::class, 'detail'])->name('materi.detail');
    Route::post('/data-materi/insert',[MateriController::class, 'insert'])->name('materi.insert');
    Route::post('/data-materi/update',[MateriController::class, 'update'])->name('materi.update');
    Route::delete('/data-materi/delete/{id}',[MateriController::class, 'delete'])->name('materi.delete');

    Route::get('/data-berita',[BeritaController::class, 'index'])->name('berita');
});

Route::middleware(['user-access:admin'])->group(function () { // only admin can use this
    Route::delete('/data-santri/delete/{id}',[SantriController::class, 'delete'])->name('santri.delete');
});
