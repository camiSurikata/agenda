@extends('layouts/layoutMaster')

@section('title', 'Editar Especialidad')
@section('content')
<div class="container">
    <h1>{{ isset($user) ? 'Editar Especialidad' : 'Crear Especialidad' }}</h1>
    <div
        class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg position-relative py-sm-5 px-4 py-4">


        <form action="{{ isset($user) ? route('especialidades.update', $especialidad) : route('especialidades.store') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-floating form-floating-outline mb-3">
                <input value="{{ old('nombre', $user->nombre ?? '') }}" type="text" class="form-control" id="nombre"
                    name="nombre" placeholder="Ingrese nombre de Especialidad" autofocus>
                <label for="nombre">Nombre especialidad</label>
            </div>

            <div class="form-floating form-floating-outline mb-3">
                <select name="status" id="form-repeater-1-2" class="form-select">
                    <option value="1" selected>Habilitado</option>
                    <option value="0">Inhabilitado</option>
                </select>
                <label for="form-repeater-1-2">Estado</label>
            </div>

            <button class="btn btn-primary d-grid w-100" type="submit">Actualizar</button>
        </form>
    </div>
</div>
@endsection
