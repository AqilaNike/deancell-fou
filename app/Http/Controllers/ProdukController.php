<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index()
    {
        $data = Produk::all();
        return view('produk.index', compact('data'));
    }

    public function create()
    {
        return view('produk.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'idProduk' => 'required|string|max:10|unique:produks,idProduk',
            'harga_beli' => 'nullable|numeric',
            'harga_jual' => 'nullable|numeric',
            'stok' => 'nullable|integer',
            'masa_aktif' => 'nullable|integer',
            'biaya_admin' => 'nullable|numeric',
        ]);

        Produk::create($request->all());

        return redirect()->route('produk.index')
            ->with('success', 'Produk created successfully.');
    }

    public function show($id)
    {
        $item = Produk::findOrFail($id);
        return view('produk.show', compact('item'));
    }

    public function edit($id)
    {
        $item = Produk::findOrFail($id);
        return view('produk.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'harga_beli' => 'nullable|numeric',
            'harga_jual' => 'nullable|numeric',
            'stok' => 'nullable|integer',
            'masa_aktif' => 'nullable|integer',
            'biaya_admin' => 'nullable|numeric',
        ]);

        $item = Produk::findOrFail($id);
        $item->update($request->all());

        return redirect()->route('produk.index')
            ->with('success', 'Produk updated successfully.');
    }

    public function destroy($id)
    {
        $item = Produk::findOrFail($id);
        $item->delete();

        return redirect()->route('produk.index')
            ->with('success', 'Produk deleted successfully.');
    }
}