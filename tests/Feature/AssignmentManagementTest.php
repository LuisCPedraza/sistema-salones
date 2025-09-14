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

    /** @test */
    public function an_assignment_can_be_updated()
    {
        $assignment = Assignment::factory()->create();
        $newRoom = Room::factory()->create();

        $newData = [
            'group_id' => $assignment->group_id,
            'teacher_id' => $assignment->teacher_id,
            'room_id' => $newRoom->id,
            'day_of_week' => $assignment->day_of_week,
            // CORRECCIÓN: Formateamos la hora al formato H:i que espera la validación
            'start_time' => date('H:i', strtotime($assignment->start_time)),
            'end_time' => date('H:i', strtotime($assignment->end_time)),
        ];

        $this->put(route('asignaciones.update', ['asignacione' => $assignment]), $newData);
        $this->assertEquals($newRoom->id, $assignment->fresh()->room_id);
    }

    /** @test */
    public function an_assignment_can_be_deleted()
    {
        $assignment = Assignment::factory()->create();
        $this->assertCount(1, Assignment::all());

        $this->delete(route('asignaciones.destroy', ['asignacione' => $assignment]));
        $this->assertCount(0, Assignment::all());
    }
}
