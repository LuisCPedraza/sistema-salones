<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Group;
use App\Models\Teacher;
use App\Models\Room;
use App\Rules\NoTimeOverlap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssignmentController extends Controller
{
    // ...mantén index(), create(), edit() si ya existen

    public function store(Request $request)
    {
        $data = $request->validate([
            'group_id'    => ['required','exists:groups,id'],
            'teacher_id'  => ['required','exists:teachers,id'],
            'room_id'     => ['required','exists:rooms,id'],
            'day_of_week' => ['required','in:lunes,martes,miércoles,jueves,viernes,sábado'],
            'start_time'  => ['required','date_format:H:i'],
            'end_time'    => [
                'required',
                'date_format:H:i',
                'after:start_time',
                new \App\Rules\NoTimeOverlap($request->all()), // ✅ validación de solape
            ],
        ]);

        Assignment::create($data);

        return redirect()
            ->route('asignaciones.index')
            ->with('success', 'Asignación creada correctamente.');
    }

    public function update(Request $request, Assignment $asignacione)
    {
        $data = $request->validate([
            'group_id'    => ['required','exists:groups,id'],
            'teacher_id'  => ['required','exists:teachers,id'],
            'room_id'     => ['required','exists:rooms,id'],
            'day_of_week' => ['required','in:lunes,martes,miércoles,jueves,viernes,sábado'],
            'start_time'  => ['required','date_format:H:i'],
            'end_time'    => [
                'required',
                'date_format:H:i',
                'after:start_time',
                new \App\Rules\NoTimeOverlap($request->all(), $asignacione->id), // ✅ ignora la propia asignación al editar
            ],
        ]);

        $asignacione->update($data);

        return redirect()
            ->route('asignaciones.index')
            ->with('success', 'Asignación actualizada correctamente.');
    }

    public function destroy(Assignment $asignacione)
    {
        $asignacione->delete();
        return redirect()->route('asignaciones.index')->with('success', 'Asignación eliminada.');
    }

    /**
     * AUTOASIGNACIÓN (HU9-HU10)
     * Parámetros (opcionales): duracion_horas=2, dias=["lunes"...], hora_inicio="07:00", hora_fin="19:00"
     * Estrategia: voraz -> para cada grupo, busca el primer slot disponible con profesor compatible y salón con capacidad.
     */
    public function autoAssign(Request $request)
    {
        $duracion = (int)($request->input('duracion_horas', 2));
        $dias = $request->input('dias', ['lunes','martes','miércoles','jueves','viernes']);
        $horaInicio = $request->input('hora_inicio', '07:00');
        $horaFin    = $request->input('hora_fin',    '19:00');

        // Slots por cada 'duracion' horas
        $slots = [];
        $start = strtotime($horaInicio);
        $end   = strtotime($horaFin);
        for ($t = $start; $t + $duracion*3600 <= $end; $t += $duracion*3600) {
            $slots[] = [date('H:i', $t), date('H:i', $t + $duracion*3600)];
        }

        $grupos = Group::orderBy('id')->get();
        $profes = Teacher::orderBy('id')->get();
        $salones = Room::orderBy('capacity', 'desc')->get(); // prioriza salones más grandes

        $creadas = 0; $saltadas = [];

        DB::beginTransaction();
        try {
            foreach ($grupos as $g) {
                $asignado = false;

                foreach ($dias as $dia) {
                    foreach ($slots as [$ini, $fin]) {

                        // profesor cualquiera (simplificado). Si tienes materias/afín, filtra acá.
                        foreach ($profes as $p) {

                            // salón con capacidad suficiente
                            foreach ($salones as $r) {
                                // Regla de capacidad (si existe campo size en grupo; si no, omite este if)
                                if (property_exists($g, 'size') && isset($g->size) && isset($r->capacity) && $r->capacity < $g->size) {
                                    continue;
                                }

                                // chequear solapes (room, teacher, group)
                                $conflicto = Assignment::where('day_of_week', $dia)
                                    ->where(function($q) use ($ini,$fin){
                                        $q->where('start_time','<',$fin)
                                          ->where('end_time','>',$ini);
                                    })->where(function($q) use ($r,$p,$g){
                                        $q->where('room_id', $r->id)
                                          ->orWhere('teacher_id', $p->id)
                                          ->orWhere('group_id', $g->id);
                                    })->exists();

                                if ($conflicto) { continue; }

                                Assignment::create([
                                    'group_id'    => $g->id,
                                    'teacher_id'  => $p->id,
                                    'room_id'     => $r->id,
                                    'day_of_week' => $dia,
                                    'start_time'  => $ini,
                                    'end_time'    => $fin,
                                ]);

                                $creadas++;
                                $asignado = true;
                                break 3; // siguiente grupo
                            }
                        }
                    }
                }

                if (!$asignado) {
                    $saltadas[] = $g->id;
                }
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors(['auto' => 'Error en autoasignación: '.$e->getMessage()]);
        }

        $msg = "Autoasignación completada. Creadas: {$creadas}.". (count($saltadas) ? " Grupos sin asignar: ".implode(',',$saltadas) : "");
        return redirect()->route('horario.show')->with('success', $msg);
    }

    // ÉPICA 7: Horarios personales y por recurso
    public function teacherSchedule(Teacher $teacher)
    {
        $asigs = Assignment::with(['group','room'])
            ->where('teacher_id', $teacher->id)->orderBy('day_of_week')->orderBy('start_time')->get();
        return view('horario.teacher', compact('teacher','asigs'));
    }

    public function groupSchedule(Group $group)
    {
        $asigs = Assignment::with(['teacher','room'])
            ->where('group_id', $group->id)->orderBy('day_of_week')->orderBy('start_time')->get();
        return view('horario.group', compact('group','asigs'));
    }

    public function roomSchedule(Room $room)
    {
        $asigs = Assignment::with(['teacher','group'])
            ->where('room_id', $room->id)->orderBy('day_of_week')->orderBy('start_time')->get();
        return view('horario.room', compact('room','asigs'));
    }

    // ÉPICA 7: Reportes y estadísticas
    public function reports()
    {
        // Utilización por salón: horas ocupadas / horas disponibles (07-19h * 5 días)
        $horasTotalesSemana = (19 - 7) * 5; // 60 slots de 1h; ajusta si manejas otra granularidad
        $ocupacionSalas = Room::withCount(['assignments as horas_ocupadas' => function ($q) {
            $q->select(DB::raw('SUM(TIMESTAMPDIFF(MINUTE, start_time, end_time))/60'));
        }])->get()->map(function($r) use($horasTotalesSemana){
            $ocup = (float)($r->horas_ocupadas ?? 0.0);
            return [
                'room' => $r->name ?? ('Sala '.$r->id),
                'horas' => round($ocup, 1),
                'utilizacion_%' => round(100 * $ocup / max(1,$horasTotalesSemana), 1),
            ];
        });

        // Carga de profesores: horas dictadas por semana
        $cargaProfes = Teacher::withCount(['assignments as horas' => function ($q) {
            $q->select(DB::raw('SUM(TIMESTAMPDIFF(MINUTE, start_time, end_time))/60'));
        }])->get()->map(function($t){
            return [
                'teacher' => $t->name ?? ('Prof '.$t->id),
                'horas' => round((float)($t->horas ?? 0.0), 1),
            ];
        });

        // Conflictos potenciales (si hubiera)
        $conflictos = []; // ya validamos solapes en creación; aquí podrías listar warnings si aplicara.

        return view('reportes.index', [
            'ocupacionSalas' => $ocupacionSalas,
            'cargaProfes' => $cargaProfes,
            'conflictos' => $conflictos,
        ]);
    }

    public function showHorario()
    {
        $days = ['lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado'];
        $timeSlots = [];
        for ($hour = 7; $hour <= 21; $hour++) {
            $timeSlots[] = sprintf('%02d:00:00', $hour);
        }
        $assignments = Assignment::with(['group', 'teacher.user', 'room'])->get();
        $horario = [];
        foreach ($assignments as $assignment) {
            $startTime = strtotime($assignment->start_time);
            $endTime = strtotime($assignment->end_time);
            $durationInHours = round(($endTime - $startTime) / 3600);
            $assignment->duration = $durationInHours > 0 ? $durationInHours : 1;
            $startTimeFormatted = date('H:00:00', $startTime);
            $horario[$startTimeFormatted][$assignment->day_of_week] = $assignment;
        }
        return view('horario.show', [
            'days' => $days,
            'timeSlots' => $timeSlots,
            'horario' => $horario,
        ]);
    }
}