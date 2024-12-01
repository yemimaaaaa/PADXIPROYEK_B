<!DOCTYPE html>
<html>
<head>
    <title>Laporan Transaksi Penjualan</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f4f4f4;
            text-align: left;
        }
    </style>
</head>
<body>

<h2>Laporan Transaksi Penjualan</h2>

@foreach($laporantransaksis as $transaksi)
    <h4>Kode Transaksi: {{ $transaksi->kode_transaksi }}</h4>
    <p>Nama Member: {{ $transaksi->member->nama ?? 'Tidak Diketahui' }}</p>
    <p>Tanggal: {{ $transaksi->tanggal_penjualan }}</p>
    <p>Total: Rp{{ number_format($transaksi->total, 0, ',', '.') }}</p>
    <p>Metode Pembayaran: {{ $transaksi->payment_method ?? 'Tidak Diketahui' }}</p>
    <p>Pegawai: {{ $transaksi->pegawai->nama ?? 'Tidak Diketahui' }}</p>

    <h5>Detail Transaksi:</h5>
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
            @foreach($transaksi->detailtransaksi as $detail)
                <tr>
                    <td>{{ $detail->produk->nama_produk ?? 'Tidak Diketahui' }}</td>
                    <td>Rp{{ number_format($detail->produk->harga, 0, ',', '.') }}</td>
                    <td>{{ $detail->jumlah }}</td>
                    <td>Rp{{ number_format($detail->produk->harga * $detail->jumlah, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <hr>
@endforeach

</body>
</html>
