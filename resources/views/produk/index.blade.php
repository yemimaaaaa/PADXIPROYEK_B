<!DOCTYPE html>
<html lang="en">
@extends('layout.sidebar')

@section('content')
    <body>
        <div class="container mt-3">
            <h2>Data Produk</h2>
            <div class="row align-items-center mb-3">
                <div class="col text-start"> <!-- Aligns search to the left -->
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
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-5 g-4">
                    @foreach($produks as $index => $produk)
                        <div class="col">
                            <div class="card h-100">
                                <img src="{{ $produk->foto }}" class="card-img-top" alt="Foto Produk" style="height: 150px; object-fit: cover;">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $produk->nama_produk }}</h5>
                                    <p class="card-text">
                                        Jenis: {{ $produk->jenis_produk }} <br>
                                        Harga: Rp{{ number_format($produk->harga, 0, ',', '.') }} <br>
                                        Deskripsi: {{ Str::limit($produk->deskripsi_produk, 50) }}
                                    </p>
                                </div>
                                <div class="card-footer">
                                    <a href="/produk/{{ $produk->id_produk }}/edit" class="btn btn-outline-primary btn-sm me-2">Edit</a>
                                    <form action="/produk/{{ $produk->id_produk }}/delete" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                                    </form>
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
