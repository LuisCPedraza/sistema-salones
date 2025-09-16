<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Asegurar que los roles existen
        $roles = [
            'admin',
            'coordinador',
            'profesor',
        ];

        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }

        // Crear usuarios por defecto
        $users = [
            [
                'name' => 'Administrador',
                'email' => 'admin@demo.com',
                'role' => 'admin',
            ],
            [
                'name' => 'Coordinador',
                'email' => 'coordinador@demo.com',
                'role' => 'coordinador',
            ],
            [
                'name' => 'Profesor',
                'email' => 'profesor@demo.com',
                'role' => 'profesor',
            ],
        ];

        foreach ($users as $u) {
            $role = Role::where('name', $u['role'])->first();

            User::firstOrCreate(
                ['email' => $u['email']],
                [
                    'name' => $u['name'],
                    'email_verified_at' => now(),
                    'password' => Hash::make('password'), // ✅ clave: "password"
                    'role_id' => $role->id,
                ]
            );
        }

        $this->command->info('✅ Usuarios demo creados: admin, coordinador, profesor (clave: password)');
    }
}
