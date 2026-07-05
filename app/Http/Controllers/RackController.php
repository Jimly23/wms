<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rack;
use Illuminate\Support\Str;

class RackController extends Controller
{
    public function index()
    {
        $racks = Rack::orderBy('created_at', 'desc')->get();
        return view('racks.index', compact('racks'));
    }

    public function create()
    {
        return view('racks.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_rak' => 'required|string|max:100',
            'barcode' => 'required|string|max:100|unique:racks',
            'lokasi' => 'nullable|string|max:150',
            'keterangan' => 'nullable|string',
        ]);

        Rack::create($validated);
        return redirect()->route('racks.index')->with('success', 'Rak berhasil ditambahkan.');
    }

    public function edit(Rack $rack)
    {
        return view('racks.edit', compact('rack'));
    }

    public function update(Request $request, Rack $rack)
    {
        $validated = $request->validate([
            'nama_rak' => 'required|string|max:100',
            'barcode' => 'required|string|max:100|unique:racks,barcode,'.$rack->id,
            'lokasi' => 'nullable|string|max:150',
            'keterangan' => 'nullable|string',
        ]);

        $rack->update($validated);
        return redirect()->route('racks.index')->with('success', 'Rak berhasil diperbarui.');
    }

    public function destroy(Rack $rack)
    {
        // Karena cascading ON DELETE, barang-barang yang terhubung juga akan terhapus.
        // Hati-hati dalam implementasinya secara riil.
        $rack->delete();
        return redirect()->route('racks.index')->with('success', 'Rak berhasil dihapus.');
    }

    public function barcode(Rack $rack)
    {
        // Dummy view untuk generate/tampilkan barcode fisik 
        // menggunakan library barcode / print
        return view('racks.barcode', compact('rack'));
    }
}
