@extends('layouts/layoutMaster')

@section('content')
    <div class="container">
        <h1>Lista de Pacientes</h1>
        <a href="{{ route('paciente.create') }}" class="btn btn-primary mb-3">Nuevo Paciente</a>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Previsión</th>
                    <th>Sexo</th>
                    <th>RUT</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pacientes as $paciente)
                    <tr>
                        <td>{{ $paciente->idpaciente }}</td>
                        <td>{{ $paciente->nombre }}</td>
                        <td>{{ $paciente->apellido }}</td>
                        <td>{{ $paciente->prevision }}</td>
                        <td>{{ $paciente->sexo }}</td>
                        <td>{{ $paciente->rut }}</td>
                        <td>
                            <a href="{{ route('paciente.show', $paciente) }}" class="btn btn-info btn-sm">Ver</a>
                            <a href="{{ route('paciente.edit', $paciente->idpaciente) }}"
                                class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{ route('paciente.destroy', $paciente->idpaciente) }}" method="POST"
                                style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('¿Seguro que deseas eliminar este paciente?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No hay pacientes registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
