<!DOCTYPE html>
<html lang="en">
@extends('layout.sidebar')

@section('content')
    <style>
        .card img {
            aspect-ratio: 16 / 14;
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
    <!-- Popper.js dan Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
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

            <div class="container mt-2">
                <div class="row align-items-center mt-4 mb-3">
                    <div class="col text-start">
                        <form class="d-flex" action="/stok/search" method="GET">
                            <input class="form-control me-2" type="search" name="query" placeholder="Search Data Stok" aria-label="Search" value="{{ request('query') }}">
                            <button class="btn btn-outline-success" type="submit">Search</button>
                        </form>
                    </div>
                    <div class="col text-end">
                        <a href="{{ route('stok.create') }}" class="btn btn-primary">Create Stok</a>
                    </div>
                </div>

                <div class="container text-center">
                    <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
                        @foreach($stoks as $stok)
                            <div class="col">
                                <div class="card h-100">
                                    <img src="{{ asset('/'. $stok['foto_stok']) }}" alt="{{ $stok['nama_stok'] }}" class="card-img-top">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $stok->nama_stok }}</h5>
                                        <p class="card-text">
                                            <strong>Jenis:</strong> {{ $stok->jenis_stok }} <br>
                                            <strong>Tanggal Masuk:</strong> {{ $stok->tanggal_masuk_stok }} <br>
                                            <strong>Detail Stok:</strong> {{ $stok->detail_stok }} <br>
                                            <strong>ID Pegawai:</strong> {{ $stok->id_pegawai }}
                                        </p>
                                        <div class="d-flex justify-content-center mt-3 gap-2">
                                            <a href="{{ route('stok.edit', ['id' => $stok->id_stok]) }}" class="btn btn-outline-primary btn-sm">Edit</a>
                                            <button class="btn btn-outline-danger btn-sm" onclick="showDeleteModal({{ $stok->id_stok }})">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                
                    <!-- Pagination -->
                    <div class="mt-4 d-flex justify-content-center">
                        {{ $stoks->links('pagination::bootstrap-5') }}
                    </div>
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
                            Apakah Anda yakin ingin menghapus data stok ini?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <form id="deleteForm" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Ya,Hapus</button>
                            </form>
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
                deleteForm.action = `/stok/${id}/delete`; // Set action URL
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
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
    </body>
@endsection
</html>
