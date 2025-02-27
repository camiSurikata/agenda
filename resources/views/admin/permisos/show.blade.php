@extends('layouts/layoutMaster')

@section('title', 'Usuarios')
@section('content')
    <div class="container-primary row">

        <form action="{{ route('permisos.store') }}" method="POST">
            @csrf
            <div class="mb-4">

                <label>Permisos a Módulos:</label><br>
                @foreach ($modulosDisponibles as $modulo)
                    <div>
                        <input type="hidden" name="usuario" value="{{ $user->id }}">
                        <input type="checkbox" name="modulos[]" value="{{ $modulo->id }}"
                            {{ in_array($modulo->id, $modulosPermitidos) ? 'checked' : '' }}>
                        {{ $modulo->nombre }}<br>
                    </div>
                @endforeach

                <button type="submit" class="btn btn-primary">Guardar</button>
                <button type="button" class="btn btn-secondary">Cancelar</button>
                <!-- falta agregarle la funcion al cancelar que simplemente te devuelva a la lista de usuarios -->
            </div>
        </form>

    </div>
@endsection
