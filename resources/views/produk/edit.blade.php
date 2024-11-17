<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Allerta&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Allerta', sans-serif; /* Menggunakan font Allerta */
        }

        .btn-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }

        .border-red-500 {
            border-color: #f87171 !important;
        }

        .hidden {
            display: none;
        }
    </style>
</head>
<body class="bg-gradient-to-r from-blue-100 via-indigo-100 to-purple-100 min-h-screen flex items-center justify-center">

    <div class="bg-white shadow-2xl rounded-lg p-10 max-w-3xl w-full">
        <h2 class="text-4xl font-bold text-center text-gray-800 mb-8">Edit Produk</h2>
        
        <!-- Tempat untuk pesan kesalahan -->
        <div id="errorMessage" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6">
            <strong class="font-bold">Peringatan:</strong>
            <span id="errorText" class="block sm:inline"></span>
        </div>

        <form id="updateForm" action="{{ route('produk.update', $produk->id_produk) }}" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
            @csrf
            @method('PUT')

            <!-- Kode Produk (Read-only) -->
            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-2">Kode Produk:</label>
                <input type="text" value="{{ $produk->id_produk }}" class="border border-gray-300 p-3 w-full rounded-lg bg-gray-100" readonly>
            </div>

            <!-- Nama Produk -->
            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-2">Nama Produk:</label>
                <input type="text" name="nama_produk" value="{{ $produk->nama_produk }}" class="border border-gray-300 p-3 w-full rounded-lg focus:ring-2 focus:ring-blue-500" required>
            </div>

            <!-- Jenis Produk -->
            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-2">Jenis Produk:</label>
                <select name="jenis_produk" class="border border-gray-300 p-3 w-full rounded-lg focus:ring-2 focus:ring-blue-500" required>
                    <option value="beverages" {{ $produk->jenis_produk == 'beverages' ? 'selected' : '' }}>Beverages</option>
                    <option value="desserts" {{ $produk->jenis_produk == 'desserts' ? 'selected' : '' }}>Desserts</option>
                    <option value="main course" {{ $produk->jenis_produk == 'main course' ? 'selected' : '' }}>Main Course</option>
                </select>
            </div>

            <!-- Harga Produk -->
            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-2">Harga Produk:</label>
                <input type="text" name="harga" value="{{ $produk->harga }}" class="border border-gray-300 p-3 w-full rounded-lg focus:ring-2 focus:ring-green-500 bg-green-50" required>
            </div>

            <!-- Foto Produk -->
            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-2">Foto Produk:</label>
                <input type="file" name="foto_produk" class="border border-gray-300 p-3 w-full rounded-lg">
                
                <!-- Menampilkan foto saat ini jika ada -->
                @if($produk->foto_produk)
                    <div class="mt-4">
                        <img src="{{ asset($produk->foto_produk) }}" alt="Foto Produk" class="w-32 h-32 object-cover rounded-lg shadow-md">
                    </div>
                @endif
            </div>

            <!-- Deskripsi Produk -->
            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-2">Deskripsi Produk:</label>
                <textarea name="deskripsi_produk" class="border border-gray-300 p-3 w-full rounded-lg h-32 focus:ring-2 focus:ring-blue-500" required>{{ $produk->deskripsi_produk }}</textarea>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex justify-between mt-8">
                <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-lg shadow-md transition duration-300 hover:bg-blue-700 btn-hover focus:outline-none focus:ring-2 focus:ring-blue-400">
                    Update Produk
                </button>
                <a href="/produk" class="bg-gray-300 text-gray-800 px-8 py-3 rounded-lg shadow-md transition duration-300 hover:bg-gray-400 btn-hover focus:outline-none focus:ring-2 focus:ring-gray-200">
                    Batal
                </a>
            </div>            
        </form>
    </div>

    <script>
        function validateForm() {
            const namaProduk = document.querySelector('input[name="nama_produk"]');
            const harga = document.querySelector('input[name="harga"]');
            const deskripsi = document.querySelector('textarea[name="deskripsi_produk"]');
            const fotoProduk = document.querySelector('input[name="foto_produk"]');
            const errorMessage = document.getElementById('errorMessage');
            const errorText = document.getElementById('errorText');
            let isValid = true;
            let message = "";

            // Validasi Nama Produk
            if (namaProduk.value.trim() === "" || namaProduk.value.length < 3) {
                isValid = false;
                message += "- Nama produk harus diisi dan minimal 3 karakter.<br>";
                namaProduk.classList.add("border-red-500");
            } else {
                namaProduk.classList.remove("border-red-500");
            }
            // Validasi Harga
            if (!/^\d+$/.test(harga.value.trim())) {
                isValid = false;
                message += "- Harga produk harus berupa angka.<br>";
                harga.classList.add("border-red-500");
            } else {
                harga.classList.remove("border-red-500");
            }

            // Validasi Deskripsi Produk
            if (deskripsi.value.trim() === "") {
                isValid = false;
                message += "- Deskripsi produk harus diisi.<br>";
                deskripsi.classList.add("border-red-500");
            } else {
                deskripsi.classList.remove("border-red-500");
            }
            // Tampilkan pesan kesalahan
            if (!isValid) {
                errorText.innerHTML = message;
                errorMessage.classList.remove("hidden");
                return false;
            }
            // Sembunyikan pesan jika validasi berhasil
            errorMessage.classList.add("hidden");
            return true;
        }
    </script>
</body>
</html>
