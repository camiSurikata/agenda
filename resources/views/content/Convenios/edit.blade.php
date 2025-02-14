@extends('layouts.layoutMaster')

@section('title', 'Editar Convenio')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Editar Convenio</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('convenios.update', $convenio->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre del Convenio</label>
                <input type="text" class="form-control" id="nombre" name="convenio" value="{{ old('convenio', $convenio->convenio) }}" required>
            </div>

            <div class="mb-3">
                <label for="fecha_afiliacion" class="form-label">Fecha de Afiliación</label>
                <input type="date" class="form-control" id="fecha_afiliacion" name="fecha_afiliacion" value="{{ old('fecha_afiliacion', $convenio->fecha_afiliacion) }}" required>
            </div>

            <div class="mb-3">
                <label for="tipo" class="form-label">Tipo</label>
                <select class="form-select" id="tipo" name="tipo" required>
                    <option value="Isapre" {{ $convenio->tipo == 'Isapre' ? 'selected' : '' }}>Isapre</option>
                    <option value="Convenio" {{ $convenio->tipo == 'Convenio' ? 'selected' : '' }}>Convenio</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="porcentaje_descuento" class="form-label">Porcentaje de Descuento</label>
                <input type="number" class="form-control" id="porcentaje_descuento" name="porcentaje_descuento" value="{{ old('porcentaje_descuento', number_format($convenio->porcentaje_descuento, 0)) }}" required>
            </div>

            <div class="mb-3">
                <label for="estado" class="form-label">Estado</label>
                <select class="form-select" id="estado" name="estado" required>
                    <option value="1" {{ $convenio->estado == 1 ? 'selected' : '' }}>Activo</option>
                    <option value="2" {{ $convenio->estado == 2 ? 'selected' : '' }}>Desactivar</option>
                    <option value="3" {{ $convenio->estado == 3 ? 'selected' : '' }}>Eliminar</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Actualizar Convenio</button>
            <a href="{{ route('convenios.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection
<script>
    document.getElementById('btnActualizar').addEventListener('click', function () {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Esta acción actualizará la información del convenio.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, actualizar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('formEditarConvenio').submit();
            }
        });
    });
</script>


