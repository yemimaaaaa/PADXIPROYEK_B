<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Allerta&display=swap" rel="stylesheet" />
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

        .text-red-500 {
            color: #f87171;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="form-container">
        <h2 class="text-4xl font-bold text-center text-gray-800 mb-8">Tambah Data Produk</h2>

        <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Nama Produk -->
            <div class="mb-6">
                <label for="nama_produk">Nama Produk:</label>
                <input type="text" id="nama_produk" name="nama_produk" placeholder="Masukkan Nama Produk" value="{{ old('nama_produk') }}" required>
                @if ($errors->has('nama_produk'))
                    <p class="text-red-500 text-sm mt-2">{{ $errors->first('nama_produk') }}</p>
                @endif
            </div>

            <!-- Jenis Produk -->
            <div class="mb-6">
                <label for="jenis_produk">Jenis Produk:</label>
                <select id="jenis_produk" name="jenis_produk" required>
                    <option value="beverages" {{ old('jenis_produk') == 'beverages' ? 'selected' : '' }}>Beverages</option>
                    <option value="desserts" {{ old('jenis_produk') == 'desserts' ? 'selected' : '' }}>Desserts</option>
                    <option value="main course" {{ old('jenis_produk') == 'main course' ? 'selected' : '' }}>Main Course</option>
                </select>
                @if ($errors->has('jenis_produk'))
                    <p class="text-red-500 text-sm mt-2">{{ $errors->first('jenis_produk') }}</p>
                @endif
            </div>

            <!-- Harga Produk -->
            <div class="mb-6">
                <label for="harga">Harga Produk:</label>
                <input type="number" id="harga" name="harga" placeholder="Masukkan Harga Produk" value="{{ old('harga') }}" required>
                @if ($errors->has('harga'))
                    <p class="text-red-500 text-sm mt-2">{{ $errors->first('harga') }}</p>
                @endif
            </div>

            <!-- Foto Produk -->
            <div class="mb-6">
                <label for="foto_produk">Foto Produk:</label>
                <input type="file" id="foto_produk" name="foto_produk" required>
                @if ($errors->has('foto_produk'))
                    <p class="text-red-500 text-sm mt-2">{{ $errors->first('foto_produk') }}</p>
                @endif
            </div>

            <!-- Deskripsi Produk -->
            <div class="mb-6">
                <label for="deskripsi_produk">Deskripsi Produk:</label>
                <textarea id="deskripsi_produk" name="deskripsi_produk" placeholder="Masukkan Deskripsi Produk">{{ old('deskripsi_produk') }}</textarea>
                @if ($errors->has('deskripsi_produk'))
                    <p class="text-red-500 text-sm mt-2">{{ $errors->first('deskripsi_produk') }}</p>
                @endif
            </div>

            <!-- Pesan Error Global -->
            {{-- @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    <strong class="font-bold">Perhatian!</strong>
                    <span class="block sm:inline">{{ $errors->first() }}</span>
                </div>
            @endif --}}

            <!-- Action Buttons -->
            <div class="flex justify-between mt-6">
                <button type="submit">Simpan</button>
                <a href="/produk">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>
