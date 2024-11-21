<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
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
            max-width: 800px;
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
            <h2>Edit Pegawai</h2>
        </div>

        <form action="{{ route('pegawai.update', $pegawai->id_pegawai) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- ID Pegawai -->
            <div class="mb-4">
                <label for="id_pegawai">ID Pegawai:</label>
                <input type="text" id="id_pegawai" name="id_pegawai" value="{{ $pegawai->id_pegawai }}" readonly class="bg-gray-100 cursor-not-allowed">
            </div>

            <!-- Nama -->
            <div class="mb-4">
                <label for="nama">Nama:</label>
                <input type="text" id="nama" name="nama" value="{{ old('nama', $pegawai->nama) }}" required>
            </div>

            <!-- Username -->
            <div class="mb-4">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="{{ old('username', $pegawai->username) }}" required>
                <p id="usernameError" class="text-red-500 hidden">Username sudah terdaftar atau belum diisi.</p>
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password">
                    Password <span class="text-blue-600">(Opsional)</span>:
                </label>
                <input type="password" id="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah password">
            </div>

            <!-- Foto -->
            <div class="mb-4">
                <label for="foto">Foto:</label>
                <input type="file" id="foto" name="foto">
             <!-- Menampilkan foto saat ini jika ada -->
                @if ($pegawai->foto)
                    <div class="mt-4">
                        <img src="{{ asset($pegawai->foto) }}" alt="Foto Pegawai" class="w-32 h-32 object-cover rounded-lg shadow-md">
                    </div>
                @endif
            </div>

            <!-- No HP -->
            <div class="mb-4">
                <label for="no_hp">No HP:</label>
                <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp', $pegawai->no_hp ?? '') }}" placeholder="Masukkan nomor HP" required>
                @error('no_hp')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            

            <!-- Email -->
            <div class="mb-4">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="{{ old('email', $pegawai->email) }}" required>
            </div>

            <!-- Role -->
            <div class="mb-4">
                <label for="id_role">Role:</label>
                <select id="id_role" name="id_role" required>
                    <option value="10101" {{ old('id_role', $pegawai->id_role) == '10101' ? 'selected' : '' }}>Owner</option>
                    <option value="10102" {{ old('id_role', $pegawai->id_role) == '10102' ? 'selected' : '' }}>Pegawai</option>
                </select>
            </div>

            <!-- Buttons -->
            <div class="flex justify-between mt-6">
                <button type="submit">Simpan Perubahan</button>
                <a href="{{ route('pegawai.index') }}">Batal</a>
            </div>
        </form>
    </div>
    <script>
        function validateForm() {
            let isValid = true;

            // Nama validation
            const nama = document.getElementById('nama');
            const namaError = document.getElementById('namaError');
            if (nama.value.trim().length < 3) {
                namaError.classList.remove('hidden');
                isValid = false;
            } else {
                namaError.classList.add('hidden');
            }

            document.getElementById('username').addEventListener('blur', function () {
                const username = this.value.trim();
                const usernameError = document.getElementById('usernameError');
                
                if (username === '') {
                    usernameError.textContent = "Username tidak boleh kosong.";
                    usernameError.classList.remove('hidden');
                } else {
                    // Buat permintaan AJAX untuk memeriksa apakah username sudah ada
                    fetch(`/check-username?username=${username}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.exists) {
                                usernameError.textContent = "Username sudah terdaftar.";
                                usernameError.classList.remove('hidden');
                            } else {
                                usernameError.classList.add('hidden');
                            }
                        })
                        .catch(error => console.error('Error:', error));
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

            // Email validation
            const email = document.getElementById('email');
            const emailError = document.getElementById('emailError');
            if (!email.value.includes('@') || email.value.trim() === '') {
                emailError.classList.remove('hidden');
                isValid = false;
            } else {
                emailError.classList.add('hidden');
            }

            return isValid;
        }
    </script>
</body>
</html>
