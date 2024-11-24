@extends('layout.sidebar')

@section('content')
<div class="container mt-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="text-dark fw-bold">Detail Poin Member</h4>
        <a href="{{ route('poinmember.index') }}" class="btn btn-secondary d-flex align-items-center">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
    </div>

    <!-- Informasi Member -->
    <div class="card mb-4 shadow border-0 rounded-4">
        <div class="card-body">
            <h5 class="text-primary fw-bold mb-3">
                <i class="fas fa-user-circle me-2"></i> Informasi Member
            </h5>
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="bg-light p-3 rounded shadow-sm">
                        <p class="mb-1"><strong>ID Member:</strong></p>
                        <p class="fw-bold text-gray-700">{{ $member->id_member }}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="bg-light p-3 rounded shadow-sm">
                        <p class="mb-1"><strong>Nama:</strong></p>
                        <p class="fw-bold text-gray-700">{{ $member->nama }}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="bg-light p-3 rounded shadow-sm">
                        <p class="mb-1"><strong>Total Poin:</strong></p>
                        <span class="badge bg-success fs-5 px-3 py-2 shadow-sm">
                            {{ $member->poins_sum_total_poin ?? 0 }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Transaksi -->
    <div class="card shadow border-0 rounded-4">
        <div class="card-body">
            <h5 class="text-primary fw-bold mb-3">
                <i class="fas fa-list-alt me-2"></i> Riwayat Transaksi
            </h5>
            <div class="table-responsive">
                <table class="table align-middle text-center">
                    <thead class="bg-secondary-subtle text-dark">
                        <tr>
                            <th>No</th>
                            <th>Kode Transaksi</th>
                            <th>Tanggal Penjualan</th>
                            <th class="text-end">Total</th>
                            <th>Pegawai</th>
                            <th>Payment Method</th>
                            <th>Detail Produk </th>
                            <th class="text-end">Subtotal Setelah Diskon</th>
                            <th class="text-end">Poin Diterima</th>
                        </tr>
                    </thead>
                    <tbody class="bg-light text-dark">
                        @forelse ($transaksiPenjualans as $index => $transaksi)
                            <tr class="{{ $loop->odd ? 'bg-white' : 'bg-secondary-subtle' }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $transaksi->kode_transaksi }}</td>
                                <td>{{ \Carbon\Carbon::parse($transaksi->tanggal_penjualan)->format('d-m-Y') }}</td>
                                <td class="text-end text-success">Rp{{ number_format($transaksi->total, 0, ',', '.') }}</td>
                                <td>{{ $transaksi->nama_pegawai ?? 'Tidak Diketahui' }}</td>
                                <td>{{ $transaksi->payment_method ?? 'Tidak Diketahui' }}</td>
                                <td class="text-start">
                                    @if($transaksi->detail_produk)
                                        <ul class="list-unstyled mb-0">
                                            @foreach (explode(',', $transaksi->detail_produk) as $detail)
                                                <li><i class="fas fa-check-circle text-success me-1"></i>{{ $detail }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <span class="text-muted">Tidak ada detail produk</span>
                                    @endif
                                </td>
                                <td class="text-end">Rp{{ number_format($transaksi->total_poin, 0, ',', '.') }}</td>
                                <td class="text-end text-primary fw-bold">{{ $transaksi->poin_diterima }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted">Belum ada transaksi</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
