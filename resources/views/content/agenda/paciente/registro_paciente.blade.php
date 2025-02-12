@extends('layouts/blankLayout')

@section('content')
    <div class="d-flex justify-content-center align-items-center" style="min-height: 88vh;">
        <div class="w-100" style="max-width: 600px;">

            <div class="text-center mb-4">
                <img src="{{ asset('img/averclaro.png') }}" alt="Logo" style="max-width: 500px;">
            </div>

            <h4 class="py-3 mb-4 text-center">
                <span class="text-muted fw-light">Reserva de Citas /</span> Registro de Paciente
            </h4>
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="/guardar-paciente" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="rut">RUT</label>
                            <input type="text" id="rut" name="rut" class="form-control"
                                value="{{ $rut }}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="nombre">Nombre</label>
                            <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Nombre"
                                required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="apellido">Apellido</label>
                            <input type="text" id="apellido" name="apellido" class="form-control" placeholder="Apellido"
                                required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="email">Correo Electrónico</label>
                            <input type="email" id="email" name="email" class="form-control"
                                placeholder="Correo Electrónico" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="prevision">Previsión</label>
                            <input type="text" id="prevision" name="prevision" class="form-control"
                                placeholder="Previsión" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="telefono">Teléfono</label>
                            <input type="text" id="telefono" name="telefono" class="form-control" placeholder="Teléfono"
                                required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100" href='/reservar-cita'>Registrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
