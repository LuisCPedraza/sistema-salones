<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define el estado por defecto del modelo.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Busca o crea automáticamente el rol "profesor"
        $profesorRole = Role::firstOrCreate(['name' => 'profesor']);

        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'role_id' => $profesorRole->id, // ✅ siempre asigna un rol válido
        ];
    }

    /**
     * Indica que el email del usuario no está verificado.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
