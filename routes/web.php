<?php

use App\Http\Controllers\CekMemberController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\TransaksiPenjualanController;
use App\Http\Controllers\LaporanTransaksiController;



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

// Route::get('/', function (){return view('welcome');});

Route::get('/', function (){return view('landingpage');});

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Route untuk cek member
Route::get('/cekmember', [CekMemberController::class, 'index'])
    ->name('cekmember');

// Route untuk dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard.index');

// Route untuk produk
Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
Route::get('/produk/search', [ProdukController::class, 'search'])->name('produk.search');

// Route untuk member
Route::get('/member', [MemberController::class, 'index'])->name('member.index');
Route::get('/member/search', [MemberController::class, 'search'])->name('member.search');

// Route untuk pegawai
Route::get('/pegawai', [PegawaiController::class, 'index'])->name('pegawai.index');
Route::get('/pegawai/search', [PegawaiController::class, 'search'])->name('pegawai.search');

// Route untuk stok
Route::get('/stok', [StokController::class, 'index'])->name('stok.index');
Route::get('/stok/search', [StokController::class, 'search'])->name('stok.search');

// Route untuk transaksi penjualan
Route::get('/transaksipenjualan', [TransaksiPenjualanController::class, 'index'])->name('transaksipenjualan.index');
Route::get('/transaksipenjualan/search', [TransaksiPenjualanController::class, 'search'])->name('transaksipenjualan.search');

// Route untuk transaksi penjualan
Route::get('/laporantransaksi', [LaporanTransaksiController::class, 'index'])
    ->name('laporantransaksi.index');






