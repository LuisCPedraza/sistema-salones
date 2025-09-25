@extends('layouts.app')

@section('content')
    <h1>Reportes de Utilización y Estadísticas</h1>

    <h2>Utilización de Salones</h2>
    <table border="1" width="100%">
        <thead>
            <tr>
                <th>Salón</th>
                <th>Horas Ocupadas</th>
                <th>% Utilización</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ocupacionSalas as $s)
                <tr>
                    <td>{{ $s['room'] }}</td>
                    <td>{{ $s['horas'] }}</td>
                    <td>{{ $s['utilizacion_%'] }}%</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Carga de Profesores</h2>
    <table border="1" width="100%">
        <thead>
            <tr>
                <th>Profesor</th>
                <th>Horas Dictadas</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cargaProfes as $p)
                <tr>
                    <td>{{ $p['teacher'] }}</td>
                    <td>{{ $p['horas'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Conflictos Detectados</h2>
    @if(count($conflictos))
        <ul>
            @foreach($conflictos as $c)
                <li>{{ $c }}</li>
            @endforeach
        </ul>
    @else
        <p>No se detectaron conflictos.</p>
    @endif
@endsection
