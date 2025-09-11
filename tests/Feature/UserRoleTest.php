<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
// --> ¡ASEGÚRATE DE QUE ESTAS DOS LÍNEAS ESTÉN AQUÍ! <--
use App\Models\User;
use App\Models\Role;

class UserRoleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_be_assigned_a_role()
    {
        // 1. Preparamos el escenario
        $adminRole = Role::create(['name' => 'admin']);
        $coordinatorRole = Role::create(['name' => 'coordinador']);

        // 2. Creamos los usuarios con sus roles
        $adminUser = User::factory()->create(['role_id' => $adminRole->id]);
        $coordinatorUser = User::factory()->create(['role_id' => $coordinatorRole->id]);

        // 3. Verificamos que todo es correcto
        $this->assertEquals('admin', $adminUser->role->name);
        $this->assertEquals('coordinador', $coordinatorUser->role->name);
    }
}