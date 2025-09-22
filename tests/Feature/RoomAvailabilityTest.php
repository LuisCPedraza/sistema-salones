<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Room;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoomAvailabilityTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_add_room_availability()
    {
        $this->actingAs(User::factory()->create());
        $room = Room::factory()->create();

        $response = $this->post("/rooms/{$room->id}/availabilities", [
            'day_of_week' => 2,
            'start_time' => '08:00',
            'end_time'   => '10:00',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('room_availabilities', [
            'room_id' => $room->id,
            'day_of_week' => 2,
        ]);
    }

    public function test_invalid_time_range_is_rejected()
    {
        $this->actingAs(User::factory()->create());
        $room = Room::factory()->create();

        $response = $this->post("/rooms/{$room->id}/availabilities", [
            'day_of_week' => 3,
            'start_time' => '10:00',
            'end_time'   => '09:00',
        ]);

        $response->assertSessionHasErrors();
    }
}
