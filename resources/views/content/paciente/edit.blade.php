@extends('layouts/layoutMaster')

@section('content')
    <div class="container">
        <h1>Editar Paciente</h1>
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

        <form action="{{ route('paciente.update', $paciente->idpaciente) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $paciente->nombre }}"
                    required>
            </div>
            <div class="mb-3">
                <label for="apellido" class="form-label">Apellido</label>
                <input type="text" class="form-control" id="apellido" name="apellido" value="{{ $paciente->apellido }}"
                    required>
            </div>
            <div class="mb-3">
                <label for="prevision" class="form-label">Previsión</label>
                <input type="text" class="form-control" id="prevision" name="prevision"
                    value="{{ $paciente->prevision }}" required>
            </div>
            <div class="mb-3">
                <label for="sexo" class="form-label">Sexo</label>
                <select id="sexo" name="sexo" class="form-control" required>
                    <option value="2" {{ $paciente->sexo == '2' ? 'selected' : '' }}>Masculino</option>
                    <option value="1" {{ $paciente->sexo == '1' ? 'selected' : '' }}>Femenino</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento"
                    value="{{ $paciente->fecha_nacimiento }}" required>
            </div>
            <div class="mb-3">
                <label for="rut" class="form-label">RUT</label>
                <input type="text" class="form-control" id="rut" name="rut" value="{{ $paciente->rut }}"
                    required>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar</button>
        </form>
    </div>
@endsection
