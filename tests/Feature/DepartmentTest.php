<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Department;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DepartmentTest extends TestCase
{
    use RefreshDatabase; 
    /**
     * Testa a rota de listagem de departamentos.
     */

    public function it_creates_a_department()
    {
        // Criar um registro
        $department = Department::create(['name' => 'Teste']);

        // Verificar se foi salvo no banco
        $this->assertDatabaseHas('departments', [
            'name' => 'Teste'
        ]);
    }
}