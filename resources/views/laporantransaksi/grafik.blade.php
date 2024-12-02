@extends('layout.sidebar')

@section('content')
<div class="container mt-4">
    <h4 class="text-dark mb-4">Grafik Penjualan</h4>
    
    <!-- Button Back -->
    <div class="d-flex justify-content-end mb-4">
        <a href="{{ route('laporantransaksi.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Filter Form -->
    <div class="card shadow-sm p-4 mb-4 border-0">
        <h5 class="card-title text-primary fw-bold mb-4">
            <i class="bi bi-funnel-fill"></i> Filter Grafik Penjualan
        </h5>
        <form method="GET" action="{{ route('laporantransaksi.grafik') }}">
            <div class="row g-3">
                <!-- Filter Member -->
                <div class="col-md-3">
                    <label for="member_id" class="form-label text-secondary fw-semibold">
                        <i class="bi bi-person-fill"></i> Member
                    </label>
                    <select name="member_id" id="member_id" class="form-select">
                        <option value="">Semua Member</option>
                        @foreach($members as $member)
                            <option value="{{ $member->id_member }}" {{ request('member_id') == $member->id_member ? 'selected' : '' }}>
                                {{ $member->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <!-- Filter Level Member -->
                <div class="col-md-3">
                    <label for="level_member" class="form-label text-secondary fw-semibold">
                        <i class="bi bi-star-fill"></i> Level Member
                    </label>
                    <select name="level_member" id="level_member" class="form-select">
                        <option value="">Semua Level</option>
                        <option value="Gold" {{ request('level_member') == 'Gold' ? 'selected' : '' }}>Gold</option>
                        <option value="Silver" {{ request('level_member') == 'Silver' ? 'selected' : '' }}>Silver</option>
                        <option value="Bronze" {{ request('level_member') == 'Bronze' ? 'selected' : '' }}>Bronze</option>
                    </select>
                </div>

                 <!-- Filter Bulan -->
                 <div class="col-md-3">
                    <label for="month" class="form-label text-secondary fw-semibold">
                        <i class="bi bi-calendar-month-fill"></i> Bulan
                    </label>
                    <select name="month" id="month" class="form-select">
                        @foreach(range(1, 12) as $month)
                            <option value="{{ str_pad($month, 2, '0', STR_PAD_LEFT) }}" {{ request('month', $selectedMonth) == str_pad($month, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                                {{ DateTime::createFromFormat('!m', $month)->format('F') }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mt-4 d-flex gap-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search"></i> Terapkan Filter
                    </button>
                    <a href="{{ route('laporantransaksi.grafik') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-counterclockwise"></i> Reset
                    </a>
                </div>
                
                {{-- <!-- Filter Tanggal Mulai -->
                <div class="col-md-3">
                    <label for="start_date" class="form-label text-secondary fw-semibold">
                        <i class="bi bi-calendar2-plus"></i> Tanggal Mulai
                    </label>
                    <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request('start_date') }}">
                </div>
                <!-- Filter Tanggal Selesai -->
                <div class="col-md-3">
                    <label for="end_date" class="form-label text-secondary fw-semibold">
                        <i class="bi bi-calendar2-check"></i> Tanggal Selesai
                    </label>
                    <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request('end_date') }}">
                </div> --}}
            </div>
        </form>
    </div>

    <!-- Row for Charts -->
    <div class="row">
        <!-- Line Chart -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-primary">Grafik Penjualan Harian</h5>
                    <div class="chart-container" style="position: relative; height: 600px; width: 100%;">
                        <canvas id="salesChart" style="height: 100%; width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pie Chart -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-primary">Grafik Penjualan Produk (Bulan: {{ DateTime::createFromFormat('!m', $selectedMonth)->format('F') }})</h5>
                    <div class="chart-container" style="position: relative; height: 600px; width: 100%;">
                        <canvas id="pieChart" style="height: 100%; width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script untuk Chart -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Line Chart
        const ctxLine = document.getElementById('salesChart').getContext('2d');
        const labels = {!! json_encode($labels) !!};
        const data = {!! json_encode($data) !!};

        new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total Penjualan Harian (Rp)',
                    data: data,
                    borderColor: '#3B82F6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4,
                    fill: true,
                    pointRadius: 5,
                    pointBackgroundColor: '#3B82F6',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: true },
                },
                scales: {
                    y: { beginAtZero: true },
                }
            }
        });

        // Pie Chart
        const ctxPie = document.getElementById('pieChart').getContext('2d');
        const pieLabels = {!! json_encode($pieLabels) !!};
        const pieValues = {!! json_encode($pieValues) !!};

        new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: pieLabels,
                datasets: [{
                    data: pieValues,
                    backgroundColor: [
                        '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#F7464A',
                    ],
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: true },
                },
            }
        });

    });
</script>
@endsection
