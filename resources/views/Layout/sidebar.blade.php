<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet" > 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Full viewport height for the container */
        .container-fluid {
            height: 100vh;
            display: flex;
            overflow: hidden;
        }

        /* Sidebar styling */
        .sidebar-custom {
            min-height: 100vh;
            background-color: rgba(2, 62, 138, 0.65);
            width: 250px;
            color: #fff;
        }

        /* Row styling with gap */
        .row.flex-nowrap {
            gap: 20px; /* Adds space between sidebar and main content */
        }

        /* Main content area to fill remaining space */
        .main-content {
            flex-grow: 1;
            overflow-y: auto;
            padding: 20px;
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row flex-nowrap">
            <!-- Sidebar -->
            <div class="col-auto sidebar-custom"> <!-- Changed bg-dark to bg-primary for blue color -->
                <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">

            <!-- Logo -->
                <div class="d-flex justify-content-center mb-3"> <!-- Centering the logo -->
                    <img src="{{ asset('/logobasado1ktmr.png') }}" alt="Logo" width="200"> <!-- Responsive logo -->
                </div>

                    <!-- Side bar Dashboard -->
                    <ul href="/dashboard" class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="dashboard">
                        <!-- Dashboard Link -->
                        <li class="nav-item"> 
                            <a href="{{ route('dashboard.index') }}" class="nav-link align-middle px-0 text-white">
                                <i class="bi bi-grid-3x3-gap"></i>
                                <span class="ms-1 d-none d-sm-inline">Dashboard</span>
                            </a>
                        </li>                      
                        
                        <!-- Produk Link -->
                        <li>
                            <a id="produk" href="{{ route('produk.index') }}" class="nav-link px-0 align-middle text-white">
                                <i class="bi bi-list"></i>
                                <span class="ms-1 d-none d-sm-inline">Produk</span>
                            </a>
                        </li>
                        
                        <!-- Member Link -->
                        <li>
                            <a id="member" href="{{ route('member.index') }}" class="nav-link px-0 align-middle text-white">
                                <i class="bi bi-people"></i>
                                <span class="ms-1 d-none d-sm-inline">Member</span>
                            </a>
                        </li>

                        <!-- Order Link -->
                        <li>
                            <a id="transaksipenjualan" href="{{ route('transaksipenjualan.index') }}" data-bs-toggle="collapse" class="nav-link px-0 align-middle text-white">
                                <i class="bi bi-receipt"></i>
                                <span class="ms-1 d-none d-sm-inline">Order</span>
                            </a>
                        </li>

                        <!-- Pegawai Link -->
                        <li>
                            <a id="pegawai" href="{{ route('pegawai.index') }}" class="nav-link px-0 align-middle text-white">
                                <i class="bi bi-person-check"></i>
                                <span class="ms-1 d-none d-sm-inline">Pegawai</span>
                            </a>                                   
                        </li>

                        <!-- Stok Link -->
                        <li>
                            <a id="stok" href="{{ route('stok.index') }}" class="nav-link px-0 align-middle text-white">
                                <i class="bi bi-box-seam"></i>
                                <span class="ms-1 d-none d-sm-inline">Stok</span>
                            </a>                                   
                        </li>

                        <!-- Laporan Link -->
                        <li>
                            <a id="laporantransaksi" href="{{ route('laporantransaksi.index') }}" class="nav-link px-0 align-middle text-white">
                                <i class="bi bi-file-earmark-text"></i>
                                <span class="ms-1 d-none d-sm-inline">Laporan Transaksi</span>
                            </a>                                   
                        </li>
                        <!-- Dropdown -->
                            <div class="dropdown pb-4">
                                <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="https://github.com/mdo.png" alt="Pegawai" width="30" height="30" class="rounded-circle">
                                    <span class="d-none d-sm-inline mx-1">AdminKasir</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-dark text-small shadow text-left">
                                    <!-- <li><a class="dropdown-item" href="#">Profile</a></li> -->
                                    <li>
                                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-white bg-transparent border-0 d-flex align-items-center">
                                            <!-- SVG Icon -->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z"/>
                                                <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/>
                                            </svg>
                                            <!-- Logout text with spacing -->
                                            <span class="ms-2">Logout</span>
                                        </button>
                                    </form>
                                    </li>
                                </ul>
                            </div>
                    </div>
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col py-3 main-content">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
