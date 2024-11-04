<!DOCTYPE html>
<html lang="en">
@extends('layout.sidebar')

@section('content')
    <style>
        /* Gaya untuk memastikan gambar tidak melebar dan menyesuaikan dengan kolom */
        .card img {
            width: 100%;           /* Pastikan gambar menyesuaikan lebar kolom */
            height: auto;          /* Atur tinggi otomatis untuk menjaga proporsi */
            max-height: 200px;     /* Tentukan tinggi maksimum */
            object-fit: cover;     /* Menjaga proporsi dan memotong jika diperlukan */
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
                <div class="col text-start">
                    <form class="d-flex" action="/stok/search" method="GET" style="justify-content: flex-start;">
                        <input class="form-control me-2" type="search" name="query" placeholder="Search" aria-label="Search" style="width: 200px;" value="{{ request('query') }}">
                        <button class="btn btn-outline-success" type="submit">Search Stok</button>
                    </form>
                </div>
                <div class="col text-end">
                    <button type="button" class="btn btn-primary">Create Stok</button>
                </div>
            </div>

            <!-- Grid Layout for Stok Data -->
            <div class="container text-center">
                <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
                    @foreach($stoks as $index => $stok)
                        <div class="col">
                            <div class="card h-100">
                                <img src="{{ asset('/'. $stok['foto_stok']) }}" alt="{{ $stok['nama_stok'] }}" width="250" height="250">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $stok->nama_stok }}</h5>
                                    <p class="card-text">
                                        Jenis: {{ $stok->jenis_stok }} <br>
                                        Tanggal Masuk: {{ $stok->tanggal_masuk_stok }} <br>
                                        Detail: {{ Str::limit($stok->detail_stok, 50) }} <br>
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
        </div>
    </body>
@endsection
</html>
