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
}
