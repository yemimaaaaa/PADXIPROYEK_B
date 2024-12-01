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
        <div class="card shadow-sm mb-4">
            <div class="card-body d-flex justify-content-between align-items-center">
                <h5 class="card-title text-dark mb-0"><strong>Total Penjualan: </strong>Rp{{ number_format($totalPenjualan, 0, ',', '.') }}</h5>
                <div class="d-flex gap-2">
                    <a href="{{ route('laporantransaksi.grafik') }}" class="btn btn-info btn-sm">
                        <i class="bi bi-bar-chart"></i> Grafik Penjualan
                    </a>
                    <a href="{{ route('laporantransaksi.export.pdf') }}" class="btn btn-danger btn-sm">
                        <i class="bi bi-file-earmark-pdf"></i> Ecport PDF
                    </a>
                    <a href="{{ route('laporantransaksi.export.excel') }}" class="btn btn-success btn-sm">
                        <i class="bi bi-file-earmark-excel"></i> Export Excel
                    </a>
                </div>
            </div>
        </div>

        <!-- Search Filter -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h5 class="card-title mb-3 text-primary">Filter Pencarian</h5>
                <div class="row">
                    <!-- Tanggal Mulai -->
                    <div class="col-md-4 mb-3">
                        <label for="start_date" class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="start_date" value="{{ request('start_date') ?? \Carbon\Carbon::now()->startOfMonth()->toDateString() }}">
                    </div>

                    <!-- Tanggal Selesai -->
                    <div class="col-md-4 mb-3">
                        <label for="end_date" class="form-label">Tanggal Selesai</label>
                        <input type="date" class="form-control" id="end_date" value="{{ request('end_date') ?? \Carbon\Carbon::now()->endOfMonth()->toDateString() }}">
                    </div>

                    <!-- Pencarian Kode Transaksi / Nama Member -->
                    <div class="col-md-4 mb-3">
                        <label for="query" class="form-label">Cari Kode / Nama Member</label>
                        <input type="text" id="query" class="form-control" value="{{ request('query') }}" placeholder="Search laporan transaksi..">
                    </div>
                </div>

                <!-- Tombol Pencarian -->
                <div class="d-flex justify-content-end">
                    <button type="button" id="searchButton" class="btn btn-primary">Search</button>
                </div>
            </div>
        </div>

        <!-- Data Transaksi -->
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title text-primary mb-4">Data Transaksi</h5>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-primary">
                            <tr>
                                <th>No</th>
                                <th>Kode Transaksi</th>
                                <th>Nama Member</th>
                                <th>Total</th>
                                <th>Tanggal Penjualan</th>
                                <th>Payment Method</th>
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
                                        <a href="{{ route('laporantransaksi.detail', $transaksi->kode_transaksi) }}" class="btn btn-warning btn-sm">
                                            <i class="bi bi-info-circle"></i> Detail Transaksi
                                        </a>

                                        <!-- Cetak Nota Button -->
                                        <a href="{{ route('laporantransaksi.cetak', $transaksi->kode_transaksi) }}" class="btn btn-primary btn-sm mt-1">
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

<script>
    document.getElementById('searchButton').addEventListener('click', function() {
        // Ambil nilai input dari field
        var startDate = document.getElementById('start_date').value;
        var endDate = document.getElementById('end_date').value;
        var query = document.getElementById('query').value;

        // Buat URL pencarian dengan query string
        var url = '{{ route('laporantransaksi.index') }}?start_date=' + startDate + '&end_date=' + endDate + '&query=' + query;

        // Redirect ke URL pencarian
        window.location.href = url;
    });
</script>

@endsection
