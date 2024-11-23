@extends('layout.sidebar')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-center text-primary">Detail Transaksi</h2>

    <!-- Informasi Utama Transaksi -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="card-title text-primary">Informasi Transaksi</h5>
            <p><strong>Kode Transaksi:</strong> {{ $transaksi->kode_transaksi }}</p>
            <p><strong>Nama Member:</strong> {{ $transaksi->member->nama ?? 'Tidak Diketahui' }}</p>
            <p><strong>Tingkatan Member:</strong> {{ $transaksi->member->levelmember->tingkatan_level ?? 'Tidak Diketahui' }}</p>
            <p><strong>Tanggal Transaksi:</strong> {{ $transaksi->tanggal_penjualan }}</p>
            <p><strong>Metode Pembayaran:</strong> {{ $transaksi->payment_method ?? 'Tidak Diketahui' }}</p>
            <p><strong>Pegawai:</strong> {{ $transaksi->pegawai->nama ?? 'Tidak Diketahui' }}</p>
        </div>
    </div>

    <!-- Detail Produk -->
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title text-primary">Detail Produk</h5>
            @if($detailtransaksi->isNotEmpty())
                <table class="table table-bordered">
                    <thead class="table-primary">
                        <tr>
                            <th>Nama Produk</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($detailtransaksi as $detail)
                            <tr>
                                <td>{{ $detail->nama_produk }}</td>
                                <td>{{ $detail->jumlah }}</td>
                                <td>Rp{{ number_format($detail->harga, 0, ',', '.') }}</td>
                                <td>Rp{{ number_format($detail->harga * $detail->jumlah, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-muted">Tidak ada detail produk.</p>
            @endif
        </div>
    </div>

    <!-- Ringkasan Perhitungan -->
    <div class="card shadow-sm mt-4">
        <div class="card-body">
            <h5 class="card-title text-primary">Ringkasan Perhitungan</h5>
            <p><strong>Subtotal:</strong> Rp{{ number_format($subtotal, 0, ',', '.') }}</p>
            <p><strong>Diskon ({{ $diskonRate * 100 }}%):</strong> Rp{{ number_format($totalDiskon, 0, ',', '.') }}</p>
            <p><strong>Subtotal Setelah Diskon:</strong> Rp{{ number_format($subtotalSetelahDiskon, 0, ',', '.') }}</p>
            <p><strong>Poin Diterima:</strong> {{ $poinDiterima }}</p>
        </div>
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('laporantransaksi.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>
@endsection
