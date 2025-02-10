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
                <img src="{{ asset('img/averclaro.png') }}" alt="Logo" style="max-width: 450px;">
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
                                        <select id="medico" name="medico_id" class="form-control" required>
                                            <option value="">Seleccione un médico</option>
                                            @foreach ($medicos as $medico)
                                                <option value="{{ $medico->id }}">{{ $medico->nombre }}</option>
                                            @endforeach
                                        </select>
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
                                                <div class="inline-calendar"></div>
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
        flatpickr(".inline-calendar", {
                inline: true,
                dateFormat: "Y-m-d",
                locale: "es",
                minDate: "today",
                onChange: function(selectedDates, dateStr) {
                    console.log("Fecha seleccionada:", dateStr);
                    loadHorarios(dateStr); // Cargar los horarios de la fecha seleccionada
                }
            });

        //Flatpickr
        function loadHorarios(fecha) {
            let horariosContainer = document.getElementById("horarios");
            let horarios = generateHorarios(fecha);

            horariosContainer.innerHTML = "";
            if (horarios.length === 0) {
                horariosContainer.innerHTML =
                    `<tr><td colspan="4" class="text-center">No hay horarios disponibles.</td></tr>`;
                return;
            }

            horarios.forEach(hora => {
                horariosContainer.innerHTML += `
                <tr>
                    <td>${hora}</td>
                    <td>15 minutos</td>
                    <td><button class="btn btn-success">Reservar hora</button></td>
                </tr>`;
            });
        }

        function generateHorarios(fecha) {
            const horarioMedico = {
                horaInicio: "08:00",
                horaTermino: "16:00",
                descansoInicio: "12:00",
                descansoTermino: "14:00",
                duracionConsulta: 15 // Minutos
            };

            let horarios = [];
            let startTime = new Date(`2025-01-01T${horarioMedico.horaInicio}`);
            let endTime = new Date(`2025-01-01T${horarioMedico.horaTermino}`);
            let descansoInicio = new Date(`2025-01-01T${horarioMedico.descansoInicio}`);
            let descansoTermino = new Date(`2025-01-01T${horarioMedico.descansoTermino}`);

            while (startTime < endTime) {
                let timeStr = startTime.toTimeString().substring(0, 5);

                if (startTime >= descansoInicio && startTime < descansoTermino) {
                    startTime.setMinutes(startTime.getMinutes() + horarioMedico.duracionConsulta);
                    continue;
                }

                horarios.push(timeStr);
                startTime.setMinutes(startTime.getMinutes() + horarioMedico.duracionConsulta);
            }

            return horarios;
        }

        

        //EventListener para cargar médicos al seleccionar una especialidad

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


        // Event listener para el botón "Siguiente" en el paso 3
        document.getElementById('siguientePaso').addEventListener('click', function() {
            stepper.next(); // Avanza al siguiente paso
        });

        //
        //script de calendario nuevo

    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
