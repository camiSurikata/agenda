@extends('layouts/layoutMaster')

@section('title', 'Usuarios')
@section('content')
    <div class="container-primary row">

        <form action="{{ route('permisos.store') }}" method="POST">
            @csrf
            <div class="mb-4">

                <label>Permisos a Módulos:</label><br>
                @foreach ($modulosDisponibles as $modulo)
                    <input type="checkbox" name="modulos[]" value="{{ $modulo }}"
                        {{ in_array($modulo, $modulosPermitidos) ? 'checked' : '' }}>
                    {{ $modulo }}<br>
                @endforeach

                <button type="submit" class="btn btn-primary">Guardar</button>
                <button type="button" class="btn btn-secondary">Cancelar</button>
        </form>

    </div>
@endsection
