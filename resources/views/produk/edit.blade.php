<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Allerta&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Allerta', sans-serif;
            background: linear-gradient(to bottom right, #e3f2fd, #e0e7ff);
        }

        .card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            max-width: 600px;
            width: 100%;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #374151;
            font-weight: bold;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 0.75rem;
            border-radius: 8px;
            border: 1px solid rgba(156, 163, 175, 0.5);
            font-size: 0.9rem;
            background-color: #f9fafb;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #4f46e5;
            box-shadow: 0 0 6px rgba(79, 70, 229, 0.4);
        }

        .form-group .error-message {
            margin-top: 0.5rem;
            font-size: 0.875rem;
            color: #f87171;
        }

        .form-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 1.5rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: linear-gradient(to right, #4f46e5, #9333ea);
            color: white;
        }

        .btn-primary:hover {
            background: linear-gradient(to right, #3730a3, #6d28d9);
            transform: translateY(-2px);
        }

        .btn-secondary {
            background-color: #e5e7eb;
            color: #374151;
        }

        .btn-secondary:hover {
            background-color: #d1d5db;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen">
    <div class="card">
        <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Edit Produk</h2>
        <form id="editForm" action="{{ route('produk.update', $produk->id_produk) }}" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
            @csrf
            @method('PUT')

            <!-- Kode Produk -->
            <div class="form-group">
                <label for="id_produk">Kode Produk:</label>
                <input type="text" id="id_produk" name="id_produk" value="{{ $produk->id_produk }}" readonly class="bg-gray-100 cursor-not-allowed">
            </div>

            <!-- Nama Produk -->
            <div class="form-group">
                <label for="nama_produk">Nama Produk:</label>
                <input type="text" id="nama_produk" name="nama_produk" value="{{ old('nama_produk', $produk->nama_produk) }}" required>
                @error('nama_produk')
                <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            <!-- Jenis Produk -->
            <div class="form-group">
                <label for="jenis_produk">Jenis Produk:</label>
                <select id="jenis_produk" name="jenis_produk" required>
                    <option value="beverages" {{ $produk->jenis_produk == 'beverages' ? 'selected' : '' }}>Beverages</option>
                    <option value="desserts" {{ $produk->jenis_produk == 'desserts' ? 'selected' : '' }}>Desserts</option>
                    <option value="main course" {{ $produk->jenis_produk == 'main course' ? 'selected' : '' }}>Main Course</option>
                </select>
            </div>
            <!-- Harga Produk -->
            <div class="form-group">
                <label for="harga">Harga Produk:</label>
                <input type="text" id="harga" name="harga" value="{{ $produk->harga }}" required>
            </div>
            <!-- Foto Produk -->
            <div class="form-group">
                <label for="foto_produk">Foto Produk:</label>
                <input type="file" id="foto_produk" name="foto_produk">
                @if($produk->foto_produk)
                <div class="mt-4">
                    <img src="{{ asset($produk->foto_produk) }}" alt="Foto Produk" class="w-32 h-32 object-cover rounded-lg shadow-md">
                </div>
                @endif
            </div>
            <!-- Deskripsi Produk -->
            <div class="form-group">
                <label for="deskripsi_produk">Deskripsi Produk:</label>
                <textarea id="deskripsi_produk" name="deskripsi_produk" rows="4" required>{{ $produk->deskripsi_produk }}</textarea>
            </div>
            <!-- Tombol Aksi -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Update Produk</button>
                <a href="/produk" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>