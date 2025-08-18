<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Department;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DepartmentDestroyTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_deletes_a_department()
    {
        // Arrange: cria um departamento
        $department = Department::factory()->create();

        // Act: envia a requisição DELETE
        $response = $this->deleteJson("/api/departments/{$department->id}");

        // Assert: verifica status e que o registro foi removido
        $response->assertStatus(204);
        $this->assertDatabaseMissing('departments', [
            'id' => $department->id,
        ]);
    }
}