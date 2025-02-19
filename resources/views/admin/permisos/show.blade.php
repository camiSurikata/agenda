@extends('layouts/layoutMaster')

@section('title', 'Usuarios')
@section('content')
    <div class="container-primary row">

        <form action="{{ route('permisos.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                {{-- CHECKOUT PRUEBA --}}
                <label>Permisos a Módulos:</label>
                @foreach ($modulos as $item)
                    <div>
                        <input type="hidden" name="usuario" value="{{ $user->id }}">
                        <input type="checkbox" name="modulo[]" id="modulo_{{ $item->id }}" value="{{ $item->id }}"
                            @if ($user_modulos->pluck('idModulo')->contains($item->id)) checked @endif>
                        <label for="modulo_{{ $item->id }}">{{ $item->nombre }}</label>
                    </div>
                @endforeach
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
            <button class="btn btn-secondary">Cancelar</button>
        </form>

    </div>
@endsection
