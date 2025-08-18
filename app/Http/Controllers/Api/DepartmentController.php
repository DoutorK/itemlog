<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{

    public function index()
    {
        try {
            return Department::all();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao buscar departamentos', 'message' => $e->getMessage()], 500);
        }
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $department = Department::create($validated);
        return response()->json($department, 201);
    }


    public function show(Department $department)
    {
        return $department;
    }


    public function update(Request $request, Department $department)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $department->update($validated);
        return response()->json($department, 200);
    }

    public function destroy(Department $department)
    {
        $department->delete();
        return response()->json(null, 204);
    }
}
