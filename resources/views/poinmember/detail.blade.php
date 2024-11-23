@extends('layout.sidebar')

@section('content')
<div class="container mt-4">
    <h4 class="text-dark mb-4">Detail Poin Member</h4>

    <!-- Informasi Member -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="mb-3">Informasi Member</h5>
            <p><strong>ID Member:</strong> {{ $member->id_member }}</p>
            <p><strong>Nama:</strong> {{ $member->nama }}</p>
            <p><strong>Total Poin:</strong> {{ $member->poins_sum_total_poin ?? 0 }}</p>
        </div>
    </div>

    <!-- Tabel Transaksi -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="mb-3">Riwayat Transaksi</h5>
            <div class="table-responsive">
                <table class="table table-bordered bg-white">
                    <thead class="table-primary">
                        <tr>
                            <th>No</th>
                            <th>Kode Transaksi</th>
                            <th>Tanggal</th>
                            <th>Total</th>
                            <th>Pegawai</th>
                            <th>Metode Pembayaran</th>
                            <th>Detail Transaksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($member->transaksi as $index => $transaksi)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $transaksi->kode_transaksi }}</td>
                                <td>{{ $transaksi->tanggal_penjualan }}</td>
                                <td>Rp{{ number_format($transaksi->total, 0, ',', '.') }}</td>
                                <td>{{ $transaksi->pegawai->nama ?? 'Tidak Diketahui' }}</td>
                                <td>{{ $transaksi->paymentMethod->nama ?? 'Tidak Diketahui' }}</td>
                                <td>
                                    <!-- Tampilkan detail produk -->
                                    <ul>
                                        @foreach ($transaksi->detailtransaksi as $detail)
                                            <li>{{ $detail->produk->nama_produk }} ({{ $detail->jumlah }} x Rp{{ number_format($detail->harga, 0, ',', '.') }})</li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Belum ada transaksi</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
