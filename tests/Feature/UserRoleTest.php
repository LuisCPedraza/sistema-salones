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
    public function the_edit_user_page_loads_correctly_with_user_data()
    {
        // 1. Preparación: Creamos un rol y un usuario.
        $role = Role::create(['name' => 'coordinador']);
        $user = User::factory()->create(['role_id' => $role->id]);

        // 2. Acción: Hacemos una petición GET a la página de edición de ese usuario.
        // La ruta 'usuarios.edit' la crea automáticamente Route::resource.
        $response = $this->get(route('usuarios.edit', $user));

        // 3. Verificación:
        // - Que la página cargue correctamente (status 200 OK).
        $response->assertStatus(200);

        // - Que la página contenga el nombre y el email del usuario,
        //   lo que prueba que los datos se están mostrando.
        $response->assertSee($user->name);
        $response->assertSee($user->email);
    }    

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

    /** @test */
    public function a_user_can_be_updated_through_the_edit_form()
    {
        // 1. Preparación: Creamos un rol y un usuario existente.
        $role = Role::create(['name' => 'coordinador']);
        $user = User::factory()->create(['role_id' => $role->id, 'name' => 'Nombre Antiguo']);

        // Los nuevos datos que enviaremos en el formulario.
        $newData = [
            'name' => 'Nombre Actualizado',
            'email' => $user->email, // Mantenemos el mismo email
            'role_id' => $role->id,
        ];

        // 2. Acción: Hacemos una petición PUT a la ruta de actualización.
        $response = $this->put(route('usuarios.update', $user), $newData);

        // 3. Verificación:
        // - Que nos redirija de vuelta a la lista de usuarios.
        $response->assertRedirect(route('usuarios.index'));

        // - Refrescamos los datos del usuario desde la base de datos.
        $user->refresh();

        // - Verificamos que el nombre del usuario en la BD ahora es el nuevo.
        $this->assertEquals('Nombre Actualizado', $user->name);
    }

    /** @test */
    public function a_user_can_be_deleted()
    {
        // 1. Preparación: Creamos un rol y un usuario.
        $role = Role::create(['name' => 'coordinador']);
        $user = User::factory()->create(['role_id' => $role->id]);

        // Verificamos que el usuario realmente existe en la BD.
        $this->assertCount(1, User::all());

        // 2. Acción: Hacemos una petición DELETE a la ruta de eliminación.
        $response = $this->delete(route('usuarios.destroy', $user));

        // 3. Verificación:
        // - Que nos redirija de vuelta a la lista de usuarios.
        $response->assertRedirect(route('usuarios.index'));

        // - Verificamos que el usuario ya NO está en la base de datos.
        $this->assertCount(0, User::all());
    }    
}