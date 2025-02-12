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
                                        <select id="medico" name="medico_id" class="form-control" onchange="obtenerHorarios()" required>
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
                loadHorarios(dateStr, 1, window.horariosMedico,diaSemana); // Pasar los horarios del médico
            }
        });

        function loadHorarios(fecha, page, horariosMedico) {
            let horariosContainer = document.getElementById("horarios");
            let paginationContainer = document.getElementById("pagination");
            let horarios = generateHorarios(fecha, horariosMedico,);

            horariosContainer.innerHTML = "";
            paginationContainer.innerHTML = "";

            if (horarios.length === 0) {
                horariosContainer.innerHTML =
                    `<tr><td colspan="4" class="text-center">No hay horarios disponibles.</td></tr>`;
                return;
            }

            let start = (page - 1) * itemsPerPage;
            let end = start + itemsPerPage;
            let paginatedHorarios = horarios.slice(start, end);

            paginatedHorarios.forEach(hora => {
                horariosContainer.innerHTML += `
                <tr>
                    <td>${hora}</td>
                    <td>15 minutos</td>
                    <td><button class="btn btn-success">Reservar hora</button></td>
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
                    loadHorarios(fecha, page, horariosMedico);
                });
            });
        }

        function generateHorarios(fecha, horariosMedico) {
            let horarios = [];
            let startTime, endTime, descansoInicio, descansoTermino;
            let duracion_consulta = 15; // Duración de la consulta en minutos
            horariosMedico.forEach(horario => {
                startTime = new Date(`2025-01-01T${horario.hora_inicio}`);
                endTime = new Date(`2025-01-01T${horario.hora_termino}`);
                descansoInicio = new Date(`2025-01-01T${horario.descanso_inicio}`);
                descansoTermino = new Date(`2025-01-01T${horario.descanso_termino}`);

                while (startTime < endTime) {
                    let timeStr = startTime.toTimeString().substring(0, 5);

                    if (startTime >= descansoInicio && startTime < descansoTermino) {
                        startTime.setMinutes(startTime.getMinutes() + duracion_consulta);
                        continue;
                    }

                    horarios.push(timeStr);
                    startTime.setMinutes(startTime.getMinutes() + duracion_consulta);
                }
            });

            return horarios;
        }

        //EventListener para cargar médicos al seleccionar una especialidad
        /*
        document.getElementById('especialidad').addEventListener('change', function() {
            let idEspecialidad = this.value; // Obtiene el ID de la especialidad seleccionada

            if (idEspecialidad) {
                axios.get(`/especialidad/${idEspecialidad}/medicos`)
                    .then(response => {
                        let selectMedico = document.getElementById('medico');
                        selectMedico.innerHTML =
                            '<option value="">Seleccione un médico</option>'; // Limpia el select

                        response.data.forEach(medico => {
                            let option = document.createElement('option');
                            option.value = medico
                                .id; // Asegúrate de que 'id' es el campo correcto en la base de datos
                            option.textContent = medico
                                .nombre; // Asegúrate de que 'nombre' es el campo correcto
                            selectMedico.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Error al cargar médicos:', error);
                    });
            }
        });
        */

        // Event listener para el botón "Siguiente" en el paso 3
        document.getElementById('siguientePaso').addEventListener('click', function() {
            stepper.next(); // Avanza al siguiente paso
        });

        //
        //script de calendario nuevo

    });

    function obtenerHorarios() {
        var medicoId = document.getElementById('medico').value;

        if (medicoId) {
            fetch(`/obtener-horarios/${medicoId}`)
            .then(response => response.json())
            .then(data => {
                let horariosHtml = "<ul>";
                data.forEach(horario => {
                    horariosHtml += `<li>${horario.dia_semana}: ${horario.hora_inicio} - ${horario.hora_termino}</li>`;
                });
                horariosHtml += "</ul>";
                document.getElementById('horarios-disponibles').innerHTML = horariosHtml;

                // Guardar los horarios del médico en una variable global
                window.horariosMedico = data;
            })
            .catch(error => console.error("Error obteniendo horarios:", error));
        }
    }
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

