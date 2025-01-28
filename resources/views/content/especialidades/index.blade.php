@extends('layouts/layoutMaster')

@section('content')
<div class="container">
    <h4>Lista de Especialidades</h4>
    <a href="{{ route('especialidades.create') }}" class="btn waves-effect waves-light">Nueva Especialidad</a>
    <table class="striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($especialidades as $especialidad)
                <tr>
                    <td>{{ $especialidad->id }}</td>
                    <td>{{ $especialidad->nombre }}</td>
                    <td>
                        <a href="{{ route('especialidades.edit', $especialidad->id) }}" class="btn-small blue">Editar</a>
                        <form action="{{ route('especialidades.destroy', $especialidad->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-small red">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
