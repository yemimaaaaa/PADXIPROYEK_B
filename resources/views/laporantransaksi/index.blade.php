@extends('layout.sidebar')

@section('content')
<body class="bg-light">
    <div class="container mt-4">
        <h4 class="text-dark mb-4">Laporan Transaksi Penjualan</h4>

        <!-- Top Bar -->
        <div class="d-flex flex-column align-items-end mb-4">
            <!-- User Dropdown -->
            <div class="dropdown mb-3">
                <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://github.com/mdo.png" alt="Pegawai" width="30" height="30" class="rounded-circle me-2">
                    <span class="fw-bold">{{ auth()->check() ? auth()->user()->nama : 'Guest' }}</span>
                </a>
                <ul class="dropdown-menu shadow dropdown-menu-end">
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Total Penjualan -->
        <div class="card shadow-sm mb-4" style="background-color: #f8f9fa;"> <!-- Warna abu -->
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0" style="color: #212529;"> <!-- Warna teks hitam -->
                        <strong>Total Penjualan:</strong> 
                        <span>Rp{{ number_format($totalPenjualan, 0, ',', '.') }}</span>
                    </h5>
                    <!-- Tombol Eksport -->
                    <div class="d-flex gap-2">
                        <a href="{{ route('laporantransaksi.export.pdf') }}" class="btn btn-danger btn-sm">
                            <i class="bi bi-file-earmark-pdf"></i> Export PDF
                        </a>
                        <a href="{{ route('laporantransaksi.export.excel') }}" class="btn btn-success btn-sm">
                            <i class="bi bi-file-earmark-excel"></i> Export Excel
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search Bar -->
        <div class="row align-items-center mb-3">
            <div class="col-md-6">
                <form class="d-flex" action="/laporantransaksi" method="GET">
                    <input class="form-control me-2" type="search" name="query" placeholder="Search Laporan Transaksi" value="{{ request('query') }}">
                    <button class="btn btn-success" type="submit">
                        Search
                    </button>                    
                </form>
            </div>
            <div class="col-md-6">
                <form class="d-flex gap-2" action="/laporantransaksi" method="GET">
                    <input type="date" class="form-control" name="start_date" placeholder="Tanggal Mulai" value="{{ request('start_date') }}">
                    <input type="date" class="form-control" name="end_date" placeholder="Tanggal Selesai" value="{{ request('end_date') }}">
                    <button class="btn btn-primary">
                        Filter
                    </button>
                </form>
            </div>
        </div>

        <!-- Tabel Data Transaksi -->
        <div class="card shadow-sm mb-5"> <!-- Tambahkan 'mb-5' untuk margin bawah -->
            <div class="card-body">
                <h5 class="card-title text-primary mb-4">Data Transaksi</h5>
                <div class="table-responsive">
                    <table class="table table-bordered bg-white"> <!-- Hapus 'table-striped' -->
                        <thead class="table-primary">
                            <tr>
                                <th>No</th>
                                <th>Kode Transaksi</th>
                                <th>Nama Member</th>
                                <th>Total</th>
                                <th>Tanggal Transaksi</th>
                                <th>Metode Pembayaran</th>
                                <th>Pegawai</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($laporantransaksis as $index => $transaksi)
                                <tr>
                                    <td>{{ $loop->iteration + ($laporantransaksis->currentPage() - 1) * $laporantransaksis->perPage() }}</td>
                                    <td><strong>{{ $transaksi->kode_transaksi }}</strong></td>
                                    <td>{{ $transaksi->member->nama ?? 'Tidak Diketahui' }}</td>
                                    <td>Rp{{ number_format($transaksi->total, 0, ',', '.') }}</td>
                                    <td>{{ $transaksi->tanggal_penjualan }}</td>
                                    <td>{{ $transaksi->payment_method ?? 'Tidak Diketahui' }}</td>
                                    <td>{{ $transaksi->pegawai->nama ?? 'Tidak Diketahui' }}</td>
                                    
                                    <td class="text-center">
                                        <!-- Detail Button -->
                                        <a href="{{ route('laporantransaksi.detail', $transaksi->kode_transaksi) }}" class="btn btn-warning btn-sm shadow-sm">
                                            <i class="bi bi-info-circle"></i> Detail
                                        </a>

                                        <!-- Cetak Nota Button -->
                                        <a href="{{ route('laporantransaksi.cetak', $transaksi->kode_transaksi) }}" class="btn btn-primary btn-sm shadow-sm mt-1">
                                        <i class="bi bi-printer"></i> Cetak Nota Transaksi
                                    </a>
                                </td>
                            </tr>
                        @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted">Tidak ada data transaksi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $laporantransaksis->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    @if(session('success'))
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div id="successToast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    {{ session('success') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
    @endif
</body>
@endsection
