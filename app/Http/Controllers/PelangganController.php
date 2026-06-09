<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index()
    {
        $data = Pelanggan::all();
        return view('pelanggan.index', compact('data'));
    }

    public function create()
    {
        return view('pelanggan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // Add validation rules here
            'idPelanggan' => 'required|string|max:10|unique:pelanggans,idPelanggan'
        ]);

        Pelanggan::create($request->all());

        return redirect()->route('pelanggan.index')
            ->with('success', 'Pelanggan created successfully.');
    }

    public function show($id)
    {
        $item = Pelanggan::findOrFail($id);
        return view('pelanggan.show', compact('item'));
    }

    public function edit($id)
    {
        $item = Pelanggan::findOrFail($id);
        return view('pelanggan.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = Pelanggan::findOrFail($id);
        $item->update($request->all());

        return redirect()->route('pelanggan.index')
            ->with('success', 'Pelanggan updated successfully.');
    }

    public function destroy($id)
    {
        $item = Pelanggan::findOrFail($id);
        $item->delete();

        return redirect()->route('pelanggan.index')
            ->with('success', 'Pelanggan deleted successfully.');
    }
}