@extends('layouts.app')

@section('content')
<div class="mb-6">
    <a href="{{ route('items.index') }}" class="text-blue-600 hover:underline flex items-center text-sm font-medium">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Kembali ke Data Barang
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden max-w-3xl">
    <div class="p-6 border-b border-gray-200">
        <h2 class="text-xl font-bold text-gray-800">Tambah Barang Baru</h2>
        <p class="text-sm text-gray-500 mt-1">Masukkan data master untuk item baru.</p>
    </div>

    <form action="{{ route('items.store') }}" method="POST" class="p-6">
        @csrf
        <div class="space-y-6">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Kode Barang -->
                <div>
                    <label for="kode_barang" class="block text-sm font-medium text-gray-700 mb-1">Kode Barang <span class="text-red-500">*</span></label>
                    <input type="text" name="kode_barang" id="kode_barang" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ old('kode_barang') }}" required placeholder="Contoh: BRG001">
                    @error('kode_barang') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Penamaan Rak -->
                <div>
                    <label for="rack_id" class="block text-sm font-medium text-gray-700 mb-1">Rak Penyimpanan <span class="text-red-500">*</span></label>
                    <select name="rack_id" id="rack_id" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
                        <option value="">-- Pilih Rak --</option>
                        @foreach($racks as $rack)
                            <option value="{{ $rack->id }}" {{ old('rack_id') == $rack->id ? 'selected' : '' }}>{{ $rack->nama_rak }} ({{ $rack->barcode }})</option>
                        @endforeach
                    </select>
                    @error('rack_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Nama Barang -->
            <div>
                <label for="nama_barang" class="block text-sm font-medium text-gray-700 mb-1">Nama Barang <span class="text-red-500">*</span></label>
                <input type="text" name="nama_barang" id="nama_barang" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ old('nama_barang') }}" required placeholder="Contoh: Pensil 2B">
                @error('nama_barang') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Satuan -->
                <div>
                    <label for="satuan" class="block text-sm font-medium text-gray-700 mb-1">Satuan <span class="text-red-500">*</span></label>
                    <input type="text" name="satuan" id="satuan" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ old('satuan') }}" required placeholder="Contoh: Pcs, Box, Kg">
                    @error('satuan') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Stok Awal -->
                <div>
                    <label for="stok" class="block text-sm font-medium text-gray-700 mb-1">Stok Awal <span class="text-red-500">*</span></label>
                    <input type="number" name="stok" id="stok" min="0" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ old('stok', 0) }}" required placeholder="0">
                    @error('stok') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Keterangan -->
            <div>
                <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-1">Keterangan Tambahan</label>
                <textarea name="keterangan" id="keterangan" rows="3" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">{{ old('keterangan') }}</textarea>
                @error('keterangan') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="mt-8 flex justify-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition duration-200 shadow-sm">
                Simpan Data
            </button>
        </div>
    </form>
</div>
@endsection
