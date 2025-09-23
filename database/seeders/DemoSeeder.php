<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use App\Models\Group;
use App\Models\Room;
use App\Models\Teacher;
use App\Models\Assignment;
use Illuminate\Support\Facades\Hash;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        // --- Roles ---
        $adminRole   = Role::firstOrCreate(['name' => 'admin']);
        $teacherRole = Role::firstOrCreate(['name' => 'profesor']);
        $studentRole = Role::firstOrCreate(['name' => 'estudiante']);

        // --- Usuario Admin ---
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('password'),
                'role_id' => $adminRole->id,
            ]
        );

        // --- Profesores (usuarios + teachers) ---
        $teacherUsers = [
            ['name' => 'Carlos Pérez', 'email' => 'carlos@example.com', 'specialty' => 'Matemáticas'],
            ['name' => 'Ana López',   'email' => 'ana@example.com',   'specialty' => 'Historia'],
            ['name' => 'Luis Torres', 'email' => 'luis@example.com',  'specialty' => 'Física'],
            ['name' => 'María Rojas', 'email' => 'maria@example.com', 'specialty' => 'Lengua'],
            ['name' => 'Pedro Díaz',  'email' => 'pedro@example.com', 'specialty' => 'Química'],
            ['name' => 'Laura Gómez', 'email' => 'laura@example.com', 'specialty' => 'Biología'],
            ['name' => 'Andrés Silva','email' => 'andres@example.com','specialty' => 'Geografía'],
        ];

        $teachers = [];
        foreach ($teacherUsers as $t) {
            $user = User::firstOrCreate(
                ['email' => $t['email']],
                [
                    'name' => $t['name'],
                    'password' => Hash::make('password'),
                    'role_id' => $teacherRole->id,
                ]
            );

            $teachers[] = Teacher::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'specialty' => $t['specialty'],
                    'bio' => "Docente de {$t['specialty']} con amplia experiencia.",
                ]
            );
        }

        // --- Grupos ---
        $groups = [
            ['name' => '1A', 'level' => 'Primero',  'students_count' => 30],
            ['name' => '2B', 'level' => 'Segundo',  'students_count' => 28],
            ['name' => '3C', 'level' => 'Tercero',  'students_count' => 25],
            ['name' => '4D', 'level' => 'Cuarto',   'students_count' => 35],
            ['name' => '5E', 'level' => 'Quinto',   'students_count' => 32],
            ['name' => '6F', 'level' => 'Sexto',    'students_count' => 27],
        ];

        $groupModels = [];
        foreach ($groups as $g) {
            $groupModels[] = Group::firstOrCreate(['name' => $g['name']], $g);
        }

        // --- Salones ---
        $rooms = [
            ['name' => 'Sala 101', 'capacity' => 40, 'location' => 'Edificio A'],
            ['name' => 'Sala 201', 'capacity' => 30, 'location' => 'Edificio B'],
            ['name' => 'Sala 301', 'capacity' => 25, 'location' => 'Edificio C'],
            ['name' => 'Laboratorio Química', 'capacity' => 20, 'location' => 'Edificio D'],
            ['name' => 'Laboratorio Computo', 'capacity' => 35, 'location' => 'Edificio E'],
            ['name' => 'Sala Magna', 'capacity' => 100, 'location' => 'Auditorio Central'],
        ];

        $roomModels = [];
        foreach ($rooms as $r) {
            $roomModels[] = Room::firstOrCreate(['name' => $r['name']], $r);
        }

        // --- Asignaciones de ejemplo ---
        $dias = [1, 2, 3, 4, 5, 6]; // lunes a sábado
        $horas = [
            ['07:00','09:00'],
            ['09:00','11:00'],
            ['11:00','13:00'],
            ['14:00','16:00'],
            ['16:00','18:00'],
            ['18:00','20:00'],
        ];

        // Generar 50 asignaciones "aleatorias"
        $count = 0;
        while ($count < 50) {
            $group   = $groupModels[array_rand($groupModels)];
            $teacher = $teachers[array_rand($teachers)];
            $room    = $roomModels[array_rand($roomModels)];
            $dia     = $dias[array_rand($dias)];
            $slot    = $horas[array_rand($horas)];

            Assignment::create([
                'group_id'    => $group->id,
                'teacher_id'  => $teacher->id,
                'room_id'     => $room->id,
                'day_of_week' => $dia,
                'start_time'  => $slot[0],
                'end_time'    => $slot[1],
            ]);
            $count++;
        }
    }
}
