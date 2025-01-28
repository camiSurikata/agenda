@extends('layouts/layoutMaster')

@section('content')
<div class="container">
    <h4>Editar Especialidad</h4>
    <form action="{{ route('especialidades.update', $especialidad->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="input-field">
            <input type="text" name="nombre" id="nombre" value="{{ $especialidad->nombre }}" required>
            <label for="nombre" class="active">Nombre de la Especialidad</label>
        </div>
        <button type="submit" class="btn waves-effect waves-light">Actualizar</button>
    </form>
</div>
@endsection
