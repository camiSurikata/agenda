@extends('layouts/layoutMaster')

@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <div class="container">
        <h1>Lista de Pacientes</h1>
        <a href="{{ route('paciente.create') }}" class="btn btn-primary mb-3">Nuevo Paciente</a>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif


        <div class="card-datatable table-responsive pt-0">
            <table class="datatables-basic table  table-responsive">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Previsión</th>
                        <th>Sexo</th>
                        <th>RUT</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pacientes as $paciente)
                        <tr>
                            <td>{{ $paciente->idpaciente }}</td>
                            <td>{{ $paciente->nombre }}</td>
                            <td>{{ $paciente->apellido }}</td>
                            <td>{{ $paciente->previsionConvenio->convenio ?? 'Sin convenio' }}</td>
                            <td>{{ $paciente->sexo == 1 ? 'Femenino' : 'Masculino' }}</td>
                            <td>{{ $paciente->rut }}</td>
                            <td>
                                <a href="{{ route('paciente.show', $paciente->idpaciente) }}" class="btn btn-info btn-sm">Ver</a>
                                <a href="{{ route('paciente.edit', $paciente->idpaciente) }}"
                                    class="btn btn-warning btn-sm">Editar</a>
                                <form action="{{ route('paciente.destroy', $paciente->idpaciente) }}" method="POST"
                                    style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('¿Seguro que deseas eliminar este paciente?')">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No hay pacientes registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
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
