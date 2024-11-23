<?php

namespace App\Http\Controllers;

use App\Models\LevelMember;
use App\Models\Member; // Mengimpor model Produk
use Illuminate\Http\Request;
use Carbon\Carbon;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        // Mendapatkan input pencarian dari request
        $query = $request->input('query');
    
        // Query untuk mengambil data member dengan filter dan paginasi
        $members = Member::with('levelmember') // Pastikan relasi 'level' didefinisikan di model Member
            ->when($query, function ($queryBuilder) use ($query) {
                $queryBuilder->where('nama', 'like', "%$query%")
                    ->orWhere('no_hp', 'like', "%$query%");
            })
            ->orderBy('created_at', 'desc') // Urutkan berdasarkan waktu dibuat
            ->paginate(8); // Batasi 8 data per halaman
    
        // Mengembalikan tampilan dengan data member dan query pencarian
        return view('member.index', compact('members', 'query'));
    }
    

    public function search(Request $request)
    {
        $query = $request->input('query');
        
        $members = Member::where('nama', 'LIKE', "{$query}%")
            ->orWhere('no_hp', 'LIKE', "%{$query}%")
            ->get();
        
        return view('member.index', compact('members'));
    }
        //     public function showDiscount($id)
        // {
        //     // Cari member berdasarkan ID
        //     $member = Member::findOrFail($id);

        //     // Hitung diskon berdasarkan level member
        //     $discountRates = [
        //         '1001' => 0.05, // Bronze
        //         '1002' => 0.15, // Silver
        //         '1003' => 0.25, // Gold
        //     ];

        //     $discount = $discountRates[$member->id_level_member] ?? 0;

        //     return view('member.discount', compact('member', 'discount'));
        // }

        public function create()
        {
            // Tampilkan halaman form untuk membuat member baru
            return view('member.create');
        }
        
        public function store(Request $request)
        {
            // Validasi data input
            $validatedData = $request->validate([
                'nama' => 'required|string|max:255',
                'no_hp' => [
                    'required',
                    'string',
                    'max:14',
                    'unique:member,no_hp',
                    'regex:/^08[0-9]{9,12}$/',
                ],
                'periode_awal' => 'required|date',
                'id_level_member' => 'required|in:1001,1002,1003',
                'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',//foto wajib untuk diunggah
            ], [
                'no_hp.required' => 'Nomor HP wajib diisi.',
                'no_hp.regex' => 'Nomor HP harus diawali dengan 08 dan terdiri dari 9 hingga 14 angka.',
                'no_hp.unique' => 'Nomor HP ini sudah terdaftar.',
                'foto.required' => 'Foto wajib diunggah.',
                'foto.image' => 'Foto harus berupa file gambar.',
                'foto.mimes' => 'Foto harus berformat JPEG, PNG, atau JPG.',
                'foto.max' => 'Ukuran foto maksimal adalah 2MB.',
            ]);

            // Set default level member ke Bronze jika tidak dipilih
            $validatedData['id_level_member'] = $validatedData['id_level_member'] ?? '1001';

    
            // Proses foto jika diunggah
            $fotoPath = null;
            if ($request->hasFile('foto')) {
                $foto = $request->file('foto');
                $fileName = time() . '_' . $foto->getClientOriginalName();
                $foto->move(public_path('members'), $fileName);
                $fotoPath = 'members/' . $fileName;
            }
    
            // Generate ID Member secara otomatis
            $latestMember = Member::latest('id_member')->first();
            $newIdMember = $latestMember ? intval($latestMember->id_member) + 1 : 3001;
    
            // Hitung periode akhir sebagai 6 bulan dari periode awal
            $periodeAwal = Carbon::parse($validatedData['periode_awal']);
            $periodeAkhir = $periodeAwal->copy()->addMonths(6);
    
            // Simpan data ke database
            Member::create([
                'id_member' => $newIdMember,
                'nama' => $validatedData['nama'],
                'no_hp' => $validatedData['no_hp'],
                'periode_awal' => $periodeAwal->format('Y-m-d'),
                'periode_akhir' => $periodeAkhir->format('Y-m-d'),
                'id_level_member' => $validatedData['id_level_member'],
                'foto' => $fotoPath,
            ]);
    
            // Redirect dengan pesan sukses
            return redirect()->route('member.index')->with('success', 'Member berhasil ditambahkan!');
        }
    
    
        public function edit($id)
        {
            // Cari member berdasarkan ID
            $member = Member::findOrFail($id);
    
            // Tampilkan halaman edit member
            return view('member.edit', compact('member'));
        }
    
        public function update(Request $request, $id)
        {
            // Cari member berdasarkan ID
            $member = Member::findOrFail($id);
        
            // Validasi data input
            $validatedData = $request->validate([
                'nama' => 'required|string|max:255',
                'no_hp' => [
                    'required',
                    'string',
                    'max:14',
                    'unique:member,no_hp,' . $id . ',id_member',
                    'regex:/^08[0-9]{9,12}$/',
                ],
                'periode_awal' => 'required|date',
                'id_level_member' => 'required|exists:levelmember,id_level_member',
                'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Foto wajib diunggah saat update
            ], [
                'no_hp.required' => 'Nomor HP wajib diisi.',
                'no_hp.regex' => 'Nomor HP harus diawali dengan 08 dan terdiri dari 9 hingga 14 angka.',
                'no_hp.unique' => 'Nomor HP ini sudah terdaftar.',
                'foto.required' => 'Foto wajib diunggah.',
                'foto.image' => 'Foto harus berupa file gambar.',
                'foto.mimes' => 'Foto harus berformat JPEG, PNG, atau JPG.',
                'foto.max' => 'Ukuran foto maksimal adalah 2MB.',
            ]);
        
            // Hapus foto lama jika ada
            if ($request->hasFile('foto')) {
                // if ($member->foto && file_exists(public_path($member->foto))) {
                //     unlink(public_path($member->foto));
                // }
            // proses foto baru
                $foto = $request->file('foto');
                $fileName = time() . '_' . $foto->getClientOriginalName();
                $foto->move(public_path('members'), $fileName);
                $member->foto = 'members/' . $fileName;
            }
        
            // Hitung periode akhir sebagai 6 bulan dari periode awal
            $periodeAwal = Carbon::parse($validatedData['periode_awal']);
            $periodeAkhir = $periodeAwal->copy()->addMonths(6);
        
            // Update data member
            $member->update([
                'nama' => $validatedData['nama'],
                'no_hp' => $validatedData['no_hp'],
                'periode_awal' => $periodeAwal->format('Y-m-d'),
                'periode_akhir' => $periodeAkhir->format('Y-m-d'),
                'id_level_member' => $validatedData['id_level_member'],
                'foto' => $member->foto,
            ]);
        
            // Redirect dengan pesan sukses
            return redirect()->route('member.index')->with('success', 'Member berhasil diperbarui!');
        }
        
    
        public function destroy($id)
        {
            // Cari member berdasarkan ID
            $member = Member::findOrFail($id);
    
            // Hapus foto jika ada
            if ($member->foto && file_exists(public_path($member->foto))) {
                unlink(public_path($member->foto));
            }
    
            // Hapus data member
            $member->delete();
    
            // Redirect dengan pesan sukses
            return redirect()->route('member.index')->with('success', 'Member berhasil dihapus!');
        }
        
    }
    