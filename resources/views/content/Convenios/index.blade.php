@extends('layouts/layoutMaster')

@section('title', 'convenios')
@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <h1>Lista de Convenios</h1>
    <a class="btn btn-primary mb-3" href="{{ route('convenios.create') }}">Crear Nuevo Convenio</a>
    
    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif
    
    <div class="card-datatable table-responsive pt-0">
        <table class="datatables-basic table table-responsive">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Fecha de Afiliación</th>
                    <th>Tipo</th>
                    <th>Porcentaje Descuento</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($convenios as $convenio)
                    <tr>
                        <td>{{ $convenio->convenio }}</td>
                        <td>{{ $convenio->fecha_afiliacion }}</td>
                        <td>{{ $convenio->tipo }}</td>
                        <td>{{ $convenio->porcentaje_descuento }}%</td>
                        <td>
                            @if ($convenio->estado == 1)
                             Activo
                            @elseif ($convenio->estado == 2)
                             Desactivado
                            @endif
                        </td>
                        <td>
                            <a class="btn btn-outline-info" href="{{ route('convenios.edit', $convenio) }}">Editar</a>
                            <form action="{{ route('convenios.destroy', $convenio) }}" method="POST" style="display:inline;" id="delete-form-{{ $convenio->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $convenio->id }})">Eliminar</button>
                            </form>
                            @if ($convenio->estado == 1)
                                <form action="{{ route('convenios.toggle', $convenio) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-outline-danger">Desactivar</button>
                                </form>
                            @elseif ($convenio->estado == 2)
                                <form action="{{ route('convenios.toggle', $convenio) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-outline-success">Activar</button>
                                </form>
                            @endif
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
    function confirmDelete(convenioId) {
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
                document.getElementById('delete-form-' + convenioId).submit();

                Swal.fire({
                    title: "Eliminado!",
                    text: "El convenio ha sido eliminado.",
                    icon: "success"
                });
            }
        });
    }
</script>
