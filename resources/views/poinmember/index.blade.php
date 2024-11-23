<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Poin Member</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f7fafc;
        }
        .header-container {
            background-color: #4f8bda;
            color: white;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.1);
        }
        .btn-primary {
            background-color: #6ea8e6;
            border: none;
            color: white;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #4f8bda;
        }
        .btn-secondary {
            background-color: #e2e8f0;
            border: none;
            color: #475569;
            transition: all 0.3s ease;
        }
        .btn-secondary:hover {
            background-color: #cbd5e1;
        }
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0px 2px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.15);
        }
        .badge-gold {
            background-color: #FFD700; /* Warna emas */
            color: #ffffff; /* Teks putih */
            font-weight: bold;
            border-radius: 12px;
            padding: 5px 10px;
        }

        .badge-silver {
            background-color: #C0C0C0; /* Warna perak */
            color: #ffffff; /* Teks putih */
            font-weight: bold;
            border-radius: 12px;
            padding: 5px 10px;
        }

        .badge-bronze {
            background-color: #CD7F32; /* Warna tembaga */
            color: #ffffff; /* Teks putih */
            font-weight: bold;
            border-radius: 12px;
            padding: 5px 10px;
        }

        .badge-regular {
            background-color: #D3D3D3; /* Abu-abu lembut */
            color: #333333; /* Teks abu-abu gelap */
            font-weight: bold;
            border-radius: 12px;
            padding: 5px 10px;
        }

    </style>
</head>
<body class="min-h-screen py-4">
    <div class="container">
        <!-- Header -->
        <div class="header-container d-flex justify-content-between align-items-center">
            <a href="/dashboard" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Dashboard
            </a>
            <h1 class="h5 text-center mb-0 flex-grow">Daftar Poin Member</h1>
            <div class="dropdown border rounded shadow p-2 bg-light">
                <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://github.com/mdo.png" alt="Pegawai" width="20" height="20" class="rounded-circle me-2">
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

        <!-- Search Bar -->
        <form action="/poinmember" method="GET" class="d-flex mb-4">
            <input type="text" name="query" class="form-control me-2" placeholder="Cari ID Member atau Nama..." value="{{ request('query') }}">
            <button type="submit" class="btn btn-primary">Cari</button>
        </form>

       <!-- Card Grid -->
            <div class="row g-3">
                @foreach ($members as $member)
                <div class="col-md-4">
                    <div class="card text-center" style="background-color: #f5f5f5;"> <!-- Warna abu -->
                        <h5 class="text-lg font-bold text-gray-800 mb-2">{{ $member->nama }}</h5>
                        <p class="text-muted mb-2">ID: {{ $member->id_member }}</p>
                        <p class="mb-2">Total Poin: <span class="text-primary fw-bold">{{ $member->poins_sum_total_poin ?? 0 }}</span></p>
                        @php
                            $badgeClass = 'badge-regular';
                            $level = 'Regular';

                            if (($member->poins_sum_total_poin ?? 0) >= 2001) {
                                $badgeClass = 'badge-gold';
                                $level = 'Gold';
                            } elseif (($member->poins_sum_total_poin ?? 0) >= 1001) {
                                $badgeClass = 'badge-silver';
                                $level = 'Silver';
                            } elseif (($member->poins_sum_total_poin ?? 0) >= 1) {
                                $badgeClass = 'badge-bronze';
                                $level = 'Bronze';
                            }
                        @endphp

                        <span class="badge {{ $badgeClass }}">{{ $level }}</span>
                        {{-- <a href="{{ route('poinmember.detail', $member->id_member) }}" class="btn btn-primary mt-3 w-100">
                            <i class="bi bi-info-circle"></i> Detail
                        </a> --}}
                    </div>
                </div>
                @endforeach
            </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
