@extends('layouts.app')

@section('content')
    <h1>Horario Semestral</h1>
    <style>
        table { width: 100%; border-collapse: collapse; table-layout: fixed; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: center; vertical-align: top; height: 60px; }
        th { background-color: #f2f2f2; }
        .assignment { background-color: #e0f7fa; border-radius: 5px; padding: 5px; font-size: 0.8em; height: 100%; }
    </style>

    @php $spannedCells = []; @endphp

    <table border="1">
        <thead>
            <tr>
                <th style="width: 10%;">Hora</th>
                @foreach ($days as $day)
                    <th>{{ ucfirst($day) }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($timeSlots as $timeSlot)
                <tr>
                    <td>{{ date('h:i A', strtotime($timeSlot)) }}</td>
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
                            <td rowspan="{{ $assignment->duration }}">
                                <div class="assignment">
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
