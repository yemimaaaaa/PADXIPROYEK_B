<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen p-8">
    <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-6">
        <!-- Header -->
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-gray-700">Detail Transaksi Penjualan</h1>
        </div>

        <!-- Transaksi Information -->
        <div class="mb-4">
            <h2 class="text-lg font-semibold text-gray-600">Informasi Transaksi</h2>
            <div class="grid grid-cols-2 gap-4 mt-2 text-gray-700">
                <p><span class="font-semibold">Kode Transaksi:</span> {{ $transaksi->kode_transaksi }}</p>
                <p><span class="font-semibold">Tanggal Penjualan:</span> {{ $transaksi->tanggal_transaksi }}</p>
                <p><span class="font-semibold">ID Pegawai:</span> {{ $transaksi->pegawai->id_pegawai }}</p>
                <p><span class="font-semibold">Nama Pegawai:</span> {{ $transaksi->pegawai->nama }}</p>
            </div>
        </div>

        <!-- Produk Details -->
        <div class="mb-6">
            <h2 class="text-lg font-semibold text-gray-600">Detail Produk</h2>
            <table class="w-full border-collapse border border-gray-300 mt-4">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="border border-gray-300 px-4 py-2 text-left">Nama Produk</th>
                        <th class="border border-gray-300 px-4 py-2 text-right">Harga</th>
                        <th class="border border-gray-300 px-4 py-2 text-right">Jumlah</th>
                        <th class="border border-gray-300 px-4 py-2 text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transaksi->details as $detail)
                        <tr>
                            <td class="border border-gray-300 px-4 py-2">{{ $detail->produk->nama_produk }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-right">Rp {{ number_format($detail->produk->harga, 0, ',', '.') }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-right">{{ $detail->jumlah }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-right">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-200">
                    <tr>
                        <td colspan="3" class="border border-gray-300 px-4 py-2 text-right font-semibold">Total:</td>
                        <td class="border border-gray-300 px-4 py-2 text-right font-semibold">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Actions -->
        <div class="flex justify-end space-x-4 mt-6">
            <a href="{{ route('transaksipenjualan.index') }}" class="bg-gray-200 text-black px-4 py-2 rounded hover:bg-gray-300 transition">
                Kembali
            </a>
        </div>
    </div>
</body>
</html>
