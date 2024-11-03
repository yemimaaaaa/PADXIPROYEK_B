<!DOCTYPE html>
<html lang="en">
@extends('layout.sidebar')

@section('content')
    <body>

        <div class="container mt-3">
            <h2>Data Pegawai</h2>
            <div class="row align-items-center mb-3">
            <div class="col text-start"> <!-- Aligns search to the left -->
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
                        <th>Foto Pegawai</th>
                        <th>NoHp Pegawai</th>
                        <th>Email Pegawai</th>
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
                    <img src="{{ $pegawai->foto }}" alt="Foto" width="50" height="50">
                </td>
                <td>{{ $pegawai->id_role }}</td>
                <td class="action-icons">
                            <a href="/pegawai/{{ $pegawai->id_pegawai }}/edit" class="bi bi-pen me-2 text-dark"></a>
                            <form action="/pegawai/{{ $pegawai->id_pegawai }}/delete" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                            <button type="submit" class="bi bi-trash btn btn-link p-0 text-dark"></button> <!-- btn-link untuk menghilangkan background -->
                            </form>
                        </td>
                     </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </body>
@endsection

</html>
