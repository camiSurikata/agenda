@extends('layouts/layoutMaster')

@section('title', 'Creador de Box')
@section('content')
    <h1>Crear Nuevo Box</h1>
    <form action="{{ route('convenios.store') }}" method="POST" class="card p-4 shadow-sm">
        @csrf

        <!-- Nombre -->
        <div class="mb-3">
            <label for="convenio" class="form-label">Nombre del Convenio:</label>
            <input 
                type="text" 
                name="convenio" 
                id="convenio" 
                value="{{ old('nombre') }}" 
                class="form-control" 
                placeholder="Ingrese el nombre del convenio"
                required>
        </div>

        <!-- Fecha de Afiliación -->
        <div class="mb-3">
            <label for="fecha_afiliacion" class="form-label">Fecha de Afiliación:</label>
            <input 
                type="date" 
                name="fecha_afiliacion" 
                id="fecha_afiliacion" 
                value="{{ old('fecha_afiliacion') }}" 
                class="form-control" 
                required>
        </div>

        <!-- Tipo -->
        <div class="mb-3">
            <label for="tipo" class="form-label">Tipo de Convenio:</label>
            <select 
                name="tipo" 
                id="tipo" 
                class="form-select" 
                required>
                <option value="Isapre" {{ old('tipo') == 'Isapre' ? 'selected' : '' }}>Isapre</option>
                <option value="Convenio" {{ old('tipo') == 'Convenio' ? 'selected' : '' }}>Convenio</option>
            </select>
        </div>

        <!-- Porcentaje de Descuento -->
        <div class="mb-3">
            <label for="porcentaje_descuento" class="form-label">Porcentaje de Descuento:</label>
            <input 
                type="number" 
                name="porcentaje_descuento" 
                id="porcentaje_descuento" 
                value="{{ old('porcentaje_descuento') }}" 
                class="form-control" 
                placeholder="0-100"
                min="0" 
                max="100" 
                required>
        </div>

        <!-- Estado -->
        <div class="mb-3">
            <label for="estado" class="form-label">Estado:</label>
            <select 
                name="estado" 
                id="estado" 
                class="form-select" 
                required>
                <option value="1" {{ old('estado') == '1' ? 'selected' : '' }}>Activo</option>
                <option value="2" {{ old('estado') == '2' ? 'selected' : '' }}>Inhabilitado</option>
            </select>
        </div>

        <!-- Botón Guardar -->
        <div class="text-center">
            <button type="submit" class="btn btn-primary w-50">Guardar Convenio</button>
        </div>
    </form>
@endsection
