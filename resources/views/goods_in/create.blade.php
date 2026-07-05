@extends('layouts.app')

@section('content')
<div class="mb-6">
    <a href="{{ route('goods-in.index') }}" class="text-blue-600 hover:underline flex items-center text-sm font-medium">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Kembali ke Riwayat Barang Masuk
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden max-w-3xl">
    <div class="p-6 border-b border-gray-200 bg-green-50">
        <h2 class="text-xl font-bold text-green-800">Input Barang Masuk</h2>
        <p class="text-sm text-green-700 mt-1">Transaksi ini akan menambah jumlah stok secara otomatis.</p>
    </div>

    <form action="{{ route('goods-in.store') }}" method="POST" class="p-6">
        @csrf
        <div class="space-y-6">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Pilih Barang -->
                <div>
                    <label for="item_id" class="block text-sm font-medium text-gray-700 mb-1">Barang <span class="text-red-500">*</span></label>
                    <select name="item_id" id="item_id" class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500" required>
                        <option value="">-- Pilih Barang --</option>
                        @foreach($items as $item)
                            <option value="{{ $item->id }}" {{ old('item_id') == $item->id ? 'selected' : '' }}>{{ $item->kode_barang }} - {{ $item->nama_barang }}</option>
                        @endforeach
                    </select>
                    @error('item_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Tanggal -->
                <div>
                    <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-1">Tanggal <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal" id="tanggal" class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                    @error('tanggal') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Jumlah / Qty -->
            <div class="w-full md:w-1/2">
                <label for="qty" class="block text-sm font-medium text-gray-700 mb-1">Jumlah (Qty) <span class="text-red-500">*</span></label>
                <input type="number" min="1" name="qty" id="qty" class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500" value="{{ old('qty', 1) }}" required>
                @error('qty') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- Keterangan -->
            <div>
                <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-1">Keterangan / Referensi</label>
                <textarea name="keterangan" id="keterangan" rows="3" class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500" placeholder="Misal: Nomor PO, nama suplier, dll...">{{ old('keterangan') }}</textarea>
                @error('keterangan') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="mt-8 flex justify-end">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-6 rounded-lg transition duration-200 shadow-sm flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
                Simpan & Tambah Stok
            </button>
        </div>
    </form>
</div>
@endsection
