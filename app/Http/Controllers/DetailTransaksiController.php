<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use Illuminate\Http\Request;

class DetailTransaksiController extends Controller
{
    public function index()
    {
        $data = DetailTransaksi::all();
        return view('detail_transaksi.index', compact('data'));
    }

    public function create()
    {
        return view('detail_transaksi.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'idTransaksi' => 'required|exists:transaksis,idTransaksi',
            'idProduk' => 'required|exists:produks,idProduk',
            'id_merchant' => 'nullable|exists:merchant_brilinks,id_merchant',
            'harga_satuan' => 'nullable|numeric',
            'jumlah' => 'nullable|integer',
            'total' => 'nullable|numeric',
        ]);

        DetailTransaksi::create($request->all());

        return redirect()->route('detail_transaksi.index')
            ->with('success', 'DetailTransaksi created successfully.');
    }

    public function show($id)
    {
        $item = DetailTransaksi::findOrFail($id);
        return view('detail_transaksi.show', compact('item'));
    }

    public function edit($id)
    {
        $item = DetailTransaksi::findOrFail($id);
        return view('detail_transaksi.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = DetailTransaksi::findOrFail($id);
        $item->update($request->all());

        return redirect()->route('detail_transaksi.index')
            ->with('success', 'DetailTransaksi updated successfully.');
    }

    public function destroy($id)
    {
        $item = DetailTransaksi::findOrFail($id);
        $item->delete();

        return redirect()->route('detail_transaksi.index')
            ->with('success', 'DetailTransaksi deleted successfully.');
    }
}