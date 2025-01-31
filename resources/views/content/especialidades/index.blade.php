@extends('layouts/layoutMaster')

@section('title', 'Especialidades')
@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <h1>Lista de Especialidades</h1>
    <a href="{{ route('especialidades.create') }}" class="btn btn-primary mb-3">Nueva Especialidad</a>

    <div class="card-datatable table-responsive pt-0">
        <table class="datatables-basic table table-responsive">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($especialidades as $especialidad)
                    <tr>
                        <td>{{ $especialidad->id }}</td>
                        <td>{{ $especialidad->nombre }}</td>
                        <td>
                            @if ($especialidad->status == 1)
                                <span class="badge rounded-pill bg-label-success me-1">Habilitado</span>
                            @elseif($especialidad->status == 0)
                                <span class="badge rounded-pill bg-label-danger me-1">Deshabilitado</span>
                            @else
                                Desconocido
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('especialidades.edit', $especialidad->id) }}" class="btn-small blue">Editar</a>
                            <form action="{{ route('especialidades.destroy', $especialidad->id) }}" method="POST"
                                style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger"
                                    onclick="confirmDelete({{ $especialidad->id }})">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
    jQuery(document).ready(function($) {
        $('.datatables-basic').DataTable({
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
            }
        });
    });
</script>

<script>
    // Función para mostrar el mensaje de confirmación
    function confirmDelete(especialidadId) {
        Swal.fire({
            title: "¿Estás seguro?",
            text: "¡No podrás revertir esta acción!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Sí, eliminarlo",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.isConfirmed) {
                // Si el usuario confirma, enviar el formulario para eliminar el convenio
                document.getElementById('delete-form-' + especialidadId).submit();

                Swal.fire({
                    title: "Eliminado!",
                    text: "El convenio ha sido eliminado.",
                    icon: "success"
                });
            }
        });
    }
</script>
