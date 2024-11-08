<!DOCTYPE html>
<html lang="en">
@extends('layout.sidebar')

@section('content')
    <body>

        <div class="container mt-2">
            <h2>Data Transaksi Penjualan</h2>
            <div class="d-flex justify-content-end align-items-center">
                <div class="dropdown border rounded shadow p-2 bg-light">
                    <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://github.com/mdo.png" alt="Pegawai" width="30" height="30" class="rounded-circle me-2">
                        <span class="d-none d-sm-inline mx-1">({{ auth()->check() ? auth()->user()->nama : 'Guest' }})</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow">
                        {{-- <li><a class="dropdown-item text-dark" href="/profile">Profile</a></li> --}}
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="m-0">
                                @csrf
                                <button type="submit" class="dropdown-item text-dark">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
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
