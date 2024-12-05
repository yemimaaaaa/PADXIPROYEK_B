<?php

use App\Http\Controllers\CekMemberController;
use App\Http\Controllers\PublicMemberController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\TransaksiPenjualanController;
use App\Http\Controllers\LaporanTransaksiController;
use App\Http\Controllers\PoinMemberController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\SearchController;

Route::get('/member/search', [SearchController::class, 'search'])->name('member.search');


Route::get('/', [LandingPageController::class, 'showLandingPage'])->name('landingpage');


/*
|--------------------------------------------------------------------------|
| Web Routes                                                               |
|--------------------------------------------------------------------------|
| Here is where you can register web routes for your application.          |
| These routes are loaded by the RouteServiceProvider and all of them will |
| be assigned to the "web" middleware group. Make something great!        |
|--------------------------------------------------------------------------|
*/

// Route for landing page
// Route::get('/', function () {
//     return view('landingpage');
// });

// Public member routes
// Route::get('/member-list', [MemberController::class, 'showAllMembers'])->name('member.list');
// Route::get('/cek-member', [PublicMemberController::class, 'searchProfile'])->name('public.member.cekmember');


// Authentication routes
Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate'])->middleware('guest');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Route to check member profile
//Route::get('/showprofile', [ShowProfileMemberController::class, 'index'])->name('showprofile.index');

