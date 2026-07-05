<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Rack;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::with('rack')->orderBy('created_at', 'desc')->get();
        return view('items.index', compact('items'));
    }

    public function create()
    {
        $racks = Rack::all();
        return view('items.create', compact('racks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'rack_id' => 'required|exists:racks,id',
            'kode_barang' => 'required|string|max:50|unique:items',
            'nama_barang' => 'required|string|max:150',
            'stok' => 'required|integer|min:0',
            'satuan' => 'required|string|max:30',
            'keterangan' => 'nullable|string',
        ]);

        Item::create($validated);
        return redirect()->route('items.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function edit(Item $item)
    {
        $racks = Rack::all();
        return view('items.edit', compact('item', 'racks'));
    }

    public function update(Request $request, Item $item)
    {
        $validated = $request->validate([
            'rack_id' => 'required|exists:racks,id',
            'kode_barang' => 'required|string|max:50|unique:items,kode_barang,'.$item->id,
            'nama_barang' => 'required|string|max:150',
            'stok' => 'required|integer|min:0',
            'satuan' => 'required|string|max:30',
            'keterangan' => 'nullable|string',
        ]);

        $item->update($validated);
        return redirect()->route('items.index')->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy(Item $item)
    {
        // Peringatan: hal ini akan menghapus history jika cascade
        $item->delete();
        return redirect()->route('items.index')->with('success', 'Barang berhasil dihapus.');
    }
}
