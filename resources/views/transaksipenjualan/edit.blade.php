<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right, #e3f2fd, #f1f8ff);
        }
        .form-container {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            max-width: 1000px;
            margin: auto;
        }
        .form-container label {
            color: #374151;
            font-weight: bold;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="form-container">
        <h2 class="text-3xl font-bold text-center text-gray-700 mb-6">Edit Transaksi Penjualan</h2>

        <form action="{{ route('transaksipenjualan.update', $transaksi->kode_transaksi) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Nama Member -->
            <div class="mb-6">
                <label class="block text-lg font-semibold mb-2">Nama Member:</label>
                <input type="text" id="nama_member" value="{{ $transaksi->member->nama ?? 'Tidak Ada Member' }}" 
                    class="border p-2 rounded w-full bg-gray-100 text-gray-600" readonly>
            </div>

            <!-- Level Member -->
            <div class="mb-6">
                <label class="block text-lg font-semibold mb-2">Level Member:</label>
                <input type="text" id="levelmember" 
                    value="{{ $transaksi->member->levelmember->tingkatan_level ?? 'N/A' }}" 
                    class="border p-2 rounded w-full bg-gray-100 text-gray-600" readonly>
            </div>

            <!-- Tanggal Transaksi -->
            <div class="mb-6">
                <label for="tanggal_transaksi" class="block text-lg font-semibold mb-2">Tanggal Transaksi:</label>
                <input type="date" id="tanggal_transaksi" name="tanggal_transaksi" 
                    value="{{ $transaksi->tanggal_transaksi ? $transaksi->tanggal_transaksi->format('Y-m-d') : now()->format('Y-m-d') }}"
                    class="border p-2 rounded w-full bg-gray-100 text-gray-600" readonly>
            </div>

            <!-- Produk -->
            <div class="mb-6">
                <label class="block text-lg font-semibold mb-2">Produk:</label>
                <table class="w-full border border-gray-300 rounded-lg overflow-hidden">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="border px-4 py-2 text-left">Produk</th>
                            <th class="border px-4 py-2 text-left">Harga</th>
                            <th class="border px-4 py-2 text-left">Jumlah</th>
                            <th class="border px-4 py-2 text-left">Total</th>
                            <th class="border px-4 py-2 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="produkTable">
                        <tr>
                            <td class="border px-4 py-2">
                                <select name="produk[0][id_produk]" class="produk-select border p-2 rounded w-full focus:ring-2 focus:ring-blue-400" required>
                                    <option value="" disabled selected>Pilih Produk</option>
                                    @foreach ($produks as $produk)
                                        <option value="{{ $produk->id_produk }}" data-harga="{{ $produk->harga }}">{{ $produk->nama_produk }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="border px-4 py-2">
                                <input type="text" class="harga-input border p-2 rounded w-full bg-gray-100 text-gray-600" readonly>
                            </td>
                            <td class="border px-4 py-2">
                                <input type="number" name="produk[0][jumlah]" class="jumlah-input border p-2 rounded w-full focus:ring-2 focus:ring-blue-400" min="1" required>
                            </td>
                            <td class="border px-4 py-2">
                                <input type="text" name="produk[0][subtotal]" class="subtotal-input border p-2 rounded w-full bg-gray-100 text-gray-600" readonly>
                            </td>
                            <td class="border px-4 py-2 text-center">
                                <button type="button" class="remove-row text-red-500 hover:underline">delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <button type="button" id="addRow" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">Tambah Produk</button>
            </div>

            <!-- Subtotal Keseluruhan -->
            <div class="mb-6">
                <label for="subtotal_keseluruhan" class="block text-lg font-semibold mb-2">Subtotal Keseluruhan:</label>
                <input type="text" id="subtotal_keseluruhan" name="subtotal_keseluruhan" 
                    value="{{ $transaksi->subtotal_keseluruhan }}" 
                    class="border p-2 rounded w-full bg-gray-100 text-gray-600" readonly>
            </div>

            <!-- Total Diskon -->
            <div class="mb-6">
                <label for="total_diskon" class="block text-lg font-semibold mb-2">Total Diskon:</label>
                <input type="text" id="total_diskon" name="total_diskon" 
                    value="{{ $transaksi->total_diskon }}" 
                    class="border p-2 rounded w-full bg-gray-100 text-gray-600" readonly>
            </div>

            <!-- Subtotal Setelah Diskon -->
            <div class="mb-6">
                <label for="subtotal_setelah_diskon" class="block text-lg font-semibold mb-2">Subtotal Setelah Diskon:</label>
                <input type="text" id="subtotal_setelah_diskon" name="subtotal_setelah_diskon" 
                    value="{{ $transaksi->subtotal_setelah_diskon }}" 
                    class="border p-2 rounded w-full bg-gray-100 text-gray-600" readonly>
            </div>

            <!-- Nominal Uang Diterima -->
            <div class="mb-6">
                <label for="nominal_uang_diterima" class="block text-lg font-semibold mb-2">Nominal Uang Diterima:</label>
                <input type="number" id="nominal_uang_diterima" name="nominal_uang_diterima" 
                    value="{{ $transaksi->nominal_uang_diterima }}" 
                    class="border p-2 rounded w-full focus:ring-2 focus:ring-blue-400" required>
            </div>

            <!-- Nominal Uang Kembalian -->
            <div class="mb-6">
                <label for="nominal_uang_kembalian" class="block text-lg font-semibold mb-2">Nominal Uang Kembalian:</label>
                <input type="text" id="nominal_uang_kembalian" name="nominal_uang_kembalian" 
                    value="{{ $transaksi->nominal_uang_kembalian }}" 
                    class="border p-2 rounded w-full bg-gray-100 text-gray-600" readonly>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end space-x-4 mt-6">
                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition font-medium">Simpan</button>
                <a href="{{ route('transaksipenjualan.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 transition font-medium">Batal</a>
            </div>
        </form>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const produkTable = document.getElementById('produkTable');
        const subtotalKeseluruhanInput = document.getElementById('subtotal_keseluruhan');
        const totalDiskonInput = document.getElementById('total_diskon');
        const subtotalSetelahDiskonInput = document.getElementById('subtotal_setelah_diskon');
        const nominalUangDiterima = document.getElementById('nominal_uang_diterima');
        const nominalUangKembalian = document.getElementById('nominal_uang_kembalian');
        
        // Fungsi untuk menghitung semua total
        function updateTotals() {
            let totalHarga = 0;

            document.querySelectorAll('.subtotal-input').forEach((el) => {
                totalHarga += parseFloat(el.value) || 0;
            });

            const levelMember = document.getElementById('levelmember').value;
            let diskonRate = 0;
            if (levelMember === 'Bronze') diskonRate = 0.05;
            else if (levelMember === 'Silver') diskonRate = 0.10;
            else if (levelMember === 'Gold') diskonRate = 0.15;

            const totalDiskon = totalHarga * diskonRate;
            const subtotalSetelahDiskon = totalHarga - totalDiskon;

            subtotalKeseluruhanInput.value = totalHarga.toFixed(2);
            totalDiskonInput.value = totalDiskon.toFixed(2);
            subtotalSetelahDiskonInput.value = subtotalSetelahDiskon.toFixed(2);

            updateNominalKembalian();
        }

        function updateNominalKembalian() {
            const uangDiterima = parseFloat(nominalUangDiterima.value) || 0;
            const subtotalSetelahDiskon = parseFloat(subtotalSetelahDiskonInput.value) || 0;

            nominalUangKembalian.value = Math.max(uangDiterima - subtotalSetelahDiskon, 0).toFixed(2);
        }

        produkTable.addEventListener('change', function (e) {
            if (e.target.classList.contains('produk-select')) {
                const harga = e.target.options[e.target.selectedIndex].dataset.harga;
                const row = e.target.closest('tr');
                row.querySelector('.harga-input').value = harga;

                const jumlah = parseFloat(row.querySelector('.jumlah-input').value) || 0;
                const subtotal = harga * jumlah;
                row.querySelector('.subtotal-input').value = subtotal.toFixed(2);

                updateTotals();
            }

            if (e.target.classList.contains('jumlah-input')) {
                const row = e.target.closest('tr');
                const harga = parseFloat(row.querySelector('.harga-input').value) || 0;
                const jumlah = parseFloat(e.target.value) || 0;
                const subtotal = harga * jumlah;
                row.querySelector('.subtotal-input').value = subtotal.toFixed(2);

                updateTotals();
            }
        });
        nominalUangDiterima.addEventListener('input', updateNominalKembalian);
    });
    </script>
</body>
</html>