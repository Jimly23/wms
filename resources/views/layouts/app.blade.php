<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Stok</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex flex-col md:flex-row">
    <!-- Mobile Header -->
    <div class="md:hidden bg-white shadow-sm p-4 flex justify-between items-center z-20 relative">
        <h2 class="text-xl font-bold text-blue-600">Simpel Stok</h2>
        <button id="mobileMenuBtn" class="text-gray-500 focus:outline-none p-2 rounded-md hover:bg-gray-100">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>

    <!-- Sidebar -->
    <aside id="sidebar" class="w-full md:w-64 bg-white shadow-md flex-col hidden md:flex z-10 md:min-h-screen">
        <div class="p-6 border-b border-gray-200 flex-shrink-0">
            <h2 class="text-xl font-bold text-blue-600">Simpel Stok</h2>
            <div class="text-xs text-gray-500 mt-1">Hello, {{ Auth::check() ? Auth::user()->name : 'Tamu (Guest)' }}</div>
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
            @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50 rounded-lg font-medium">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block text-center w-full px-4 py-2 bg-blue-600 text-white hover:bg-blue-700 rounded-lg font-medium shadow-sm transition">Login Staff</a>
            @endauth
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-4 md:p-8 overflow-y-auto w-full max-w-full">
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

    <!-- Mobile Menu Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var btn = document.getElementById('mobileMenuBtn');
            if(btn) {
                btn.addEventListener('click', function() {
                    var sidebar = document.getElementById('sidebar');
                    if (sidebar.classList.contains('hidden')) {
                        sidebar.classList.remove('hidden');
                        sidebar.classList.add('flex');
                    } else {
                        sidebar.classList.add('hidden');
                        sidebar.classList.remove('flex');
                    }
                });
            }
        });
    </script>
</body>
</html>
