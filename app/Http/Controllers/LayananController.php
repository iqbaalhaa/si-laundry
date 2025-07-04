<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Layanan;

class LayananController extends Controller
{
    public function index()
{
    // Ambil semua data layanan dari database
    $data = \App\Models\Layanan::orderBy('created_at', 'desc')->get();

    // Kirim ke view
    return view('admin.layanan.index', compact('data'));
}


    public function create()
    {
        return view('admin.layanan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_layanan' => 'required|string|max:255',
            'harga_per_satuan' => 'required|numeric|min:0',
            'satuan' => 'required|string|max:50',
            'deskripsi' => 'nullable|string',
        ]);
        
        Layanan::create($request->all());

        return redirect()->route('layanan.index')->with('success', 'Layanan berhasil ditambahkan.');
    }

    public function edit(Layanan $layanan)
    {
        return view('admin.layanan.edit', compact('layanan'));
    }

    public function update(Request $request, Layanan $layanan)
    {
        $request->validate([
            'nama_layanan' => 'required|string|max:255',
            'harga_per_satuan' => 'required|numeric|min:0',
            'satuan' => 'required|string|max:50',
            'deskripsi' => 'nullable|string',
        ]);
        
        Layanan::create($request->all());

        return redirect()->route('layanan.index')->with('success', 'Layanan berhasil diupdate.');
    }

    public function destroy(Layanan $layanan)
    {
        $layanan->delete();

        return redirect()->route('layanan.index')->with('success', 'Layanan berhasil dihapus.');
    }
}
