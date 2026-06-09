<?php

namespace App\Http\Controllers;

use App\Models\DetailPengadaan;
use Illuminate\Http\Request;

class DetailPengadaanController extends Controller
{
    public function index()
    {
        $data = DetailPengadaan::all();
        return view('detail_pengadaan.index', compact('data'));
    }

    public function create()
    {
        return view('detail_pengadaan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'idPengadaan' => 'required|exists:pengadaan_barangs,idPengadaan',
            'idProduk' => 'required|exists:produks,idProduk',
            'jumlah_pesan' => 'nullable|integer',
            'total' => 'nullable|numeric',
        ]);

        DetailPengadaan::create($request->all());

        return redirect()->route('detail_pengadaan.index')
            ->with('success', 'DetailPengadaan created successfully.');
    }

    public function show($id)
    {
        $item = DetailPengadaan::findOrFail($id);
        return view('detail_pengadaan.show', compact('item'));
    }

    public function edit($id)
    {
        $item = DetailPengadaan::findOrFail($id);
        return view('detail_pengadaan.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'idPengadaan' => 'required|exists:pengadaan_barangs,idPengadaan',
            'idProduk' => 'required|exists:produks,idProduk',
            'jumlah_pesan' => 'nullable|integer',
            'total' => 'nullable|numeric',
        ]);

        $item = DetailPengadaan::findOrFail($id);
        $item->update($request->all());

        return redirect()->route('detail_pengadaan.index')
            ->with('success', 'DetailPengadaan updated successfully.');
    }

    public function destroy($id)
    {
        $item = DetailPengadaan::findOrFail($id);
        $item->delete();

        return redirect()->route('detail_pengadaan.index')
            ->with('success', 'DetailPengadaan deleted successfully.');
    }
}