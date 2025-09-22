@extends('layouts.app')

@section('content')
    <h1 class="text-xl font-bold mb-4">Horario Semestral</h1>

    @php $spannedCells = []; @endphp

    <table class="w-full border-collapse table-fixed text-sm">
        <thead>
            <tr>
                <th class="w-24 border border-gray-300 bg-gray-200 dark:bg-gray-700 dark:text-gray-100">Hora</th>
                @foreach ($days as $day)
                    <th class="border border-gray-300 bg-gray-200 dark:bg-gray-700 dark:text-gray-100">
                        {{ ucfirst($day) }}
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($timeSlots as $timeSlot)
                <tr>
                    <td class="border border-gray-300 p-2 text-center dark:border-gray-600">
                        {{ date('h:i A', strtotime($timeSlot)) }}
                    </td>
                    @foreach ($days as $day)
                        @if(isset($spannedCells[$timeSlot][$day]))
                            @continue
                        @endif

                        @if(isset($horario[$timeSlot][$day]))
                            @php
                                $assignment = $horario[$timeSlot][$day];
                                for ($i = 1; $i < $assignment->duration; $i++) {
                                    $nextSlot = date('H:00:00', strtotime($timeSlot) + $i * 3600);
                                    $spannedCells[$nextSlot][$day] = true;
                                }
                            @endphp
                            <td rowspan="{{ $assignment->duration }}" class="border border-gray-300 dark:border-gray-600 p-1">
                                <div class="p-2 rounded bg-blue-100 text-gray-900 dark:bg-blue-800 dark:text-white">
                                    <strong>{{ $assignment->group->name }}</strong><br>
                                    {{ $assignment->teacher->user->name }}<br>
                                    <em>Salón: {{ $assignment->room->name }}</em>
                                </div>
                            </td>
                        @else
                            <td class="border border-gray-300 dark:border-gray-600"></td>
                        @endif
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
