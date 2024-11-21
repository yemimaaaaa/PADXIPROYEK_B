<!DOCTYPE html>
<html lang="en">
@extends('layout.sidebar')

@section('content')
    <style>
        /* Mengatur tampilan gambar di dalam kartu */
        .card img {
            aspect-ratio: 16 / 14;
            width: 100%;
            object-fit: cover;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        /* Responsif pada layar kecil */
        @media (max-width: 600px) {
            .card img {
                max-height: 280px;
            }
        }

        /* Mengatur margin pada kartu dan container agar lebih rapi */
        .container-full-width {
            width: 100%;
            max-width: 100%;
            padding-left: 2rem;
            padding-right: 2rem;
        }
    </style>

    <body>
        <div class="container-full-width mt-2">
            <h2>Data Member</h2>
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
        </div>

            <div class="row align-items-center mt-4 mb-3">
                <div class="col text-start">
                    <form class="d-flex" action="/member/search" method="GET" style="justify-content: flex-start;">
                        <input class="form-control me-2" type="search" name="query" placeholder="Search Member" aria-label="Search" style="width: 200px;" value="{{ request('query') }}">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                </div>
                <div class="col text-end">
                    <a href="{{ route('member.create') }}" class="btn btn-primary">Create Member</a>
                </div>
            </div>

            <div class="container-full-width text-center">
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
                    @foreach($members as $member)
                        <div class="col">
                            <div class="card h-100 shadow-sm">
                                <img src="{{ asset('/' . $member['foto']) }}" alt="{{ $member['nama'] }}" class="card-img-top">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $member->nama }}</h5>
                                    <p class="card-text">
                                        <strong>No. Telepon:</strong> {{ $member->no_hp }} <br>
                                        <strong>Periode Awal:</strong> {{ $member->periode_awal }} <br>
                                        <strong>Periode Akhir:</strong> {{ $member->periode_akhir }} <br>
                                        <strong>Level Member:</strong> {{ $member->nama_level }}
                                        {{-- <div class="mb-1">📱 {{ $member->no_hp }}</div>
                                        <div class="mb-1">🗓️ {{ $member->periode_awal }}</div>
                                        <div class="mb-1">📅 {{ $member->periode_akhir }}</div>
                                        <div>⭐ Level {{ $member->id_level_member }}</div> --}}
                                    </p>
                                </div>
                                <div class="d-flex justify-content-center mt-3 mb-3">
                                    <a href="{{ route('member.edit', ['id' => $member->id_member]) }}" class="btn btn-outline-primary btn-sm me-2">Edit</a>
                                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="showDeleteModal('{{ $member->id_member }}')">Delete</button>
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
                        Apakah Anda yakin ingin menghapus data member ini?
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
                deleteForm.action = `/member/${id}/delete`; // Set action URL
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
