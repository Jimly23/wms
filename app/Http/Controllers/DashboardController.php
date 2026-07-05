<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rack;
use App\Models\Item;
use App\Models\GoodsIn;
use App\Models\GoodsOut;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalRak = Rack::count();
        $totalBarang = Item::count();
        $totalStok = Item::sum('stok');

        $today = Carbon::today();
        $masukHariIni = GoodsIn::whereDate('tanggal', $today)->sum('qty');
        $keluarHariIni = GoodsOut::whereDate('tanggal', $today)->sum('qty');

        // Chart data for last 7 days
        $labels = [];
        $dataMasuk = [];
        $dataKeluar = [];

        for($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $labels[] = $date->format('d/m');
            $dataMasuk[] = GoodsIn::whereDate('tanggal', $date)->sum('qty');
            $dataKeluar[] = GoodsOut::whereDate('tanggal', $date)->sum('qty');
        }

        return view('dashboard', compact(
            'totalRak', 'totalBarang', 'totalStok', 
            'masukHariIni', 'keluarHariIni', 
            'labels', 'dataMasuk', 'dataKeluar'
        ));
    }
}
