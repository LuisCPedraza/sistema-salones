<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Role;

class UserRoleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_be_assigned_a_role()
    {
        $adminRole = Role::create(['name' => 'admin']);
        $coordinatorRole = Role::create(['name' => 'coordinador']);

        $adminUser = User::factory()->create(['role_id' => $adminRole->id]);
        $coordinatorUser = User::factory()->create(['role_id' => $coordinatorRole->id]);

        $this->assertEquals('admin', $adminUser->role->name);
        $this->assertEquals('coordinador', $coordinatorUser->role->name);
    }

    // --- ESTA ES LA NUEVA PRUEBA QUE AÑADIMOS ---

    /** @test */
    public function the_create_user_form_can_store_a_new_user()
    {
        // 1. Preparación (Arrange)
        $role = Role::create(['name' => 'coordinador']);

        $userData = [
            'name' => 'Luis Pedraza',
            'email' => 'luis@example.com',
            'password' => 'password123',
            'role_id' => $role->id,
        ];

        // 2. Acción (Act)
        $response = $this->post(route('usuarios.store'), $userData);

        // 3. Verificación (Assert)
        $this->assertCount(1, User::all());
        $this->assertEquals('luis@example.com', User::first()->email);
        $response->assertRedirect(route('usuarios.index'));
    }
}