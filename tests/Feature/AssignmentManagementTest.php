<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Assignment;
use App\Models\Group;
use App\Models\Room;
use App\Models\Teacher;
use App\Models\Role;

class AssignmentManagementTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;

    /** @test */
    public function a_manual_assignment_can_be_created()
    {
        $teacher = Teacher::factory()->create();
        $group = Group::factory()->create();
        $room = Room::factory()->create();
        $assignmentData = [
            'group_id' => $group->id,
            'teacher_id' => $teacher->id,
            'room_id' => $room->id,
            'day_of_week' => 'lunes',
            'start_time' => '08:00',
            'end_time' => '10:00',
        ];
        $response = $this->post(route('asignaciones.store'), $assignmentData);
        $this->assertCount(1, Assignment::all());
        $response->assertRedirect(route('asignaciones.index'));
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

    /** @test */
    public function it_prevents_creating_a_conflicting_assignment_for_a_teacher()
    {
        // 1. Preparación: Creamos una asignación que ya existe en la BD
        $teacher = Teacher::factory()->create();
        Assignment::factory()->create([
            'teacher_id' => $teacher->id,
            'day_of_week' => 'lunes',
            'start_time' => '08:00',
            'end_time' => '10:00',
        ]);

        // 2. Intentamos crear una asignación conflictiva
        $conflictingAssignmentData = [
            'group_id' => Group::factory()->create()->id,
            'teacher_id' => $teacher->id, // Mismo profesor
            'room_id' => Room::factory()->create()->id,
            'day_of_week' => 'lunes',     // Mismo día
            'start_time' => '09:00',      // La hora se cruza
            'end_time' => '11:00',
        ];

        // 3. Acción
        $response = $this->post(route('asignaciones.store'), $conflictingAssignmentData);

        // 4. Verificación
        $response->assertSessionHasErrors();
        $this->assertCount(1, Assignment::all());
    }
}
