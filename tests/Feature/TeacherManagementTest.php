<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Role;

class TeacherManagementTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;

    #[Test]
    public function a_teacher_can_be_created()
    {
        $role = Role::where('name', 'profesor')->first();
        $user = User::factory()->create(['role_id' => $role->id]);

        $teacherData = [
            'user_id' => $user->id,
            'specialty' => 'Matemáticas Discretas',
            'bio' => 'Experto en algoritmos y estructuras de datos.',
        ];

        $this->post('/profesores', $teacherData);
        $this->assertCount(1, Teacher::all());
    }

    #[Test]
    public function a_teacher_can_be_updated()
    {
        $teacher = Teacher::factory()->create(['specialty' => 'Física']);

        $newData = [
            'user_id' => $teacher->user_id,
            'specialty' => 'Física Cuántica',
            'bio' => $teacher->bio,
        ];

        $this->put(route('profesores.update', ['profesore' => $teacher]), $newData);
        $this->assertEquals('Física Cuántica', $teacher->fresh()->specialty);
    }

    #[Test]
    public function a_teacher_can_be_deleted()
    {
        $teacher = Teacher::factory()->create();
        $this->assertCount(1, Teacher::all());

        $this->delete(route('profesores.destroy', ['profesore' => $teacher]));
        $this->assertCount(0, Teacher::all());
    }
}
