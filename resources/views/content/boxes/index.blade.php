@extends('layouts/layoutMaster')

@section('title', 'Usuarios')
@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <h1>Lista de Boxes</h1>
    {{-- <a href="{{ route('boxes.create') }}">Crear Nuevo Box</a> --}}
    <a class="btn btn-primary mb-3" href="{{ route('boxes.create') }}">Crear Box</a>
    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif
    
    
    <div class="card-datatable table-responsive pt-0">
        <table class="datatables-basic table  table-responsive">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($boxes as $box)
                    <tr>
                        <td>{{ $box->nombre }}</td>
                        <td>
                            <a href="{{ route('boxes.edit', $box) }}"class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{ route('boxes.destroy', $box) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $box->id }})">Eliminar</button>
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
    console.log('2');
    console.log($.fn.DataTable); // Debería devolver una función, no `undefined`.

    jQuery(document).ready(function($) {
        console.log('jQuery está cargado correctamente');
        $('.datatables-basic').DataTable({
            language:{
                url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
            }
        });
    });
</script>
<script>
    function confirmDelete(pacienteId) {
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
                document.getElementById('delete-form-' + pacienteId).submit();

                Swal.fire({
                    title: "Eliminado!",
                    text: "El paciente ha sido eliminado.",
                    icon: "success"
                });
            }
        });
    }
</script>