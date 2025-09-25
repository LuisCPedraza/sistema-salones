<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Assignment>
 */
class AssignmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'group_id' => \App\Models\Group::factory(),
            'teacher_id' => \App\Models\Teacher::factory(),
            'room_id' => \App\Models\Room::factory(),
            'day_of_week' => $this->faker->randomElement(['lunes', 'martes', 'miércoles', 'jueves', 'viernes']),
            'start_time' => '08:00:00',
            'end_time' => '10:00:00',
        ];
    }
}
