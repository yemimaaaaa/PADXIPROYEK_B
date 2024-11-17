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
                <label for="tanggal_transaksi" class="block text-lg font-semibold mb-2">Tanggal Transaksi:</label>
                <input type="date" id="tanggal_transaksi" name="tanggal_transaksi" class="border p-2 rounded w-full focus:ring-2 focus:ring-blue-400" required>
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
                <input type="text" id="subtotal_keseluruhan" name="subtotal_keseluruhan" class="border p-2 rounded w-full bg-gray-100 text-gray-600" readonly>
            </div>

            <!-- Poin Diterima -->
            <div class="mb-6">
                <label for="poin_diterima" class="block text-lg font-semibold mb-2">Poin Diterima:</label>
                <input type="text" id="poin_diterima" name="poin_diterima" class="border p-2 rounded w-full bg-gray-100 text-gray-600" readonly placeholder="Poin akan dihitung otomatis">
            </div>            

            <!-- Nominal Uang -->
            <div class="mb-6">
                <label for="nominal_uang_diterima" class="block text-lg font-semibold mb-2">Nominal Uang Diterima:</label>
                <input type="number" id="nominal_uang_diterima" name="nominal_uang_diterima" class="border p-2 rounded w-full focus:ring-2 focus:ring-blue-400" placeholder="Masukkan nominal uang diterima" required>
            </div>

            <div class="mb-6">
                <label for="nominal_uang_kembalian" class="block text-lg font-semibold mb-2">Nominal Uang Kembalian:</label>
                <input type="text" id="nominal_uang_kembalian" name="nominal_uang_kembalian" class="border p-2 rounded w-full bg-gray-100 text-gray-600" readonly placeholder="Uang kembalian akan dihitung otomatis">
            </div>

            <!-- Total Diskon -->
            <div class="mb-6">
                <label for="total_diskon" class="block text-lg font-semibold mb-2">Total Diskon:</label>
                <input type="text" id="total_diskon" name="total_diskon" class="border p-2 rounded w-full bg-gray-100 text-gray-600" readonly placeholder="Diskon akan dihitung otomatis">
            </div>

            <!-- Metode Pembayaran -->
            <div class="mb-6">
                <label class="block text-lg font-semibold mb-2">Metode Pembayaran:</label>
                <div class="flex space-x-4">
                    <div>
                        <input type="radio" id="cash" name="payment_method" value="Cash" class="hidden peer" required>
                        <label for="cash" class="cursor-pointer bg-blue-100 px-4 py-2 rounded-lg shadow hover:bg-blue-200 peer-checked:bg-blue-500 peer-checked:text-white">Cash</label>
                    </div>
                    <div>
                        <input type="radio" id="e-wallet" name="payment_method" value="E-Wallet" class="hidden peer" required>
                        <label for="e-wallet" class="cursor-pointer bg-blue-100 px-4 py-2 rounded-lg shadow hover:bg-blue-200 peer-checked:bg-blue-500 peer-checked:text-white">E-Wallet</label>
                    </div>
                    <div>
                        <input type="radio" id="debit" name="payment_method" value="Debit" class="hidden peer" required>
                        <label for="debit" class="cursor-pointer bg-blue-100 px-4 py-2 rounded-lg shadow hover:bg-blue-200 peer-checked:bg-blue-500 peer-checked:text-white">Debit</label>
                    </div>
                </div>
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
            let rowIndex = 1;
    
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
                            <button type="button" class="remove-row text-red-500">delete</button>
                        </td>
                    </tr>
                `;
                produkTable.insertAdjacentHTML('beforeend', newRow);
                rowIndex++;
            });
    
            produkTable.addEventListener('click', function (e) {
                if (e.target.classList.contains('remove-row')) {
                    e.target.closest('tr').remove();
                    updateSubtotalKeseluruhan();
                }
            });
    
            produkTable.addEventListener('change', function (e) {
                if (e.target.classList.contains('produk-select')) {
                    const harga = e.target.options[e.target.selectedIndex].dataset.harga;
                    const row = e.target.closest('tr');
                    row.querySelector('.harga-input').value = harga;
                }
    
                if (e.target.classList.contains('jumlah-input')) {
                    const row = e.target.closest('tr');
                    const harga = parseFloat(row.querySelector('.harga-input').value) || 0;
                    const jumlah = parseFloat(e.target.value) || 0;
                    const subtotal = harga * jumlah;
                    row.querySelector('.subtotal-input').value = subtotal.toFixed(2);
                }
    
                updateSubtotalKeseluruhan();
            });
    
            function calculateDiskon(subtotal, id_level_member) {
            let diskonRate = 0;

            switch (id_level_member) {
                case '1': // Bronze
                    diskonRate = 0.05;
                    break;
                case '2': // Silver
                    diskonRate = 0.15;
                    break;
                case '3': // Gold
                    diskonRate = 0.25;
                    break;
                default:
                    diskonRate = 0; // Tidak ada diskon
            }

            return subtotal * diskonRate;
        }


            function calculatePoin(subtotal) {
                const subtotalInt = Math.floor(subtotal);
                const poin = Math.floor(subtotalInt / 1000);
                return poin;
            }
            
            function updateSubtotalKeseluruhan() {
            const totalHarga = Array.from(document.querySelectorAll('.subtotal-input'))
                .reduce((sum, el) => sum + (parseFloat(el.value) || 0), 0);

            const memberElement = document.getElementById('id_member');
            const selectedOption = memberElement.options[memberElement.selectedIndex];
            const id_level_member = selectedOption.dataset.idLevel || null; // Ambil data-id-level dari opsi

            const totalDiskon = calculateDiskon(totalHarga, id_level_member);
            const totalHargaSetelahDiskon = totalHarga - totalDiskon;

            document.getElementById('subtotal_keseluruhan').value = totalHarga.toFixed(2);
            document.getElementById('total_diskon').value = totalDiskon.toFixed(2);

            const nominalUangDiterima = parseFloat(document.getElementById('nominal_uang_diterima').value) || 0;
            const kembalian = nominalUangDiterima - totalHargaSetelahDiskon;
            document.getElementById('nominal_uang_kembalian').value = kembalian > 0 ? kembalian.toFixed(2) : 0;

            const poin = calculatePoin(totalHargaSetelahDiskon);
            document.getElementById('poin_diterima').value = poin;
        }
        
                document.addEventListener('DOMContentLoaded', function () {
                    const memberSelect = document.getElementById('id_member');
                    const displayNamaMember = document.getElementById('display_nama_member');
                    const displayLevelMember = document.getElementById('level_member');

                memberSelect.addEventListener('change', function () {
                    const selectedOption = memberSelect.options[memberSelect.selectedIndex];
                    const namaMember = selectedOption.getAttribute('data-nama-member');
                    const levelMember = selectedOption.getAttribute('data-level-member');

                    // Perbarui tampilan nama dan level member
                    displayNamaMember.textContent = namaMember || 'Tidak Ada';
                    displayLevelMember.textContent = levelMember || 'N/A';
                });
            });
    
            document.getElementById('nominal_uang_diterima').addEventListener('input', function () {
                updateSubtotalKeseluruhan();
            });
    
            document.getElementById('id_member').addEventListener('change', function () {
                updateSubtotalKeseluruhan();
            });
        });
    </script>    
</body>
</html>
