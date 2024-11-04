<!DOCTYPE html>
<html lang="en">
@extends('layout.sidebar')

@section('content')
    <body>

        <div class="container mt-2">
            <h2>Data Transaksi Penjualan</h2>
                            <!-- Dropdown positioned at the top-right corner -->
                            <div class="dropdown user-dropdown mt-4 pb-4">
                                <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                                    <!-- Display Pegawai photo if available, otherwise use a default image -->
                                    <img src="{{ auth()->user()->pegawai && auth()->user()->pegawai->foto ? asset('/pegawaii.jpg' . auth()->user()->pegawai->foto) : asset('pegawaibisayok.jpeg') }}" 
                                        alt="Pegawai" width="30" height="30" class="rounded-square">
                                    <!-- Display Pegawai name if available, otherwise show 'Guest' -->
                                </a>
                                <ul class="dropdown-menu dropdown-menu-dark text-small shadow text-left">
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-white bg-transparent border-0 d-flex align-items-center">
                                                <i class="bi bi-box-arrow-right"></i>
                                                <span class="ms-2">Logout</span>
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
            <div class="row align-items-center mb-3">
            <div class="col text-start"> <!-- Aligns search to the left -->
            <form class="d-flex" action="/transaksipenjualan/search" method="GET" style="justify-content: flex-start;">
                        <input class="form-control me-2" type="search" name="query" placeholder="Search" aria-label="Search" style="width: 200px;" value="{{ request('query') }}">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                </div>
                <div class="col text-end">
                <button type="button" class="btn btn-primary">Create</button>
                </div>
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Tanggal Penjualan</th>
                        <th>Nominal Uang Diterima</th>
                        <th>Nominal Uang Kembalian</th>
                        <th>Subtotal</th>
                        <th>Payment Method</th>
                        <th>Pegawai</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($transaksipenjualans as $index => $transaksipenjualan)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $transaksipenjualan->tanggal_penjualan }}</td>
                        <td>{{ $transaksipenjualan->nominal_uang_diterima }}</td>
                        <td>{{ $transaksipenjualan->nominal_uang_kembalian }}</td>
                        <td>{{ $transaksipenjualan->subtotal }}</td>
                        <td>{{ $transaksipenjualan->payment_method }}</td>
                        <td>{{ $transaksipenjualan->pegawai ? $transaksipenjualan->pegawai->nama : 'N/A' }}</td> <!-- Updated to access pegawai -->
                        <td class="action-icons">
                        <a href="/transaksipenjualan/{{ $transaksipenjualan->kode_transaksi }}/edit" class="bi bi-pen me-2 text-dark"></a>
                        <a href="/transaksipenjualan/{{ $transaksipenjualan->kode_transaksi }}/cetak" class="bi bi-printer text-dark"></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </body>
@endsection

</html>
