<!DOCTYPE html>
<html lang="en">
{{-- @extends('layout.sidebar')

@section('content') --}}

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
        }

        .form-container label {
            color: #374151;
            font-weight: bold;
        }

        .form-container input, 
        .form-container select, 
        .form-container textarea {
            border: 1px solid rgba(2, 62, 138, 0.45);
            background-color: #f8fafc;
            color: #374151;
            padding: 0.75rem;
            border-radius: 8px;
            width: 100%;
            transition: all 0.3s;
        }

        .form-container input:focus, 
        .form-container select:focus, 
        .form-container textarea:focus {
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

        .pengelola-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            background-color: #f1f5f9;
            padding: 0.75rem;
            border-radius: 12px;
        }

        .pengelola-info span {
            font-size: 0.9rem;
            font-weight: 600;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="form-container">
        <h2 class="text-4xl font-bold text-center text-gray-800 mb-8">Edit Stok</h2>

        <!-- Pengelola Info -->
        <div class="pengelola-info">
            <span>Pengelola: <span class="text-blue-500">{{ auth()->user()->nama }}</span></span>
            <span>ID Pegawai: <span class="text-blue-500">{{ auth()->user()->id_pegawai }}</span></span>
        </div>

        <form action="{{ route('stok.update', $stok->id_stok) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Hidden Field for ID Pegawai -->
            <input type="hidden" name="id_pegawai" value="{{ auth()->user()->id_pegawai }}" />

            <!-- ID Stok (Read-only) -->
            <div class="mb-6">
                <label for="id_stok">ID Stok:</label>
                <input type="text" id="id_stok" name="id_stok" value="{{ $stok->id_stok }}" readonly class="bg-gray-100 cursor-not-allowed">
            </div>

            <!-- Nama Stok -->
            <div class="mb-6">
                <label for="nama_stok">Nama Stok:</label>
                <input type="text" id="nama_stok" name="nama_stok" value="{{ old('nama_stok', $stok->nama_stok) }}" required>
                @error('nama_stok')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>


            <!-- Jenis Stok -->
            <div class="mb-6">
                <label for="jenis_stok">Jenis Stok:</label>
                <select id="jenis_stok" name="jenis_stok" required>
                    <option value="biji kopi" {{ $stok->jenis_stok == 'biji kopi' ? 'selected' : '' }}>Biji Kopi</option>
                    <option value="bahan pokok" {{ $stok->jenis_stok == 'bahan pokok' ? 'selected' : '' }}>Bahan Pokok</option>
                    <option value="bahan campuran" {{ $stok->jenis_stok == 'bahan campuran' ? 'selected' : '' }}>Bahan Campuran</option>
                    <option value="snack" {{ $stok->jenis_stok == 'snack' ? 'selected' : '' }}>Snack</option>
                    <option value="minuman" {{ $stok->jenis_stok == 'minuman' ? 'selected' : '' }}>Minuman</option>
                </select>
            </div>

            <!-- Tanggal Masuk Stok -->
            <div class="mb-6">
                <label for="tanggal_masuk_stok">Tanggal Masuk Stok:</label>
                <input type="date" id="tanggal_masuk_stok" name="tanggal_masuk_stok" value="{{ $stok->tanggal_masuk_stok }}" required>
            </div>

            <!-- Foto Stok -->
            <div class="mb-6">
                <label for="foto_stok">Foto Stok:</label>
                <input type="file" id="foto_stok" name="foto_stok">
                
                @if($stok->foto_stok)
                    <div class="mt-4">
                        <img src="{{ asset($stok->foto_stok) }}" alt="Foto Stok" class="w-32 h-32 object-cover rounded-lg shadow-md">
                    </div>
                @endif
            </div>

            <!-- Detail Stok -->
            <div class="mb-6">
                <label for="detail_stok">Detail Stok:</label>
                <textarea id="detail_stok" name="detail_stok" class="h-32" required>{{ $stok->detail_stok }}</textarea>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-between mt-6">
                <button type="submit">Update Stok</button>
                <a href="{{ route('stok.index') }}">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>