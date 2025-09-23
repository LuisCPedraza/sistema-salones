@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">Asignación Manual</h1>

<div class="flex gap-4">
    <!-- Panel lateral -->
    <div class="w-1/3 p-4 bg-gray-100 dark:bg-gray-800 rounded">
        <h2 class="font-semibold mb-2">Grupos</h2>
        @foreach($groups as $group)
            <div draggable="true" class="draggable p-2 mb-2 bg-blue-200 dark:bg-blue-600 rounded cursor-move"
                 data-type="group" data-id="{{ $group->id }}" data-name="{{ $group->name }}">
                {{ $group->name }}
            </div>
        @endforeach

        <h2 class="font-semibold mt-4 mb-2">Profesores</h2>
        @foreach($teachers as $teacher)
            <div draggable="true" class="draggable p-2 mb-2 bg-green-200 dark:bg-green-600 rounded cursor-move"
                 data-type="teacher" data-id="{{ $teacher->id }}" data-name="{{ $teacher->user->name }}">
                {{ $teacher->user->name }}
            </div>
        @endforeach

        <h2 class="font-semibold mt-4 mb-2">Salones</h2>
        @foreach($rooms as $room)
            <div draggable="true" class="draggable p-2 mb-2 bg-purple-200 dark:bg-purple-600 rounded cursor-move"
                 data-type="room" data-id="{{ $room->id }}" data-name="{{ $room->name }}">
                {{ $room->name }} (cap. {{ $room->capacity }})
            </div>
        @endforeach
    </div>

    <!-- Horario -->
    <div class="w-2/3 grid grid-cols-6 gap-2">
        @foreach($days as $dayIndex => $day)
            <div>
                <h3 class="font-bold text-center mb-1">{{ ucfirst($day) }}</h3>
                @for($h=7; $h<=19; $h++)
                    <div class="slot border h-16 flex items-center justify-center text-sm"
                         data-day="{{ $dayIndex+1 }}" data-hour="{{ sprintf('%02d:00', $h) }}">
                        {{ $h }}:00
                    </div>
                @endfor
            </div>
        @endforeach
    </div>
</div>

<script>
let selected = {};
document.querySelectorAll('.draggable').forEach(item => {
    item.addEventListener('dragstart', e => {
        selected[item.dataset.type] = {
            id: item.dataset.id,
            name: item.dataset.name
        };
        e.dataTransfer.setData("text/plain", JSON.stringify(selected));
    });
});

document.querySelectorAll('.slot').forEach(slot => {
    slot.addEventListener('dragover', e => e.preventDefault());
    slot.addEventListener('drop', e => {
        e.preventDefault();
        if (!selected.group || !selected.teacher || !selected.room) {
            alert("⚠️ Debes arrastrar un grupo, un profesor y un salón antes.");
            return;
        }

        fetch("{{ route('assignments.storeManual') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                group_id: selected.group.id,
                teacher_id: selected.teacher.id,
                room_id: selected.room.id,
                day_of_week: slot.dataset.day,
                start_time: slot.dataset.hour,
                end_time: (parseInt(slot.dataset.hour) + 1) + ":00"
            })
        })
        .then(res => res.json())
        .then(resp => {
            if (resp.error) {
                alert(resp.error);
            } else {
                slot.innerHTML = `${selected.group.name}<br>${selected.teacher.name}<br>${selected.room.name}`;
                slot.classList.add("bg-green-300");
                selected = {}; // reset selección
            }
        });
    });
});
</script>
@endsection
