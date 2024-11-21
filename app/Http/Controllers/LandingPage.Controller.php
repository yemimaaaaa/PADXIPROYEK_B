<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;

class LandingPageController extends Controller
{
    public function index()
    {
        // Pastikan kolom 'jenis_produk' ada di tabel produk
        $beverages = Produk::where('jenis_produk', 'beverages')->get();
        $desserts = Produk::where('jenis_produk', 'desserts')->get();

        // Kirim data ke view landingpage.blade.php
        return view('landingpage', compact('beverages', 'desserts'));
    }
}
