@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Scan Barcode</h1>
            <p class="text-gray-500 text-sm mt-1">Arahkan scanner ke kode barcode rak atau barang.</p>
        </div>
    </div>

    <!-- Scanner Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 mb-8">
        <form action="{{ route('scan.search') }}" method="GET" class="flex flex-col md:flex-row items-center gap-4">
            <div class="flex-1 w-full relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                    </svg>
                </div>
                <input type="text" name="barcode" id="barcodeInput" class="w-full pl-12 pr-4 py-4 rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-lg shadow-sm" placeholder="Scan atau ketik kode barcode di sini..." value="{{ old('barcode', $keyword ?? '') }}" autofocus required>
            </div>
            <button type="submit" class="w-full md:w-auto bg-blue-600 hover:bg-blue-700 text-white font-semibold py-4 px-8 rounded-xl transition duration-200 shadow-sm text-lg flex items-center justify-center">
                Cari Data
            </button>
        </form>
    </div>

    <!-- Search Results -->
    @if(isset($keyword))
        @if(isset($notFound) && $notFound)
            <div class="bg-red-50 border-l-4 border-red-400 py-6 px-8 rounded-xl shadow-sm text-center">
                <p class="text-xl text-red-700 font-semibold mb-2">Data Tidak Ditemukan</p>
                <p class="text-red-500">Barcode/Kode <span class="font-bold underline">{{ $keyword }}</span> tidak terdaftar dalam sistem.</p>
                <p class="text-sm text-red-400 mt-2">Pastikan barcode yang discan adalah bagian dari Gudang.</p>
            </div>
        @endif

        @if(isset($rackResult))
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-blue-600 px-6 py-4">
                    <h3 class="text-lg font-bold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        Hasil: Rak Ditemukan
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 gap-4 mb-6 text-sm">
                        <div>
                            <span class="block text-gray-500 mb-1">Nama Rak</span>
                            <span class="font-bold text-gray-900 text-lg">{{ $rackResult->nama_rak }}</span>
                        </div>
                        <div>
                            <span class="block text-gray-500 mb-1">Kode Barcode</span>
                            <span class="font-semibold text-gray-900">{{ $rackResult->barcode }}</span>
                        </div>
                        <div>
                            <span class="block text-gray-500 mb-1">Lokasi</span>
                            <span class="font-medium text-gray-700">{{ $rackResult->lokasi ?? '-' }}</span>
                        </div>
                    </div>
                    
                    <h4 class="font-bold text-gray-800 mb-3 border-b pb-2">Daftar Barang di Rak Ini</h4>
                    @if($rackResult->items->count() > 0)
                        <ul class="space-y-3">
                            @foreach($rackResult->items as $item)
                                <li class="bg-gray-50 p-3 rounded flex justify-between items-center border border-gray-100">
                                    <div>
                                        <p class="font-bold text-gray-800">{{ $item->nama_barang }}</p>
                                        <p class="text-xs text-gray-500">{{ $item->kode_barang }}</p>
                                    </div>
                                    <div class="text-right">
                                        <span class="block font-bold text-indigo-600 text-lg">{{ $item->stok }} <span class="text-sm font-normal text-gray-500">{{ $item->satuan }}</span></span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-500 text-sm italic">Rak ini kosong. Tidak ada barang.</p>
                    @endif

                    <h4 class="font-bold text-gray-800 mt-8 mb-3 border-b pb-2">Riwayat Transaksi (Keluar / Masuk) di Rak Ini</h4>
                    @if(isset($history) && $history->count() > 0)
                        <div class="overflow-x-auto rounded-lg border border-gray-200">
                            <table class="min-w-full divide-y divide-gray-200 text-sm">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Tgl</th>
                                        <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Barang</th>
                                        <th class="px-4 py-3 text-center font-medium text-gray-500 uppercase tracking-wider">Tipe</th>
                                        <th class="px-4 py-3 text-center font-medium text-gray-500 uppercase tracking-wider">Qty</th>
                                        <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Petugas</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($history as $trx)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 whitespace-nowrap">{{ \Carbon\Carbon::parse($trx->tanggal)->format('d/m/Y') }}</td>
                                        <td class="px-4 py-3">{{ $trx->item->nama_barang ?? '-' }}</td>
                                        <td class="px-4 py-3 text-center">
                                            @if($trx->transaction_type == 'masuk')
                                                <span class="inline-flex px-2 text-xs font-bold leading-5 rounded-full bg-green-100 text-green-700">Masuk</span>
                                            @else
                                                <span class="inline-flex px-2 text-xs font-bold leading-5 rounded-full bg-red-100 text-red-700">Keluar</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-center font-bold">{{ $trx->qty }}</td>
                                        <td class="px-4 py-3 text-gray-500 whitespace-nowrap">{{ $trx->createdBy->name ?? '-' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500 text-sm italic">Belum ada riwayat transaksi barang masuk atau keluar untuk rak ini.</p>
                    @endif
                </div>
            </div>
        @endif

        @if(isset($itemResult))
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-indigo-600 px-6 py-4">
                    <h3 class="text-lg font-bold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        Hasil: Barang Ditemukan
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 gap-y-6 gap-x-4 mb-4">
                        <div>
                            <span class="block text-gray-500 text-sm mb-1">Nama Barang</span>
                            <span class="font-bold text-gray-900 text-xl">{{ $itemResult->nama_barang }}</span>
                        </div>
                        <div>
                            <span class="block text-gray-500 text-sm mb-1">Kode Barang</span>
                            <span class="font-bold text-indigo-600 text-lg">{{ $itemResult->kode_barang }}</span>
                        </div>
                        <div>
                            <span class="block text-gray-500 text-sm mb-1">Total Stok Tersedia</span>
                            <span class="font-bold text-gray-900 text-2xl text-emerald-600">{{ $itemResult->stok }} <span class="text-sm font-medium text-gray-600">{{ $itemResult->satuan }}</span></span>
                        </div>
                        <div>
                            <span class="block text-gray-500 text-sm mb-1">Rak Penyimpanan</span>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                {{ $itemResult->rack->nama_rak ?? 'Tidak Ada Lokasi' }}
                            </span>
                        </div>
                        <div class="col-span-2">
                            <span class="block text-gray-500 text-sm mb-1">Keterangan / Deskripsi</span>
                            <p class="text-gray-700 text-sm">{{ $itemResult->keterangan ?? 'Tidak ada keterangan tambahan.' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endif
</div>

<!-- Auto focus snippet for physical barcode scanners -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const barcodeInput = document.getElementById('barcodeInput');
        
        // Ensure focus whenever user clicks outside
        document.body.addEventListener('click', function(e) {
            if(e.target.tagName !== 'INPUT' && e.target.tagName !== 'BUTTON' && e.target.tagName !== 'A') {
                barcodeInput.focus();
            }
        });
        
        setTimeout(() => {
            barcodeInput.focus();
        }, 100);
    });
</script>
@endsection
