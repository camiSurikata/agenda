@extends('layouts/layoutMaster')

@section('title', 'Usuarios')
@section('content')

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <h1>Lista de Usuarios</h1>

    <a class="btn btn-primary mb-3" href="{{ route('users.create') }}">Crear Usuario</a>
    <div class="card-datatable table-responsive pt-0">
        <table class="datatables-basic table  table-responsive">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Estado</th>
                    <th>Acciones</th>
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
                            <a class="btn btn-outline-info" href="{{ route('users.edit', $user) }}">Editar</a>
                            @if ($user->status == 1)
                                <form action="{{ route('users.destroy', $user) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger">Desactivar</button>
                                </form>
                            @elseif ($user->status == 0)
                                <form action="{{ route('users.activate', $user) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PUT')
                                    <!-- O el método que uses para activar -->
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

<script>
    console.log('2');
    console.log($.fn.DataTable); // Debería devolver una función, no `undefined`.

    jQuery(document).ready(function($) {
        console.log('jQuery está cargado correctamente');
        $('.datatables-basic').DataTable();
    });
</script>
