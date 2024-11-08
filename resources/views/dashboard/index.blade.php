<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Lusitana:wght@400;600&display=swap" rel="stylesheet">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Basic Styling */
        body {
            font-family: 'Lusitana', sans-serif;
            display: flex;
            background-color: #FAF3E0;
            margin: 0;
            height: 100vh;
            overflow: hidden;
        }

        /* Sidebar Styling */
        .sidebar {
            width: 250px;
            background-color: #466ba0;
            color: #FFF;
            height: 100vh;
            position: fixed;
        }

        /* Main Content Styling */
        .main-content {
            margin-left: 250px; /* Width of the sidebar */
            padding: 20px;
            flex: 1;
            background-color: #FAF3E0;
            color: #333;
            overflow-y: auto; /* Allows scrolling if content is large */
        }

        /* Header Styling */
        h1 {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #466ba0;
        }

        /* Card Container Styling */
        .card-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .card {
            background-color: #e3ecf6;
            border: 2px solid #466ba0;
            border-radius: 10px;
            padding: 20px;
            color: #333;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-title {
            font-size: 18px;
            font-weight: bold;
            color: #466ba0;
            margin-bottom: 10px;
        }

        .card p {
            font-size: 28px;
            font-weight: bold;
            color: #466ba0;
        }

        /* Full-width Chart Container for Recent Revenue */
        .chart-container {
            background-color: #FFFFFF;
            border: 2px solid #697565;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 100%; /* Full width to take up the space */
        }

        .chart-container h3 {
            margin-bottom: 20px;
            font-size: 20px;
            color: #333;
        }

    </style>
</head>

<body>
    <!-- Sidebar (unchanged) -->
    <div class="sidebar">
        @include('layout.sidebar')
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <h1>Dashboard</h1>
        <div class="d-flex justify-content-end align-items-center mb-3"> <!-- Added margin-bottom here -->
            <div class="dropdown border rounded shadow p-2 bg-light me-3"> <!-- Added margin-end here -->
                <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://github.com/mdo.png" alt="Pegawai" width="30" height="30" class="rounded-circle me-2">
                    <span class="d-none d-sm-inline mx-1">({{ auth()->check() ? auth()->user()->nama : 'Guest' }})</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow">
                    {{-- <li><a class="dropdown-item text-dark" href="/profile">Profile</a></li> --}}
                    <li>
                        <form action="{{ route('logout') }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="dropdown-item text-dark">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Card Container (2 Columns) -->
        <div class="card-container">
            <div class="card">
                <div class="card-title">Collected</div>
                <p>Rp {{ number_format($totalIncome, 2, ',', '.') }}</p>
            </div>
            <div class="card">
                <div class="card-title">Sold Items</div>
                <p>{{ $totalSales }}</p>
            </div>
            <div class="card">
                <div class="card-title">Total Invoices</div>
                <p>{{ $totalProduct }}</p>
            </div>
            <div class="card">
                <div class="card-title">Total Member</div>
                <p>{{ $totalMember }}</p>
            </div>
        </div>

        <!-- Full-width Recent Revenue Section -->
        <div class="chart-container">
            <h3>Recent Revenue</h3>
            <select>
                <option>Bulan/Tahun</option>
                <option>Karyawan</option>
            </select>
            <canvas id="salesChart"></canvas>
        </div>
    </div>

    <!-- Chart.js Script -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('salesChart').getContext('2d');
            const salesChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [{
                        label: 'Sales',
                        data: [10, 15, 12, 8, 17, 10, 18, 22, 19, 24, 21, 25],
                        backgroundColor: '#3C3D37'
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>