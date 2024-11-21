<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right, #f3f4f6, #e5e7eb);
        }
        .container {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            max-width: 1000px;
            margin: auto;
        }
        .header {
            background-color: #2563eb;
            color: white;
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
             }
        .header h2 {
            font-size: 1.75rem;
        }
        .btn-primary {
            background-color: #3b82f6;
            color: white;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #2563eb;
        }
        .btn-secondary {
            background-color: #f9fafb;
            color: #374151;
            transition: all 0.3s ease;
        }
        .btn-secondary:hover {
            background-color: #f3f4f6;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-100 to-gray-50 min-h-screen flex items-center justify-center">
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h2>Detail Transaksi Penjualan</h2>
        </div>
        <!-- Informasi Transaksi -->
        <div class="grid grid-cols-2 gap-6 mb-8">
            <div>
                <h3 class="text-lg font-semibold text-gray-700">Kode Transaksi:</h3>
                <p class="text-xl font-bold text-blue-500">{{ $transaksi->kode_transaksi }}</p>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-700">Pegawai:</h3>
                <p class="text-gray-700">{{ $transaksi->pegawai->nama }}</p>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-700">Member:</h3>
                <p class="text-gray-700">{{ $transaksi->member ? $transaksi->member->nama : 'Tanpa Member' }}</p>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-700">Level Member:</h3>
                <p class="text-gray-700">{{ optional($transaksi->member->levelmember)->tingkatan_level ?? 'Tidak Ada Level' }}</p>
            </div>            
            <div>
                <h3 class="text-lg font-semibold text-gray-700">Tanggal Penjualan:</h3>
                <p class="bg-gray-100 p-3 rounded-lg text-gray-600 shadow">{{ $transaksi->tanggal_penjualan }}</p>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-700">Metode Pembayaran:</h3>
                <p class="bg-gray-100 p-3 rounded-lg text-gray-600 shadow">{{ $transaksi->payment_method }}</p>
            </div>
        </div>

        <!-- Tabel Produk -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold text-gray-700 mb-3">Produk yang Dibeli:</h3>
            <div class="overflow-hidden rounded-lg border border-gray-300 shadow-md">
                <table class="w-full text-left">
                    <thead class="bg-blue-100 text-gray-700">
                        <tr>
                            <th class="px-4 py-2">Produk</th>
                            <th class="px-4 py-2">Harga</th>
                            <th class="px-4 py-2">Jumlah</th>
                            <th class="px-4 py-2">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transaksi->detailtransaksi as $detail)
                        <tr class="even:bg-gray-100">
                            <td class="px-4 py-2">{{ $detail->produk->nama_produk ?? 'Produk tidak ditemukan' }}</td>
                            <td class="px-4 py-2">Rp{{ number_format($detail->produk->harga ?? 0, 0, ',', '.') }}</td>
                            <td class="px-4 py-2">{{ $detail->jumlah }}</td>
                            <td class="px-4 py-2">Rp{{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Detail Harga -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <div class="p-4 bg-gray-100 rounded-lg shadow-sm">
                    <h4 class="text-gray-700 font-semibold">Total:</h4>
                    <p class="text-lg text-gray-600">Rp{{ number_format($subtotal, 0, ',', '.') }}</p>
                </div>
                <div class="p-4 bg-gray-100 rounded-lg shadow-sm">
                    <h4 class="text-gray-700 font-semibold">Total Diskon:</h4>
                    <p class="text-lg text-gray-600">Rp{{ number_format($totalDiskon, 0, ',', '.') }}</p>
                </div>
                <div class="p-4 bg-gray-100 rounded-lg shadow-sm">
                    <h4 class="text-gray-700 font-semibold">Subtotal Setelah Diskon:</h4>
                    <p class="text-lg text-gray-600">Rp{{ number_format($subtotalSetelahDiskon, 0, ',', '.') }}</p>
                </div>
                <div class="p-4 bg-gray-100 rounded-lg shadow-sm">
                    <h4 class="text-gray-700 font-semibold">Nominal Uang Diterima:</h4>
                    <p class="text-lg text-gray-600">Rp{{ number_format($transaksi->nominal_uang_diterima, 0, ',', '.') }}</p>
                </div>
                <div class="p-4 bg-gray-100 rounded-lg shadow-sm">
                    <h4 class="text-gray-700 font-semibold">Nominal Uang Kembalian:</h4>
                    <p class="text-lg text-gray-600">Rp{{ number_format($transaksi->nominal_uang_kembalian, 0, ',', '.') }}</p>
                </div>
                <div class="p-4 bg-gray-100 rounded-lg shadow-sm">
                    <h4 class="text-gray-700 font-semibold">Poin yang Diterima:</h4>
                    <p class="text-lg text-gray-600">{{ $poinDiterima }}</p>
                </div>
            </div>

        <!-- Tombol Aksi -->
        <div class="flex justify-center space-x-4">
            <a href="{{ route('transaksipenjualan.index') }}" class="btn-secondary px-6 py-2 rounded-lg shadow hover:shadow-md">
                Kembali
            </a>
            <a href="{{ route('transaksipenjualan.cetak', ['kode_transaksi' => $transaksi->kode_transaksi]) }}" class="btn-primary px-6 py-2 rounded-lg shadow hover:shadow-md">
                Cetak Nota
            </a>
        </div>
    </div>
</body>
</html>