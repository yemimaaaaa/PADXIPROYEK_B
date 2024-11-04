<?php

use App\Http\Controllers\ShowProfileMemberController;
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
|--------------------------------------------------------------------------|
| Web Routes                                                               |
|--------------------------------------------------------------------------|
| Here is where you can register web routes for your application.          |
| These routes are loaded by the RouteServiceProvider and all of them will |
| be assigned to the "web" middleware group. Make something great!        |
|--------------------------------------------------------------------------|
*/

// Route for landing page
Route::get('/', function () {
    return view('landingpage');
});

// Authentication routes
Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::middleware('auth')->group(function () {
    Route::middleware('role:pegawai')->group(function () {
        Route::get('/pegawai', [MemberController::class, 'index'])->name('pegawai.index');
        // Other routes for pegawai
    });

    Route::middleware('role:admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
        // Other routes for admin
    });

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

    // Route to check member profile
    Route::get('/showprofile', [MemberController::class, 'showProfile'])->name('showprofile');

    // Dashboard route
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // Product routes
    Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
    Route::get('/produk/search', [ProdukController::class, 'search'])->name('produk.search');

    // Member routes
    Route::get('/member', [MemberController::class, 'index'])->name('member.index');
    Route::get('/member/search', [MemberController::class, 'search'])->name('member.search');

    // Employee routes
    Route::get('/pegawai', [PegawaiController::class, 'index'])->name('pegawai.index');
    Route::get('/pegawai/search', [PegawaiController::class, 'search'])->name('pegawai.search');

    // Stock routes
    Route::get('/stok', [StokController::class, 'index'])->name('stok.index');
    Route::get('/stok/search', [StokController::class, 'search'])->name('stok.search');

    // Sales transaction routes
    Route::get('/transaksipenjualan', [TransaksiPenjualanController::class, 'index'])->name('transaksipenjualan.index');
    Route::get('/transaksipenjualan/search', [TransaksiPenjualanController::class, 'search'])->name('transaksipenjualan.search');
    Route::get('/transaksipenjualan/{kode_transaksi}/edit', [TransaksiPenjualanController::class, 'edit'])->name('transaksipenjualan.edit');
    Route::get('/transaksipenjualan/{kode_transaksi}/cetak', [TransaksiPenjualanController::class, 'cetak'])->name('transaksipenjualan.cetak');

    // Report routes
    Route::get('/laporantransaksi', [LaporanTransaksiController::class, 'index'])->name('laporantransaksi.index');
