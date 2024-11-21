<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Transaksi</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .nota-container {
            max-width: 600px;
            margin: 30px auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border: 1px solid #e0e0e0;
        }
        .nota-header {
            background-color: #3a87ad; /* Biru pastel */
            color: #fff;
            padding: 20px;
            text-align: center;
        }
        .nota-header h1 {
            margin: 0;
            font-size: 22px;
            font-weight: bold;
        }
        .nota-header p {
            margin: 5px 0;
            font-size: 14px;
        }
        .nota-body {
            padding: 20px;
        }
        h3 {
            margin-top: 15px;
            margin-bottom: 10px;
            color: #3a87ad; /* Warna biru pastel */
            font-size: 16px;
            border-bottom: 2px solid #3a87ad;
            display: inline-block;
            padding-bottom: 4px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 14px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #e0e0e0;
            text-align: left;
        }
        th {
            background-color: #f5f9fc; /* Warna latar biru lembut */
            color: #333;
            font-weight: bold;
        }
        .summary-table th {
            text-align: right;
        }
        .summary-table td {
            text-align: left;
        }
        .total-row {
            font-weight: bold;
            font-size: 16px;
            color: #3a87ad;
        }
        .footer {
            text-align: center;
            padding: 15px;
            background-color: #f5f9fc; /* Warna latar biru lembut */
            color: #555;
            font-size: 14px;
            border-top: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <div class="nota-container">
        <!-- Header -->
        <div class="nota-header">
            <h1>Nota Transaksi</h1>
            <p>Kode Transaksi: <strong>{{ $transaksi->kode_transaksi }}</strong></p>
            <p>{{ $transaksi->tanggal_penjualan }}</p>
        </div>

        <!-- Body -->
        <div class="nota-body">
            <!-- Detail Transaksi -->
            <h3>Informasi Transaksi</h3>
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
                    <th>Pegawai</th>
                    <td>{{ $transaksi->pegawai->nama }}</td>
                </tr>
                <tr>
                    <th>Pembayaran</th>
                    <td>{{ ucfirst($transaksi->payment_method->value ?? $transaksi->payment_method) }}</td>
                </tr>
            </table>

            <!-- Produk -->
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

            <!-- Ringkasan -->
            <h3>Ringkasan Transaksi</h3>
            <table class="summary-table">
                <tr>
                    <th>Subtotal:</th>
                    <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Diskon:</th>
                    <td>Rp {{ number_format($totalDiskon ?? 0, 0, ',', '.') }}</td>
                </tr>
                <tr class="total-row">
                    <th>Total Setelah Diskon:</th>
                    <td>Rp {{ number_format($totalSetelahDiskon ?? 0, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Poin Diterima:</th>
                    <td>{{ $poinDiterima ?? 0 }}</td>
                </tr>
                <tr>
                    <th>Uang Diterima:</th>
                    <td>Rp {{ number_format($transaksi->nominal_uang_diterima, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Uang Kembalian:</th>
                    <td>Rp {{ number_format($transaksi->nominal_uang_kembalian, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Terima kasih atas kunjungannya ke Basado F&D!</p>
        </div>
    </div>
</body>
</html>
