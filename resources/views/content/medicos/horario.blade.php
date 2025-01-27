@extends('layouts/layoutMaster')
<!-- Bootstrap CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>


@section('title', 'Crear Medicos')
@section('content')
    <div class="container">
        <h3>Editar Horario de {{ $medico->nombre }}</h3>

        <form action="{{ route('medicos.horario.update', $medico->id) }}" method="POST">
            @csrf
            @method('PUT')

            <table class="table">
                <thead>
                    <tr>
                        <th>Día</th>
                        <th>Hora Inicio</th>
                        <th>Hora Término</th>
                        <th>Descanso</th>
                        <th>Box Atención</th>
                        <th>No Atiende</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'] as $dia)
                        @php
                            $horario = $medico->horarios->firstWhere('dia_semana', $dia);
                        @endphp
                        <tr>
                            <td>{{ $dia }}</td>
                            <td>
                                <input type="time" name="horarios[{{ $dia }}][hora_inicio]"
                                    value="{{ $horario->hora_inicio ?? '' }}" class="form-control">
                            </td>
                            <td>
                                <input type="time" name="horarios[{{ $dia }}][hora_termino]"
                                    value="{{ $horario->hora_termino ?? '' }}" class="form-control">
                            </td>
                            <td>
                                <input type="time" name="horarios[{{ $dia }}][descanso_inicio]"
                                    value="{{ $horario->descanso_inicio ?? '' }}" class="form-control">
                                <input type="time" name="horarios[{{ $dia }}][descanso_termino]"
                                    value="{{ $horario->descanso_termino ?? '' }}" class="form-control mt-2">
                            </td>
                            <td>
                                <input type="text" name="horarios[{{ $dia }}][box_atencion]"
                                    value="{{ $horario->box_atencion ?? '' }}" class="form-control">
                            </td>
                            <td>
                                <input type="checkbox" name="horarios[{{ $dia }}][no_atiende]" value="1"
                                    {{ $horario->no_atiende ? 'checked' : '' }}>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <button type="submit" class="btn btn-success">Guardar Cambios</button>
            <a href="{{ route('medicos.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
    <br>
    <button id="addBloqueoBtn" class="btn btn-success" data-toggle="modal" data-target="#bloqueoModal">
        + Crear un nuevo bloqueo programado
    </button>
    <br>
    <div class="row">
        <table id="bloqueosTable">
            <thead>
                <tr>
                    <th>Sucursal</th>
                    <th>Fecha</th>
                    <th>Hora Inicio</th>
                    <th>Hora Término</th>
                    <th>Creado Por</th>
                    <th>Recurso</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>



    {{-- MODAL BLOQUEO  --}}
    <!-- Modal -->
    <div class="modal fade" id="bloqueoModal" tabindex="-1" role="dialog" aria-labelledby="bloqueoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bloqueoModalLabel">Agregar Bloqueo Programado</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="sucursal">Sucursal:</label>
                            <input type="text" class="form-control" name="sucursal" id="sucursal" required>
                        </div>
                        <div class="form-group">
                            <label for="fecha">Fecha:</label>
                            <input type="date" class="form-control" name="fecha" id="fecha" required>
                        </div>
                        <div class="form-group">
                            <label for="hora_inicio">Hora Inicio:</label>
                            <input type="time" class="form-control" name="hora_inicio" id="hora_inicio" required>
                        </div>
                        <div class="form-group">
                            <label for="hora_termino">Hora Término:</label>
                            <input type="time" class="form-control" name="hora_termino" id="hora_termino" required>
                        </div>
                        <button type="button" id="bloqueoForm" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection


<script>
    $(document).ready(function() {
        const medicoId = {{ $medico->id }};
        alert();
        cargarBloqueos();

        // Agregar nuevo bloqueo
        $('#bloqueoForm').on('click', function(e) { // Cambié 'onClick' por 'click'
            e.preventDefault();
            console.log('BloqueoForm button clicked'); // Para verificar que el evento se activa

            const formData = {
                sucursal: $('#sucursal').val(),
                fecha: $('#fecha').val(),
                hora_inicio: $('#hora_inicio').val(),
                hora_termino: $('#hora_termino').val(),
                recurso: 1,
                creado_por: 'Usuario Actual', // Cambiar según tu lógica
            };

            console.log('Form data:', formData);

            // Aquí puedes descomentar la lógica para enviar el formulario por AJAX
            $.ajax({
                url: `/medicos/${medicoId}/bloqueos`,
                method: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(response) {
                    alert('Bloqueo guardado correctamente.');
                    $('#bloqueoModal').modal('hide'); // Cerrar el modal
                    // cargarBloqueos(); // Actualizar la tabla
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    alert('Error al guardar el bloqueo.');
                },
            });
        });

        // Cargar bloqueos
        function cargarBloqueos() {
            $.ajax({
                url: `/medicos/${medicoId}/bloqueos`,
                method: 'GET',
                success: function(data) {
                    const tbody = $('#bloqueosTable tbody');
                    tbody.empty(); // Limpia la tabla

                    data.forEach((bloqueo) => {
                        tbody.append(`
                        <tr>
                            <td>${bloqueo.sucursal}</td>
                            <td>${bloqueo.fecha}</td>
                            <td>${bloqueo.hora_inicio}</td>
                            <td>${bloqueo.hora_termino}</td>
                            <td>${bloqueo.creado_por}</td>
                            <td>${bloqueo.recurso}</td>
                            <td>
                                <button class="btn btn-danger btn-sm delete-btn" data-id="${bloqueo.id}">
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                    `);
                    });

                    // Agregar evento para eliminar
                    $('.delete-btn').on('click', function() {
                        const id = $(this).data('id');
                        eliminarBloqueo(id);
                    });
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    alert('Error al cargar los bloqueos.');
                },
            });
        }

        // Eliminar bloqueo
        function eliminarBloqueo(id) {
            $.ajax({
                url: `/bloqueos/${id}`,
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function() {
                    alert('Bloqueo eliminado correctamente.');
                    cargarBloqueos();
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    alert('Error al eliminar el bloqueo.');
                },
            });
        }
    });
</script>
