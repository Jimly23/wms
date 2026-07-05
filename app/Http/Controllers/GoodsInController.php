<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GoodsIn;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class GoodsInController extends Controller
{
    public function index()
    {
        $transactions = GoodsIn::with(['item', 'createdBy'])->orderBy('tanggal', 'desc')->orderBy('created_at', 'desc')->get();
        return view('goods_in.index', compact('transactions'));
    }

    public function create()
    {
        $items = Item::all();
        return view('goods_in.create', compact('items'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_id' => 'required|exists:items,id',
            'tanggal' => 'required|date',
            'qty' => 'required|integer|min:1',
            'keterangan' => 'nullable|string',
        ]);

        $validated['created_by'] = Auth::id();

        $goodsIn = GoodsIn::create($validated);
        
        // Auto increment stock
        $item = Item::find($validated['item_id']);
        $item->increment('stok', $validated['qty']);

        return redirect()->route('goods-in.index')->with('success', 'Transaksi barang masuk berhasil disimpan dan stok bertambah.');
    }

    public function show(GoodsIn $goodsIn)
    {
        return view('goods_in.show', compact('goodsIn'));
    }

    public function destroy(GoodsIn $goodsIn)
    {
        // Revert stok sebelum hapus (optional, but good practice)
        $item = Item::find($goodsIn->item_id);
        if ($item) {
            $item->decrement('stok', $goodsIn->qty);
        }
        
        $goodsIn->delete();
        return redirect()->route('goods-in.index')->with('success', 'Transaksi berhasil dihapus dan stok dikembalikan.');
    }
}
