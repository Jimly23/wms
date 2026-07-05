<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GoodsOut;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class GoodsOutController extends Controller
{
    public function index()
    {
        $transactions = GoodsOut::with(['item', 'createdBy'])->orderBy('tanggal', 'desc')->orderBy('created_at', 'desc')->get();
        return view('goods_out.index', compact('transactions'));
    }

    public function create()
    {
        $items = Item::where('stok', '>', 0)->get(); // Hanya tampilkan yang ada stoknya
        return view('goods_out.create', compact('items'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_id' => 'required|exists:items,id',
            'tanggal' => 'required|date',
            'qty' => 'required|integer|min:1',
            'keterangan' => 'nullable|string',
        ]);

        $item = Item::find($validated['item_id']);
        
        if ($item->stok < $validated['qty']) {
            return back()->with('error', 'Stok tidak mencukupi! Stok saat ini: ' . $item->stok)->withInput();
        }

        $validated['created_by'] = Auth::id();

        $goodsOut = GoodsOut::create($validated);
        
        // Auto decrement stock
        $item->decrement('stok', $validated['qty']);

        return redirect()->route('goods-out.index')->with('success', 'Transaksi barang keluar berhasil disimpan dan stok berkurang.');
    }

    public function show(GoodsOut $goodsOut)
    {
        return view('goods_out.show', compact('goodsOut'));
    }

    public function destroy(GoodsOut $goodsOut)
    {
        // Revert stok sebelum hapus (optional)
        $item = Item::find($goodsOut->item_id);
        if ($item) {
            $item->increment('stok', $goodsOut->qty);
        }
        
        $goodsOut->delete();
        return redirect()->route('goods-out.index')->with('success', 'Transaksi berhasil dihapus dan stok direstorasi.');
    }
}
