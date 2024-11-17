<!DOCTYPE html>
<html lang="en">
@extends('layout.sidebar')

@section('content')
    <style>
        .card img {
            aspect-ratio: 16 / 9;
            width: 100%;
            object-fit: cover;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        @media (max-width: 600px) {
            .card img {
                max-height: 280px;
            }
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>    

    <body>
        <div class="container mt-2">
            <h2>Data Pegawai</h2>
            <!-- Akun Dropdown -->
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
        </div>

        <div class="row align-items-center mt-4 mb-3">
            <div class="col text-start">
                <form class="d-flex" action="/pegawai/search" method="GET" style="justify-content: flex-start;">
                    <input class="form-control me-2" type="search" name="query" placeholder="Search Pegawai" aria-label="Search" style="width: 200px;" value="{{ request('query') }}">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
            <div class="col text-end">
                <a href="{{ route('pegawai.create') }}" class="btn btn-primary">Create Pegawai</a>
            </div>
        </div>

        <!-- Kartu Data Pegawai -->
        <div class="container text-center">
            <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
                @foreach($pegawais as $pegawai)
                    <div class="col">
                        <div class="card h-100">
                            <img src="{{ asset($pegawai->foto) }}" alt="{{ $pegawai->nama }}" class="card-img-top">
                            <div class="card-body">
                                <h5 class="card-title">{{ $pegawai->nama }}</h5>
                                <p class="card-text">
                                    <strong>Username:</strong> {{ $pegawai->username }} <br>
                                    <strong>No HP:</strong> {{ $pegawai->no_hp }} <br>
                                    <strong>Email:</strong> {{ $pegawai->email }} <br>
                                    <strong>Role:</strong> {{ $pegawai->id_role }}
                                </p>
                                <div class="d-flex justify-content-center mt-3">
                                    <a href="{{ route('pegawai.edit', ['id' => $pegawai->id_pegawai]) }}" class="btn btn-outline-primary btn-sm me-2">Edit</a>
                                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="showDeleteModal('{{ $pegawai->id_pegawai }}')">Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Modal Konfirmasi Hapus -->
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Apakah Anda yakin ingin menghapus data pegawai ini?
                    </div>
                    <div class="modal-footer">
                        <form id="deleteForm" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                        </form>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Toast Notification -->
        @if(session('success'))
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
            <div id="successToast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>
        @endif

        <script>
            function showDeleteModal(id) {
                const deleteForm = document.getElementById('deleteForm');
                deleteForm.action = `/pegawai/${id}/delete`; // Set action URL
                const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'), {});
                deleteModal.show();
            }

            // Auto-show Toast Notification
            document.addEventListener('DOMContentLoaded', function () {
                const successToast = document.getElementById('successToast');
                if (successToast) {
                    const toast = new bootstrap.Toast(successToast);
                    toast.show();
                }
            });
        </script>
    </body>
@endsection
</html>
