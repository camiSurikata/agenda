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
                        <td>{{ $convenio->nombre }}</td>
                        <td>{{ $convenio->fecha_afiliacion }}</td>
                        <td>{{ $convenio->tipo }}</td>
                        <td>{{ $convenio->porcentaje_descuento }}%</td>
                        <td>
                            @if ($convenio->estado == 1)
                                Activo
                            @elseif ($convenio->estado == 2)
                                Inhabilitado
                            @else
                                Eliminado Lógicamente
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('convenios.edit', $convenio) }}">Editar</a>
                            <form action="{{ route('convenios.destroy', $convenio) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Eliminar</button>
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

<script>
    jQuery(document).ready(function($) {
        $('.datatables-basic').DataTable({
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
            }
        });
    });
</script>
