<?php

namespace App\Http\Controllers;

use App\Models\Stok; // Mengimpor model Stok
use Illuminate\Http\Request;
use App\Models\Pegawai;
use Carbon\Carbon;


class StokController extends Controller
{
    public function index()
    {
        // Mengambil semua data stok dari database
        $stoks = Stok::orderBy('created_at', 'desc')->get(); 


        // Mengembalikan tampilan dengan data stok
        return view('stok.index', compact('stoks'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        
        // Pastikan kolom nama_stok yang digunakan untuk pencarian
        $stoks = Stok::where('nama_stok', 'LIKE', "%{$query}%")->get();
        
        // Kembalikan hasil ke view stok.index
        return view('stok.index', compact('stoks'));
    }
    public function create()
    {
        // $pegawais = Pegawai::all();
        // return view('stok.create', compact('pegawais'));
        return view('stok.create');
    }
    public function pegawai()
    {
    return $this->belongsTo(Pegawai::class, 'id_pegawai', 'id');
    }


    public function store(Request $request)
{
    //dd($request->all());
    $validatedData = $request->validate([
        //'id_stok' => 'required|string|max:255',
        'nama_stok' => 'required|string|max:255',
        'jenis_stok' => 'required|string|max:255',
        'tanggal_masuk_stok' => 'required|date',
        'foto_stok' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'detail_stok' => 'nullable|string',
        'id_pegawai' => 'required|exists:pegawai,id_pegawai', // Validasi foreign key
    ]);

    //dd($validatedData);

    $fotoPath = '';

    // Proses file foto produk jika ada
    if ($request->hasFile('foto_stok')) {
        $foto_produk = $request->file('foto_stok');
        $fileName = time() . '_' . $foto_produk->getClientOriginalName();
        $foto_produk->move(public_path('uploads'), $fileName);
        $fotoPath = 'uploads/' . $fileName; // Path relatif untuk disimpan di database
    }
    // Generate ID Stok secara otomatis
    $latestStok = Stok::latest('id_stok')->first();
    $newIdStok = $latestStok ? intval($latestStok->id_stok) + 1 : 7001; // Mulai dari 1001 jika tidak ada stok
    // Konversi `tanggal_masuk_stok` ke format timestamp
    $validatedData['tanggal_masuk_stok'] = Carbon::parse($request->input('tanggal_masuk_stok'))->format('Y-m-d');

    // Simpan data ke database
    Stok::create([
        'id_stok' => $newIdStok,// Generate ID Stok secara otomatis
        'nama_stok' => $validatedData['nama_stok'],
        'jenis_stok' => $validatedData['jenis_stok'],
        'tanggal_masuk_stok' => $validatedData['tanggal_masuk_stok'],
        'foto_stok' => $fotoPath, // Menyimpan path foto yang relatif
        'detail_stok' => $validatedData['detail_stok'],
        'id_pegawai' => $validatedData['id_pegawai'], // Simpan id_pegawai sebagai foreign key
    ]);

    // Redirect dengan pesan sukses
    return redirect()->route('stok.index')->with('success', 'Data stok berhasil ditambahkan!');
    }

    
    public function edit($id)
    {
        $stok = Stok::findOrFail($id); // Mencari produk berdasarkan ID
        return view('stok.edit', compact('stok')); // Menampilkan form edit
    }

public function update(Request $request, $id)
{
    //dd($request->all());
    // Validasi input
    $validatedData = $request->validate([
        //'id_stok' => 'required|string|max:255',
        'nama_stok' => 'required|string|max:255',
        'jenis_stok' => 'required|string|max:255',
        'tanggal_masuk_stok' => 'required|date',
        'foto_stok' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'detail_stok' => 'nullable|string',
        'id_pegawai' => 'required|exists:pegawai,id_pegawai', // Validasi foreign key
    ]);

    // Temukan stok berdasarkan ID
    $stok = Stok::findOrFail($id);

    // Konversi tanggal masuk stok menjadi timestamp
    $validatedData['tanggal_masuk_stok'] = Carbon::parse($request->input('tanggal_masuk_stok'))->format('Y-m-d');

    // Proses file foto produk jika ada
    if ($request->hasFile('foto_stok')) {
        $foto_stok = $request->file('foto_stok');
        $fileName = time() . '_' . $foto_stok->getClientOriginalName();
        $foto_stok->move(public_path('uploads'), $fileName);
        $stok->foto_stok = 'uploads/' . $fileName; // Simpan path foto
    }

    // Update data stok
    $stok->update([
        //'id_stok' => $validatedData['id_stok'],
        'nama_stok' => $validatedData['nama_stok'],
        'jenis_stok' => $validatedData['jenis_stok'],
        'tanggal_masuk_stok' => $validatedData['tanggal_masuk_stok'],
        'foto_stok' => $stok->foto_stok, // Pastikan foto tetap ada jika tidak diubah
        'detail_stok' => $validatedData['detail_stok'],
        'id_pegawai' => $validatedData['id_pegawai'],
    ]);

    // Redirect dengan pesan sukses
    return redirect('/stok')->with('success', 'Stok berhasil diperbarui!');
}

public function destroy($id)
{
    $stok = Stok::findOrFail($id);

    // Hapus file foto jika ada
    if ($stok->foto_stok && file_exists(public_path($stok->foto_stok))) {
        unlink(public_path($stok->foto_stok));
    }

    $stok->delete();

    return redirect('/stok')->with('success', 'Stok berhasil dihapus!');
}

}
