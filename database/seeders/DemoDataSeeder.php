<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\Room;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Crear algunos grupos
        $groups = [
            ['name' => 'Grupo 1A', 'level' => 'Primaria', 'students_count' => 25, 'special_characteristics' => ''],
            ['name' => 'Grupo 2B', 'level' => 'Secundaria', 'students_count' => 30, 'special_characteristics' => 'Bilingüe'],
            ['name' => 'Grupo 3C', 'level' => 'Universidad', 'students_count' => 40, 'special_characteristics' => 'Ingeniería'],
        ];
        foreach ($groups as $g) {
            Group::firstOrCreate(['name' => $g['name']], $g);
        }

        // 2. Crear algunos salones
        $rooms = [
            ['name' => 'Sala 101', 'capacity' => 30, 'location' => 'Edificio A, Piso 1', 'resources' => 'Proyector, Pizarra'],
            ['name' => 'Sala 202', 'capacity' => 40, 'location' => 'Edificio B, Piso 2', 'resources' => 'Computadores, Aire acondicionado'],
            ['name' => 'Laboratorio 301', 'capacity' => 20, 'location' => 'Edificio C, Piso 3', 'resources' => 'Equipos de laboratorio'],
        ];
        foreach ($rooms as $r) {
            Room::firstOrCreate(['name' => $r['name']], $r);
        }

        // 3. Crear algunos profesores (con usuarios asociados)
        $teachers = [
            ['name' => 'Juan Pérez', 'email' => 'juanperez@demo.com', 'specialty' => 'Matemáticas'],
            ['name' => 'María López', 'email' => 'marialopez@demo.com', 'specialty' => 'Física'],
            ['name' => 'Carlos Ruiz', 'email' => 'carlosruiz@demo.com', 'specialty' => 'Programación'],
        ];

        foreach ($teachers as $t) {
            // Crear usuario vinculado
            $user = User::firstOrCreate(
                ['email' => $t['email']],
                [
                    'name' => $t['name'],
                    'email_verified_at' => now(),
                    'password' => Hash::make('password'),
                    'role_id' => \App\Models\Role::where('name', 'profesor')->first()->id,
                ]
            );

            Teacher::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'specialty' => $t['specialty'],
                    'bio' => 'Profesor de '.$t['specialty'],
                ]
            );
        }

        $this->command->info('✅ Datos demo creados: grupos, salones y profesores');
    }
}

