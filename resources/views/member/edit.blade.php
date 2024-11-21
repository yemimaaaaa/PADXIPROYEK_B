<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Allerta&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Allerta', sans-serif;
            background: linear-gradient(to right, #e3f2fd, #f8fafc);
        }

        .form-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            max-width: 600px;
        }

        .form-title {
            color: #2c3e50;
            font-size: 2rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .input-group input,
        .input-group select {
            border: 1px solid #d1d5db;
            padding: 0.75rem;
            border-radius: 8px;
            width: 100%;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .input-group input:focus,
        .input-group select:focus {
            border-color: #007BFF;
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.2);
        }

        .btn-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .btn-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            background-color: #007BFF;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-secondary {
            background-color: #e5e7eb;
            color: #374151;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
        }

        .btn-secondary:hover {
            background-color: #d1d5db;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white shadow-2xl rounded-lg p-10 max-w-2xl w-full">
        <h2 class="text-4xl font-bold text-center text-gray-800 mb-8">Edit Data Member</h2>

        <form action="{{ route('member.update', $member->id_member) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- ID Member -->
            <div class="input-group mb-6">
                <label for="id_member" class="block text-gray-700 font-medium mb-2">
                    <i class="fas fa-id-badge mr-2 text-blue-500"></i>ID Member
                </label>
                <input type="text" id="id_member" name="id_member" value="{{ $member->id_member }}" class="form-input bg-gray-100 cursor-not-allowed" readonly>
            </div>

            <!-- Nama Member -->
            <div class="input-group mb-6">
                <label for="nama" class="block text-gray-700 font-medium mb-2">
                    <i class="fas fa-user mr-2 text-green-500"></i>Nama Member
                </label>
                <input type="text" id="nama" name="nama" value="{{ old('nama', $member->nama) }}" class="form-input" placeholder="Masukkan nama member" required>
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
            <div class="input-group mb-6">
                <label for="periode_awal" class="block text-gray-700 font-medium mb-2">
                    <i class="fas fa-calendar-alt mr-2 text-purple-500"></i>Periode Awal
                </label>
                <input type="date" id="periode_awal" name="periode_awal" value="{{ old('periode_awal', $member->periode_awal) }}" class="form-input" required>
            </div>

            <!-- Periode Akhir -->
            <div class="input-group mb-6">
                <label for="periode_akhir" class="block text-gray-700 font-medium mb-2">
                    <i class="fas fa-calendar-check mr-2 text-indigo-500"></i>Periode Akhir
                </label>
                <input type="date" id="periode_akhir" name="periode_akhir" value="{{ old('periode_akhir', $member->periode_akhir) }}" class="form-input" readonly>
            </div>

            <!-- Foto Membeer -->
            <div class="mb-4">
                <label for="foto">Foto:</label>
                <input type="file" id="foto" name="foto">
             <!-- Menampilkan foto saat ini jika ada -->
                @if ($member->foto)
                    <div class="mt-4">
                        <img src="{{ asset($member->foto) }}" alt="Foto Member" class="w-32 h-32 object-cover rounded-lg shadow-md">
                    </div>
                @endif
            </div>
                
            <!-- Level Member -->
            <div class="input-group mb-6">
                <label for="id_level_member" class="block text-gray-700 font-medium mb-2">
                    <i class="fas fa-layer-group mr-2 text-pink-500"></i>Level Member
                </label>
                <select id="id_level_member" name="id_level_member" class="form-input" required>
                    <option value="" disabled>Pilih Level Member</option>
                    <option value="1001" {{ old('id_level_member', $member->id_level_member) == '1001' ? 'selected' : '' }}>Bronze</option>
                    <option value="1002" {{ old('id_level_member', $member->id_level_member) == '1002' ? 'selected' : '' }}>Silver</option>
                    <option value="1003" {{ old('id_level_member', $member->id_level_member) == '1003' ? 'selected' : '' }}>Gold</option>
                </select>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-between mt-8">
                <button type="submit" class="btn-primary btn-hover">
                    Simpan
                </button>
                <a href="{{ route('member.index') }}" class="btn-secondary btn-hover">
                    Batal
                </a>
            </div>
        </form>

        <!-- Script untuk otomatis mengisi Periode Akhir -->
        <script>
            document.getElementById('periode_awal').addEventListener('change', function () {
                const periodeAwal = new Date(this.value); // Ambil tanggal dari Periode Awal
                if (!isNaN(periodeAwal)) { // Pastikan tanggal valid
                    const periodeAkhir = new Date(periodeAwal);
                    periodeAkhir.setMonth(periodeAkhir.getMonth() + 6); // Tambahkan 6 bulan
                    const formattedDate = periodeAkhir.toISOString().split('T')[0]; // Format tanggal ke format YYYY-MM-DD
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
    </div>
</body>
</html>