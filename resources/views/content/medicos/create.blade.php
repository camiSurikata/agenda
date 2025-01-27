@extends('layouts/layoutMaster')

@section('title', 'Crear Medicos')

@section('content')
    <div class="container row">
        <h1>Crear Médico</h1>
        <div class="col-5">
            <form action="{{ route('medicos.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre y apellido</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>
                <div class="mb-3">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="text" class="form-control" id="telefono" name="telefono" required>
                </div>
                <div class="mb-3">
                    <label for="rut" class="form-label">Rut</label>
                    <input type="text" class="form-control" id="rut" name="rut" required>
                </div>
                {{-- <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div> --}}

                <button type="submit" class="btn btn-success">Guardar</button>

        </div>

        <div class=" col-6">
            <div>
                {{-- FORMULARIO --}}
                <h3>Usuario para entrar al sistema</h3>
                <div class="form-floating form-floating-outline mb-3">
                    <input type="text" class="form-control" id="email" name="email" placeholder="Ingrese su Email">
                    <label for="email">Correo electronico</label>
                </div>
                <div class="mb-3 form-password-toggle">
                    <div class="input-group input-group-merge">
                        <div class="form-floating form-floating-outline">
                            <input type="password" id="password" class="form-control" name="password"
                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                aria-describedby="password" />
                            <label for="password">Contraseña</label>
                        </div>
                        <span class="input-group-text cursor-pointer"><i class="mdi mdi-eye-off-outline"></i></span>
                    </div>
                </div>
                </form>



            </div>
        </div>
    </div>

@endsection
