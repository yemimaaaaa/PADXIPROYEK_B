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
        <h2 class="text-3xl font-bold text-center text-gray-700 mb-6">Tambah Transaksi Penjualan</h2>

        <!-- Pegawai Info -->
        <div class="flex items-center justify-between mb-6">
            <div class="text-lg text-gray-600">
                <span>Pengelola: </span>
                <span class="font-medium text-blue-500">{{ auth()->user()->nama }}</span>
            </div>
            <div class="bg-blue-100 text-blue-500 px-4 py-2 rounded-lg text-sm font-medium">
                ID Pegawai: {{ auth()->user()->id_pegawai }}
            </div>
        </div>

        <form action="{{ route('transaksipenjualan.store') }}" method="POST">
            @csrf

            <!-- Member -->
            <div class="mb-6">
                <label for="id_member" class="block text-lg font-semibold mb-2">Member (Opsional):</label>
                <select id="id_member" name="id_member" class="border p-2 rounded w-full focus:ring-2 focus:ring-blue-400">
                    <option value="" selected data-nama-member="Tidak Ada" data-level-member="N/A">Tanpa Member</option>
                    @foreach ($members as $member)
                        <option value="{{ $member->id_member }}" 
                            data-nama-member="{{ $member->nama }}" 
                            data-level-member="{{ $member->tingkatan_level ?? 'N/A' }}">
                            {{ $member->nama }}
                        </option>
                    @endforeach
                </select>                
            </div>

            <!-- Level Member -->
            <div class="mb-6">
                <label class="block text-lg font-semibold mb-2">Level Member:</label>
                <div class="bg-gray-100 p-4 rounded-lg text-gray-700">
                    Level Member:
                    <span id="level_member">N/A</span>
                </div>
            </div>

            <!-- Tanggal Transaksi -->
            <div class="mb-6">
                <label for="tanggal_penjualan" class="block text-lg font-semibold mb-2">Tanggal Penjualan:</label>
                <input 
                    type="date" 
                    id="tanggal_penjualan" 
                    name="tanggal_penjualan" 
                    class="border p-2 rounded w-full focus:ring-2 focus:ring-blue-400" 
                    value="{{ date('Y-m-d') }}" 
                    required>
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
                                <button type="button" class="remove-row text-red-500 hover:underline">Hapus</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <button type="button" id="addRow" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">Tambah Produk</button>
            </div>

            <!-- Subtotal Keseluruhan -->
            <div class="mb-6">
                <label for="subtotal_keseluruhan_display" class="block text-lg font-semibold mb-2">Subtotal Keseluruhan:</label>
                <input type="text" id="subtotal_keseluruhan_display" class="border p-2 rounded w-full bg-gray-100 text-gray-600" readonly>
                <input type="hidden" id="subtotal_keseluruhan" name="subtotal_keseluruhan" value="0">
            </div>

             <!-- Poin Diterima -->
             <div class="mb-6">
                <label for="poin_diterima" class="block text-lg font-semibold mb-2">Poin Diterima:</label>
                <input type="text" id="poin_diterima" name="poin_diterima" class="border p-2 rounded w-full bg-gray-100 text-gray-600" readonly placeholder="Poin akan dihitung otomatis">
            </div>  

            <!-- Total Diskon -->
            <div class="mb-6">
                <label for="total_diskon_display" class="block text-lg font-semibold mb-2">Total Diskon:</label>
                <input type="text" id="total_diskon_display" class="border p-2 rounded w-full bg-gray-100 text-gray-600" readonly>
                {{-- <input type="hidden" id="total_diskon" name="total_diskon" value="0"> --}}
            </div>

            <!-- Subtotal Setelah Diskon -->
            <div class="mb-6">
                <label for="subtotal_setelah_diskon_display" class="block text-lg font-semibold mb-2">Subtotal Setelah Diskon:</label>
                <input type="text" id="subtotal_setelah_diskon_display" class="border p-2 rounded w-full bg-gray-100 text-gray-600" readonly>
                <input type="hidden" id="subtotal_setelah_diskon" name="subtotal_setelah_diskon" value="0">
            </div>

            <!-- Nominal Uang Diterima -->
            <div class="mb-6">
                <label for="nominal_uang_diterima" class="block text-lg font-semibold mb-2">Nominal Uang Diterima:</label>
                <input type="number" id="nominal_uang_diterima" name="nominal_uang_diterima" class="border p-2 rounded w-full focus:ring-2 focus:ring-blue-400" placeholder="Masukkan nominal uang diterima" required>
            </div>

            <!-- Nominal Uang Kembalian -->
            <div class="mb-6">
                <label for="nominal_uang_kembalian" class="block text-lg font-semibold mb-2">Nominal Uang Kembalian:</label>
                <input type="text" id="nominal_uang_kembalian" name="nominal_uang_kembalian" class="border p-2 rounded w-full bg-gray-100 text-gray-600" readonly>
            </div>

            <!-- Metode Pembayaran -->
            <div class="mb-6">
                <label class="block text-lg font-semibold mb-2">Metode Pembayaran:</label>
                <select name="payment_method" id="payment_method" class="border rounded p-2 w-full">
                    @foreach (\App\Enums\PaymentMethod::cases() as $method)
                        <option value="{{ $method->value }}">{{ ucfirst($method->value) }}</option>
                    @endforeach
                </select>
            </div>

            <input type="hidden" name="id_pegawai" value="{{ auth()->user()->id_pegawai }}">

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
            const memberSelect = document.getElementById('id_member');
            const levelMemberDisplay = document.getElementById('level_member');
            const subtotalKeseluruhanInput = document.getElementById('subtotal_keseluruhan');
            const subtotalKeseluruhanDisplay = document.getElementById('subtotal_keseluruhan_display');
            const totalDiskonInput = document.getElementById('total_diskon');
            const totalDiskonDisplay = document.getElementById('total_diskon_display');
            const subtotalSetelahDiskonInput = document.getElementById('subtotal_setelah_diskon');
            const subtotalSetelahDiskonDisplay = document.getElementById('subtotal_setelah_diskon_display');
            const nominalUangKembalian = document.getElementById('nominal_uang_kembalian');
            const nominalUangDiterima = document.getElementById('nominal_uang_diterima');
    
            let rowIndex = 1;
    
            // Tambahkan baris baru produk
            document.getElementById('addRow').addEventListener('click', function () {
                const newRow = `
                    <tr>
                        <td class="border px-4 py-2">
                            <select name="produk[${rowIndex}][id_produk]" class="produk-select border p-2 rounded w-full focus:ring-2 focus:ring-blue-400" required>
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
                            <input type="number" name="produk[${rowIndex}][jumlah]" class="jumlah-input border p-2 rounded w-full focus:ring-2 focus:ring-blue-400" min="1" required>
                        </td>
                        <td class="border px-4 py-2">
                            <input type="text" name="produk[${rowIndex}][subtotal]" class="subtotal-input border p-2 rounded w-full bg-gray-100 text-gray-600" readonly>
                        </td>
                        <td class="border px-4 py-2 text-center">
                            <button type="button" class="remove-row text-red-500 hover:underline">Hapus</button>
                        </td>
                    </tr>
                `;
                produkTable.insertAdjacentHTML('beforeend', newRow);
                rowIndex++;
            });
    
            // Update harga dan subtotal pada perubahan produk/jumlah
            produkTable.addEventListener('change', function (e) {
                if (e.target.classList.contains('produk-select')) {
                    const harga = e.target.options[e.target.selectedIndex].dataset.harga;
                    const row = e.target.closest('tr');
                    row.querySelector('.harga-input').value = harga;
                    row.querySelector('.jumlah-input').value = 1;
                    const subtotal = parseFloat(harga) || 0;
                    row.querySelector('.subtotal-input').value = subtotal.toFixed(2);
                }
    
                if (e.target.classList.contains('jumlah-input')) {
                    const row = e.target.closest('tr');
                    const jumlah = parseFloat(e.target.value) || 1;
                    const harga = parseFloat(row.querySelector('.harga-input').value) || 0;
                    const subtotal = harga * jumlah;
                    row.querySelector('.subtotal-input').value = subtotal.toFixed(2);
                }
    
                updateTotals();
            });
    
            // Hapus baris produk
            produkTable.addEventListener('click', function (e) {
                if (e.target.classList.contains('remove-row')) {
                    e.target.closest('tr').remove();
                    updateTotals();
                }
            });
    
            // Fungsi untuk menghitung semua total
            function updateTotals() {
                const totalHarga = Array.from(document.querySelectorAll('.subtotal-input'))
                    .reduce((sum, el) => sum + (parseFloat(el.value) || 0), 0);

                document.getElementById('subtotal_keseluruhan_display').value = totalHarga.toFixed(2);
                document.getElementById('subtotal_keseluruhan').value = totalHarga.toFixed(2);

                const memberLevel = document.getElementById('id_member')
                    .options[document.getElementById('id_member').selectedIndex]
                    .getAttribute('data-level-member') || 'N/A';

                let discountRate = 0;
                if (memberLevel === 'Bronze') discountRate = 0.05;
                if (memberLevel === 'Silver') discountRate = 0.10;
                if (memberLevel === 'Gold') discountRate = 0.15;

                const totalDiskon = totalHarga * discountRate;
                const subtotalSetelahDiskon = totalHarga - totalDiskon;

                document.getElementById('total_diskon_display').value = totalDiskon.toFixed(2);
                document.getElementById('subtotal_setelah_diskon_display').value = subtotalSetelahDiskon.toFixed(2);
                document.getElementById('subtotal_setelah_diskon').value = subtotalSetelahDiskon.toFixed(2);

                // Hitung poin berdasarkan subtotal keseluruhan
                const poin = Math.floor(totalHarga / 1000); // Contoh: 1 poin per Rp1000
                document.getElementById('poin_diterima').value = poin;

                document.getElementById('nominal_uang_diterima').dispatchEvent(new Event('input'));
            }

    
            // Update Level Member Display saat member berubah
            memberSelect.addEventListener('change', function () {
                const selectedOption = memberSelect.options[memberSelect.selectedIndex];
                const levelMember = selectedOption.getAttribute('data-level-member') || 'N/A';
                levelMemberDisplay.textContent = levelMember;
    
                updateTotals();
            });
    
            // Hitung uang kembalian
            nominalUangDiterima.addEventListener('input', function () {
                const uangDiterima = parseFloat(nominalUangDiterima.value) || 0;
                const subtotalSetelahDiskon = parseFloat(subtotalSetelahDiskonInput.value) || 0;
                nominalUangKembalian.value = (uangDiterima >= subtotalSetelahDiskon ? uangDiterima - subtotalSetelahDiskon : 0).toFixed(2);
            });
    
            // Validasi sebelum form disubmit
            document.querySelector('form').addEventListener('submit', function (e) {
                updateTotals();
    
                if (parseFloat(subtotalKeseluruhanInput.value) <= 0) {
                    e.preventDefault();
                    alert('Subtotal keseluruhan tidak boleh 0.');
                }
            });
        });
    </script>
    
</body>
</html>
