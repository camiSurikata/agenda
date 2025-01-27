@extends('layouts/layoutMaster')

@section('title', 'Medicos')

@section('content')
    <div class="container">
        <h1>Médicos</h1>
        <a href="{{ route('medicos.create') }}" class="btn btn-primary mb-3">Crear Nuevo Médico</a>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Teléfono</th>
                    <th>Email</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($medicos as $medico)
                    <tr>
                        <td>{{ $medico->nombre }}</td>
                        <td>{{ $medico->telefono }}</td>
                        <td>{{ $medico->email }}</td>
                        <td style="padding: 5px; text-align: center;">
                            <a href="{{ route('medicos.horario', $medico->id) }}" class="btn btn-info btn-sm m-1">Editar
                                Horario</a>
                            <a href="{{ route('medicos.edit', $medico->id) }}" class="btn btn-info btn-sm">Editar
                                Contrato</a>
                            <a href="{{ route('medicos.edit', $medico->id) }}" class="btn btn-warning btn-sm">Editar
                                Datos</a>
                            <br>
                            <a href="{{ route('medicos.edit', $medico->id) }}" class="btn btn-warning btn-sm">Arancel
                                Previsional</a>
                            <form action="{{ route('medicos.destroy', $medico->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Deshabilitar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
