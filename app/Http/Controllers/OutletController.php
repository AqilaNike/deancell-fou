<?php

namespace App\Http\Controllers;

use App\Models\Outlet;
use Illuminate\Http\Request;

class OutletController extends Controller
{
    public function index()
    {
        $data = Outlet::all();
        return view('outlet.index', compact('data'));
    }

    public function create()
    {
        return view('outlet.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // Add validation rules here
            'id_outlet' => 'required|string|max:10|unique:outlets,id_outlet'
        ]);

        Outlet::create($request->all());

        return redirect()->route('outlet.index')
            ->with('success', 'Outlet created successfully.');
    }

    public function show($id)
    {
        $item = Outlet::findOrFail($id);
        return view('outlet.show', compact('item'));
    }

    public function edit($id)
    {
        $item = Outlet::findOrFail($id);
        return view('outlet.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = Outlet::findOrFail($id);
        $item->update($request->all());

        return redirect()->route('outlet.index')
            ->with('success', 'Outlet updated successfully.');
    }

    public function destroy($id)
    {
        $item = Outlet::findOrFail($id);
        $item->delete();

        return redirect()->route('outlet.index')
            ->with('success', 'Outlet deleted successfully.');
    }
}