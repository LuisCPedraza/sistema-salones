<?php

namespace Database\Seeders;

use App\Models\Assignment;
use App\Models\Group;
use App\Models\Room;
use App\Models\Teacher;
use Illuminate\Database\Seeder;

class DemoAssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dias = ['lunes', 'martes', 'miércoles', 'jueves', 'viernes'];

        $grupos   = Group::all();
        $salones  = Room::all();
        $profes   = Teacher::with('user')->get();

        if ($grupos->isEmpty() || $salones->isEmpty() || $profes->isEmpty()) {
            $this->command->warn('⚠️ No se encontraron grupos, salones o profesores. Ejecuta primero DemoDataSeeder.');
            return;
        }

        $horaInicio = 7; // 7 AM
        $duracion   = 2; // cada clase dura 2 horas
        $index      = 0;

        foreach ($grupos as $grupo) {
            $profesor = $profes[$index % $profes->count()];
            $salon    = $salones[$index % $salones->count()];
            $dia      = $dias[$index % count($dias)];

            $start = sprintf('%02d:00', $horaInicio + ($index % 5) * $duracion);
            $end   = sprintf('%02d:00', $horaInicio + ($index % 5) * $duracion + $duracion);

            Assignment::firstOrCreate([
                'group_id'    => $grupo->id,
                'teacher_id'  => $profesor->id,
                'room_id'     => $salon->id,
                'day_of_week' => $dia,
                'start_time'  => $start,
                'end_time'    => $end,
            ]);

            $index++;
        }

        $this->command->info('✅ Asignaciones demo creadas para los grupos, salones y profesores.');
    }
}
