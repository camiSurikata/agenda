@extends('layouts/layoutMaster')

@section('content')
<div class="container">
    <h4>Nueva Especialidad</h4>
    <form action="{{ route('especialidades.store') }}" method="POST">
        @csrf
        <div class="input-field">
            <input type="text" name="nombre" id="nombre" required>
            <label for="nombre">Nombre de la Especialidad</label>
        </div>
        <button type="submit" class="btn waves-effect waves-light">Guardar</button>
    </form>
</div>
@endsection
