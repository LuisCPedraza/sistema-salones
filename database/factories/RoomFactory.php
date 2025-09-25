<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'Salón ' . $this->faker->numberBetween(100, 400),
            'capacity' => $this->faker->numberBetween(20, 50),
            'location' => 'Edificio ' . $this->faker->randomElement(['A', 'B', 'C']),
            'resources' => $this->faker->randomElement(['Proyector', 'Proyector y Pizarra Digital']),
        ];
    }
}
