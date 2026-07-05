<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Stok</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 flex min-h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-md flex flex-col">
        <div class="p-6 border-b border-gray-200 flex-shrink-0">
            <h2 class="text-xl font-bold text-blue-600">Simpel Stok</h2>
            <div class="text-xs text-gray-500 mt-1">Hello, {{ Auth::user()->name }}</div>
        </div>
        <nav class="p-4 space-y-2 flex-grow overflow-y-auto">
            <a href="{{ route('dashboard') }}" class="block px-4 py-2 {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-700 font-medium' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg">Dashboard</a>
            
            <div class="pt-4 pb-2">
                <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Master Data</p>
            </div>
            <a href="{{ route('racks.index') }}" class="block px-4 py-2 {{ request()->routeIs('racks.*') ? 'bg-blue-50 text-blue-700 font-medium' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg">Data Rak</a>
            <a href="{{ route('items.index') }}" class="block px-4 py-2 {{ request()->routeIs('items.*') ? 'bg-blue-50 text-blue-700 font-medium' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg">Data Barang</a>

            <div class="pt-4 pb-2">
                <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Transaksi</p>
            </div>
            <a href="{{ route('goods-in.index') }}" class="block px-4 py-2 {{ request()->routeIs('goods-in.*') ? 'bg-blue-50 text-blue-700 font-medium' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg">Barang Masuk</a>
            <a href="{{ route('goods-out.index') }}" class="block px-4 py-2 {{ request()->routeIs('goods-out.*') ? 'bg-blue-50 text-blue-700 font-medium' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg">Barang Keluar</a>
            
            <div class="pt-4 pb-2">
                <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Lainnya</p>
            </div>
            <a href="{{ route('scan.index') }}" class="block px-4 py-2 {{ request()->routeIs('scan.*') ? 'bg-blue-50 text-blue-700 font-medium' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg">Scan Barcode</a>
            <a href="{{ route('reports.index') }}" class="block px-4 py-2 {{ request()->routeIs('reports.*') ? 'bg-blue-50 text-blue-700 font-medium' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg">Laporan</a>
            
        </nav>
        <div class="p-4 border-t border-gray-200">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50 rounded-lg font-medium">Logout</button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8 overflow-y-auto">
        <!-- Display Flash Messages -->
        @if(session('success'))
            <div class="mb-4 bg-green-50 border-l-4 border-green-400 p-4 rounded text-green-700">
                <p>{{ session('success') }}</p>
            </div>
        @endif
        @if(session('error'))
            <div class="mb-4 bg-red-50 border-l-4 border-red-400 p-4 rounded text-red-700">
                <p>{{ session('error') }}</p>
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>
