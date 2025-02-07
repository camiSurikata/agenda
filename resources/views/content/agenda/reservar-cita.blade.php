@extends('layouts/blankLayout')

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
        });
    </script>
@endsection



@section('content')
    

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const medicoId = 1; // ID fijo del médico
            const horariosContainer = document.getElementById("horarios");
            const calendar = document.getElementById("calendar");
            const monthYear = document.getElementById("monthYear");

            let currentDate = new Date();

            // Horario del médico (Lunes de 08:00 a 16:00, con descanso de 12:00 a 14:00)
            const horarioMedico = {
                dias: ["Lunes"], // Solo atiende los lunes
                horaInicio: "08:00",
                horaTermino: "16:00",
                descansoInicio: "12:00",
                descansoTermino: "14:00",
                duracionConsulta: 15 // Minutos
            };

            // Bloqueos programados (fechas y horas bloqueadas)
            const bloqueos = [{
                    fecha: "2025-02-24",
                    horaInicio: "08:00",
                    horaTermino: "09:00"
                },
                {
                    fecha: "2025-02-24",
                    horaInicio: "10:00",
                    horaTermino: "11:00"
                }
            ];

            // Verificar si una hora está bloqueada
            function estaBloqueado(fecha, hora) {
                return bloqueos.some(bloqueo => {
                    return bloqueo.fecha === fecha &&
                        hora >= bloqueo.horaInicio &&
                        hora < bloqueo.horaTermino;
                });
            }

            function renderCalendar() {
                const year = currentDate.getFullYear();
                const month = currentDate.getMonth();
                const firstDay = new Date(year, month, 1).getDay();
                const lastDate = new Date(year, month + 1, 0).getDate();

                monthYear.innerText = currentDate.toLocaleString('es-ES', {
                    month: 'long',
                    year: 'numeric'
                });

                let days = '<div class="calendar-grid">';
                const weekDays = ['Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa', 'Do'];
                days += weekDays.map(d => `<div class="day-name">${d}</div>`).join("");

                for (let i = 1; i < firstDay; i++) days += '<div class="empty"></div>';

                for (let i = 1; i <= lastDate; i++) {
                    let date = new Date(year, month, i);
                    let dayName = date.toLocaleDateString('es-ES', {
                        weekday: 'long'
                    }).toLowerCase(); // Convertir el nombre del día a minúsculas

                    let dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;
                    let isWorkDay = horarioMedico.dias.some(dia => dia.toLowerCase() ===
                        dayName); // Comparación en minúsculas

                    days +=
                        `<div class="calendar-day ${isWorkDay ? '' : 'disabled'}" data-date="${dateStr}">${i}</div>`;
                }

                days += '</div>';
                calendar.innerHTML = days;

                document.querySelectorAll(".calendar-day:not(.disabled)").forEach(day => {
                    day.addEventListener("click", function() {
                        let selectedDate = this.dataset.date;
                        loadHorarios(selectedDate);
                        document.querySelectorAll(".calendar-day").forEach(d => d.classList.remove(
                            "selected"));
                        this.classList.add("selected");
                    });
                });
            }

            function generateHorarios(fecha) {
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

                    // Verificar si la hora está bloqueada
                    if (estaBloqueado(fecha, timeStr)) {
                        startTime.setMinutes(startTime.getMinutes() + horarioMedico.duracionConsulta);
                        continue;
                    }

                    horarios.push(timeStr);
                    startTime.setMinutes(startTime.getMinutes() + horarioMedico.duracionConsulta);
                }

                return horarios;
            }

            function loadHorarios(fecha) {
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
                <td>${fecha}</td>
                <td>${hora}</td>
                <td>15 minutos</td>
                <td><button class="btn btn-success">Reservar hora</button></td>
            </tr>`;
                });
            }

            document.getElementById("prevMonth").addEventListener("click", () => {
                currentDate.setMonth(currentDate.getMonth() - 1);
                renderCalendar();
            });

            document.getElementById("nextMonth").addEventListener("click", () => {
                currentDate.setMonth(currentDate.getMonth() + 1);
                renderCalendar();
            });

            renderCalendar();
        });
    </script>

    <style>
        #calendar-container {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
            width: 100%; /* Adjust the width */
            height: auto; /* Adjust the height */
        }

        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: bold;
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 2px; /* Reduce gap */
            text-align: center;
        }

        .day-name {
            font-weight: bold;
            font-size: 0.8rem; /* Smaller font size */
        }

        .calendar-day,
        .empty {
            padding: 5px; /* Reduce padding */
            border-radius: 3px; /* Smaller border radius */
            cursor: pointer;
            font-size: 0.8rem; /* Smaller font size */
        }

        .calendar-day:hover {
            background-color: #007bff;
            color: white;
        }

        .calendar-day.selected {
            background-color: #0056b3;
            color: white;
        }

        .calendar-day.disabled {
            background-color: #ddd;
            color: #777;
            cursor: not-allowed;
        }
    </style>




    <div class="d-flex justify-content-center align-items-center" style="padding: 20px; min-height: 70vh;">
        <div class="w-100" style="max-width: 800px;">

            <!-- Logo -->
            <div class="text-center mb-4">
                <img src="{{ asset('img/averclaro.png') }}" alt="Logo" style="max-width: 500px;">
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
                                <div class="container">
                                    <a href="#" class="btn btn-secondary mb-3">« Volver</a>
                            
                                    <div class="card p-3">
                                        <div class="row">
                                            <!-- Info del Médico -->
                                            <div class="col-md-4">
                                                <div class="text-center">
                                                    <img src="{{ asset('images/default-doctor.png') }}" alt="Doctor" class="rounded-circle"
                                                        width="80">
                                                    <h5 class="mt-2">Dr. Gabriel Enrique Figueroa Benavides</h5>
                                                    <p>Cima Salud - Gran Avenida 4564</p>
                                                </div>
                            
                                                <!-- Calendario -->
                                                <div id="calendar-container">
                                                    <div class="calendar-header">
                                                        <button id="prevMonth">«</button>
                                                        <span id="monthYear"></span>
                                                        <button id="nextMonth">»</button>
                                                    </div>
                                                    <div id="calendar"></div>
                                                </div>
                                            </div>
                            
                                            <!-- Tabla de Horarios -->
                                            <div class="col-md-8">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>Fecha</th>
                                                            <th>Hora</th>
                                                            <th>Duración</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="horarios">
                                                        <tr>
                                                            <td colspan="4" class="text-center">Seleccione un día para ver horarios.</td>
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
        const sucursalSelect = document.getElementById('sucursal');
        const especialidadSelect = document.getElementById('especialidad');
        const medicoSelect = document.getElementById('medico');

        const stepperElement = document.querySelector('.bs-stepper');
        const stepper = new Stepper(stepperElement);

        sucursalSelect.addEventListener('change', cargarHorarios);
        especialidadSelect.addEventListener('change', cargarHorarios);
        medicoSelect.addEventListener('change', cargarHorarios);


        function cargarHorarios() {
            const sucursalId = sucursalSelect.value;
            const especialidadId = especialidadSelect.value;
            const medicoId = medicoSelect.value;

            if (sucursalId && especialidadId && medicoId) {
                Promise.all([
                        axios.post('{{ route('horarios.disponibles') }}', {
                            sucursal_id: sucursalId,
                            especialidad_id: especialidadId,
                            medico_id: medicoId,
                            _token: '{{ csrf_token() }}'
                        }),
                        axios.get(`{{ url('medicos') }}/${medicoId}/bloqueos`) // Obtener bloqueos
                    ])
                    .then(([horariosResponse, bloqueoResponse]) => {
                        const horarios = horariosResponse.data.horarios || [];
                        horariosBloqueados = bloqueoResponse.data.bloqueos ||
                    []; // Guardar bloqueos en variable global

                        console.log("Horarios Disponibles:", horarios);
                        console.log("Horarios Bloqueados:", horariosBloqueados);

                        if (horarios.length > 0) {
                            const horariosDisponibles = horarios.filter(horario => {
                                return !horariosBloqueados.some(bloqueo =>
                                    bloqueo.dia_semana === horario.dia_semana
                                );
                            });

                            if (horariosDisponibles.length > 0) {
                                generarPestañasHorarios(horariosDisponibles);
                            } else {
                                alert("No hay horarios disponibles después del bloqueo.");
                            }
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
            const prevDayButton = document.getElementById('prevDay');
            const nextDayButton = document.getElementById('nextDay');

            horariosTabs.innerHTML = ''; // Limpiar pestañas
            horariosTabContent.innerHTML = ''; // Limpiar contenido

            const diasDisponibles = {};
            const semanasExtra = 2; // Puedes ajustar esto para mostrar más semanas

            // Agrupar horarios por día, incluyendo semanas adicionales
            horarios.forEach(horario => {
                for (let i = 0; i <= semanasExtra; i++) {
                    const fechaCompleta = obtenerProximoDia(horario.dia_semana, i);
                    if (!diasDisponibles[fechaCompleta]) {
                        diasDisponibles[fechaCompleta] = [];
                    }
                    diasDisponibles[fechaCompleta].push(horario);
                }
            });

            // Ordenar las fechas en orden cronológico
            const fechasOrdenadas = Object.keys(diasDisponibles).sort((a, b) => {
                const fechaA = new Date(a.split(' ')[1].split('/').reverse().join('-'));
                const fechaB = new Date(b.split(' ')[1].split('/').reverse().join('-'));
                return fechaA - fechaB;
            });

            let currentStartIndex = 0;
            const daysToShow = 6; // Number of days to show at once

            function updateTabs() {
                // Clear current tabs and content
                horariosTabs.innerHTML = '';
                horariosTabContent.innerHTML = '';

                // Add new tabs and content based on currentStartIndex
                for (let i = currentStartIndex; i < currentStartIndex + daysToShow && i < fechasOrdenadas
                    .length; i++) {
                    const dia = fechasOrdenadas[i];

                    // Crear pestaña
                    const tabItem = document.createElement('li');
                    tabItem.className = 'nav-item';
                    tabItem.innerHTML = `
                        <button class="nav-link ${i === currentStartIndex ? 'active' : ''}" id="tab-${i}"
                            data-bs-toggle="tab" data-bs-target="#content-${i}" type="button" role="tab">
                            ${dia}
                        </button>
                    `;
                    horariosTabs.appendChild(tabItem);

                    // Crear contenido de pestaña
                    const tabContent = document.createElement('div');
                    tabContent.className = `tab-pane fade ${i === currentStartIndex ? 'show active' : ''}`;
                    tabContent.id = `content-${i}`;
                    tabContent.innerHTML = generarBotonesHorarios(diasDisponibles[dia]);
                    horariosTabContent.appendChild(tabContent);

                    // Asociar eventos click a los botones generados
                    const intervalos = diasDisponibles[dia].flatMap(horario =>
                        generarIntervalos(horario.hora_inicio, horario.hora_termino, horario
                            .descanso_inicio, horario.descanso_termino)
                    );
                    intervalos.forEach(intervalo => {
                        const buttonId = `btn-${intervalo.replace(/[:\s]/g, '-')}`;
                        document.getElementById(buttonId).addEventListener('click', () =>
                            seleccionarHorario(intervalo));
                    });
                }
            }

            prevDayButton.addEventListener('click', function() {
                if (currentStartIndex > 0) {
                    currentStartIndex -= daysToShow;
                    updateTabs();
                }
            });

            nextDayButton.addEventListener('click', function() {
                if (currentStartIndex + daysToShow < fechasOrdenadas.length) {
                    currentStartIndex += daysToShow;
                    updateTabs();
                }
            });

            // Initialize tabs
            updateTabs();
        }

        let horariosBloqueados = []; // Define as global variable

        function generarBotonesHorarios(horarios) {
            let botonesHTML = '<div class="d-flex flex-wrap gap-2">';

            horarios.forEach(horario => {
                const intervalos = generarIntervalos(horario.hora_inicio, horario.hora_termino, horario
                    .descanso_inicio, horario.descanso_termino);

                intervalos.forEach(intervalo => {
                    const [inicio, fin] = intervalo.split(' - ');

                    // Verificar si el intervalo está bloqueado
                    const bloqueado = horariosBloqueados.some(bloqueo =>
                        bloqueo.fecha === horario.fecha &&
                        // Comparar fecha en lugar de dia_semana
                        bloqueo.hora_inicio === inicio &&
                        bloqueo.hora_termino === fin
                    );

                    console.log(`Intervalo: ${intervalo} - Bloqueado: ${bloqueado}`);

                    if (!bloqueado) {
                        const buttonId = `btn-${intervalo.replace(/[:\s]/g, '-')}`;
                        botonesHTML += `
                            <button id="${buttonId}" class="btn btn-primary btn-sm">
                                ${intervalo}
                            </button>
                        `;
                    }
                });
            });

            botonesHTML += '</div>';
            return botonesHTML;
        }




        let horarioSeleccionado;

        function seleccionarHorario(horario) {
            horarioSeleccionado = horario;
            console.log("Horario seleccionado:", horario);

            // Actualizar resumen de reserva
            document.getElementById('resumenSucursal').textContent = sucursalSelect.options[sucursalSelect
                .selectedIndex].text;
            document.getElementById('resumenEspecialidad').textContent = especialidadSelect.options[
                especialidadSelect.selectedIndex].text;
            document.getElementById('resumenMedico').textContent = medicoSelect.options[medicoSelect
                .selectedIndex].text;
            document.getElementById('resumenHorario').textContent = horario;

            stepper.next(); // Avanza al siguiente paso
        }

        function obtenerProximoDia(diaSemana, semanasExtra = 0) {
            const dias = ["domingo", "lunes", "martes", "miércoles", "jueves", "viernes", "sábado"];
            const hoy = new Date();
            const diaActual = hoy.getDay();
            const indiceDia = dias.indexOf(diaSemana.toLowerCase());

            let diferencia = indiceDia - diaActual;
            if (diferencia <= 0) {
                diferencia += 7;
            }

            hoy.setDate(hoy.getDate() + diferencia + (semanasExtra * 7));

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
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
