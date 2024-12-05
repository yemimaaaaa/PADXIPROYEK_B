<table>
    <thead>
        <tr>
            <th>Kode Transaksi</th>
            <th>Nama Member</th>
            <th>Tanggal Transaksi</th>
            <th>Total</th>
            <th>Metode Pembayaran</th>
            <th>Pegawai</th>
            <th>Nama Produk</th> <!-- Kolom Nama Produk -->
            <th>Harga Produk</th> <!-- Kolom Harga Produk -->
            <th>Jumlah Produk</th> <!-- Kolom Jumlah Produk -->
            <th>Total Produk</th> <!-- Kolom Total Produk -->
        </tr>
    </thead>
    <tbody>
        @foreach($laporantransaksis as $transaksi)
        <tr class="transaksi-row">
            <td>{{ $transaksi->kode_transaksi }}</td>
            <td>{{ $transaksi->member->nama ?? 'Tidak Diketahui' }}</td>
            <td>{{ $transaksi->tanggal_penjualan }}</td>
            <td>Rp{{ number_format($transaksi->total, 0, ',', '.') }}</td>
            <td>{{ $transaksi->payment_method ?? 'Tidak Diketahui' }}</td>
            <td>{{ $transaksi->pegawai->nama ?? 'Tidak Diketahui' }}</td>
            <td></td> <!-- Nama Produk di baris berikutnya -->
            <td></td> <!-- Harga Produk di baris berikutnya -->
            <td></td> <!-- Jumlah Produk di baris berikutnya -->
            <td></td> <!-- Total Produk di baris berikutnya -->
        </tr>
        
        <!-- Detail Transaksi (dalam baris baru) -->
        @foreach($transaksi->detailtransaksi as $detail)
        <tr class="detail-row">
            <td></td>  <!-- Kosongkan kolom untuk menunjukkan bahwa ini adalah detail -->
            <td></td>  <!-- Kosongkan kolom Nama Member -->
            <td></td>  <!-- Kosongkan kolom Tanggal -->
            <td></td>  <!-- Kosongkan kolom Total -->
            <td></td>  <!-- Kosongkan kolom Metode Pembayaran -->
            <td></td>  <!-- Kosongkan kolom Pegawai -->
            
            <!-- Detail Produk -->
            <td>{{ $detail->produk->nama_produk ?? 'Tidak Diketahui' }}</td> <!-- Nama Produk -->
            <td>Rp{{ number_format($detail->produk->harga, 0, ',', '.') }}</td> <!-- Harga Produk -->
            <td>{{ $detail->jumlah }}</td> <!-- Jumlah Produk -->
            <td>Rp{{ number_format($detail->produk->harga * $detail->jumlah, 0, ',', '.') }}</td> <!-- Total Produk -->
        </tr>
        @endforeach
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="9"><strong>Total Penjualan</strong></td>
            <td>Rp{{ number_format($laporantransaksis->sum('total'), 0, ',', '.') }}</td>
        </tr>
    </tfoot>
</table>
