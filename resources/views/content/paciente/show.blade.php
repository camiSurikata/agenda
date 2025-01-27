@extends('layouts/layoutMaster')

@section('content')
    <div class="container">
        <h1>Detalles del Paciente</h1>
        <a href="{{ route('paciente.index') }}" class="btn btn-secondary mb-3">Volver</a>

        <table class="table table-bordered">
            <tr>
                <th>Nombre</th>
                <td>{{ $paciente->nombre }}</td>
            </tr>
            <tr>
                <th>Apellido</th>
                <td>{{ $paciente->apellido }}</td>
            </tr>
            <tr>
                <th>Previsión</th>
                <td>{{ $paciente->prevision }}</td>
            </tr>
            <tr>
                <th>Sexo</th>
                <td>{{ $paciente->sexo }}</td>
            </tr>
            <tr>
                <th>Fecha de Nacimiento</th>
                <td>{{ $paciente->fecha_nacimiento }}</td>
            </tr>
            <tr>
                <th>RUT</th>
                <td>{{ $paciente->rut }}</td>
            </tr>
        </table>
    </div>
@endsection
