<!DOCTYPE html>
<html lang="en">
@extends('layout.sidebar')

@section('content')
    <style>
        /* Pastikan gambar tidak melebar */
        .table img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
        }

        /* Pastikan tombol aksi memiliki padding dan margin yang sesuai */
        .action-icons .btn {
            padding: 0;
            margin-right: 5px;
        }
    </style>
    <body>
        <div class="container mt-2">
            <h2>Data Pegawai</h2>
            
            <!-- Dropdown untuk akun di pojok kanan atas -->
            <div class="d-flex justify-content-end align-items-center mb-3">
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
            
            <!-- Form pencarian dan tombol tambah pegawai -->
            <div class="row align-items-center mb-3">
                <div class="col text-start">
                    <form class="d-flex" action="/pegawai/search" method="GET" style="justify-content: flex-start;">
                        <input class="form-control me-2" type="search" name="query" placeholder="Search" aria-label="Search" style="width: 200px;" value="{{ request('query') }}">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                </div>
                <div class="col text-end">
                    <a href="/pegawai/create" class="btn btn-primary">Create Pegawai</a>
                </div>
            </div>

            <!-- Tabel Data Pegawai -->
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
