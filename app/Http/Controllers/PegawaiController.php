<?php

namespace App\Http\Controllers;

use App\Models\Pegawai; // Mengimpor model Pegawai
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class PegawaiController extends Controller
{
    public function index()
    {
        // Mengambil semua data pegawai dari database
        $pegawais = Pegawai::all(); 

        // Mengembalikan tampilan dengan data pegawai
        return view('pegawai.index', compact('pegawais'));
    }
    public function search(Request $request)
    {
        $query = $request->input('query');
        
        $pegawais = Pegawai::where('nama', 'LIKE', "{$query}%")
            ->orWhere('no_hp', 'LIKE', "%{$query}%")
            ->orWhere('email', 'LIKE', "%{$query}%")
            ->get();

        // Cek apakah hasil pencarian kosong
        if ($pegawais->isEmpty()) {
        return view('pegawai.index', compact('pegawais'))
        ->with('error', 'Data tidak ditemukan untuk kata kunci: ' . $query);
    }
        
        return view('pegawai.index', compact('pegawais'));
    }
    public function create()
    {
        // Tampilkan halaman form untuk menambahkan pegawai baru
        return view('pegawai.create');
    }
    public function role()
    {
    return $this->belongsTo(Role::class, 'id_role', 'id');
    }

    public function store(Request $request)
    {
        //dd($request->all());
        // Validasi data input
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:pegawai,username',
            'password' => 'required|string|min:6',
            'email' => 'required|email|unique:pegawai,email',
            'no_hp' => 'required|string|max:14|unique:pegawai,no_hp',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'id_role' => 'required|integer|exists:role,id_role',
        ]);

        $fotoPath = '';
        // Proses foto jika diunggah
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $fileName = time() . '_' . $foto->getClientOriginalName();
            $foto->move(public_path('pegawais'), $fileName);
            $fotoPath = 'pegawais/' . $fileName;
        }

         // Generate ID Pegawai otomatis
         $latestPegawai = Pegawai::latest('id_pegawai')->first();
         $newIdPegawai = $latestPegawai ? intval($latestPegawai->id_pegawai) + 1 : 4010;

        // Simpan data ke database
        Pegawai::create([
            'id_pegawai' => $newIdPegawai,
            'nama' => $validatedData['nama'],
            'username' => $validatedData['username'],
            'password' => Hash::make($validatedData['password']),
            'email' => $validatedData['email'],
            'no_hp' => $validatedData['no_hp'],
            'foto' => $fotoPath,
            'id_role' => $validatedData['id_role'],
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil ditambahkan!');
    }

    public function edit($id)
    {
        // Cari pegawai berdasarkan ID
        $pegawai = Pegawai::findOrFail($id);

        // Tampilkan halaman edit pegawai
        return view('pegawai.edit', compact('pegawai'));
    }

    public function update(Request $request, $id)
    {
        // Validasi data input
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:pegawai,username,' . $id . ',id_pegawai',
            'email' => 'required|email|unique:pegawai,email,' . $id . ',id_pegawai',
            'no_hp' => 'required|string|max:14|unique:pegawai,no_hp,' . $id . ',id_pegawai',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'id_role' => 'required|integer|exists:role,id_role',
        ]);

        // Temukan stok berdasarkan ID
        $pegawai = Pegawai::findOrFail($id);

        // Proses foto jika diunggah
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $fileName = time() . '_' . $foto->getClientOriginalName();
            $foto->move(public_path('pegawais'), $fileName);
            $pegawai->foto = 'pegawais/' . $fileName; // Simpan path foto
        }

        // Update data pegawai
        $pegawai->update([
            'nama' => $validatedData['nama'],
            'username' => $validatedData['username'],
            'email' => $validatedData['email'],
            'no_hp' => $validatedData['no_hp'],
            'foto' => $pegawai->foto, // Tetap gunakan foto lama jika tidak ada yang baru
            'id_role' => $validatedData['id_role'],
        ]);

        // Redirect dengan pesan sukses
        return redirect('/pegawai')->with('success', 'Pegawai berhasil diperbarui!');
    }

    public function destroy($id)
    {
        // Cari pegawai berdasarkan ID
        $pegawai = Pegawai::findOrFail($id);

        // Hapus foto jika ada
        if ($pegawai->foto && file_exists(public_path($pegawai->foto))) {
            unlink(public_path($pegawai->foto));
        }

        // Hapus data pegawai
        $pegawai->delete();

        // Redirect dengan pesan sukses
        return redirect('/pegawai')->with('success', 'Stok berhasil dihapus!');
    }
}