// Group routes that require authentication
Route::middleware('auth')->group(function () {
    // Dashboard route (protected by auth middleware)
    // Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // Product routes
    Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
    // Form untuk membuat produk baru
    Route::get('/produk/create', [ProdukController::class, 'create'])->name('produk.create');
    // Menyimpan produk baru
    Route::post('/produk/store', [ProdukController::class, 'store'])->name('produk.store');
    // Mencari produk
    Route::get('/produk/search', [ProdukController::class, 'search'])->name('produk.search');
       // Rute untuk menampilkan halaman edit produk
    Route::get('/produk/{id}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
    // Rute untuk mengupdate produk
    Route::put('/produk/{id}', [ProdukController::class, 'update'])->name('produk.update');
    // Rute untuk menghapus produk
    Route::delete('/produk/{id}/delete', [ProdukController::class, 'destroy'])->name('produk.delete');


    // Member routes
    Route::get('/member', [MemberController::class, 'index'])->name('member.index');
    // Form untuk membuat produk baru
    Route::get('/member/create', [MemberController::class, 'create'])->name('member.create');
    //Route::get('/member/{id}/discount', [MemberController::class, 'showDiscount'])->name('member.discount');
    Route::post('/member/store', [MemberController::class, 'store'])->name('member.store');
    Route::get('/member/search', [MemberController::class, 'search'])->name('member.search');
    // Rute untuk menampilkan halaman edit member
    Route::get('/member/{id}/edit', [MemberController::class, 'edit'])->name('member.edit');
    // Rute untuk mengupdate member
    Route::put('/member/{id}', [MemberController::class, 'update'])->name('member.update');
    // Rute untuk menghapus member
    Route::delete('/member/{id}/delete', [MemberController::class, 'destroy'])->name('member.delete');
    Route::get('/member/search', [CekMemberController::class, 'index'])->name('member.search');
    //Route::get('/cek-member', [MemberController::class, 'searchProfile'])->name('member.cekmember');


    // Employee routes
    // Route::get('/pegawai', [PegawaiController::class, 'index'])->name('pegawai.index');
    // Route::get('/pegawai/create', [PegawaiController::class, 'create'])->name('pegawai.create');
    // Route::post('/pegawai/store', [PegawaiController::class, 'store'])->name('pegawai.store');
    // Route::get('/pegawai/search', [PegawaiController::class, 'search'])->name('pegawai.search');
    // // Rute untuk menampilkan halaman edit member
    // Route::get('/pegawai/{id}/edit', [PegawaiController::class, 'edit'])->name('pegawai.edit');
    // // Rute untuk mengupdate member
    // Route::put('/pegawai/{id}', [PegawaiController::class, 'update'])->name('pegawai.update');
    // // Rute untuk menghapus member
    // Route::delete('/pegawai/{id}/delete', [PegawaiController::class, 'destroy'])->name('pegawai.delete');

    
    //stok
    Route::get('/stok', [StokController::class, 'index'])->name('stok.index');
    Route::get('/stok/search', [StokController::class, 'search'])->name('stok.search');
    // Stock routes
    Route::middleware(['auth'])->group(function () {
        Route::get('/stok/create', [StokController::class, 'create'])->name('stok.create');
        Route::post('/stok/store', [StokController::class, 'store'])->name('stok.store');
        Route::get('/stok/{id}/edit', [StokController::class, 'edit'])->name('stok.edit');
        // Rute untuk mengupdate produk
        Route::put('/stok/{id}', [StokController::class, 'update'])->name('stok.update');
    });
    // Rute untuk menghapus produk
    Route::delete('/stok/{id}/delete', [StokController::class, 'destroy'])->name('stok.delete');


    // Sales transaction routes
    Route::get('/transaksipenjualan', [TransaksiPenjualanController::class, 'index'])->name('transaksipenjualan.index'); // Menampilkan semua transaksi
    Route::get('/transaksipenjualan/create', [TransaksiPenjualanController::class, 'create'])->name('transaksipenjualan.create'); // Menampilkan form buat transaksi
    Route::post('/transaksipenjualan/store', [TransaksiPenjualanController::class, 'store'])->name('transaksipenjualan.store'); // Menyimpan data transaksi baru
    Route::get('/transaksipenjualan/search', [TransaksiPenjualanController::class, 'search'])->name('transaksipenjualan.search'); // Mencari transaksi berdasarkan parameter
    //Route::get('/transaksipenjualan/{kode_transaksi}/edit', [TransaksiPenjualanController::class, 'edit'])->name('transaksipenjualan.edit'); // Menampilkan form edit transaksi
    //Route::put('/transaksipenjualan/{kode_transaksi}', [TransaksiPenjualanController::class, 'update'])->name('transaksipenjualan.update'); // Mengupdate data transaksi
    Route::get('/transaksipenjualan/{kode_transaksi}/cetak', [TransaksiPenjualanController::class, 'cetak'])->name('transaksipenjualan.cetak'); // Mencetak transaksi
    Route::get('/transaksipenjualan/{kode_transaksi}/detail', [TransaksiPenjualanController::class, 'detail'])->name('transaksipenjualan.detail'); // Mencetak transaksi
    Route::delete('/transaksipenjualan/{kode_transaksi}/delete', [TransaksiPenjualanController::class, 'destroy'])->name('transaksipenjualan.delete');


    // Report routes
    Route::get('/laporantransaksi', [LaporanTransaksiController::class, 'index'])->name('laporantransaksi.index');
    Route::get('/laporantransaksi/search', [LaporanTransaksiController::class, 'search'])->name('laporantransaksi.search');
    Route::get('/laporantransaksi/{kode_transaksi}/detail', [LaporanTransaksiController::class, 'detail'])->name('laporantransaksi.detail');
    Route::get('/laporantransaksi/{kode_transaksi}/cetak', [LaporanTransaksiController::class, 'detail'])->name('laporantransaksi.cetak');
    Route::get('/laporantransaksi/export/excel', [LaporanTransaksiController::class, 'exportExcel'])->name('laporantransaksi.export.excel');
    Route::get('/laporantransaksi/export/pdf', [LaporanTransaksiController::class, 'exportPdf'])->name('laporantransaksi.export.pdf');
    Route::get('/laporantransaksi/grafik', [LaporanTransaksiController::class, 'grafik'])->name('laporantransaksi.grafik');


    // Poin routes
    Route::get('/poinmember', [PoinMemberController::class, 'index'])->name('poinmember.index');
    Route::post('/poinmember/search', [PoinMemberController::class, 'search'])->name('poinmember.search');
    Route::get('/poinmember/{id_member}', [PoinMemberController::class, 'showDetail'])->name('poinmember.detail');

});

Route::middleware(['auth', 'role:owner'])->group(function () {
    Route::get('/pegawai', [PegawaiController::class, 'index'])->name('pegawai.index');
    Route::get('/pegawai/create', [PegawaiController::class, 'create'])->name('pegawai.create');
    Route::post('/pegawai/store', [PegawaiController::class, 'store'])->name('pegawai.store');
    Route::get('/pegawai/{id}/edit', [PegawaiController::class, 'edit'])->name('pegawai.edit');
    Route::put('/pegawai/{id}', [PegawaiController::class, 'update'])->name('pegawai.update');
    Route::delete('/pegawai/{id}/delete', [PegawaiController::class, 'destroy'])->name('pegawai.delete');
});
