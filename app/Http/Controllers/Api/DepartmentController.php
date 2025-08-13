<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{

    public function index()
    {
        return Department::all();
    }


    public function store(Request $request)
    {
        //
    }


    public function show(Department $department)
    {
        //
    }


    public function update(Request $request, Department $department)
    {
        //
    }


    public function destroy(Department $department)
    {
        //
    }
}
