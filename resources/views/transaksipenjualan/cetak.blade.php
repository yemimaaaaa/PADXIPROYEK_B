<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Transaksi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .nota-container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        .nota-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .nota-header h1 {
            margin: 0;
            font-size: 24px;
            color: #007bff;
        }
        .nota-header p {
            margin: 5px 0 0 0;
            color: #555;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f3f4f6;
        }
        .total {
            font-weight: bold;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="nota-container">
        <!-- Header Nota -->
        <div class="nota-header">
            <h1>Nota Transaksi</h1>
            <p>Kode Transaksi: <strong>{{ $transaksi->kode_transaksi }}</strong></p>
            <p>Tanggal Transaksi: {{ $transaksi->tanggal_penjualan }}</p>
        </div>

        <!-- Detail Transaksi -->
        <h3>Detail Transaksi</h3>
        <table>
            <tr>
                <th>Member</th>
                <td>{{ $transaksi->member->nama ?? 'Tanpa Member' }}</td>
            </tr>
            <tr>
                <th>Level Member</th>
                <td>{{ $transaksi->member->levelmember->tingkatan_level ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Nama Pegawai</th>
                <td>{{ $transaksi->pegawai->nama }}</td>
            </tr>
            <tr>
                <th>Metode Pembayaran</th>
                <td>{{ ucfirst($transaksi->payment_method->value ?? $transaksi->payment_method) }}</td>
            </tr>
        </table>

        <!-- Daftar Produk -->
        <h3>Detail Produk</h3>
        <table>
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transaksi->detailtransaksi as $detail)
                <tr>
                    <td>{{ $detail->produk->nama_produk ?? 'Produk tidak ditemukan' }}</td>
                    <td>Rp {{ number_format($detail->produk->harga ?? 0, 0, ',', '.') }}</td>
                    <td>{{ $detail->jumlah }}</td>
                    <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>            
        </table>

        <!-- Ringkasan Transaksi -->
        <h3>Ringkasan Transaksi</h3>
        <table>
            <tr>
                <th>Subtotal</th>
                <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Diskon</th>
                <td>Rp {{ number_format($totalDiskon ?? 0, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Total Setelah Diskon</th>
                <td>Rp {{ number_format($totalSetelahDiskon ?? 0, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Poin Diterima</th>
                <td>{{ $poinDiterima ?? 0 }}</td>
            </tr>
             <!-- Nominal Uang Diterima -->
             <div class="flex flex-col">
                <label class="text-gray-600 font-semibold mb-1">Nominal Uang Diterima:</label>
                <div class="bg-gray-100 p-3 rounded-lg shadow-sm text-gray-600">
                    Rp{{ number_format($transaksi->nominal_uang_diterima, 0, ',', '.') }}
                </div>
            </div>
        
            <!-- Nominal Uang Kembalian -->
            <div class="flex flex-col">
                <label class="text-gray-600 font-semibold mb-1">Nominal Uang Kembalian:</label>
                <div class="bg-gray-100 p-3 rounded-lg shadow-sm text-gray-600">
                    Rp{{ number_format($transaksi->nominal_uang_kembalian, 0, ',', '.') }}
                </div>
            </div>
        </table>

        <!-- Footer -->
        <p style="text-align: center; margin-top: 20px;">Terima kasih telah berbelanja di toko kami!</p>
    </div>
</body>
</html>
