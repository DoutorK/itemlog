<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{

    public function index()
    {
        try {
            return Item::all();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao buscar itens', 'message' => $e->getMessage()], 500);
        }
    }


    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'department_id' => 'required|exists:departments,id',
                // Adicione outros campos conforme necessário
            ]);
            $item = Item::create($validated);
            return response()->json($item, 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => 'Dados inválidos', 'messages' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao criar item', 'message' => $e->getMessage()], 500);
        }
    }


    public function show(Item $item)
    {
        try {
            return $item;
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao buscar item', 'message' => $e->getMessage()], 500);
        }
    }


    public function update(Request $request, Item $item)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'department_id' => 'required|exists:departments,id',
                // Adicione outros campos conforme necessário
            ]);
            $item->update($validated);
            return response()->json($item);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => 'Dados inválidos', 'messages' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao atualizar item', 'message' => $e->getMessage()], 500);
        }
    }

    public function itemsByDepartment($departmentId)
    {
        try {
            return Item::where('department_id', $departmentId)->get();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao buscar itens do departamento', 'message' => $e->getMessage()], 500);
        }
    }

    // Adiciona item a um departamento
    public function storeForDepartment(Request $request, $departmentId)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
            ]);
            $item = Item::create([
                'name' => $validated['name'],
                'department_id' => $departmentId,
            ]);
            return response()->json($item, 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => 'Dados inválidos', 'messages' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao criar item para departamento', 'message' => $e->getMessage()], 500);
        }
    }


    public function destroy(Item $item)
    {
        try {
            $item->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao excluir item', 'message' => $e->getMessage()], 500);
        }
    }
}
