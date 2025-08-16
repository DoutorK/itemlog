<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DepartmentController;
use App\Http\Controllers\Api\ItemController;

Route::apiResource('departments', DepartmentController::class);
Route::apiResource('items', ItemController::class)->shallow();

// Rotas customizadas para itens de um departamento
Route::get('departments/{department}/items', [App\Http\Controllers\Api\ItemController::class, 'itemsByDepartment']);
Route::post('departments/{department}/items', [App\Http\Controllers\Api\ItemController::class, 'storeForDepartment']);