@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Dashboard</h1>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 flex flex-col justify-between">
            <p class="text-sm font-medium text-gray-500">Total Rak</p>
            <p class="text-3xl font-bold text-blue-600 mt-2">{{ number_format($totalRak) }}</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 flex flex-col justify-between">
            <!-- Represent Total Stok with a different color optionally -->
            <p class="text-sm font-medium text-gray-500">Total Barang/Item</p>
            <p class="text-3xl font-bold text-indigo-600 mt-2">{{ number_format($totalBarang) }}</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 flex flex-col justify-between">
            <p class="text-sm font-medium text-emerald-600">Total Stok Fisik</p>
            <p class="text-3xl font-bold text-emerald-700 mt-2">{{ number_format($totalStok) }}</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 flex flex-col justify-between">
            <p class="text-sm font-medium text-gray-500">Masuk / Keluar (Hari ini)</p>
            <div class="flex items-center space-x-4 mt-2">
                <p class="text-2xl font-bold text-green-600 flex items-center" title="Barang Masuk">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                    {{ number_format($masukHariIni) }}
                </p>
                <p class="text-2xl font-bold text-red-600 flex items-center" title="Barang Keluar">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                    {{ number_format($keluarHariIni) }}
                </p>
            </div>
        </div>
    </div>

    <!-- Chart -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Grafik Barang Masuk & Keluar (7 Hari Terakhir)</h3>
        <div class="relative h-72 w-full">
            <canvas id="transactionChart"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('transactionChart').getContext('2d');
        const transactionChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($labels) !!},
                datasets: [
                    {
                        label: 'Barang Masuk',
                        data: {!! json_encode($dataMasuk) !!},
                        borderColor: 'rgb(34, 197, 94)', // Tailwind green-500
                        backgroundColor: 'rgba(34, 197, 94, 0.1)',
                        tension: 0.3,
                        fill: true
                    },
                    {
                        label: 'Barang Keluar',
                        data: {!! json_encode($dataKeluar) !!},
                        borderColor: 'rgb(239, 68, 68)', // Tailwind red-500
                        backgroundColor: 'rgba(239, 68, 68, 0.1)',
                        tension: 0.3,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    </script>
@endsection
