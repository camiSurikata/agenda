@extends('layouts/layoutMaster')

@section('title', 'Usuarios')
@section('content')

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <h1>Lista de Usuarios</h1>

    <div class="card-datatable table-responsive pt-0">
        <table class="datatables-basic table  table-responsive">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Estado</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->nombre }}</td>
                        <td>
                            @if ($user->status == 1)
                                <span class="badge rounded-pill bg-label-success me-1">Activo</span>
                            @elseif($user->status == 0)
                                <span class="badge rounded-pill bg-label-danger me-1">Inactivo</span>
                            @else
                                Desconocido
                            @endif
                        </td>
                        <td>
                            <a class="btn btn-success" href="{{route('permisos.show', $user->id)}}">Ver permisos</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

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