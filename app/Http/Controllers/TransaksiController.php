<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        $data = Transaksi::all();
        return view('transaksi.index', compact('data'));
    }

    public function create()
    {
        return view('transaksi.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'idTransaksi' => 'required|string|max:10|unique:transaksis,idTransaksi',
            'idPelanggan' => 'required|exists:pelanggans,idPelanggan',
            'idKaryawan' => 'required|exists:karyawans,idKaryawan',
            'id_outlet' => 'required|exists:outlets,id_outlet',
            'tanggal' => 'nullable|date',
            'total' => 'nullable|numeric',
        ]);

        Transaksi::create($request->all());

        return redirect()->route('transaksi.index')
            ->with('success', 'Transaksi created successfully.');
    }

    public function show($id)
    {
        $item = Transaksi::findOrFail($id);
        return view('transaksi.show', compact('item'));
    }

    public function edit($id)
    {
        $item = Transaksi::findOrFail($id);
        return view('transaksi.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'idPelanggan' => 'required|exists:pelanggans,idPelanggan',
            'idKaryawan' => 'required|exists:karyawans,idKaryawan',
            'id_outlet' => 'required|exists:outlets,id_outlet',
            'tanggal' => 'nullable|date',
            'total' => 'nullable|numeric',
        ]);

        $item = Transaksi::findOrFail($id);
        $item->update($request->all());

        return redirect()->route('transaksi.index')
            ->with('success', 'Transaksi updated successfully.');
    }

    public function destroy($id)
    {
        $item = Transaksi::findOrFail($id);
        $item->delete();

        return redirect()->route('transaksi.index')
            ->with('success', 'Transaksi deleted successfully.');
    }
}