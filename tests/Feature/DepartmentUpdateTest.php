<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Department;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DepartmentUpdateTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_updates_an_existing_department()
    {
        // Arrange: cria um departamento existente
        $department = Department::factory()->create([
            'name' => 'Old Department'
        ]);

        $payload = [
            'name' => 'Updated Department Name'
        ];

        // Act: envia a requisição para o método update
        $response = $this->putJson("/api/departments/{$department->id}", $payload);

        // Assert: verifica status e estrutura JSON
        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'name' => 'Updated Department Name'
                 ]);

        // Verifica que o registro foi atualizado e não criado um novo
        $this->assertDatabaseCount('departments', 1);
        $this->assertDatabaseHas('departments', [
            'id' => $department->id,
            'name' => 'Updated Department Name'
        ]);
    }
}