<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet"> <!-- Bootstrap Icons -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            display: flex;
            background-color: #F9FAFB;
            margin: 0;
            min-height: 100vh;
        }

        .card-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .card {
            background-color: #FFF;
            border: 1px solid #E5E7EB;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            color: #1F2937;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .card-icon {
            font-size: 2.5em;
            color: #3B82F6;
            margin-bottom: 15px;
        }

        .card-title {
            font-size: 1.1em;
            font-weight: 600;
            margin-bottom: 5px;
            color: #1F2937;
        }

        .card p {
            font-size: 1em;
            color: #6B7280;
            margin: 0;
        }

        .chart-container {
            background-color: #FFF;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: 1px solid #E5E7EB;
            margin-bottom: 30px;
            height: 400px;
        }

        .chart-container h3 {
            font-size: 1.5em;
            font-weight: 600;
            text-align: center;
            color: #1F2937;
            margin-bottom: 20px;
        }

        .row {
            margin-bottom: 30px;
        }

        .chart-wrapper {
            width: 100%;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        @include('layout.sidebar')
    </div>

    <!-- Main Content -->
    <div class="main-content container">
        <h1 class="mt-4">Dashboard</h1>

        <!-- Dashboard Cards -->
        <div class="card-container">
            <div class="card">
                <div class="card-icon"><i class="bi bi-wallet2"></i></div>
                <div class="card-title">Collected</div>
                <p>Rp {{ number_format($totalIncome, 2, ',', '.') }}</p>
            </div>
            <div class="card">
                <div class="card-icon"><i class="bi bi-cart"></i></div>
                <div class="card-title">Sold Products</div>
                <p>{{ $totalSales }}</p>
            </div>
            <div class="card">
                <div class="card-icon"><i class="bi bi-file-earmark-text"></i></div>
                <div class="card-title">Total Invoices</div>
                <p>{{ $totalProduct }}</p>
            </div>
            <div class="card">
                <div class="card-icon"><i class="bi bi-people"></i></div>
                <div class="card-title">Total Member</div>
                <p>{{ $totalMember }}</p>
            </div>
        </div>

        <!-- Row for Charts -->
        <div class="row">
            <div class="col-lg-6">
                <div class="chart-container chart-wrapper">
                    <h3>Recent Revenue</h3>
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="chart-container chart-wrapper">
                    <h3>Transaksi Pegawai</h3>
                    <canvas id="pegawaiChart"></canvas>
                </div>
            </div>

            {{-- <!-- Row for Pie Charts -->
                <div class="row">
                    <div class="col-lg-6">
                        <div class="chart-container">
                            <h3>Jenis Produk Terjual</h3>
                            <canvas id="productPieChart"></canvas>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="chart-container">
                            <h3>Total Pemasukan Bulanan</h3>
                            <canvas id="incomePieChart"></canvas>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>

    <!-- Chart.js Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Grafik Pendapatan Bulanan
            const revenueCtx = document.getElementById('salesChart').getContext('2d');
            const monthlyLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            const monthlyData = {!! json_encode($monthlyData) !!};

            const revenueData = monthlyLabels.map((_, index) => monthlyData[index + 1] || 0);

            new Chart(revenueCtx, {
                type: 'line',
                data: {
                    labels: monthlyLabels,
                    datasets: [{
                        label: 'Monthly Revenue (Rp)',
                        data: revenueData,
                        borderColor: '#3B82F6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#3B82F6',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });

            // Grafik Transaksi Pegawai
            const pegawaiCtx = document.getElementById('pegawaiChart').getContext('2d');
            const pegawaiLabels = {!! json_encode($pegawaiNames) !!};
            const transactionCounts = {!! json_encode($transactionCounts) !!};

            new Chart(pegawaiCtx, {
                type: 'bar',
                data: {
                    labels: pegawaiLabels,
                    datasets: [{
                        label: 'Jumlah Transaksi',
                        data: transactionCounts,
                        backgroundColor: '#36A2EB',
                        borderColor: '#FFFFFF',
                        borderWidth: 1,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        x: {
                            barPercentage: 0.2, // Lebar bar 60% dari kategori
                            categoryPercentage: 0.8 // Jarak antar kategori
                        },
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
        // document.addEventListener('DOMContentLoaded', function () {
        //     // Diagram Pie untuk Jenis Produk Terjual
        //     const productPieCtx = document.getElementById('productPieChart').getContext('2d');
        //     const productLabels = {!! json_encode($productTypes) !!}; // Contoh: ['Produk A', 'Produk B', 'Produk C']
        //     const productData = {!! json_encode($productSales) !!}; // Contoh: [300, 200, 500]

        //     new Chart(productPieCtx, {
        //         type: 'pie',
        //         data: {
        //             labels: productLabels,
        //             datasets: [{
        //                 data: productData,
        //                 backgroundColor: [
        //                     '#FF6384', // Merah muda
        //                     '#36A2EB', // Biru
        //                     '#FFCE56', // Kuning
        //                     '#4BC0C0', // Hijau muda
        //                     '#9966FF'  // Ungu
        //                 ],
        //                 borderColor: '#FFF',
        //                 borderWidth: 1
        //             }]
        //         },
        //         options: {
        //             responsive: true,
        //             plugins: {
        //                 tooltip: {
        //                     callbacks: {
        //                         label: (tooltipItem) => `${tooltipItem.label}: ${tooltipItem.raw.toLocaleString('id-ID')} pcs`
        //                     }
        //                 }
        //             }
        //         }
        //     });

        //     // Diagram Pie untuk Total Pemasukan Bulanan
        //     const incomePieCtx = document.getElementById('incomePieChart').getContext('2d');
        //     const monthlyLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        //     const incomeData = {!! json_encode($monthlyIncome) !!}; // Contoh: [1000000, 1500000, ...]

        //     new Chart(incomePieCtx, {
        //         type: 'pie',
        //         data: {
        //             labels: monthlyLabels,
        //             datasets: [{
        //                 data: incomeData,
        //                 backgroundColor: monthlyLabels.map((_, i) => `rgba(${Math.random() * 255}, ${Math.random() * 255}, ${Math.random() * 255}, 0.8)`),
        //                 borderColor: '#FFF',
        //                 borderWidth: 1
        //             }]
        //         },
        //         options: {
        //             responsive: true,
        //             plugins: {
        //                 tooltip: {
        //                     callbacks: {
        //                         label: (tooltipItem) => `${tooltipItem.label}: Rp ${tooltipItem.raw.toLocaleString('id-ID')}`
        //                     }
        //                 }
        //             }
        //         }
        //     });
        // });
    </script>
</body>
</html>
