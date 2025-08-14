<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{

    public function index()
    {
        return Item::all();
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            // Adicione outros campos conforme necessário
        ]);
        $item = Item::create($validated);
        return response()->json($item, 201);
    }


    public function show(Item $item)
    {
        return $item;
    }


    public function update(Request $request, Item $item)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            // Adicione outros campos conforme necessário
        ]);
        $item->update($validated);
        return response()->json($item);
    }


    public function destroy(Item $item)
    {
        $item->delete();
        return response()->json(null, 204);
    }
}
