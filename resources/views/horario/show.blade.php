@extends('layouts.app')

@section('content')
    <h1 class="text-xl font-bold mb-4">Horario Semestral</h1>
    <style>
        table { width: 100%; border-collapse: collapse; table-layout: fixed; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: center; vertical-align: top; height: 60px; }
        th { background-color: #f2f2f2; }
    </style>

    @php $spannedCells = []; @endphp

    <table>
        <thead>
            <tr>
                <th style="width: 10%;">Hora</th>
                @foreach ($days as $num => $day)
                    <th>{{ $day }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($timeSlots as $timeSlot)
                <tr>
                    <td>{{ date('h:i A', strtotime($timeSlot)) }}</td>
                    @foreach ($days as $num => $day)
                        @if(isset($spannedCells[$timeSlot][$num]))
                            @continue
                        @endif

                        @if(isset($horario[$timeSlot][$num]))
                            @php
                                $assignment = $horario[$timeSlot][$num];
                                for ($i = 1; $i < $assignment->duration; $i++) {
                                    $nextSlot = date('H:00:00', strtotime($timeSlot) + $i * 3600);
                                    $spannedCells[$nextSlot][$num] = true;
                                }
                            @endphp
                            <td rowspan="{{ $assignment->duration }}">
                                <div class="p-2 rounded bg-blue-100 text-gray-900 dark:bg-blue-800 dark:text-white">
                                    <strong>{{ $assignment->group->name }}</strong><br>
                                    {{ $assignment->teacher->user->name }}<br>
                                    <em>Salón: {{ $assignment->room->name }}</em>
                                </div>
                            </td>
                        @else
                            <td></td>
                        @endif
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
