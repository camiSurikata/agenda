@extends('layouts.layoutMaster')

@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <div class="container">
        <h1>Lista de Pacientes</h1>
        <a href="{{ route('paciente.create') }}" class="btn waves-effect waves-light btn-primary mb-3">Nuevo Paciente</a>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card-datatable table-responsive pt-0">
            <table class="datatables-basic table responsive" >
                <thead>
                    <tr>
                        <th>Imagen</th>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Sexo</th>
                        <th>RUT</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pacientes as $paciente)
                        <tr>
                            <td>
                                <img src="{{ asset('assets/img/avatars/' . $paciente->idpaciente . '.png') }}" alt="User Image" class="rounded-circle" style="height: 100px; width: 100px;">
                            </td>
                            <td>{{ $paciente->idpaciente }}</td>
                            <td>{{ $paciente->nombre }} {{ $paciente->apellido }}</td>
                            <td>{{ $paciente->sexo == 2 ? 'Masculino' : 'Femenino' }}</td>
                            <td>{{ $paciente->rut }}</td>
                            <td>
                                <a href="{{ route('paciente.show', $paciente->idpaciente) }}" class="btn btn-info btn-sm">Ver</a>
                                <a href="{{ route('paciente.edit', $paciente->idpaciente) }}" class="btn btn-warning btn-sm">Editar</a>
                                <form action="{{ route('paciente.destroy', $paciente) }}" method="POST" style="display:inline;" id="delete-form-{{ $paciente->idpaciente }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $paciente->idpaciente }})">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
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

