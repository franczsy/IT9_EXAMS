<?php

namespace App\Http\Controllers;

use App\Models\RiceItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 

class RiceItemController extends Controller
{
   
    public function index()
    {
        $riceItems = RiceItem::all();
        return view('rice-items.index', compact('riceItems'));
    }

    public function create()
    {
        return view('rice-items.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:rice_items',
            'price_per_kg' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'description' => 'nullable|string',
        ]);

        RiceItem::create($request->all());
        return redirect()->route('rice-items.index')->with('success', 'Rice product added successfully.');
    }

    public function edit(RiceItem $riceItem)
    {
        return view('rice-items.edit', compact('riceItem'));
    }

    public function update(Request $request, RiceItem $riceItem)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:rice_items,name,' . $riceItem->id,
            'price_per_kg' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'description' => 'nullable|string',
        ]);

        $riceItem->update($request->all());
        return redirect()->route('rice-items.index')->with('success', 'Rice product updated successfully.');
    }

    public function destroy(RiceItem $riceItem)
    {
        $riceItem->delete();
        return redirect()->route('rice-items.index')->with('success', 'Rice product deleted successfully.');
    }
}