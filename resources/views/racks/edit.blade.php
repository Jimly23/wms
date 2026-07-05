@extends('layouts.app')

@section('content')
<div class="mb-6">
    <a href="{{ route('racks.index') }}" class="text-blue-600 hover:underline flex items-center text-sm font-medium">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Kembali ke Data Rak
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden max-w-3xl">
    <div class="p-6 border-b border-gray-200">
        <h2 class="text-xl font-bold text-gray-800">Edit Data Rak</h2>
        <p class="text-sm text-gray-500 mt-1">Ubah informasi untuk rak {{ $rack->nama_rak }}.</p>
    </div>

    <form action="{{ route('racks.update', $rack->id) }}" method="POST" class="p-6">
        @csrf
        @method('PUT')
        <div class="space-y-6">
            <!-- Nama Rak -->
            <div>
                <label for="nama_rak" class="block text-sm font-medium text-gray-700 mb-1">Nama Rak <span class="text-red-500">*</span></label>
                <input type="text" name="nama_rak" id="nama_rak" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ old('nama_rak', $rack->nama_rak) }}" required>
                @error('nama_rak') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- Barcode -->
            <div>
                <label for="barcode" class="block text-sm font-medium text-gray-700 mb-1">Kode Barcode <span class="text-red-500">*</span></label>
                <input type="text" name="barcode" id="barcode" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ old('barcode', $rack->barcode) }}" required placeholder="Contoh: RK001">
                @error('barcode') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- Lokasi -->
            <div>
                <label for="lokasi" class="block text-sm font-medium text-gray-700 mb-1">Lokasi Rak</label>
                <input type="text" name="lokasi" id="lokasi" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ old('lokasi', $rack->lokasi) }}" placeholder="Contoh: Gudang A">
                @error('lokasi') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- Keterangan -->
            <div>
                <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-1">Keterangan Tambahan</label>
                <textarea name="keterangan" id="keterangan" rows="3" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">{{ old('keterangan', $rack->keterangan) }}</textarea>
                @error('keterangan') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="mt-8 flex justify-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition duration-200 shadow-sm">
                Update Data
            </button>
        </div>
    </form>
</div>
@endsection
