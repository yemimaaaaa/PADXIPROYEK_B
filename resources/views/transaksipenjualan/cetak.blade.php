{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Transaksi</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: #f9f9f9;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .nota-container {
            max-width: 800px;
            margin: 20px auto;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border: 1px solid #ddd;
        }
        .nota-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .nota-header h1 {
            font-size: 24px;
            margin: 0;
            font-weight: bold;
        }
        .nota-header .brand {
            font-size: 18px;
            color: #007bff;
            margin: 5px 0;
        }
        .nota-header .details {
            font-size: 14px;
            color: #555;
        }
        .nota-section {
            margin-bottom: 20px;
        }
        .nota-section table {
            width: 100%;
            border-collapse: collapse;
        }
        .nota-section table th,
        .nota-section table td {
            padding: 8px 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .nota-section table th {
            font-weight: bold;
            background: #f4f4f4;
        }
        .nota-footer {
            text-align: center;
            margin-top: 20px;
            color: #555;
        }
        .nota-footer p {
            margin: 0;
            font-size: 14px;
        }
        .summary {
            margin-top: 20px;
        }
        .summary table {
            width: 100%;
            border-collapse: collapse;
        }
        .summary table td {
            padding: 8px 10px;
        }
        .summary .total-row {
            font-weight: bold;
            border-top: 2px solid #ddd;
        }
        .highlight {
            color: #007bff;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="nota-container">
        <!-- Header -->
        <div class="nota-header">
            <h1>Nota Transaksi</h1>
            <p class="brand">Basado Food & Drink</p>
            <div class="details">
                Kode Transaksi: <span class="highlight">{{ $transaksi->kode_transaksi }}</span> | Tanggal: {{ $transaksi->tanggal_transaksi }}
            </div>
        </div>

        <!-- Detail Transaksi -->
        <div class="nota-section">
            <table>
                <tr>
                    <td>Nama Pegawai</td>
                    <td>{{ $transaksi->pegawai->nama }}</td>
                </tr>
                <tr>
                    <td>Member</td>
                    <td>{{ $transaksi->member->nama ?? 'Tanpa Member' }}</td>
                </tr>
                <tr>
                    <td>Level Member</td>
                    <td>{{ $transaksi->member->level->tingkatan_level ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Diskon Member</td>
                    <td>{{ $transaksi->diskon ? $transaksi->member->level->diskon . '%' : '0%' }}</td>
                </tr>
                <tr>
                    <td>Point Number</td>
                    <td>{{ $transaksi->member->id_member ?? '-' }}</td>
                </tr>
            </table>
        </div>

        <!-- Produk -->
        <div class="nota-section">
            <h3>Produk</h3>
            <table>
                <thead>
                    <tr>
                        <th>Kode Produk</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transaksipenjualan->detail as $detail)
                    <tr>
                        <td>{{ $detail->produk->kode_produk }}</td>
                        <td>{{ $detail->produk->nama_produk }}</td>
                        <td>Rp {{ number_format($detail->produk->harga, 0, ',', '.') }}</td>
                        <td>{{ $detail->jumlah }}</td>
                        <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Summary -->
        <div class="summary">
            <table>
                <tr>
                    <td>Sub Total (Qty {{ $transaksi->total_qty }})</td>
                    <td>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Diskon Member</td>
                    <td>- Rp {{ number_format($transaksi->diskon, 0, ',', '.') }}</td>
                </tr>
                <tr class="total-row">
                    <td>Total Setelah Diskon</td>
                    <td>Rp {{ number_format($transaksi->total_harga - $transaksi->diskon, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Metode Pembayaran</td>
                    <td>{{ $transaksi->payment_method }}</td>
                </tr>
                <tr>
                    <td>Nominal Uang Diterima</td>
                    <td>Rp {{ number_format($transaksi->nominal_uang_diterima, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Nominal Uang Kembalian</td>
                    <td>Rp {{ number_format($transaksi->nominal_uang_kembalian, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Earned Point</td>
                    <td>{{ $transaksi->earned_point }}</td>
                </tr>
                <tr>
                    <td>Closing Point</td>
                    <td>{{ $transaksi->closing_point }}</td>
                </tr>
            </table>
        </div>

        <!-- Footer -->
        <div class="nota-footer">
            <p>Terima kasih telah berbelanja di Basado Food & Drink!</p>
        </div>
    </div>
</body>
</html> --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Transaksi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .nota-container {
            max-width: 800px;
            margin: 20px auto;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        .nota-header {
            text-align: center;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .nota-header h1 {
            font-size: 24px;
            color: #007bff;
            margin: 0;
        }
        .nota-header p {
            margin: 0;
            color: #555;
        }
        .nota-details {
            margin-bottom: 20px;
        }
        .nota-details table {
            width: 100%;
            border-collapse: collapse;
        }
        .nota-details td {
            padding: 8px 5px;
            border-bottom: 1px solid #ddd;
        }
        .nota-details td:first-child {
            font-weight: bold;
            color: #333;
        }
        .nota-details td:last-child {
            text-align: right;
            color: #555;
        }
        .nota-footer {
            text-align: center;
            margin-top: 20px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="nota-container">
        <div class="nota-header">
            <h1>Nota Transaksi</h1>
            <p>Kode Transaksi: <strong>{{ $transaksi->kode_transaksi }}</strong></p>
        </div>

        <div class="nota-details">
            <h2 class="text-xl font-bold text-gray-700 mb-4">Detail Transaksi</h2>
            <table>
                <tr>
                    <td>Tanggal Transaksi</td>
                    <td>{{ $transaksi->tanggal_transaksi }}</td>
                </tr>
                <tr>
                    <td>Member</td>
                    <td>{{ $transaksi->member->nama ?? 'Tanpa Member' }}</td>
                </tr>
                <tr>
                    <td>Level Member</td>
                    <td>{{ $transaksi->member->level->tingkatan_level ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Total Harga</td>
                    <td>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Total Diskon</td>
                    <td>Rp {{ number_format($transaksi->diskon, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Harga Setelah Diskon</td>
                    <td>Rp {{ number_format($transaksi->total_harga - $transaksi->diskon, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Nominal Uang Diterima</td>
                    <td>Rp {{ number_format($transaksi->nominal_uang_diterima, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Nominal Uang Kembalian</td>
                    <td>Rp {{ number_format($transaksi->nominal_uang_kembalian, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Metode Pembayaran</td>
                    <td>{{ $transaksi->payment_method }}</td>
                </tr>
                <tr>
                    <td>Nama Pegawai</td>
                    <td>{{ $transaksi->pegawai->nama }}</td>
                </tr>
            </table>
        </div>

        <div class="nota-footer">
            <p>Terima kasih telah berbelanja!</p>
        </div>
    </div>
</body>
</html>
