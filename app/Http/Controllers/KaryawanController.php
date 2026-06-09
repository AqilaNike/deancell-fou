<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    public function index()
    {
        $data = Karyawan::all();
        return view('karyawan.index', compact('data'));
    }

    public function create()
    {
        return view('karyawan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // Add validation rules here
            'idKaryawan' => 'required|string|max:10|unique:karyawans,idKaryawan'
        ]);

        Karyawan::create($request->all());

        return redirect()->route('karyawan.index')
            ->with('success', 'Karyawan created successfully.');
    }

    public function show($id)
    {
        $item = Karyawan::findOrFail($id);
        return view('karyawan.show', compact('item'));
    }

    public function edit($id)
    {
        $item = Karyawan::findOrFail($id);
        return view('karyawan.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = Karyawan::findOrFail($id);
        $item->update($request->all());

        return redirect()->route('karyawan.index')
            ->with('success', 'Karyawan updated successfully.');
    }

    public function destroy($id)
    {
        $item = Karyawan::findOrFail($id);
        $item->delete();

        return redirect()->route('karyawan.index')
            ->with('success', 'Karyawan deleted successfully.');
    }
}