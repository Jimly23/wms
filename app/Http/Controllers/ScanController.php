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
            return view('scan.index', ['rackResult' => $rack, 'keyword' => $keyword]);
        }
        
        $item = Item::where('kode_barang', $keyword)->with('rack')->first();
        if ($item) {
            return view('scan.index', ['itemResult' => $item, 'keyword' => $keyword]);
        }

        return view('scan.index', ['notFound' => true, 'keyword' => $keyword]);
    }
}
