@component('layouts/sections/navbar/navbar-agenda')
@endcomponent
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
<!-- Materialize Icons -->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<style>
    .day-box {
        padding: 10px;
        text-align: center;
        border: 1px solid #ccc;
        border-radius: 5px;
        margin: 5px;
    }

    .day-box:hover {
        background-color: #f0f0f0;
    }
</style>
@component('content')
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .step-header {
            display: flex;
            justify-content: space-around;
            margin-bottom: 30px;
        }

        .step {
            text-align: center;
        }

        .step.active {
            color: #007bff;
            font-weight: bold;
        }
    </style>

    <body>
        <div class="container">
            <h4 class="center">Próximos 28 días</h4>
            <p class="center">Haz clic en una fecha para ver el detalle</p>
            <div id="weeksContainer"></div>
            <div class="row center">
                <h5 id="selectedDate">Selecciona un día para más detalles</h5>
            </div>
        </div>
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <div class="container mt-5">
            <h2>Buscar Cita</h2>
            <form id="form-reserva">
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
                    <label for="medico">Medico</label>
                    <select id="medico" name="medico_id" class="form-control" required>
                        <option value="">Seleccione un médico</option>
                        @foreach ($medicos as $medico)
                            <option value="{{ $medico->id }}">{{ $medico->nombre }}</option>
                        @endforeach
                    </select>
                </div>
            </form>

            <!-- Botón para abrir el modal manualmente si es necesario -->
            <button id="abrirModal" type="button" class="btn btn-info d-none" data-bs-toggle="modal"
                data-bs-target="#modalHorarios">
                Ver Horarios Disponibles
            </button>
        </div>

        <!-- Modal para mostrar los horarios -->
        <div class="modal fade" id="modalHorarios" tabindex="-1" aria-labelledby="modalHorariosLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="horariosModalLabel">Horarios Disponibles</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="horariosContainer">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
        <script>
            const sucursalSelect = document.getElementById('sucursal');
            const especialidadSelect = document.getElementById('especialidad');
            const medicoSelect = document.getElementById('medico');
            const modalHorarios = new bootstrap.Modal(document.getElementById('modalHorarios'));

            // Listeners para los selects
            sucursalSelect.addEventListener('change', cargarHorarios);
            console.log('2');
            especialidadSelect.addEventListener('change', cargarHorarios);
            medicoSelect.addEventListener('change', cargarHorarios);

            function cargarHorarios() {
                const sucursalId = document.getElementById('sucursal').value;
                const especialidadId = document.getElementById('especialidad').value;
                const medicoId = document.getElementById('medico').value;

                console.log("Sucursal ID:", sucursalId);
                console.log("Especialidad ID:", especialidadId);
                console.log("Medico ID:", medicoId);

                if (sucursalId && especialidadId && medicoId) {
                    axios.post('{{ route('horarios.disponibles') }}', {
                            sucursal_id: sucursalId,
                            especialidad_id: especialidadId,
                            medico_id: medicoId,
                            _token: '{{ csrf_token() }}'
                        })
                        .then(response => {
                            console.log("Horarios disponibles:", response.data.horarios);
                            // Aquí puedes actualizar el modal con los horarios
                            const horarios = response.data.horarios;
                            const horariosContainer = document.getElementById('horariosContainer');

                            if (horarios && horarios.length > 0) {
                                // Limpiar contenido previo
                                horariosContainer.innerHTML = '';

                                // Crear una lista de horarios
                                const list = document.createElement('ul');
                                list.className = 'list-group';

                                horarios.forEach(horario => {
                                    const listItem = document.createElement('li');
                                    listItem.className = 'list-group-item';

                                    const intervalos = generarIntervalos(horario.hora_inicio, horario.hora_termino,
                                        horario.descanso_inicio, horario.descanso_termino);
                                    const intervalosText = intervalos.map(i => `<div>${i}</div>`).join('');

                                    listItem.innerHTML = `<strong>${obtenerProximoDia(horario.dia_semana)}</strong> -
            <strong>${horario.sucursal}</strong> - ${horario.medico.nombre}
            <div class="mt-2">
                ${intervalosText}
            </div>
        `;

                                    list.appendChild(listItem);
                                });

                                horariosContainer.appendChild(list);
                            } else {
                                // Si no hay horarios disponibles
                                horariosContainer.innerHTML = '<p>No hay horarios disponibles.</p>';
                            }

                            // Mostrar el modal
                            // const horariosModal = new bootstrap.Modal(document.getElementById('horariosModal'));
                            modalHorarios.show();
                        })
                        .catch(error => {
                            console.error("Error:", error);

                        })
                        .catch(error => {
                            if (error.response) {
                                console.error("Error al cargar los horarios (response):", error.response.data);
                            } else if (error.request) {
                                console.error("Error al cargar los horarios (request):", error.request);
                            } else {
                                console.error("Error al cargar los horarios (message):", error.message);
                            }
                        });
                } else {
                    console.error("Faltan datos para cargar los horarios");
                }
            }

            function obtenerProximoDia(diaBuscado) {
                const diasSemana = [
                    "domingo", "lunes", "martes", "miércoles", "jueves", "viernes", "sábado"
                ];

                // Convertir el día buscado a minúsculas para evitar problemas de mayúsculas/minúsculas
                diaBuscado = diaBuscado.toLowerCase();

                // Validar que el día buscado exista
                if (!diasSemana.includes(diaBuscado)) {
                    return "Día inválido";
                }

                // Obtener el índice del día buscado
                const indiceDiaBuscado = diasSemana.indexOf(diaBuscado);

                // Fecha actual
                const hoy = new Date();

                // Índice del día actual
                const indiceHoy = hoy.getDay();

                // Calcular los días restantes hasta el día buscado
                const diasRestantes =
                    (indiceDiaBuscado - indiceHoy + 7) % 7 || 7; // Asegura que siempre sea el siguiente día

                // Calcular la fecha del próximo día
                const proximaFecha = new Date();
                proximaFecha.setDate(hoy.getDate() + diasRestantes);

                // Formatear la fecha
                const meses = [
                    "enero", "febrero", "marzo", "abril", "mayo", "junio",
                    "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre"
                ];

                const diaSemana = diasSemana[proximaFecha.getDay()];
                const dia = proximaFecha.getDate();
                const mes = meses[proximaFecha.getMonth()];
                const anio = proximaFecha.getFullYear();

                return `Próximo ${diaSemana} ${dia} de ${mes} del ${anio}`;
            }

            // Ejemplo de uso
            console.log(obtenerProximoDia("lunes")); // "Próximo lunes 20 de enero del 2025" (si hoy fuera 13 de enero de 2025)
            console.log(obtenerProximoDia("viernes")); // "Próximo viernes 17 de enero del 2025"

            function formatearFechaChile(fechaStr) {
                const fecha = new Date(`${fechaStr}T00:00:00-03:00`); // Chile Continental en horario estándar UTC-3

                // Verificar que la fecha sea válida
                if (isNaN(fecha.getTime())) {
                    return "Fecha inválida";
                }

                const formato = new Intl.DateTimeFormat('es-CL', {
                    weekday: 'long',
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric',
                    timeZone: 'America/Santiago', // Asegura el huso horario de Chile
                });

                return formato.format(fecha);
            }

            function generarIntervalos(horaInicio, horaTermino, descansoInicio, descansoTermino) {
                const intervalos = [];
                const [startHour, startMinutes] = horaInicio.split(':').map(Number);
                const [endHour, endMinutes] = horaTermino.split(':').map(Number);

                const [breakStartHour, breakStartMinutes] = descansoInicio ? descansoInicio.split(':').map(Number) : [null,
                    null
                ];
                const [breakEndHour, breakEndMinutes] = descansoTermino ? descansoTermino.split(':').map(Number) : [null, null];

                let currentHour = startHour;
                let currentMinutes = startMinutes;

                while (currentHour < endHour || (currentHour === endHour && currentMinutes < endMinutes)) {
                    const nextMinutes = (currentMinutes + 30) % 60;
                    const nextHour = currentMinutes + 30 >= 60 ? currentHour + 1 : currentHour;

                    // Validar si el intervalo está dentro del rango del descanso
                    const isInBreak =
                        breakStartHour !== null &&
                        breakEndHour !== null &&
                        (
                            (currentHour > breakStartHour || (currentHour === breakStartHour && currentMinutes >=
                                breakStartMinutes)) &&
                            (currentHour < breakEndHour || (currentHour === breakEndHour && currentMinutes < breakEndMinutes))
                        );

                    if (!isInBreak) {
                        intervalos.push(
                            `${String(currentHour).padStart(2, '0')}:${String(currentMinutes).padStart(2, '0')} - ${String(nextHour).padStart(2, '0')}:${String(nextMinutes).padStart(2, '0')}`
                        );
                    }

                    currentHour = nextHour;
                    currentMinutes = nextMinutes;
                }

                return intervalos;
            }


            function mostrarHorarios(horarios) {
                const listaHorarios = document.getElementById('lista-horarios');
                listaHorarios.innerHTML = ''; // Limpiar lista antes de agregar nuevos datos

                if (horarios.length > 0) {
                    horarios.forEach(horario => {
                        const listItem = document.createElement('li');
                        listItem.classList.add('list-group-item');
                        listItem.textContent = `Fecha: ${horario.fecha} - Hora: ${horario.hora}`;
                        listaHorarios.appendChild(listItem);
                    });
                } else {
                    const listItem = document.createElement('li');
                    listItem.classList.add('list-group-item', 'text-danger');
                    listItem.textContent = 'No hay horarios disponibles.';
                    listaHorarios.appendChild(listItem);
                }

                modalHorarios.show(); // Mostrar el modal automáticamente
            }
        </script>


        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const diasSemana = ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"];
                const meses = [
                    "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
                    "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
                ];
                const weeksContainer = document.getElementById("weeksContainer");
                const selectedDate = document.getElementById("selectedDate");

                // Generar los próximos 28 días
                function generarFechas() {
                    const hoy = new Date();
                    let dias = [];

                    // Generar fechas desde hoy hasta 28 días después
                    for (let i = 0; i < 28; i++) {
                        const nuevaFecha = new Date(hoy);
                        nuevaFecha.setDate(hoy.getDate() + i);
                        dias.push(nuevaFecha);
                    }

                    // Dividir las fechas en semanas (grupos de 7 días)
                    const semanas = [];
                    for (let i = 0; i < dias.length; i += 7) {
                        semanas.push(dias.slice(i, i + 7));
                    }

                    return semanas;
                }

                // Renderizar las semanas en el contenedor
                function renderizarSemanas(semanas) {
                    weeksContainer.innerHTML = "";
                    semanas.forEach((semana, index) => {
                        const weekRow = document.createElement("div");
                        weekRow.className = "row";

                        semana.forEach((fecha) => {
                            const dayBox = document.createElement("div");
                            dayBox.className = "col s12 m2 day-box";

                            const diaSemana = diasSemana[fecha.getDay()];
                            const dia = fecha.getDate();
                            const mes = meses[fecha.getMonth()];
                            const anio = fecha.getFullYear();

                            dayBox.innerHTML = `
                              <strong>${diaSemana}</strong><br>
                              ${dia} de ${mes} ${anio}
                          `;

                            // Evento al hacer clic
                            dayBox.addEventListener("click", () => {
                                selectedDate.innerText =
                                    `Seleccionaste: ${diaSemana}, ${dia} de ${mes} del ${anio}`;
                            });

                            weekRow.appendChild(dayBox);
                        });

                        weeksContainer.appendChild(weekRow);
                    });
                }

                // Inicializar
                const semanas = generarFechas();
                renderizarSemanas(semanas);
            });
        </script>
