@extends('layouts/layoutMaster')
<link rel="stylesheet" href="assets/vendor/libs/select2/select2.css " />
<script src="assets/vendor/libs/select2/select2.js"></script>

@section('title', 'Crear Nueva Atención')
@section('content')
    <h1>Crear Nueva Atención</h1>
    <div class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg position-relative py-sm-5 px-4 py-4">
        <div class="w-px-400 mx-auto pt-5 pt-lg-0">
            <h4>Nueva Atención</h4>
            <form action="{{ route('examenes.store') }}" method="POST">
                @csrf
                <div class="form-floating form-floating-outline mb-3">
                    <input type="text" class="form-control" id="nombre" name="nombre" required placeholder="Ingrese nombre del paciente" autofocus>
                    <label for="nombre">Nombre del Paciente</label>
                </div>
                <div class="form-floating form-floating-outline mb-3">
                    <input type="text" class="form-control" id="profesional" name="profesional" required placeholder="Ingrese nombre del profesional">
                    <label for="profesional">Profesional</label>
                </div>
                <div class="form-floating form-floating-outline mb-3">
                    <input type="text" class="form-control" id="codigo" name="codigo" required placeholder="Ingrese código">
                    <label for="codigo">Código</label>
                </div>
                <div class="form-floating form-floating-outline mb-3">
                    <input type="text" class="form-control" id="examen" name="examen" required placeholder="Ingrese examen">
                    <label for="examen">Examen</label>
                </div>
                <div class="form-floating form-floating-outline mb-3">
                    <input type="text" class="form-control" id="resultado" name="resultado" required placeholder="Ingrese resultado">
                    <label for="resultado">Resultado</label>
                </div>
                <div class="form-floating form-floating-outline mb-3">
                    <input type="date" class="form-control" id="fecha" name="fecha" required placeholder="Ingrese fecha">
                    <label for="fecha">Fecha</label>
                </div>
                <div class="form-floating form-floating-outline mb-3">
                    <input type="text" class="form-control" id="estado" name="estado" required placeholder="Ingrese estado">
                    <label for="estado">Estado</label>
                </div>
                <button class="btn btn-primary d-grid w-100" type="submit">Guardar Examen</button>
            </form>
        </div>
    </div>
@endsection