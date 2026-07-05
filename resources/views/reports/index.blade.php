@extends('layouts.app')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Laporan Transaksi</h1>
        <p class="text-gray-500 text-sm mt-1">Filter dan cetak laporan barang masuk / keluar.</p>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-8 p-6">
    <h2 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Filter Laporan</h2>
    <form action="{{ route('reports.index') }}" method="GET" class="flex flex-col md:flex-row items-end gap-4" id="filterForm">
        <div class="w-full md:w-1/4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Mulai Tanggal</label>
            <input type="date" name="start_date" id="start_date" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ $startDate }}">
        </div>
        <div class="w-full md:w-1/4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Sampai Tanggal</label>
            <input type="date" name="end_date" id="end_date" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ $endDate }}">
        </div>
        <div class="w-full md:w-1/4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Transaksi</label>
            <select name="type" id="type" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                <option value="masuk" {{ $type == 'masuk' ? 'selected' : '' }}>Barang Masuk</option>
                <option value="keluar" {{ $type == 'keluar' ? 'selected' : '' }}>Barang Keluar</option>
            </select>
        </div>
        <div class="w-full md:w-1/4 flex space-x-2">
            <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg shadow-sm">
                Filter Tampil
            </button>
            <button type="button" onclick="exportPdf()" class="flex-1 bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg shadow-sm flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                PDF
            </button>
        </div>
    </form>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
        <h3 class="font-bold text-gray-700">Pratinjau Hasil (Laporan Barang {{ ucfirst($type) }})</h3>
        <p class="text-xs text-gray-500">Menampilkan hasil sesuai dengan filter yang dipilih.</p>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Barang</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Qty</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stok Akhir</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keterangan</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Petugas</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($transactions as $trx)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ \Carbon\Carbon::parse($trx->tanggal)->format('d/m/Y') }}</td>
                    <td class="px-4 py-3">
                        <div class="text-sm font-medium text-gray-900">{{ $trx->item->nama_barang ?? '-' }}</div>
                        <div class="text-xs text-gray-500">{{ $trx->item->kode_barang ?? '-' }} | {{ $trx->item->rack->nama_rak ?? 'Tanpa Rak' }}</div>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-center">
                        <span class="inline-flex px-2 rounded-full text-xs font-bold {{ $type == 'masuk' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $type == 'masuk' ? '+' : '-' }}{{ $trx->qty }}
                        </span>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                        {{ $trx->item->stok ?? 0 }} {{ $trx->item->satuan ?? '' }}
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ Str::limit($trx->keterangan, 30) }}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-center text-xs text-gray-500">{{ $trx->createdBy->name ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-8 text-center text-gray-500 text-sm">Tidak ada transaksi ditemukan pada range tanggal ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    function exportPdf() {
        const form = document.getElementById('filterForm');
        // Retrieve current values
        const type = document.getElementById('type').value;
        const startDate = document.getElementById('start_date').value;
        const endDate = document.getElementById('end_date').value;
        
        // Build export URL with params
        const url = `{{ route('reports.export') }}?type=${type}&start_date=${startDate}&end_date=${endDate}`;
        window.open(url, '_blank');
    }
</script>
@endsection
