@component('layouts/sections/navbar/navbar-agenda')
    @extends('layouts/layoutMaster')

    @section('title', 'Reserva de Citas')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bs-stepper/bs-stepper.css') }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/bs-stepper/bs-stepper.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection

@section('page-script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var stepper = new Stepper(document.querySelector('.bs-stepper'));

            document.getElementById('siguientePaso').addEventListener('click', function() {
                stepper.next(); // Avanza al siguiente paso
            });

            document.getElementById('abrirModal').addEventListener('click', function() {
                var modal = new bootstrap.Modal(document.getElementById('modalHorarios'));
                modal.show();
            });
        });
    </script>
@endsection

@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">Reserva de Citas /</span> Paso a Paso
    </h4>

    <div class="row">
        <div class="col-12">
            <h5>Proceso de Reserva</h5>
        </div>

        <!-- Stepper -->
        <div class="col-12 mb-4">
            <div class="bs-stepper wizard-numbered mt-2">
                <div class="bs-stepper-header">
                    <!-- Paso 1: Selección de Datos -->
                    <div class="step" data-target="#seleccion-datos">
                        <button type="button" class="step-trigger">
                            <span class="bs-stepper-circle"><i class="mdi mdi-account"></i></span>
                            <span class="bs-stepper-label">
                                <span class="bs-stepper-number">01</span>
                                <span class="bs-stepper-title">Datos del Paciente</span>
                            </span>
                        </button>
                    </div>
                    <div class="line"></div>

                    <!-- Paso 2: Selección de Horarios -->
                    <div class="step active" data-target="#seleccion-horarios">
                        <button type="button" class="step-trigger">
                            <span class="bs-stepper-circle"><i class="mdi mdi-clock"></i></span>
                            <span class="bs-stepper-label">
                                <span class="bs-stepper-number">02</span>
                                <span class="bs-stepper-title">Seleccionar Horario</span>
                            </span>
                        </button>
                    </div>
                </div>

                <div class="bs-stepper-content">
                    <!-- Paso 1: Selección de Datos -->
                    <div id="seleccion-datos" class="content active">
                        <form id="form-reserva" class="mt-4">
                            @csrf
                            <div class="form-group">
                                <label for="nombre">Paciente</label>
                                <input type="text" id="nombre" class="form-control"
                                    value="{{ $paciente->nombre }} {{ $paciente->apellido }}" readonly>
                                <input type="hidden" name="paciente_id" value="{{ $paciente->id }}">
                            </div>

                            <div class="form-group">
                                <label for="sucursal">Sucursal</label>
                                <select id="sucursal" name="sucursal_id" class="form-control" required>
                                    <option value="">Seleccione una sucursal</option>
                                    @foreach ($sucursales as $sucursal)
                                        <option value="{{ $sucursal->id }}">{{ $sucursal->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="especialidad">Especialidad</label>
                                <select id="especialidad" name="especialidad_id" class="form-control" required>
                                    <option value="">Seleccione una especialidad</option>
                                    @foreach ($especialidades as $especialidad)
                                        <option value="{{ $especialidad->id }}">{{ $especialidad->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="medico">Médico</label>
                                <select id="medico" name="medico_id" class="form-control" required>
                                    <option value="">Seleccione un médico</option>
                                    @foreach ($medicos as $medico)
                                        <option value="{{ $medico->id }}">{{ $medico->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="button" id="siguientePaso" class="btn btn-primary mt-3">Siguiente</button>
                            <button id="abrirModal" type="button" class="btn btn-info mt-3">Ver Horarios Disponibles</button>

                        </form>
                    </div>

                    <!-- Paso 2: Selección de Horarios -->
                    <div id="seleccion-horarios" class="content">
                        <h5 class="text-center mt-4">Seleccione un horario disponible</h5>
                        <button id="abrirModal" type="button" class="btn btn-info mt-3">Ver Horarios Disponibles</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Horarios con Pestañas -->
    <div class="modal fade" id="modalHorarios" tabindex="-1" aria-labelledby="modalHorariosLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="horariosModalLabel">Horarios Disponibles</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Pestañas para los días disponibles -->
                    <ul class="nav nav-tabs" id="horariosTabs" role="tablist"></ul>

                    <!-- Contenedor de contenido de pestañas -->
                    <div class="tab-content mt-3" id="horariosTabContent"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        id="cerrarModal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@endsection



<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sucursalSelect = document.getElementById('sucursal');
        const especialidadSelect = document.getElementById('especialidad');
        const medicoSelect = document.getElementById('medico');

        sucursalSelect.addEventListener('change', cargarHorarios);
        especialidadSelect.addEventListener('change', cargarHorarios);
        medicoSelect.addEventListener('change', cargarHorarios);

        function cargarHorarios() {
            const sucursalId = sucursalSelect.value;
            const especialidadId = especialidadSelect.value;
            const medicoId = medicoSelect.value;

            if (sucursalId && especialidadId && medicoId) {
                axios.post('{{ route('horarios.disponibles') }}', {
                        sucursal_id: sucursalId,
                        especialidad_id: especialidadId,
                        medico_id: medicoId,
                        _token: '{{ csrf_token() }}'
                    })
                    .then(response => {
                        const horarios = response.data.horarios;
                        if (horarios.length > 0) {
                            generarPestañasHorarios(horarios);
                            const modalHorarios = new bootstrap.Modal(document.getElementById(
                                'modalHorarios'));
                            modalHorarios.show();
                        } else {
                            alert("No hay horarios disponibles.");
                        }
                    })
                    .catch(error => console.error("Error al cargar los horarios:", error));
            } else {
                console.error("Faltan datos para cargar los horarios");
            }
        }

        function generarPestañasHorarios(horarios) {
            const horariosTabs = document.getElementById('horariosTabs');
            const horariosTabContent = document.getElementById('horariosTabContent');

            horariosTabs.innerHTML = ''; // Limpiar pestañas
            horariosTabContent.innerHTML = ''; // Limpiar contenido

            const diasDisponibles = {};

            // Agrupar horarios por día
            horarios.forEach(horario => {
                const fechaCompleta = obtenerProximoDia(horario.dia_semana);
                if (!diasDisponibles[fechaCompleta]) {
                    diasDisponibles[fechaCompleta] = [];
                }
                diasDisponibles[fechaCompleta].push(horario);
            });

            // Crear pestañas y contenido
            let primeraPestaña = true;

            Object.keys(diasDisponibles).forEach((dia, index) => {
                // Crear pestaña
                const tabItem = document.createElement('li');
                tabItem.className = 'nav-item';
                tabItem.innerHTML = `
                <button class="nav-link ${primeraPestaña ? 'active' : ''}" id="tab-${index}" data-bs-toggle="tab" data-bs-target="#content-${index}" type="button" role="tab">
                    ${dia}
                </button>
            `;
                horariosTabs.appendChild(tabItem);

                // Crear contenido de pestaña
                const tabContent = document.createElement('div');
                tabContent.className = `tab-pane fade ${primeraPestaña ? 'show active' : ''}`;
                tabContent.id = `content-${index}`;
                tabContent.innerHTML = generarBotonesHorarios(diasDisponibles[dia]);
                horariosTabContent.appendChild(tabContent);

                primeraPestaña = false;
            });
        }

        function generarBotonesHorarios(horarios) {
            let botonesHTML = '<div class="d-flex flex-wrap gap-2">';
            horarios.forEach(horario => {
                const intervalos = generarIntervalos(horario.hora_inicio, horario.hora_termino, horario
                    .descanso_inicio, horario.descanso_termino);
                intervalos.forEach(intervalo => {
                    botonesHTML += `
                    <button class="btn btn-primary btn-sm" onclick="seleccionarHorario('${intervalo}')">
                        ${intervalo}
                    </button>
                `;
                });
            });
            botonesHTML += '</div>';
            return botonesHTML;
        }

        function seleccionarHorario(horario) {
            alert(`Has seleccionado el horario: ${horario}`);
            const modalHorarios = bootstrap.Modal.getInstance(document.getElementById('modalHorarios'));
            modalHorarios.hide();
        }

        function obtenerProximoDia(diaSemana) {
            const dias = ["domingo", "lunes", "martes", "miércoles", "jueves", "viernes", "sábado"];
            const hoy = new Date();
            const diaActual = hoy.getDay();
            const indiceDia = dias.indexOf(diaSemana.toLowerCase());
            let diferencia = indiceDia - diaActual;
            if (diferencia <= 0) {
                diferencia += 7;
            }
            hoy.setDate(hoy.getDate() + diferencia);
            return `${dias[hoy.getDay()]} ${hoy.getDate()}/${hoy.getMonth() + 1}/${hoy.getFullYear()}`;
        }

        function generarIntervalos(horaInicio, horaTermino, descansoInicio, descansoTermino) {
            const intervalos = [];
            let [hInicio, mInicio] = horaInicio.split(':').map(Number);
            let [hFin, mFin] = horaTermino.split(':').map(Number);

            let descansoInicioHora = descansoInicio ? descansoInicio.split(':').map(Number) : null;
            let descansoFinHora = descansoTermino ? descansoTermino.split(':').map(Number) : null;

            while (hInicio < hFin || (hInicio === hFin && mInicio < mFin)) {
                let siguienteMinutos = (mInicio + 30) % 60;
                let siguienteHora = mInicio + 30 >= 60 ? hInicio + 1 : hInicio;

                let enDescanso = descansoInicioHora && descansoFinHora &&
                    ((hInicio > descansoInicioHora[0] || (hInicio === descansoInicioHora[0] && mInicio >=
                            descansoInicioHora[1])) &&
                        (hInicio < descansoFinHora[0] || (hInicio === descansoFinHora[0] && mInicio <
                            descansoFinHora[1])));

                if (!enDescanso) {
                    intervalos.push(
                        `${String(hInicio).padStart(2, '0')}:${String(mInicio).padStart(2, '0')} - ${String(siguienteHora).padStart(2, '0')}:${String(siguienteMinutos).padStart(2, '0')}`
                    );
                }

                hInicio = siguienteHora;
                mInicio = siguienteMinutos;
            }

            return intervalos;
        }
    });
</script>

<script>
    // Listener para el botón de abrir el modal
    document.getElementById('abrirModal').addEventListener('click', function(event) {
        // Reemplaza 'campo1' y 'campo2' con los IDs de tus campos necesarios
        var campo1 = document.getElementById('sucursal').value;
        var campo2 = document.getElementById('especialidad').value;
        var campo3 = document.getElementById('medico').value;

        if (!campo1 || !campo2 || !campo3) {
            event.preventDefault(); // Prevenir el comportamiento predeterminado del botón
            alert('Por favor, rellena todos los campos necesarios.');
        } else {
            // Si los campos están completos, abre el modal
            var modal = new bootstrap.Modal(document.getElementById('modalHorarios'));
            modal.show();
        }
    });
</script>



<script>
    document.getElementById('cerrarModal').addEventListener('click', function() {
        // Obtener y restablecer los formularios dentro del modal
        var modal = document.getElementById('modalHorarios');
        if (modal) {
            modal.querySelectorAll('input, select').forEach(function(field) {
                field.value = '';
            });
        }
    });
</script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
