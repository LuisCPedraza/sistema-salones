@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <h1 class="text-2xl font-bold mb-6">Horario Drag & Drop</h1>

    <div class="overflow-x-auto">
        <table class="w-full border-collapse border">
            <thead>
                <tr>
                    <th class="border p-2">Hora</th>
                    @foreach($days as $day)
                        <th class="border p-2">{{ $day }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($timeSlots as $slot)
                    <tr>
                        <td class="border p-2">{{ $slot }}</td>
                        @foreach($days as $dayNum => $dayName)
                            <td class="border p-2 align-top">
                                <div class="slot min-h-[80px]" data-day="{{ $dayNum }}" data-time="{{ $slot }}">
                                    @if(isset($horario[$dayNum][$slot]))
                                        @foreach($horario[$dayNum][$slot] as $a)
                                            <div class="assignment bg-blue-500 text-white p-2 mb-1 rounded cursor-move" 
                                                 data-id="{{ $a->id }}">
                                                <strong>{{ $a->group->name }}</strong><br>
                                                {{ $a->teacher->user->name }}<br>
                                                <em>{{ $a->room->name }}</em>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Drag & Drop con SortableJS --}}
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".slot").forEach(slot => {
        new Sortable(slot, {
            group: "horario",
            animation: 150,
            onAdd: function (evt) {
                let item = evt.item;
                let id   = item.dataset.id;
                let day  = evt.to.dataset.day;
                let time = evt.to.dataset.time;

                fetch("{{ route('horario.dragdrop.update') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({id, day, time})
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        console.log("Asignación actualizada");
                    }
                });
            }
        });
    });
});
</script>
@endsection
