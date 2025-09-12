<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Group;

class GroupManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_group_can_be_created()
    {
        // 1. Datos de prueba
        $groupData = [
            'name' => 'Cálculo I - Grupo 1',
            'level' => '1er Semestre',
            'students_count' => 30,
            'special_characteristics' => 'Requiere proyector',
        ];

        // 2. Acción
        $response = $this->post('/grupos', $groupData);

        // 3. Verificación
        $this->assertCount(1, Group::all());
        $response->assertRedirect('/grupos');
    }

    /** @test */
    public function the_edit_group_page_loads_correctly()
    {
        // 1. Creamos un grupo para poder editarlo.
        $group = Group::factory()->create();

        // 2. Intentamos acceder a la página de edición de ese grupo.
        $response = $this->get(route('grupos.edit', $group));

        // 3. Verificamos que la página cargó bien y que muestra los datos del grupo.
        $response->assertStatus(200);
        $response->assertSee($group->name);
        $response->assertSee($group->level);
    }    

    /** @test */
    public function a_group_can_be_updated()
    {
        // 1. Preparación: Creamos un grupo existente.
        $group = Group::factory()->create([
            'name' => 'Nombre Antiguo'
        ]);

        // 2. Nuevos datos
        $newData = [
            'name' => 'Nombre Actualizado',
            'level' => $group->level,
            'students_count' => $group->students_count,
        ];

        // 3. Acción: Hacemos una petición PUT a la ruta de actualización.
        $response = $this->put(route('grupos.update', $group), $newData);

        // 4. Verificación:
        $response->assertRedirect('/grupos');
        $this->assertEquals('Nombre Actualizado', $group->fresh()->name);
    }
    /** @test */
    public function a_group_can_be_deleted()
    {
        // 1. Preparación
        $group = Group::factory()->create();
        $this->assertCount(1, Group::all());

        // 2. Acción
        $response = $this->delete(route('grupos.destroy', $group));

        // 3. Verificación
        $response->assertRedirect('/grupos');
        $this->assertCount(0, Group::all());
    }    
}