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
            <div class="dropdown mb-3"> <!-- Menambahkan margin-bottom untuk jarak vertikal -->
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
                    <input class="form-control me-2" type="search" name="query" placeholder="Search transaksi..." aria-label="Search" value="{{ request('query') }}">
                    <button class="btn btn-outline-success" type="submit">Search</button>
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
                @foreach($transaksipenjualans as $index => $transaksipenjualan)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $transaksipenjualan->tanggal_penjualan }}</td>
                    <td>Rp{{ number_format($transaksipenjualan->nominal_uang_diterima, 0, ',', '.') }}</td>
                    <td>Rp{{ number_format($transaksipenjualan->nominal_uang_kembalian, 0, ',', '.') }}</td>
                    <td>Rp{{ number_format($transaksipenjualan->total, 0, ',', '.') }}</td>
                    <td>{{ $transaksipenjualan->payment_method }}</td>
                    <td>{{ $transaksipenjualan->pegawai ? $transaksipenjualan->pegawai->nama : 'N/A' }}</td>
                    <td>{{ $transaksipenjualan->member ? $transaksipenjualan->member->nama : 'N/A' }}</td>

                    <td class="text-center">
                        <a href="/transaksipenjualan/{{ $transaksipenjualan->kode_transaksi }}/edit" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil"></i>
                        </a>
                        
                        {{-- <a href="/transaksipenjualan/{{ $transaksipenjualan->kode_transaksi }}/detail" class="btn btn-success btn-sm">
                            <i class="bi bi-eye"></i>
                        </a> --}}

                        <a href="/transaksipenjualan/{{ $transaksipenjualan->kode_transaksi }}/cetak" class="btn btn-info btn-sm">
                            <i class="bi bi-printer"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
@endsection

</html>
