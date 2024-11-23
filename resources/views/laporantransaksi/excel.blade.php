<table>
    <thead>
        <tr>
            <th>Kode Transaksi</th>
            <th>Nama Member</th>
            <th>Tanggal Transaksi</th>
            <th>Total</th>
            <th>Metode Pembayaran</th>
            <th>Pegawai</th>
        </tr>
    </thead>
    <tbody>
        @foreach($laporantransaksis as $transaksi)
        <tr>
            <td>{{ $transaksi->kode_transaksi }}</td>
            <td>{{ $transaksi->member->nama ?? 'Tidak Diketahui' }}</td>
            <td>{{ $transaksi->tanggal_penjualan }}</td>
            <td>Rp{{ number_format($transaksi->total, 0, ',', '.') }}</td>
            <td>{{ $transaksi->payment_method ?? 'Tidak Diketahui' }}</td>
            <td>{{ $transaksi->pegawai->nama ?? 'Tidak Diketahui' }}</td>
        </tr>
        <tr>
            <td colspan="6">
                <strong>Detail:</strong>
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
            </td>
        </tr>
        @endforeach
    </tbody>
</table>