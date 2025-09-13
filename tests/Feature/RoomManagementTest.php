<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Room;

class RoomManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_room_can_be_created()
    {
        // Datos de prueba
        $roomData = [
            'name' => 'Salón 101',
            'capacity' => 30,
            'location' => 'Edificio Principal',
            'resources' => 'Proyector y pizarra',
        ];

        // Acción
        $response = $this->post('/salones', $roomData);

        // Verificación
        $this->assertCount(1, Room::all());
        $response->assertRedirect('/salones');
    }

    /** @test */
    public function the_edit_room_page_loads_correctly()
    {
        // 1. Preparación
        $room = Room::factory()->create();

        // 2. Acción
        $response = $this->get(route('salones.edit', $room));

        // 3. Verificación
        $response->assertStatus(200);
        $response->assertSee($room->name);
    }

    /** @test */
    public function a_room_can_be_updated()
    {
        // 1. Preparación
        $room = Room::factory()->create(['name' => 'Salón Antiguo']);

        // 2. Nuevos datos
        $newData = [
            'name' => 'Salón Moderno',
            'capacity' => $room->capacity,
            'location' => $room->location,
        ];

        // 3. Acción
        $response = $this->put(route('salones.update', ['salone' => $room]), $newData);

        // 4. Verificación
        $response->assertRedirect('/salones');
        $this->assertEquals('Salón Moderno', $room->fresh()->name);
    }

    /** @test */
    public function a_room_can_be_deleted()
    {
        // 1. Preparación
        $room = Room::factory()->create();
        $this->assertCount(1, Room::all());

        // 2. Acción
        $response = $this->delete(route('salones.destroy', ['salone' => $room]));

        // 3. Verificación
        $response->assertRedirect('/salones');
        $this->assertCount(0, Room::all());
    }
}
