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

        <div class="list-group" style="max-height: 80vh; overflow-y: auto; padding: 15px; margin-bottom: 0; display: flex; flex-wrap: wrap; justify-content: space-between;">
            @foreach ($pacientes as $paciente)
                <div class="list-group-item list-group-item-action d-flex align-items-center cursor-pointer" style="padding: 20px; border-radius: 10px; flex: 0 0 48%; margin-bottom: 20px;">
                    <img src="{{ asset('assets/img/avatars/' . $paciente->idpaciente . '.png') }}" alt="User Image" class="rounded-circle me-3" style="height: 100px; width: 100px;">
                    <div class="w-100">
                        <div class="d-flex justify-content-between">
                            <div class="user-info">
                                <h6 class="mb-1" style="font-size: 22px; font-weight: bold;">{{ $paciente->nombre }} {{ $paciente->apellido }}</h6>
                                <div class="d-flex flex-column align-items-start">
                                    <div class="d-flex justify-content-start">
                                        <small style="font-size: 16px; margin-right: 10px;">Sexo: {{ $paciente->sexo == 2 ? 'Masculino' : 'Femenino' }}</small>
                                        <small style="font-size: 16px;">Rut: {{ $paciente->rut }}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="add-btn">
                                <a href="{{ route('paciente.show', $paciente->idpaciente) }}" class="btn btn-info btn-sm">Ver</a>
                                <a href="{{ route('paciente.edit', $paciente->idpaciente) }}" class="btn btn-warning btn-sm">Editar</a>
                                <form action="{{ route('paciente.destroy', $paciente) }}" method="POST" style="display:inline;" id="delete-form-{{ $paciente->idpaciente }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $paciente->idpaciente }})">Eliminar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>                  
    </div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    
    $(document).ready(function() {
        $('#pacienteTable').DataTable({
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
            }
        });
    });
    
    

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

