@extends('layouts.app')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Barang Keluar</h1>
        <p class="text-gray-500 text-sm mt-1">Kelola riwayat pengeluaran barang dari gudang.</p>
    </div>
    <a href="{{ route('goods-out.create') }}" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-200 shadow-sm flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
        </svg>
        Input Barang Keluar
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Barang</th>
                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Qty (Jumlah)</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keterangan</th>
                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Petugas</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($transactions as $trx)
            <tr class="hover:bg-gray-50 transition duration-150">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">{{ \Carbon\Carbon::parse($trx->tanggal)->format('d/m/Y') }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900">{{ $trx->item->nama_barang ?? 'Unknown' }}</div>
                    <div class="text-xs text-gray-500">{{ $trx->item->kode_barang ?? '' }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                        - {{ $trx->qty }}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ Str::limit($trx->keterangan, 20) ?? '-' }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">{{ $trx->createdBy->name ?? 'System' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-10 whitespace-nowrap text-sm text-gray-500 text-center">
                    Belum ada riwayat barang keluar. <a href="{{ route('goods-out.create') }}" class="text-blue-600 hover:underline">Buat input baru</a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
