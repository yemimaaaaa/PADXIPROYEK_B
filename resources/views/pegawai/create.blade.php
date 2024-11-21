<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Allerta&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Allerta', sans-serif;
        }

        .form-container {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            max-width: 600px;
            margin: 2rem auto;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .form-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .form-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .form-header h2 {
            color: #374151;
            font-size: 2.5rem;
            font-weight: bold;
        }

        .form-container label {
            color: #4b5563;
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: block;
        }

        .form-container input, 
        .form-container select {
            border: 1px solid rgba(2, 62, 138, 0.45);
            background-color: #f9fafb;
            color: #374151;
            padding: 0.75rem;
            border-radius: 8px;
            width: 100%;
            transition: all 0.3s;
        }

        .form-container input:focus, 
        .form-container select:focus {
            border-color: #6366f1;
            box-shadow: 0 0 6px rgba(99, 102, 241, 0.4);
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

        .form-container .error {
            color: #ef4444;
            font-size: 0.875rem;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="form-container">
        <div class="text-3xl font-semibold text-center text-gray-800 mb-6">
            <h2>Tambah Data Pegawai</h2>
        </div>
        <form action="{{ route('pegawai.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Nama -->
            <div class="mb-4">
                <label for="nama">Nama:</label>
                <input type="text" id="nama" name="nama" value="{{ old('nama') }}" placeholder="Masukkan nama pegawai" required>
                @error('nama')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <!-- Username -->
            <div class="mb-4">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="{{ old('username') }}" placeholder="Masukkan username" required>
                @error('username')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Masukkan password" required>
                @error('password')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <!-- Foto -->
            <div class="mb-4">
                <label for="foto">Foto:</label>
                <input type="file" id="foto" name="foto">
                @error('foto')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <!-- No HP -->
            <div class="input-group mb-6">
                <label for="no_hp" class="block text-gray-700 font-medium mb-2">
                    <i class="fas fa-phone mr-2 text-yellow-500"></i>No HP
                </label>
                <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp', $pegawai->no_hp ?? '') }}" class="form-input" placeholder="Masukkan nomor HP" required>
                @error('no_hp')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Masukkan email" required>
                @error('email')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <!-- Role -->
            <div class="mb-4">
                <label for="id_role">Role:</label>
                <select id="id_role" name="id_role" required>
                    <option value="" disabled selected>Pilih Role</option>
                    <option value="10101" {{ old('id_role') == '10101' ? 'selected' : '' }}>Owner</option>
                    <option value="10102" {{ old('id_role') == '10102' ? 'selected' : '' }}>Pegawai</option>
                </select>
                @error('id_role')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex justify-between mt-6">
                <button type="submit">Simpan</button>
                <a href="{{ route('pegawai.index') }}">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>