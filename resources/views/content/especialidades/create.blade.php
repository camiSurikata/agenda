@extends('layouts/layoutMaster')
<link rel="stylesheet" href="assets/vendor/libs/select2/select2.css " />
<script src="assets/vendor/libs/select2/select2.js"></script>

@section('title', 'Crear Especialidad')
@section('content')
    <h1>{{ isset($user) ? 'Editar Especialidad' : 'Crear Especialidad' }}</h1>
    <div class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg position-relative py-sm-5 px-4 py-4">
        <div class="w-px-400 mx-auto pt-5 pt-lg-0">
            <h4>Nueva Especialidad</h4>
            <form action="{{ route('especialidades.store') }}" method="POST">
                @csrf
                <div class="form-floating form-floating-outline mb-3">
                    <input type="text" class="form-control" id="nombre" name="nombre" required
                        placeholder="Ingrese nombre de la especialidad" autofocus>
                    <label for="username">Nombre de la especialidad</label>
                </div>

                <div class="input-field">
                    <select name="status" id="status">
                        <option value="1" selected>Habilitado</option>
                        <option value="0">Inhabilitado</option>
                    </select>
                    <label for="status">Estado</label>
                </div>

                <button  class="btn btn-primary d-grid w-100" type="submit">Registrar</button>
        </div>

        
        </form>
    
    </div>
@endsection
