<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BobotController;
use App\Http\Controllers\BobotnilaiController;
use App\Http\Controllers\DetailKategoriController;
use App\Http\Controllers\FakultasController;
use App\Http\Controllers\JuriController;
use App\Http\Controllers\PenilaianFakultasController;
use App\Http\Controllers\PenilaianProdiController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\UserControlController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::view('/', 'halaman_auth/login');
Route::get('/sesi', [AuthController::class, 'index'])->name('auth');
Route::post('/sesi', [AuthController::class, 'login']);

//akses kedua rule
Route::group(['middleware' => ['auth']], function () {
    Route::get('/keluar-aplikasi', [AuthController::class, 'logout']);
    Route::get('/redirect', [RedirectController::class, 'cek']);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    });

    Route::get('/prodi', [ProdiController::class, 'index']);
    Route::get('/keluar-aplikasi', [AuthController::class, 'logout']);
    Route::get('/prodi/index', [ProdiController::class, 'index']);
    Route::get('/prodi/add', [ProdiController::class, 'formAdd']);
    Route::post('/prodi/saveData', [ProdiController::class, 'saveData']);
    Route::get('/prodi/edit/{kode}', [ProdiController::class, 'editData']);
    Route::put('/prodi/updateData', [ProdiController::class, 'updateData']);
    Route::delete('/prodi/deleteData/{kode}', [ProdiController::class, 'deleteData']);

    Route::get('/fakultas', [FakultasController::class, 'index']);
    Route::get('/fakultas/index', [FakultasController::class, 'index']);
    Route::get('/fakultas/add', [FakultasController::class, 'formAdd']);
    Route::get('/fakultas/edit/{id}', [FakultasController::class, 'editData']);
    Route::post('/fakultas/saveData', [FakultasController::class, 'saveData']);
    Route::put('/fakultas/updateData', [FakultasController::class, 'updateData']);
    Route::delete('/fakultas/deleteData/{id}', [FakultasController::class, 'deleteData']);

    Route::get('/user-juri', [JuriController::class, 'index']);
    Route::get('/user-juri/index', [JuriController::class, 'index']);
    Route::get('/user-juri/add', [JuriController::class, 'formAdd']);
    Route::post('/user-juri/saveData', [JuriController::class, 'saveData']);
    Route::get('/user-juri/edit/{id}', [JuriController::class, 'editData']);
    Route::put('/user-juri/updateData', [JuriController::class, 'updateData']);
    Route::delete('/user-juri/deleteData/{id}', [JuriController::class, 'deleteData']);

    Route::get('/kategori', [DetailKategoriController::class, 'index']);
    Route::get('/kategori/index', [DetailKategoriController::class, 'index']);
    Route::get('/kategori/add', [DetailKategoriController::class, 'formAdd']);
    Route::get('/kategori/edit/{id}', [DetailKategoriController::class, 'editData']);
    Route::post('/kategori/saveData', [DetailKategoriController::class, 'saveData']);
    Route::put('/kategori/updateData', [DetailKategoriController::class, 'updateData']);
    Route::delete('/kategori/deleteData/{id}', [DetailKategoriController::class, 'deleteData']);

    Route::get('/sub-kategori', [BobotController::class, 'index']);
    Route::get('/sub-kategori/index', [BobotController::class, 'index']);
    Route::get('/sub-kategori/add', [BobotController::class, 'formAdd']);
    Route::get('/sub-kategori/edit/{id}', [BobotController::class, 'editData']);
    Route::post('/sub-kategori/saveData', [BobotController::class, 'saveData']);
    Route::put('/sub-kategori/updateData', [BobotController::class, 'updateData']);
    Route::delete('/sub-kategori/deleteData/{id}', [BobotController::class, 'deleteData']);


    Route::get('/penilaian-fakultas', [PenilaianFakultasController::class, 'index']);
    Route::get('/penilaian-fakultas/index', [PenilaianFakultasController::class, 'index']);
    Route::get('/penilaian-fakultas/add', [PenilaianFakultasController::class, 'add']);
    Route::get('/penilaian-fakultas/doExportExcel', [PenilaianFakultasController::class, 'doExportExcel']);
    Route::post('/penilaian-fakultas/simpan', [PenilaianFakultasController::class, 'simpan']);
    Route::delete('/penilaian-fakultas/deleteData/{id}', [PenilaianFakultasController::class, 'deleteData']);
    Route::get('/penilaian-fakultas/edit/{id}', [PenilaianFakultasController::class, 'edit']);
    Route::put('/penilaian-fakultas/updateData', [PenilaianFakultasController::class, 'updateData']);

    Route::get('/penilaian-prodi', [PenilaianProdiController::class, 'index']);
    Route::get('/penilaian-prodi/index', [PenilaianProdiController::class, 'index']);
    Route::get('/penilaian-prodi/add', [PenilaianProdiController::class, 'add']);
    Route::post('/penilaian-prodi/pilihProdi', [PenilaianProdiController::class, 'pilihProdi']);
    // Route::post('/penilaian-prodi/tampilDataDetail', [PenilaianProdiController::class, 'tampilDataDetail']);
    // Route::post('/penilaian-prodi/modalCariBobot', [PenilaianProdiController::class, 'modalCariBobot']);
    Route::post('/penilaian-prodi/simpan', [PenilaianProdiController::class, 'simpan']);
    Route::delete('/penilaian-prodi/deleteDetail/{id}', [PenilaianProdiController::class, 'deleteDetail']);
    Route::delete('/penilaian-prodi/deleteData/{id}', [PenilaianProdiController::class, 'deleteData']);
    Route::get('/penilaian-prodi/edit/{id}', [PenilaianProdiController::class, 'edit']);
    Route::put('/penilaian-prodi/updateData', [PenilaianProdiController::class, 'updateData']);
    Route::get('/penilaian-prodi/doExportExcel', [PenilaianProdiController::class, 'doExportExcel']);



    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});