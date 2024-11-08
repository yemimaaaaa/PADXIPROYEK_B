<!DOCTYPE html>
<html lang="en">
@extends('layout.sidebar')

@section('content')
    <style>
        /* Gaya untuk memastikan gambar tidak melebar dan menyesuaikan dengan kolom */
        .card img {
            aspect-ratio: 16 / 9;
            width: 100%;
            object-fit: cover;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        /* Sesuaikan tinggi gambar pada layar yang lebih kecil */
        @media (max-width: 600px) {
            .card img {
                max-height: 280px;
            }
        }
    </style>
    <body>
        <div class="container mt-2">
            <h2>Data Stok</h2>
            <div class="d-flex justify-content-end align-items-center">
                <div class="dropdown border rounded shadow p-2 bg-light">
                    <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://github.com/mdo.png" alt="Pegawai" width="30" height="30" class="rounded-circle me-2">
                        <span class="d-none d-sm-inline mx-1">({{ auth()->check() ? auth()->user()->nama : 'Guest' }})</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow">
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="m-0">
                                @csrf
                                <button type="submit" class="dropdown-item text-dark">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Baris pencarian dan tombol create stok -->
            <div class="row align-items-center mt-4 mb-3">
                <div class="col text-start">
                    <form class="d-flex" action="/stok/search" method="GET">
                        <input class="form-control me-2" type="search" name="query" placeholder="Search" aria-label="Search" value="{{ request('query') }}">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                </div>
                <div class="col text-end">
                    <button type="button" class="btn btn-primary">Create Stok</button>
                </div>
            </div>

            <!-- Baris data stok menggunakan row-cols untuk responsivitas -->
            <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
                @foreach($stoks as $index => $stok)
                    <div class="col">
                        <div class="card h-100">
                            <img src="{{ asset('/'. $stok['foto_stok']) }}" alt="{{ $stok['nama_stok'] }}" class="card-img-top">
                            <div class="card-body">
                                <h5 class="card-title">{{ $stok->nama_stok }}</h5>
                                <p class="card-text">
                                    Jenis: {{ $stok->jenis_stok }} <br>
                                    Tanggal Masuk: {{ $stok->tanggal_masuk_stok }} <br>
                                    Detail Stok: {{ $stok->detail_stok }} <br>
                                    ID Pegawai: {{ $stok->id_pegawai }}
                                </p>
                                <div class="d-flex justify-content-center mt-3">
                                    <a href="/stok/{{ $stok->id_stok }}/edit" class="btn btn-outline-primary btn-sm me-2">Edit</a>
                                    <form action="/stok/{{ $stok->id_stok }}/delete" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </body>
@endsection
</html>
