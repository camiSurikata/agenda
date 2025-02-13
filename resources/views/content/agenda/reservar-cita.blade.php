@extends('layouts/blankLayout')

@section('title', 'Reserva de Citas')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bs-stepper/bs-stepper.css') }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/bs-stepper/bs-stepper.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/flatpickr/l10n/es.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>

@endsection

@section('page-script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var stepper = new Stepper(document.querySelector('.bs-stepper'));

            document.getElementById('siguientePaso').addEventListener('click', function() {
                stepper.next(); // Avanza al siguiente paso
            });
        });
    </script>
@endsection

@section('content')
    <div class="d-flex justify-content-center align-items-center" style="padding: 20px; min-height: 70vh;">
        <div class="w-100" style="max-width: 1000px;">

            <!-- Logo -->
            <div class="text-center mb-4">
                <img src="{{ asset('img/averclaro.png') }}" alt="Logo" style="max-width: 400px;">
            </div>


            <h4 class="py-3 mb-4 text-center">
                <span class="text-muted fw-light">Reserva de Citas /</span> Agendar
            </h4>

            <div class="row">
                <div class="col-12">
                    <h5 class="text-center">Agendar Hora</h5>
                </div>
                <!-- Stepper -->
                <div class="col-12 mb-4">
                    <div class="bs-stepper wizard-numbered mt-2">
                        <div class="bs-stepper-header">
                            <!-- Paso 2: Selección de Médico -->
                            <div class="step active" data-target="#seleccion-medico">
                                <button type="button" class="step-trigger">
                                    <span class="bs-stepper-circle"><i class="mdi mdi-hospital"></i></span>
                                    <span class="bs-stepper-label">
                                        <span class="bs-stepper-number">01</span>
                                        <span class="bs-stepper-title">Seleccionar Médico</span>
                                    </span>
                                </button>
                            </div>
                            <div class="line"></div>

                            <!-- Paso 3: Ver Horarios Disponibles -->
                            <div class="step" data-target="#seleccion-horarios">
                                <button type="button" class="step-trigger">
                                    <span class="bs-stepper-circle"><i class="mdi mdi-clock"></i></span>
                                    <span class="bs-stepper-label">
                                        <span class="bs-stepper-number">02</span>
                                        <span class="bs-stepper-title">Ver Horarios</span>
                                    </span>
                                </button>
                            </div>
                            <div class="line"></div>

                            <!-- Paso 4: Confirmar Reserva -->
                            <div class="step" data-target="#confirmar-reserva">
                                <button type="button" class="step-trigger">
                                    <span class="bs-stepper-circle"><i class="mdi mdi-check-circle"></i></span>
                                    <span class="bs-stepper-label">
                                        <span class="bs-stepper-number">03</span>
                                        <span class="bs-stepper-title">Confirmar Reserva</span>
                                    </span>
                                </button>
                            </div>
                        </div>

                        <div class="bs-stepper-content">
                            <!-- Paso 2: Selección de Médico -->
                            <div id="seleccion-medico" class="content active">
                                <form id="form-reserva" class="mt-4">
                                    @csrf
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
                                                <option value="{{ $especialidad->id }}">{{ $especialidad->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="medico">Médico</label>
                                        <select id="medico" name="medico_id" class="form-control"
                                            onchange="obtenerHorarios()" required>
                                            <option value="">Seleccione un médico</option>
                                            @foreach ($medicos as $medico)
                                                <option value="{{ $medico->id }}">{{ $medico->nombre }}</option>
                                            @endforeach
                                        </select>
                                        <div id="horarios-disponibles"></div> <!-- Aquí se mostrarán los horarios -->
                                    </div>
                                    <button type="button" id="siguientePaso"
                                        class="btn btn-primary mt-3">Siguiente</button>
                                </form>
                            </div>

                            <!-- Paso 3: Ver Horarios Disponibles -->
                            <div id="seleccion-horarios" class="content">
                                <h5 class="text-center mt-4">Seleccione un horario disponible</h5>
                                <div class="card app-calendar-wrapper p-3">
                                    <div class="row g-0">
                                        <!-- Sidebar del Calendario -->
                                        <div class="col-md-4 app-calendar-sidebar border-end">
                                            <div class="text-center p-3">
                                                <img src="{{ asset('images/default-doctor.png') }}" alt="Doctor"
                                                    class="rounded-circle" width="80">
                                                <h5 class="mt-2">Dr. Gabriel Enrique Figueroa Benavides</h5>
                                                <p>Cima Salud - Gran Avenida 4564</p>
                                            </div>
                                            <div class="p-4">
                                                <!-- Calendario Flatpickr -->
                                                <div class="inline-calendar mx-auto"></div>
                                            </div>
                                        </div>

                                        <!-- Contenido del Calendario y Horarios -->
                                        <div class="col-md-8 app-calendar-content">
                                            <div class="card-body">
                                                <!-- FullCalendar -->
                                                <div id="calendar"></div>
                                            </div>
                                            <div class="table-responsive p-3">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>Hora</th>
                                                            <th>Duración</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="horarios">
                                                        <tr>
                                                            <td colspan="4" class="text-center">Seleccione un día para
                                                                ver horarios.</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <nav>
                                                    <ul class="pagination justify-content-center" id="pagination">
                                                        <!-- Paginación generada dinámicamente -->
                                                    </ul>
                                                </nav>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Paso 4: Confirmar Reserva -->
                            <div id="confirmar-reserva" class="content">
                                <h5 class="text-center mt-4">Confirmar Reserva</h5>
                                <p>Por favor, revise la información antes de confirmar.</p>
                                <ul>
                                    <li><strong>Sucursal:</strong> <span id="resumenSucursal"></span></li>
                                    <li><strong>Especialidad:</strong> <span id="resumenEspecialidad"></span></li>
                                    <li><strong>Médico:</strong> <span id="resumenMedico"></span></li>
                                    <li><strong>Horario:</strong> <span id="resumenHorario"></span></li>
                                </ul>
                                <button type="submit" class="btn btn-success">Confirmar Reserva</button>
                            </div>
                        </div>
                    </div>
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

        const stepperElement = document.querySelector('.bs-stepper');
        const stepper = new Stepper(stepperElement);
        const itemsPerPage = 5; // Número de horarios por página
        flatpickr(".inline-calendar", {
            inline: true,
            dateFormat: "Y-m-d",
            locale: "es",
            minDate: "today",
            onChange: function(selectedDates, dateStr) {
                console.log("Fecha seleccionada:", dateStr);
                let diaSemana = new Date(dateStr).getDay();
                console.log(diaSemana)
                loadHorarios(dateStr, 1, window.horariosMedico,
                    diaSemana); // Pasar los horarios del médico
            }
        });

        // Event listener para el botón "Siguiente" en el paso 3
        document.getElementById('siguientePaso').addEventListener('click', function() {
            stepper.next(); // Avanza al siguiente paso
        });

        // Definir la función reservarHora dentro del ámbito de la función DOMContentLoaded
        window.reservarHora = function(button) {
            // Obtener la fila del botón
            const row = button.parentElement.parentElement;
            // Obtener la hora seleccionada
            const horaSeleccionada = row.querySelector('td:first-child').innerText;
            // Asignar la hora seleccionada al campo oculto
            const inputHora = document.getElementById('inputHora');
            if (inputHora) {
                inputHora.value = horaSeleccionada;
            }
            // Actualizar el resumen de la reserva
            const resumenSucursal = document.getElementById('resumenSucursal');
            const resumenEspecialidad = document.getElementById('resumenEspecialidad');
            const resumenMedico = document.getElementById('resumenMedico');
            const resumenHorario = document.getElementById('resumenHorario');
            if (resumenSucursal && resumenEspecialidad && resumenMedico && resumenHorario) {
                resumenSucursal.innerText = document.getElementById('sucursal').options[document.getElementById('sucursal').selectedIndex].text;
                resumenEspecialidad.innerText = document.getElementById('especialidad').options[document.getElementById('especialidad').selectedIndex].text;
                resumenMedico.innerText = document.getElementById('medico').options[document.getElementById('medico').selectedIndex].text;
                resumenHorario.innerText = horaSeleccionada;
            }
            // Avanzar al siguiente paso
            stepper.next();
        }
    });

    function generateHorarios(fecha, horariosMedico) {
        let horarios = [];
        let duracion_consulta = 15; // Duración de la consulta en minutos
        console.log(horariosMedico);
        horariosMedico.forEach(horario => {
            let startTime = new Date(`2025-01-01T${horario.hora_inicio}`);
            let endTime = new Date(`2025-01-01T${horario.hora_termino}`);
            let descansoInicio = horario.descanso_inicio ? new Date(`2025-01-01T${horario.descanso_inicio}`) :
                null;
            let descansoTermino = horario.descanso_termino ? new Date(
                `2025-01-01T${horario.descanso_termino}`) : null;

            while (startTime < endTime) {
                let timeStr = startTime.toTimeString().substring(0, 5);

                // Filtrar si la hora está dentro del descanso
                if (descansoInicio && descansoTermino && startTime >= descansoInicio && startTime <
                    descansoTermino) {
                    startTime.setMinutes(startTime.getMinutes() + duracion_consulta);
                    continue;
                }

                horarios.push(timeStr);
                startTime.setMinutes(startTime.getMinutes() + duracion_consulta);
            }
        });

        return horarios;
    }

    function loadHorarios(fecha, page, horariosMedico, diaSemana) {
        let horariosContainer = document.getElementById("horarios");
        let paginationContainer = document.getElementById("pagination");

        console.log("Fecha seleccionada:", fecha);
        console.log("Día seleccionado (número):", diaSemana);
        console.log("Horarios médicos:", horariosMedico);
        console.log("Horario bloqueado:", window.bloqueosMedico);

        const diasSemanaMap = {
            6: "Domingo",
            0: "Lunes",
            1: "Martes",
            2: "Miércoles",
            3: "Jueves",
            4: "Viernes",
            5: "Sábado"
        };

        let nombreDia = diasSemanaMap[diaSemana];
        let horariosDelDia = horariosMedico.filter(horario => horario.dia_semana === nombreDia);
        console.log("Horarios filtrados para:", nombreDia, horariosDelDia);

        let horarios = generateHorarios(fecha, horariosDelDia);

        horariosContainer.innerHTML = "";
        paginationContainer.innerHTML = "";

        const itemsPerPage = 5;
        let start = (page - 1) * itemsPerPage;
        let end = start + itemsPerPage;
        let paginatedHorarios = horarios.slice(start, end);

        let horariosDisponibles = paginatedHorarios.filter(hora => {
            let horarioValido = true;

            window.bloqueosMedico.forEach(bloqueo => {
                let bloqueoFecha = new Date(bloqueo.fecha).toISOString().split('T')[0];
                let seleccionadaFecha = new Date(fecha).toISOString().split('T')[0];

                if (bloqueoFecha === seleccionadaFecha) {
                    let bloqueoInicio = new Date(`${bloqueoFecha}T${bloqueo.hora_inicio}`);
                    let bloqueoFin = new Date(`${bloqueoFecha}T${bloqueo.hora_termino}`);
                    let horaSeleccionada = new Date(
                    `${seleccionadaFecha}T${hora}`); // Convertir hora en cadena

                    if (!isNaN(horaSeleccionada) && horaSeleccionada >= bloqueoInicio &&
                        horaSeleccionada < bloqueoFin) {
                        horarioValido = false;
                    }
                }
            });

            return horarioValido;
        });

        if (horariosDisponibles.length === 0) {
            horariosContainer.innerHTML =
                `<tr><td colspan="4" class="text-center">No hay horarios disponibles.</td></tr>`;
            return;
        }

        horariosDisponibles.forEach(hora => {
            horariosContainer.innerHTML += `
    <tr>
        <td>${hora}</td>
        <td>15 minutos</td>
        <td><button class="btn btn-success" onclick="reservarHora(this)">Reservar hora</button></td>
    </tr>`;
        });

        let totalPages = Math.ceil(horarios.length / itemsPerPage);
        for (let i = 1; i <= totalPages; i++) {
            paginationContainer.innerHTML += `
    <li class="page-item ${i === page ? 'active' : ''}">
        <a class="page-link" href="#" data-page="${i}">${i}</a>
    </li>`;
        }

        document.querySelectorAll('.page-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                let page = parseInt(this.getAttribute('data-page'));
                loadHorarios(fecha, page, horariosMedico, diaSemana);
            });
        });
    }

    function actualizarCalendario() {
        flatpickr(".inline-calendar", {
            inline: true,
            dateFormat: "Y-m-d",
            locale: "es",
            minDate: "today",
            disable: [
                function(date) {
                    let diaSemana = date.getDay(); // Obtener número del día (0=Domingo, ..., 6=Sábado)
                    return !window.diasLaborales.has(
                        diaSemana); // Bloquear si NO está en los días laborales
                }
            ],
            onChange: function(selectedDates, dateStr) {
                console.log("Fecha seleccionada:", dateStr);
                let diaSemana = new Date(dateStr).getDay();
                console.log(diaSemana);
                console.log(window.horariosMedico);
                loadHorarios(dateStr, 1, window.horariosMedico, diaSemana);
            }
        });
    }

    function obtenerHorarios() {
        var medicoId = document.getElementById('medico').value;

        if (medicoId) {
            fetch(`/obtener-horarios/${medicoId}`)
                .then(response => response.json())
                .then(data => {
                    const horarios = data.horarios;
                    const bloqueos = data.bloqueos;
                    let horariosHtml = "<table class='table'>";
                    let diasLaborales = new Set();

                    // Mapeo de nombres de días a números
                    const diasSemanaMap = {
                        "Domingo": 0,
                        "Lunes": 1,
                        "Martes": 2,
                        "Miércoles": 3,
                        "Jueves": 4,
                        "Viernes": 5,
                        "Sábado": 6
                    };

                    // Mostrar horarios
                    horarios.forEach(horario => {
                        horariosHtml += `
                        <tr>
                            <td>${horario.dia_semana}</td>
                            <td>${horario.hora_inicio} - ${horario.hora_termino}</td>
                        </tr>`;

                        let diaNumero = diasSemanaMap[horario.dia_semana];
                        if (diaNumero !== undefined) {
                            diasLaborales.add(diaNumero);
                        }
                    });

                    horariosHtml += "</table>";
                    document.getElementById('horarios-disponibles').innerHTML = horariosHtml;

                    // Guardar los horarios y los bloqueos en variables globales
                    window.horariosMedico = data.horarios;
                    window.bloqueosMedico = data.bloqueos;
                    window.diasLaborales = diasLaborales;
                    console.log("Días bloqueados:", bloqueosMedico);

                    // Recargar el calendario con las restricciones correctas
                    actualizarCalendario();
                })
                .catch(error => console.error("Error obteniendo horarios:", error));
        }
    }
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
