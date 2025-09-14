<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Assignment;
use App\Models\Group;
use App\Models\Room;
use App\Models\Teacher;

class AssignmentManagementTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true; // Para que los roles se creen y las fábricas funcionen

    /** @test */
    public function a_manual_assignment_can_be_created()
    {
        // 1. Preparación: Creamos todos los recursos necesarios
        $teacher = Teacher::factory()->create();
        $group = Group::factory()->create();
        $room = Room::factory()->create();

        // 2. Datos de la nueva asignación
        $assignmentData = [
            'group_id' => $group->id,
            'teacher_id' => $teacher->id,
            'room_id' => $room->id,
            'day_of_week' => 'lunes',
            'start_time' => '08:00',
            'end_time' => '10:00',
        ];

        // 3. Acción: Enviamos la petición para crear la asignación
        $response = $this->post('/asignaciones', $assignmentData);

        // 4. Verificación
        $this->assertCount(1, Assignment::all());
        $response->assertRedirect('/asignaciones'); // O a una vista de calendario, por ahora la lista.
    }
}
