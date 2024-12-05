<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet"> 
    <style>
        /* Full viewport height for the container */
        .container-fluid {
            height: 100vh;
            display: flex;
            overflow: hidden;
        }
    
        /* Sidebar styling */
        .sidebar-custom {
            position: relative;
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
    
        /* Sidebar link styling */
        .nav-link {
            color: white; /* Set default link color */
            transition: background-color 0.3s, color 0.3s; /* Transition effect */
            display: block; /* Make the link a block element */
            padding: 10px 15px; /* Add padding to make the link area larger */
            width: 100%; /* Full width of the sidebar */
            text-align: left; /* Align text to the left */
            border-radius: 5px; /* Add some border radius for rounded corners */
            box-sizing: border-box; /* Ensure padding and borders are included in the element's total width */
        }
    
        /* Sidebar link hover effect */
        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            width: 200px;
            color: #fff;
        }

        /* Position dropdown in the top right */
        .user-dropdown {
            position: absolute;
            top: 10px;
            right: 10px;
        }
    </style>
    
</head>
<body>
    <div class="container-fluid">
        <div class="row flex-nowrap">
            <!-- Sidebar -->
            <div class="col-auto sidebar-custom"> 
                <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                    <!-- Logo -->
                    <div class="d-flex justify-content-center mb-3"> 
                        <img src="{{ asset('/logobasado1ktmr.png') }}" alt="Logo" width="200">
                    </div>

                    <!-- Sidebar Navigation Links -->
                    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="dashboard">
                        <li class="nav-item"> 
                            <a href="{{ route('dashboard.index') }}" class="nav-link align-middle px-0">
                                <i class="bi bi-grid-3x3-gap"></i>
                                <span class="ms-1 d-none d-sm-inline">Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a id="produk" href="{{ route('produk.index') }}" class="nav-link px-0 align-middle">
                                <i class="bi bi-list"></i>
                                <span class="ms-1 d-none d-sm-inline">Produk</span>
                            </a>
                        </li>
                        <li>
                            <a id="member" href="{{ route('member.index') }}" class="nav-link px-0 align-middle">
                                <i class="bi bi-people"></i>
                                <span class="ms-1 d-none d-sm-inline">Member</span>
                            </a>
                        </li>
                        <li>
                            <a id="transaksipenjualan" href="/transaksipenjualan" class="nav-link px-0 align-middle">
                                <i class="bi bi-receipt"></i>
                                <span class="ms-1 d-none d-sm-inline">Transaksi Penjualan</span>
                            </a>
                        </li>
                        @if (Auth::check() && Auth::user()->role->nama_role === 'owner')
                        <li>
                            <a id="pegawai" href="{{ route('pegawai.index') }}" class="nav-link px-0 align-middle">
                                <i class="bi bi-person-check"></i>
                                <span class="ms-1 d-none d-sm-inline">Pegawai</span>
                            </a>                                   
                        </li>
                        @endif
                        <li>
                            <a id="stok" href="{{ route('stok.index') }}" class="nav-link px-0 align-middle">
                                <i class="bi bi-box-seam"></i>
                                <span class="ms-1 d-none d-sm-inline">Stok</span>
                            </a>                                   
                        </li>
                        <li>
                            <a id="poinmember" href="{{ route('poinmember.index') }}" class="nav-link px-0 align-middle">
                                <i class="bi bi-star"></i>
                                <span class="ms-1 d-none d-sm-inline">Poin Member</span>
                            </a>                                   
                        </li>

                        <li>
                            <a id="laporantransaksi" href="{{ route('laporantransaksi.index') }}" class="nav-link px-0 align-middle">
                                <i class="bi bi-file-earmark-text"></i>
                                <span class="ms-1 d-none d-sm-inline">Laporan Transaksi</span>
                            </a>                                   
                        </li>
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