<?php

namespace App\Rules;

use App\Models\Assignment;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NoTimeOverlap implements ValidationRule
{
    protected $data;
    protected $ignoreId;

    public function __construct(array $data, $ignoreId = null)
    {
        $this->data = $data;
        $this->ignoreId = $ignoreId;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $day = $this->data['day_of_week'] ?? null;
        $start = $this->data['start_time'] ?? null;
        $end   = $this->data['end_time'] ?? null;
        $room  = $this->data['room_id'] ?? null;
        $teacher = $this->data['teacher_id'] ?? null;
        $group   = $this->data['group_id'] ?? null;

        if (!$day || !$start || !$end) {
            return; // no valida si faltan datos
        }

        $conflicto = Assignment::where('day_of_week', $day)
            ->where(function($q) use ($start,$end){
                $q->where('start_time','<',$end)
                  ->where('end_time','>',$start);
            })
            ->where(function($q) use ($room,$teacher,$group){
                if ($room)    $q->orWhere('room_id',$room);
                if ($teacher) $q->orWhere('teacher_id',$teacher);
                if ($group)   $q->orWhere('group_id',$group);
            });

        if ($this->ignoreId) {
            $conflicto->where('id','<>',$this->ignoreId);
        }

        if ($conflicto->exists()) {
            $fail('Conflicto: ya existe una asignación en este horario.');
        }
    }
}
