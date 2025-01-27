@extends('layouts/layoutMaster')

@section('content')
    <div class="container">
        <h1>Nuevo Paciente</h1>
        <a href="{{ route('paciente.index') }}" class="btn btn-secondary mb-3">Volver</a>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('paciente.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre') }}"
                    required>
            </div>
            <div class="mb-3">
                <label for="apellido" class="form-label">Apellido</label>
                <input type="text" class="form-control" id="apellido" name="apellido" value="{{ old('apellido') }}"
                    required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}"
                    required>
            </div>
            <div class="mb-3">
                <label for="telefono" class="form-label">Telefono</label>
                <input type="text" class="form-control" id="telefono" name="telefono" value="{{ old('telefono') }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="prevision" class="form-label">Previsión</label>
                <input type="text" class="form-control" id="prevision" name="prevision" value="{{ old('prevision') }}"
                    required>
            </div>
            <div class="mb-3">
                <label for="sexo" class="form-label">Sexo</label>
                <select id="sexo" name="sexo" class="form-control" required>
                    <option value="">Seleccione</option>
                    <option value="2" {{ old('sexo') == '2' ? 'selected' : '' }}>Masculino</option>
                    <option value="1" {{ old('sexo') == '1' ? 'selected' : '' }}>Femenino</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento"
                    value="{{ old('fecha_nacimiento') }}" required>
            </div>
            <div class="mb-3">
                <label for="rut" class="form-label">RUT</label>
                <input type="text" class="form-control" id="rut" name="rut" value="{{ old('rut') }}"
                    required>
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>
@endsection
