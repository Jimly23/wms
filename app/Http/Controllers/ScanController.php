<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rack;
use App\Models\Item;

class ScanController extends Controller
{
    public function index()
    {
        return view('scan.index');
    }

    public function search(Request $request)
    {
        $keyword = $request->input('barcode');
        if (!$keyword) {
            return back();
        }

        $rack = Rack::where('barcode', $keyword)->with('items')->first();
        if ($rack) {
            $goodsIn = \App\Models\GoodsIn::whereHas('item', function($q) use ($rack) {
                $q->where('rack_id', $rack->id);
            })->with(['item', 'createdBy'])->get()->map(function($t) {
                $t->transaction_type = 'masuk';
                return $t;
            });
            
            $goodsOut = \App\Models\GoodsOut::whereHas('item', function($q) use ($rack) {
                $q->where('rack_id', $rack->id);
            })->with(['item', 'createdBy'])->get()->map(function($t) {
                $t->transaction_type = 'keluar';
                return $t;
            });
            
            $history = $goodsIn->concat($goodsOut)->sortByDesc('tanggal')->values();

            return view('scan.index', [
                'rackResult' => $rack, 
                'history' => $history,
                'keyword' => $keyword
            ]);
        }
        
        $item = Item::where('kode_barang', $keyword)->with('rack')->first();
        if ($item) {
            return view('scan.index', ['itemResult' => $item, 'keyword' => $keyword]);
        }

        return view('scan.index', ['notFound' => true, 'keyword' => $keyword]);
    }
}
