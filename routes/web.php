<?php

use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DendaController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PeminjamanController;
use Illuminate\Support\Facades\Route;

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

// Login
Route::get('/login',[LoginController::class, 'login'])->name('login');
Route::post('/loginuser',[LoginController::class, 'loginproses'])->name('loginuser');
Route::get('/register',[LoginController::class, 'register'])->name('register');
Route::post('/registeruser',[LoginController::class, 'registeruser'])->name('registeruser');
Route::get('/logout',[LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', [Controller::class, 'Home'])->name('home');
    Route::get('/anggota', [Controller::class, 'Anggota'])->name('anggota');
    Route::get('/buku', [Controller::class, 'Buku'])->name('buku');
    Route::get('/kategori', [Controller::class, 'Kategori'])->name('kategori');
    Route::get('/peminjaman', [Controller::class, 'Peminjaman'])->name('peminjaman');
    Route::get('/pengembalian', [Controller::class, 'Pengembalian'])->name('pengembalian');
    Route::get('/denda', [Controller::class, 'Denda'])->name('denda');
    Route::get('/laporan', [Controller::class, 'Laporan'])->name('laporan');
    Route::get('/profile', [Controller::class, 'Profile'])->name('profile');

    Route::post('/anggota/store', [AnggotaController::class, 'store'])->name('anggota.store');
    Route::put('/anggota/update/{id}', [AnggotaController::class, 'update'])->name('anggota.update');
    Route::delete('/anggota/delete/{id}', [AnggotaController::class, 'destroy'])->name('anggota.delete');

    Route::post('/kategori/store', [KategoriController::class, 'store'])->name('kategori.store');
    Route::put('/kategori/update/{id}', [KategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/kategori/delete/{id}', [KategoriController::class, 'destroy'])->name('kategori.delete');

    Route::post('/buku', [BukuController::class, 'store'])->name('buku.store');
    Route::put('/buku/update/{buku}', [BukuController::class, 'update'])->name('buku.update');
    Route::delete('/buku/delete/{buku}', [BukuController::class, 'destroy'])->name('buku.destroy');

    Route::post('/peminjaman', [PeminjamanController::class,'store'])->name('peminjaman.store');
    Route::put('/peminjaman/{peminjaman}/kembali-semua',[PeminjamanController::class,'kembaliSemua'])->name('peminjaman.kembaliSemua');
    Route::put('/peminjaman/perpanjang/{detail}', [PeminjamanController::class,'perpanjang'])->name('peminjaman.perpanjang');
    Route::put('/peminjaman/kembali/{detail}', [PeminjamanController::class,'kembali'])->name('peminjaman.kembali');
    
    Route::put('/denda/{denda}/bayar',[DendaController::class,'bayar'])->name('denda.bayar');
});