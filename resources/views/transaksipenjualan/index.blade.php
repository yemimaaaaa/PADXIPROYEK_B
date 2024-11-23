<!DOCTYPE html>
<html lang="en">
@extends('layout.sidebar')

@section('content')
<body class="bg-light">
    <div class="container mt-4">
        <h4 class="text-dark mb-4">Data Transaksi Penjualan</h4>

        <!-- Top Bar -->
        <div class="d-flex flex-column align-items-end mb-4">
            <!-- User Dropdown -->
            <div class="dropdown mb-3">
                <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://github.com/mdo.png" alt="Pegawai" width="40" height="40" class="rounded-circle me-2">
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

            <!-- Create Transaksi Button -->
            <a href="{{ route('transaksipenjualan.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i>Create Transaksi Penjualan
            </a>
        </div>

        <!-- Search Bar -->
        <div class="row align-items-center mb-3">
            <div class="col-md-6">
                <form class="d-flex" action="/transaksipenjualan/search" method="GET">
                    <input class="form-control me-2" type="search" name="query" placeholder="Search Data Transaksi" aria-label="Search" value="{{ request('query') }}">
                    <button class="btn btn-success" type="submit">Search</button>
                </form>
            </div>
        </div>

       <!-- Transaksi Table -->
<table class="table table-bordered table-striped shadow-sm bg-white">
    <thead class="table-primary">
        <tr>
            <th>No.</th>
            <th>Tanggal Penjualan</th>
            <th>Nominal Uang Diterima</th>
            <th>Nominal Uang Kembalian</th>
            <th>Total</th>
            <th>Payment Method</th>
            <th>Pegawai</th>
            <th>Member</th>
            <th class="text-center">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($transaksipenjualans as $index => $transaksipenjualan)
        <tr>
            <td>{{ $loop->iteration + ($transaksipenjualans->currentPage() - 1) * $transaksipenjualans->perPage() }}</td>
            <td>{{ $transaksipenjualan->tanggal_penjualan }}</td>
            <td>Rp{{ number_format($transaksipenjualan->nominal_uang_diterima, 0, ',', '.') }}</td>
            <td>Rp{{ number_format($transaksipenjualan->nominal_uang_kembalian, 0, ',', '.') }}</td>
            <td>Rp{{ number_format($transaksipenjualan->total, 0, ',', '.') }}</td>
            <td>{{ $transaksipenjualan->payment_method }}</td>
            <td>{{ $transaksipenjualan->pegawai ? $transaksipenjualan->pegawai->nama : 'N/A' }}</td>
            <td>{{ $transaksipenjualan->member ? $transaksipenjualan->member->nama : 'N/A' }}</td>
            <td class="text-center">
                <!-- Detail Button -->
                <a href="{{ route('transaksipenjualan.detail', ['kode_transaksi' => $transaksipenjualan->kode_transaksi]) }}" 
                   class="btn btn-warning btn-sm shadow-sm d-flex align-items-center">
                    <i class="bi bi-info-circle me-1"></i> Detail
                </a>

                <!-- Cetak Button -->
                <a href="/transaksipenjualan/{{ $transaksipenjualan->kode_transaksi }}/cetak" 
                   class="btn btn-primary btn-sm shadow-sm d-flex align-items-center mt-1">
                    <i class="bi bi-printer me-1"></i> Cetak
                </a>

                <!-- Hapus Button -->
                <button 
                    type="button" 
                    class="btn btn-danger btn-sm shadow-sm d-flex align-items-center mt-1"
                    onclick="showDeleteModal('{{ $transaksipenjualan->kode_transaksi }}')">
                    <i class="bi bi-trash me-1"></i> Hapus
                </button>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="9" class="text-center">Tidak ada data transaksi.</td>
        </tr>
        @endforelse
    </tbody>
        </table>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $transaksipenjualans->links('pagination::bootstrap-5') }}
        </div>

    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus data transaksi ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form id="deleteForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                    </form>
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

    <!-- Scripts -->
    <script>
        function showDeleteModal(kodeTransaksi) {
            const deleteForm = document.getElementById('deleteForm');
            deleteForm.action = `/transaksipenjualan/${kodeTransaksi}/delete`; // Set action URL
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'), {});
            deleteModal.show();
        }

        // Auto-show Toast Notification
        document.addEventListener('DOMContentLoaded', function () {
            const successToast = document.getElementById('successToast');
            if (successToast) {
                const toast = new bootstrap.Toast(successToast);
                toast.show();
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>

</body>
@endsection
</html>