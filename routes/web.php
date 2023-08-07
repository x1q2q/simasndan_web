<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SantriController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\AbsenkanController;
use App\Http\Middleware\Authenticate;
use App\Models\Penilaian;
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
    Route::post('/data-berita/lists',[BeritaController::class, 'lists'])->name('berita.lists');
    Route::get('/data-berita/detail/{id}',[BeritaController::class, 'detail'])->name('berita.detail');
    Route::post('/data-berita/insert',[BeritaController::class, 'insert'])->name('berita.insert');
    Route::post('/data-berita/update',[BeritaController::class, 'update'])->name('berita.update');
    Route::delete('/data-berita/delete/{id}',[BeritaController::class, 'delete'])->name('berita.delete');
    
    Route::get('/data-semester',[SemesterController::class,'index'])->name('semester');
    Route::post('/data-semester/lists',[SemesterController::class, 'lists'])->name('semester.lists');
    Route::get('/data-semester/detail/{id}',[SemesterController::class, 'detail'])->name('semester.detail');
    Route::post('/data-semester/insert',[SemesterController::class, 'insert'])->name('semester.insert');
    Route::post('/data-semester/update',[SemesterController::class, 'update'])->name('semester.update');
    Route::delete('/data-semester/delete/{id}',[SemesterController::class, 'delete'])->name('semester.delete');

    Route::get('/data-jadwal',[JadwalController::class,'index'])->name('jadwal');
    Route::post('/data-jadwal/lists',[JadwalController::class, 'lists'])->name('jadwal.lists');
    Route::get('/data-jadwal/detail/{id}',[JadwalController::class, 'detail'])->name('jadwal.detail');
    Route::post('/data-jadwal/insert',[JadwalController::class, 'insert'])->name('jadwal.insert');
    Route::post('/data-jadwal/update',[JadwalController::class, 'update'])->name('jadwal.update');
    Route::delete('/data-jadwal/delete/{id}',[JadwalController::class, 'delete'])->name('jadwal.delete');
    Route::get('/data-jadwal/getkelas',[JadwalController::class,'getKelasData'])->name('jadwal.getkelas');
    Route::get('/data-jadwal/getmateri',[JadwalController::class,'getMateriData'])->name('jadwal.getmateri');
    Route::get('/data-jadwal/getsemester',[JadwalController::class,'getSemesterData'])->name('jadwal.getsemester');

    Route::get('/data-jadwal/absenkan/{id}',[AbsenkanController::class,'index'])->name('absenkan');
    Route::post('/data-jadwal/absenkan/update',[AbsenkanController::class,'update'])->name('absenkan.update');
    Route::post('/data-jadwal/absenkan/updateall',[AbsenkanController::class,'updateAll'])->name('absenkan.updateall');

    Route::get('/data-kelas',[KelasController::class,'index'])->name('kelas');
    Route::post('/data-kelas/lists',[KelasController::class, 'lists'])->name('kelas.lists');
    Route::get('/data-kelas/detail/{id}',[KelasController::class, 'detail'])->name('kelas.detail');
    Route::post('/data-kelas/insert',[KelasController::class, 'insert'])->name('kelas.insert');
    Route::post('/data-kelas/update',[KelasController::class, 'update'])->name('kelas.update');
    Route::delete('/data-kelas/delete/{id}',[KelasController::class, 'delete'])->name('kelas.delete');
    Route::get('/data-kelas/getsantri',[KelasController::class,'getSantriData'])->name('kelas.getsantri');

    Route::get('/data-penilaian',[PenilaianController::class,'index'])->name('penilaian');
    Route::post('/data-penilaian/lists',[PenilaianController::class, 'lists'])->name('penilaian.lists');
    Route::get('/data-penilaian/detail/{id}',[PenilaianController::class, 'detail'])->name('penilaian.detail');
    Route::post('/data-penilaian/update',[PenilaianController::class, 'update'])->name('penilaian.update');
    
});

Route::middleware(['user-access:admin'])->group(function () { // only admin can use this
    Route::delete('/data-santri/delete/{id}',[SantriController::class, 'delete'])->name('santri.delete');
});
