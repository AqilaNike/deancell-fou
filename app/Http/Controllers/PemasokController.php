<?php

namespace App\Http\Controllers;

use App\Models\Pemasok;
use Illuminate\Http\Request;

class PemasokController extends Controller
{
    public function index()
    {
        $data = Pemasok::all();
        return view('pemasok.index', compact('data'));
    }

    public function create()
    {
        return view('pemasok.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // Add validation rules here
            'idPemasok' => 'required|string|max:10|unique:pemasoks,idPemasok'
        ]);

        Pemasok::create($request->all());

        return redirect()->route('pemasok.index')
            ->with('success', 'Pemasok created successfully.');
    }

    public function show($id)
    {
        $item = Pemasok::findOrFail($id);
        return view('pemasok.show', compact('item'));
    }

    public function edit($id)
    {
        $item = Pemasok::findOrFail($id);
        return view('pemasok.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = Pemasok::findOrFail($id);
        $item->update($request->all());

        return redirect()->route('pemasok.index')
            ->with('success', 'Pemasok updated successfully.');
    }

    public function destroy($id)
    {
        $item = Pemasok::findOrFail($id);
        $item->delete();

        return redirect()->route('pemasok.index')
            ->with('success', 'Pemasok deleted successfully.');
    }
}