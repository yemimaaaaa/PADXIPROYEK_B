<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Allerta&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Allerta', sans-serif;
            background: linear-gradient(to right, #e3f2fd, #f1f8ff);
        }

        .form-container {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            max-width: 600px;
            margin: auto;
        }

        .form-container label {
            color: #374151;
            font-weight: bold;
        }

        .form-container input, 
        .form-container select {
            border: 1px solid rgba(2, 62, 138, 0.45);
            background-color: #f8fafc;
            color: #374151;
            padding: 0.75rem;
            border-radius: 8px;
            width: 100%;
            transition: all 0.3s;
        }

        .form-container input:focus, 
        .form-container select:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 6px rgba(79, 70, 229, 0.4);
            outline: none;
        }

        .form-container button {
            background: linear-gradient(to right, #4f46e5, #9333ea);
            color: #ffffff;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            transition: all 0.3s;
            cursor: pointer;
            font-size: 1rem;
        }

        .form-container button:hover {
            background: linear-gradient(to right, #3730a3, #6d28d9);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.5);
        }

        .form-container a {
            color: #374151;
            background-color: #e5e7eb;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            transition: all 0.3s;
            text-decoration: none;
        }

        .form-container a:hover {
            background-color: #d1d5db;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .form-header h2 {
            color: #374151;
            font-size: 2rem;
            font-weight: bold;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="form-container">
        <div class="form-header">
            <h2>Tambah Data Member</h2>
        </div>
        <form action="{{ route('member.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Nama Member -->
            <div class="mb-4">
                <label for="nama" class="block mb-2">Nama Member:</label>
                <input type="text" id="nama" name="nama" class="form-input" value="{{ old('nama') }}" placeholder="Masukkan nama member" required>
                @error('nama')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

           <!-- No HP -->
           <div class="input-group mb-6">
            <label for="no_hp" class="block text-gray-700 font-medium mb-2">
                <i class="fas fa-phone mr-2 text-yellow-500"></i>No HP
            </label>
            <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp', $member->no_hp ?? '') }}" class="form-input" placeholder="Masukkan nomor HP" required>
            @error('no_hp')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        

            <!-- Periode Awal -->
            <div class="mb-4">
                <label for="periode_awal" class="block mb-2">Periode Awal:</label>
                <input type="date" id="periode_awal" name="periode_awal" class="form-input" value="{{ old('periode_awal') }}" required>
                @error('periode_awal')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Periode Akhir -->
            <div class="mb-4">
                <label for="periode_akhir" class="block mb-2">Periode Akhir:</label>
                <input type="date" id="periode_akhir" name="periode_akhir" class="form-input" value="{{ old('periode_akhir') }}" readonly>
                @error('periode_akhir')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Level Member -->
            <div class="mb-4">
                <label for="id_level_member" class="block mb-2">Level Member:</label>
                <input type="text" id="id_level_member_display" value="Bronze" class="form-input bg-gray-100 cursor-not-allowed" readonly>
                <input type="hidden" id="id_level_member" name="id_level_member" value="1001">
                @error('id_level_member')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Foto Member -->
            <div class="mb-6">
                <label for="foto" class="block text-gray-700 font-medium mb-2">
                    <i class="fas fa-image mr-2 text-teal-500"></i>Foto Member:
                </label>
                <input type="file" name="foto" id="foto" class="border border-gray-300 p-3 w-full rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">

                <!-- Menampilkan foto saat ini jika variabel $member ada dan memiliki foto -->
                @isset($member)
                    @if($member->foto)
                        <div class="mt-4">
                            <img src="{{ asset($member->foto) }}" alt="Foto Member" class="w-32 h-32 object-cover rounded-lg shadow-md">
                        </div>
                    @endif
                @endisset

                <!-- Pesan error -->
                @error('foto')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>


            <!-- Buttons -->
            <div class="flex justify-between mt-6">
                <button type="submit" class="bg-blue-600 text-white py-2 px-6 rounded-lg hover:bg-blue-700">Simpan</button>
                <a href="{{ route('member.index') }}" class="bg-gray-300 text-gray-800 py-2 px-6 rounded-lg hover:bg-gray-400">Batal</a>
            </div>
        </form>
    </div>

    <!-- Script untuk otomatis mengisi Periode Akhir -->
    <script>
document.getElementById('periode_awal').addEventListener('change', function () {
    const periodeAwal = new Date(this.value); // Ambil tanggal dari Periode Awal
    if (!isNaN(periodeAwal)) { // Pastikan tanggal valid
        const periodeAkhir = new Date(periodeAwal);
        
        // Tambahkan 6 bulan
        periodeAkhir.setMonth(periodeAkhir.getMonth() + 6);

        // Format tanggal ke format YYYY-MM-DD
        const formattedDate = periodeAkhir.toISOString().split('T')[0];
        document.getElementById('periode_akhir').value = formattedDate; // Isi Periode Akhir
    }
});
    
            // No HP validation
            const noHp = document.getElementById('no_hp');
            const noHpError = document.getElementById('noHpError');
            if (noHp.value.trim().length > 14 || noHp.value.trim() === '') {
                noHpError.classList.remove('hidden');
                isValid = false;
            } else {
                noHpError.classList.add('hidden');
            }
            
            // Nama validation
            const nama = document.getElementById('nama');
            const namaError = document.getElementById('namaError');
            if (nama.value.trim().length < 3) {
                namaError.classList.remove('hidden');
                isValid = false;
            } else {
                namaError.classList.add('hidden');
            }
    </script>
</body>
</html>