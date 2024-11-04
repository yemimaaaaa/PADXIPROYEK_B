<!DOCTYPE html>
<html lang="en">
@extends('layout.sidebar')
@section('content')
<style>
    /* Gaya untuk memastikan gambar tidak melebar */
    .card img {
        width: 100%;               /* Sesuaikan gambar dengan lebar kartu */
        height: auto;              /* Biarkan tinggi menyesuaikan secara otomatis */
        max-height: 200px;         /* Tetapkan tinggi maksimum */
        object-fit: cover;         /* Menjaga proporsi gambar tanpa merusak tampilannya */
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
    }

    /* Tambahan untuk aksi tombol agar terlihat rapi */
    .action-icons .btn {
        padding: 0; /* Hilangkan padding tombol agar tidak terlalu besar */
        margin-right: 5px;
    }
</style>
    <body>
        <div class="container mt-2">
            <h2>Data Member</h2>
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
        </div>
            <div class="row align-items-center mb-3">
                <div class="col text-start">
                    <form class="d-flex" action="{{ route('member.search') }}" method="GET" style="justify-content: flex-start;">
                        <input class="form-control me-2" type="search" name="query" placeholder="Search" aria-label="Search" style="width: 200px;" value="{{ request('query') }}">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                </div>
                <div class="col text-end">
                    <button type="button" class="btn btn-primary">Create Member</button>
                </div>
            </div>
            <div class="container text-center">
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-5 g-4">
                    @foreach($members as $index => $member)
                        <div class="col">
                            <div class="card h-100">
                                <img src="{{ asset('/'. $member['foto']) }}" alt="{{ $member['nama'] }}" class="card-img-top">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $member->nama }}</h5>
                                    <p class="card-text">
                                        No. Telepon: {{ $member->no_hp }} <br>
                                        Periode Awal: {{ $member->periode_awal }} <br>
                                        Periode Akhir: {{ $member->periode_akhir }} <br>
                                        Level Member: {{ $member->id_level_member }}
                                    </p>
                                </div>
                                <div class="card-footer">
                                    <a href="/member/{{ $member->id_member }}/edit" class="btn btn-outline-primary btn-sm me-2">Edit</a>
                                    <form action="/member/{{ $member->id_member }}/delete" method="POST" style="display:inline;">
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
