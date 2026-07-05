<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('login.post');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    
    // Master data
    Route::resource('racks', \App\Http\Controllers\RackController::class);
    Route::get('/racks/{rack}/barcode', [\App\Http\Controllers\RackController::class, 'barcode'])->name('racks.barcode');

    Route::resource('items', \App\Http\Controllers\ItemController::class);

    Route::resource('goods-in', \App\Http\Controllers\GoodsInController::class)->except(['edit', 'update']);
    Route::resource('goods-out', \App\Http\Controllers\GoodsOutController::class)->except(['edit', 'update']);

    // Barcode Scan
    Route::get('/scan', [\App\Http\Controllers\ScanController::class, 'index'])->name('scan.index');
    Route::get('/scan/search', [\App\Http\Controllers\ScanController::class, 'search'])->name('scan.search');

    // Laporan
    Route::get('/reports', [\App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export', [\App\Http\Controllers\ReportController::class, 'exportPdf'])->name('reports.export');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
