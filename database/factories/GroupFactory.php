<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class GroupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'Grupo de ' . $this->faker->word(),
            'level' => $this->faker->randomElement(['1er Semestre', '2do Semestre', '3er Semestre']),
            'students_count' => $this->faker->numberBetween(15, 35),
            'special_characteristics' => $this->faker->sentence(),
        ];
    }
}