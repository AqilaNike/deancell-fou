<?php

namespace App\Http\Controllers;

use App\Models\MerchantBrilink;
use Illuminate\Http\Request;

class MerchantBrilinkController extends Controller
{
    public function index()
    {
        $data = MerchantBrilink::all();
        return view('merchant_brilink.index', compact('data'));
    }

    public function create()
    {
        return view('merchant_brilink.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_merchant' => 'required|string|max:10|unique:merchant_brilinks,id_merchant',
            'saldo_limit' => 'nullable|numeric',
            'target_bulanan' => 'nullable|integer',
            'status_aktif' => 'nullable|boolean',
        ]);

        MerchantBrilink::create($request->all());

        return redirect()->route('merchant_brilink.index')
            ->with('success', 'MerchantBrilink created successfully.');
    }

    public function show($id)
    {
        $item = MerchantBrilink::findOrFail($id);
        return view('merchant_brilink.show', compact('item'));
    }

    public function edit($id)
    {
        $item = MerchantBrilink::findOrFail($id);
        return view('merchant_brilink.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'saldo_limit' => 'nullable|numeric',
            'target_bulanan' => 'nullable|integer',
            'status_aktif' => 'nullable|boolean',
        ]);

        $item = MerchantBrilink::findOrFail($id);
        $item->update($request->all());

        return redirect()->route('merchant_brilink.index')
            ->with('success', 'MerchantBrilink updated successfully.');
    }

    public function destroy($id)
    {
        $item = MerchantBrilink::findOrFail($id);
        $item->delete();

        return redirect()->route('merchant_brilink.index')
            ->with('success', 'MerchantBrilink deleted successfully.');
    }
}