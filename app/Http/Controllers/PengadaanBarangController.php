<?php

namespace App\Http\Controllers;

use App\Models\PengadaanBarang;
use Illuminate\Http\Request;

class PengadaanBarangController extends Controller
{
    public function index()
    {
        $data = PengadaanBarang::all();
        return view('pengadaan_barang.index', compact('data'));
    }

    public function create()
    {
        return view('pengadaan_barang.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'idPengadaan' => 'required|string|max:10|unique:pengadaan_barangs,idPengadaan',
            'tanggal_pesan' => 'nullable|date',
            'tanggal_terima' => 'nullable|date',
            'total_biaya' => 'nullable|numeric',
        ]);

        PengadaanBarang::create($request->all());

        return redirect()->route('pengadaan_barang.index')
            ->with('success', 'PengadaanBarang created successfully.');
    }

    public function show($id)
    {
        $item = PengadaanBarang::findOrFail($id);
        return view('pengadaan_barang.show', compact('item'));
    }

    public function edit($id)
    {
        $item = PengadaanBarang::findOrFail($id);
        return view('pengadaan_barang.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'tanggal_pesan' => 'nullable|date',
            'tanggal_terima' => 'nullable|date',
            'total_biaya' => 'nullable|numeric',
        ]);

        $item = PengadaanBarang::findOrFail($id);
        $item->update($request->all());

        return redirect()->route('pengadaan_barang.index')
            ->with('success', 'PengadaanBarang updated successfully.');
    }

    public function destroy($id)
    {
        $item = PengadaanBarang::findOrFail($id);
        $item->delete();

        return redirect()->route('pengadaan_barang.index')
            ->with('success', 'PengadaanBarang deleted successfully.');
    }
}