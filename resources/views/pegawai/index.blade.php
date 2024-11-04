<!DOCTYPE html>
<html lang="en">
@extends('layout.sidebar')

@section('content')
    <style>
        /* Gaya untuk memastikan gambar tidak melebar */
        .table img {
            width: 100px;               /* Tentukan lebar tetap untuk gambar */
            height: 100px;              /* Tentukan tinggi tetap untuk gambar */
            object-fit: cover;          /* Menjaga proporsi gambar tanpa merusak tampilannya */
            border-radius: 8px;         /* Membuat sudut gambar menjadi bulat */
        }
        
        /* Tambahan untuk aksi tombol agar terlihat rapi */
        .action-icons .btn {
            padding: 0; /* Hilangkan padding tombol agar tidak terlalu besar */
            margin-right: 5px;
        }
    </style>
    <body>
        <div class="container mt-2">
            <h2>Data Pegawai</h2>
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
                    <form class="d-flex" action="/pegawai/search" method="GET" style="justify-content: flex-start;">
                        <input class="form-control me-2" type="search" name="query" placeholder="Search" aria-label="Search" style="width: 200px;" value="{{ request('query') }}">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                </div>
                <div class="col text-end">
                    <button type="button" class="btn btn-primary">Create Pegawai</button>
                </div>
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Pegawai</th>
                        <th>Username</th>
                        <th>NoHp Pegawai</th>
                        <th>Email Pegawai</th>
                        <th>Foto Pegawai</th>
                        <th>Role Pegawai</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pegawais as $index => $pegawai)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $pegawai->nama }}</td>
                        <td>{{ $pegawai->username }}</td>
                        <td>{{ $pegawai->no_hp }}</td>
                        <td>{{ $pegawai->email }}</td>
                        <td>
                            <img src="{{ asset($pegawai->foto) }}" alt="{{ $pegawai->nama }}">
                        </td>
                        <td>{{ $pegawai->id_role }}</td>
                        <td class="action-icons">
                            <a href="/pegawai/{{ $pegawai->id_pegawai }}/edit" class="bi bi-pen me-2 text-dark"></a>
                            <form action="/pegawai/{{ $pegawai->id_pegawai }}/delete" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bi bi-trash btn btn-link p-0 text-dark"></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </body>
@endsection
</html>
