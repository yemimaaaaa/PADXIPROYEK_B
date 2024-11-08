<!DOCTYPE html>
<html lang="en">
@extends('layout.sidebar')

@section('content')
    <style>
        /* Gaya untuk memastikan gambar tidak melebar dan menyesuaikan dengan kolom */
        .card img {
        aspect-ratio: 16 / 9; /* Atur aspek rasio (opsional) */
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
            <h2>Data Produk</h2>
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
            <div class="row align-items-center mt-4 mb-3">
                <div class="col text-start">
                    <form class="d-flex" action="/produk/search" method="GET" style="justify-content: flex-start;">
                        <input class="form-control me-2" type="search" name="query" placeholder="Search" aria-label="Search" style="width: 200px;" value="{{ request('query') }}">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                </div>
                <div class="col text-end">
                    <button type="button" class="btn btn-primary">Create Produk</button>
                </div>
            </div>

            <div class="container text-center">
                <!-- Mengatur jumlah kolom per baris sesuai layar -->
                <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
                    @foreach($produks as $index => $produk)
                        <div class="col">
                            <div class="card h-100">
                                <img src="{{ asset('/'. $produk['foto_produk']) }}" alt="{{ $produk['nama_produk'] }}" class="card-img-top">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $produk->nama_produk }}</h5>
                                    <p class="card-text">
                                        Jenis: {{ $produk->jenis_produk }} <br>
                                        Harga: Rp{{ number_format($produk->harga, 0, ',', '.') }} <br>
                                        Deskripsi: {{ Str::limit($produk->deskripsi_produk, 50) }}
                                    </p>
                                    <div class="d-flex justify-content-center mt-3">
                                        <a href="/produk/{{ $produk->id_produk }}/edit" class="btn btn-outline-primary btn-sm me-2">Edit</a>
                                        <form action="/produk/{{ $produk->id_produk }}/delete" method="POST" style="display:inline;">
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
