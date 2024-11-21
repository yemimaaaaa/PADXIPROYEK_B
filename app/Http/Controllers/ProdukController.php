<?php

namespace App\Http\Controllers;

use App\Models\Produk; // Mengimpor model Produk
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class ProdukController extends Controller
{
    public function index()
{
    // Mengambil semua data produk dari database dan mengurutkan berdasarkan created_at secara menurun
    $produks = Produk::orderBy('created_at', 'desc')->get(); 

    // Mengembalikan tampilan dengan data produk
    return view('produk.index', compact('produks'));
}

    public function search(Request $request)
    {
        $query = $request->input('query');
        
        $produks = Produk::where('nama_produk', 'LIKE', "{$query}%")
            ->get();
        
        return view('produk.index', compact('produks'));
    }

    public function create()
    {
        return view('produk.create');
    }

    public function store(Request $request)
{
    $validatedData = $request->validate([
        //'id_produk' => 'required|string|max:255',
        'nama_produk' => 'required|string|max:255|unique:produk,nama_produk',
        'jenis_produk' => 'required|string|max:255',
        'harga' => 'required|numeric',
        'deskripsi_produk' => 'nullable|string',
        'foto_produk' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $fotoPath = '';

    // Proses file foto produk jika ada
    if ($request->hasFile('foto_produk')) {
        $foto_produk = $request->file('foto_produk');
        $fileName = time() . '_' . $foto_produk->getClientOriginalName();
        $foto_produk->move(public_path('uploads'), $fileName);
        $fotoPath = 'uploads/' . $fileName; // Path relatif untuk disimpan di database
    }

        // Generate ID Produk secara otomatis
        $latestProduk = Produk::orderBy('id_produk', 'desc')->first();
        $newIdProduk = $latestProduk ? intval($latestProduk->id_produk) + 1 : 2001;
        
        Produk::create([
            'id_produk' => $newIdProduk,
            'nama_produk' => $validatedData['nama_produk'],
            'jenis_produk' => $validatedData['jenis_produk'],
            'harga' => $validatedData['harga'],
            'deskripsi_produk' => $validatedData['deskripsi_produk'],
            'foto_produk' => $fotoPath,
        ]);
        

    // Hapus pemisah ribuan jika ada (untuk harga)
    $validatedData['harga'] = str_replace('.', '', $validatedData['harga']);

    // Redirect dengan pesan sukses
    return redirect('/produk')->with('success', 'Produk berhasil ditambahkan!');
}
public function edit($id)
{
    $produk = Produk::findOrFail($id); // Mencari produk berdasarkan ID
    return view('produk.edit', compact('produk')); // Menampilkan form edit
}

public function update(Request $request, $id)
{
    // Temukan produk berdasarkan ID
    $produk = Produk::findOrFail($id);

    // Validasi input
    $validatedData = $request->validate([
        'nama_produk' => "required|string|max:255|unique:produk,nama_produk,{$produk->id_produk},id_produk",
        'jenis_produk' => 'required|string|max:255',
        'harga' => 'required|numeric',
        'deskripsi_produk' => 'nullable|string',
        'foto_produk' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

    ]);

    // Proses file foto produk jika ada
    if ($request->hasFile('foto_produk')) {
        $foto_produk = $request->file('foto_produk');
        $fileName = time() . '_' . $foto_produk->getClientOriginalName();
        $foto_produk->move(public_path('uploads'), $fileName);
        $produk->foto_produk = 'uploads/' . $fileName; // Simpan path foto
    }

    // Update data produk
    $produk->nama_produk = $validatedData['nama_produk'];
    $produk->jenis_produk = $validatedData['jenis_produk'];
    $produk->harga = str_replace('.', '', $validatedData['harga']); // Hapus pemisah ribuan
    $produk->deskripsi_produk = $validatedData['deskripsi_produk'] ?? $produk->deskripsi_produk;
    $produk->save(); // Simpan ke database

    // Redirect dengan pesan sukses
    return redirect('/produk')->with('success', 'Produk berhasil diperbarui!');
}

public function destroy($id)
{
    // Mencari produk berdasarkan ID
    $produk = Produk::findOrFail($id);

    // Menghapus produk
    $produk->delete();

    // Redirect kembali ke halaman produk dengan pesan sukses
    return redirect('/produk')->with('success', 'Produk berhasil dihapus!');
}
}