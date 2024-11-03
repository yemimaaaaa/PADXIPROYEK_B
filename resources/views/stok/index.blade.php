<!DOCTYPE html>
<html lang="en">
@extends('layout.sidebar')

@section('content')
    <body>
        <div class="container mt-3">
            <h2>Data Stok</h2>
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
                                <img src="{{ $stok->foto }}" class="card-img-top" alt="Foto Stok" style="height: 150px; object-fit: cover;">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $stok->nama_stok }}</h5>
                                    <p class="card-text">
                                        Jenis: {{ $stok->jenis_stok }} <br>
                                        Tanggal Masuk: {{ $stok->tanggal_masuk_stok }} <br>
                                        Detail: {{ Str::limit($stok->detail_stok, 50) }} <br>
                                        ID Pegawai: {{ $stok->id_pegawai }}
                                    </p>
                                </div>
                                <div class="card-footer">
                                    <a href="/stok/{{ $stok->id_stok }}/edit" class="btn btn-outline-primary btn-sm me-2">Edit</a>
                                    <form action="/stok/{{ $stok->id_stok }}/delete" method="POST" style="display:inline;">
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
