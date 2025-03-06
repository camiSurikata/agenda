
@extends('layouts/layoutMaster')


@section('title', 'Fullcalendar - Apps')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('/assets/vendor/libs/fullcalendar/fullcalendar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/editor.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css') }}" />
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/app-calendar.css') }}" />
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/fullcalendar/fullcalendar.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/app-calendar-events.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/app-calendar.js') }}"></script> --}}
@endsection

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="card app-calendar-wrapper">
        <div class="row g-0">
            <!-- Calendar Sidebar -->
            <div class="col app-calendar-sidebar border-end" id="app-calendar-sidebar">
                <div class="p-3 pb-2 my-sm-0 mb-3">
                    <div class="d-grid">
                        <button class="btn btn-primary btn-toggle-modal" data-bs-toggle="modal"
                            data-bs-target="#addEventModal" aria-controls="addEventModal">
                            <i class="mdi mdi-plus me-1"></i>
                            <span class="align-middle">Añadir Cita</span>
                        </button>
                    </div>
                </div>
                <div class="p-4">
                    <!-- inline calendar (flatpicker) -->
                    {{-- <div class="inline-calendar"></div> --}}
                    <div class="mt-3 text-center">
                        <strong>Fecha y Hora Actual:</strong>
                        <div id="currentDateTime" class="text-primary"></div>
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            // Función para obtener la hora local de Chile
                            function updateDateTime() {
                                // Crear una nueva fecha con la zona horaria de Chile
                                const chileTime = new Date().toLocaleString('es-CL', {
                                    timeZone: 'America/Santiago',
                                    weekday: 'long',
                                    year: 'numeric',
                                    month: 'long',
                                    day: 'numeric',
                                    hour: '2-digit',
                                    minute: '2-digit',
                                    second: '2-digit',
                                });

                                // Mostrar la fecha y hora en el contenedor
                                document.getElementById('currentDateTime').innerText = chileTime;
                            }

                            // Actualizar la fecha y hora cada segundo
                            setInterval(updateDateTime, 1000);

                            // Llamar la función inicialmente
                            updateDateTime();
                        });
                    </script>

                    <hr class="container-m-nx my-4">

                    <!-- Filter -->
                    <div class="mb-4">
                        <small class="text-small text-muted text-uppercase align-middle">Filtrar por medico</small>
                    </div>

                    <div class="form-floating form-floating-outline mb-4 select2-primary">
                        <select class="select2 select-medicos form-select" id="filtroMedico" name="filtroMedico">
                            @foreach ($medicos as $medico)
                                <option value="{{ $medico->id }}"
                                    {{ isset($cita) && $medico->id == $citas->medico_id ? 'selected' : '' }}>
                                    {{ $medico->nombre }}
                                </option>
                            @endforeach
                        </select>
                        <label for="medicosSelect">Seleccione Médico</label>
                    </div>

                    <div class="mb-4">
                        <small class="text-small text-muted text-uppercase align-middle">Estado de la cita</small>
                    </div>    

                    <div class="form-check form-check-secondary mb-3">
                        <input class="form-check-input select-all" type="checkbox" id="selectAll" data-value="all" checked>
                        <label class="form-check-label" for="selectAll">Ver Todas</label>
                    </div>
                    
                    <div class="app-calendar-events-filter">
                        <div class="form-check form-check-danger mb-3">
                            <input class="form-check-input input-filter" type="checkbox" id="select-atendiendose"
                                data-value="atendiendose" checked>
                            <label class="form-check-label" for="select-atendiendose">Atendiendose</label>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input input-filter" type="checkbox" id="select-atendido"
                                data-value="atendido" checked>
                            <label class="form-check-label" for="select-atendido">Atendido</label>
                        </div>
                        <div class="form-check form-check-warning mb-3">
                            <input class="form-check-input input-filter" type="checkbox" id="select-noasiste"
                                data-value="noasiste" checked>
                            <label class="form-check-label" for="select-noasiste">No Asiste</label>
                        </div>
                        <div class="form-check form-check-success mb-3">
                            <input class="form-check-input input-filter" type="checkbox" id="select-Confirmado"
                                data-value="confirmado" checked>
                            <label class="form-check-label" for="select-Confirmado">Confirmado</label>
                        </div>
                        <div class="form-check form-check-info">
                            <input class="form-check-input input-filter" type="checkbox" id="select-Espera"
                                data-value="espera" checked>
                            <label class="form-check-label" for="select-Espera">Espera</label>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Calendar Sidebar -->

            <!-- Calendar & Modal -->
            <div class="col app-calendar-content">
                <div class="card shadow-none border-0 ">
                    <div class="card-body pb-0">
                        <!-- FullCalendar -->
                        <div id="calendar"></div>
                    </div>
                </div>
                <div class="app-overlay"></div>
                <!-- FullCalendar Modal -->
                <div class="modal fade" id="addEventModal" tabindex="-1" aria-labelledby="addEventModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header border-bottom">
                                <h5 class="modal-title" id="addEventModalLabel">Add Event</h5>
                                <button type="button" class="btn-close text-reset" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form class="event-form pt-0" id="eventForm" onsubmit="return false">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <input type="text" class="form-control" id="eventTitle" name="eventTitle"
                                            placeholder="Event Title" />
                                        <label for="eventTitle">Title</label>
                                    </div>
                                    <div class="form-floating form-floating-outline mb-4">
                                        <select class="select2 select-event-label form-select" id="eventLabel" name="eventLabel">
                                            <option data-label="primary" value="Atendido" selected>Atendido</option>
                                            <option data-label="danger" value="Atendiendose">Atendiendose</option>
                                            <option data-label="warning" value="Noasiste">No Asiste</option>
                                            <option data-label="success" value="Confirmado">Confirmado</option>
                                            <option data-label="info" value="Espera">Espera</option>
                                        </select>
                                        <label for="eventLabel">Label</label>
                                    </div>
                                    <div class="form-floating form-floating-outline mb-4">
                                        <input type="text" class="form-control" id="eventStartDate" name="eventStartDate"
                                            placeholder="Start Date" />
                                        <label for="eventStartDate">Start Date</label>
                                    </div>
                                    <div class="form-floating form-floating-outline mb-4">
                                        <input type="text" class="form-control" id="eventEndDate" name="eventEndDate"
                                            placeholder="End Date" />
                                        <label for="eventEndDate">End Date</label>
                                    </div>
                                    <div class="form-floating form-floating-outline mb-4 select2-primary">
                                        <select class="select2 select-sucursal form-select" id="eventSucursal" name="eventSucursal">
                                            @foreach ($sucursales as $sucursal)
                                                <option value="{{ $sucursal->id }}"
                                                    {{ isset($cita) && $sucursal->id == $citas->id ? 'selected' : '' }}>
                                                    {{ $sucursal->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <label for="sucursalSelect">Seleccione Sucursal</label>
                                    </div>
                                    <div class="form-floating form-floating-outline mb-4 select2-primary">
                                        <select class="select2 select-medicos form-select" id="eventMedico" name="eventMedico">
                                            @foreach ($medicos as $medico)
                                                <option value="{{ $medico->id }}"
                                                    {{ isset($cita) && $medico->id == $citas->medico_id ? 'selected' : '' }}>
                                                    {{ $medico->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <label for="medicosSelect">Seleccione Médico</label>
                                    </div>
                                    <div class="form-floating form-floating-outline mb-4 select2-primary">
                                        <select class="select2 select-especialidad form-select" id="eventEspecialidad" name="eventEspecialidad">
                                            @foreach ($especialidades as $especialidad)
                                                <option value="{{ $especialidad->id }}"
                                                    {{ isset($cita) && $especialidad->id == $citas->especialidad_id ? 'selected' : '' }}>
                                                    {{ $especialidad->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <label for="especialidadSelect">Seleccione Especialidad</label>
                                    </div>
                                    <div class="form-floating form-floating-outline mb-4 select2-primary">
                                        <select class="select2 select-pacientes form-select" id="eventPaciente"
                                            name="eventPaciente">
                                            @foreach ($pacientes as $paciente)
                                                <option value="{{ $paciente->idpaciente }}"
                                                    {{ isset($cita) && $paciente->idpaciente == $citas->paciente_id ? 'selected' : '' }}>
                                                    {{ $paciente->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <label for="pacientesSelect">Seleccione Paciente</label>
                                    </div>
                                    <div class="form-floating form-floating-outline mb-4 select2-primary">
                                        <select class="select2 select-boxes form-select" id="eventBox" name="eventBox">
                                            @foreach ($boxes as $box)
                                                <option value="{{ $box->id }}"
                                                    {{ isset($cita) && $box->id == $citas->box_id ? 'selected' : '' }}>
                                                    {{ $box->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <label for="boxesSelect">Seleccione Box</label>
                                    </div>
                                    <div class="form-floating form-floating-outline mb-4">
                                        <textarea class="form-control" name="eventDescription" id="eventDescription"></textarea>
                                        <label for="eventDescription">Description</label>
                                    </div>
                                    <div class="form-floating form-floating-outline mb-4">
                                        <textarea class="form-control" name="eventComentario" id="eventComentario"></textarea>
                                        <label for="eventComentario">Comentario</label>
                                    </div>
                                    <div class="form-floating form-floating-outline mb-4">
                                        <textarea class="form-control" name="eventMotivo" id="eventMotivo"></textarea>
                                        <label for="eventMotivo">Motivo</label>
                                    </div>
                                    <div class="mb-3 d-flex justify-content-sm-between justify-content-start my-4 gap-2">
                                        <div class="d-flex">
                                            <button type="submit" class="btn btn-primary btn-add-event me-sm-2 me-1" onclick="confirmarReserva()">Add</button>
                                            <button type="reset" class="btn btn-outline-secondary btn-cancel me-sm-0 me-1"
                                                data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                        <button class="btn btn-outline-danger btn-delete-event d-none" onclick="confirmarReserva()">Delete</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Calendar & Modal -->
        </div>
    </div>
@endsection

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        (function() {
            const estadosCita = {
                1: 'Atendido',
                2: 'Atendiendose',
                3: 'Noasiste',
                4: 'Confirmado', // Si existe este estado adicional
                5: 'Espera' // Agrega otros estados si son necesarios
            };

            const calendarEl = document.getElementById('calendar'),
                appCalendarSidebar = document.querySelector('.app-calendar-sidebar'),
                addEventModal = document.getElementById('addEventModal'),
                appOverlay = document.querySelector('.app-overlay'),
                calendarsColor = {
                    Atendido: 'primary',
                    Atendiendose: 'danger',
                    Noasiste: 'warning',
                    Confirmado: 'success',
                    Espera: 'info'
                },
                modalTitle = document.querySelector('.modal-title'),
                btnToggleModal = document.querySelector('.btn-toggle-modal'),
                btnSubmit = document.querySelector('button[type="submit"]'),
                btnDeleteEvent = document.querySelector('.btn-delete-event'),
                btnCancel = document.querySelector('.btn-cancel'),
                eventTitle = document.querySelector('#eventTitle'),
                eventStartDate = document.querySelector('#eventStartDate'),
                eventEndDate = document.querySelector('#eventEndDate'),
                eventUrl = document.querySelector('#eventURL'),
                eventLabel = $('#eventLabel'), // ! Using jquery vars due to select2 jQuery dependency
                eventGuests = $('#eventGuests'), // ! Using jquery vars due to select2 jQuery dependency
                eventLocation = document.querySelector('#eventLocation'),
                eventDescription = document.querySelector('#eventDescription'),
                eventMedico = document.querySelector('#eventMedico'),
                eventPaciente = document.querySelector('#eventPaciente'),
                eventBox = document.querySelector('#eventBox'),
                eventSucursal = document.querySelector('#eventSucursal'),
                eventEspecialidad = document.querySelector('#eventEspecialidad'),
                eventComentario = document.querySelector('#eventComentario'),
                eventMotivo = document.querySelector('#eventMotivo'),


                // allDaySwitch = document.querySelector('.allDay-switch'),
                selectAll = document.querySelector('.select-all'),
                filterInput = [].slice.call(document.querySelectorAll('.input-filter')),
                inlineCalendar = document.querySelector('.inline-calendar');
            
            // Variable para almacenar el número del estado
            let eventLabelValue = null;

            // Función para obtener la clave del estado según el valor
            function obtenerClaveEstado(valor) {
                return Object.keys(estadosCita).find(key => estadosCita[key] === valor);
            }

            // Obtener el valor inicial del evento (si ya está seleccionado un valor)
            eventLabelValue = obtenerClaveEstado(eventLabel.val());
            console.log("Valor inicial de eventLabel:", eventLabelValue);

            // Evento cuando cambia el select para capturar el valor
            eventLabel.on("change", function() {
                eventLabelValue = obtenerClaveEstado(this.value); // Guarda el número en la variable
                console.log("Número guardado en eventLabel:", eventLabelValue);
            });

            let eventToUpdate,
                currentEvents =
                events, // Assign app-calendar-events.js file events (assume events from API) to currentEvents (browser store/object) to manage and update calender events
                isFormValid = false,
                inlineCalInstance;

            // Init event Modal
            const bsAddEventModal = new bootstrap.Modal(addEventModal);

            //! TODO: Update Event label and guest code to JS once select removes jQuery dependency
            // Event Label (select2)
            if (eventLabel.length) {
                function renderBadges(option) {
                    if (!option.id) {
                        return option.text;
                    }
                    var $badge =
                        "<span class='badge badge-dot bg-" + $(option.element).data('label') + " me-2'> " +
                        '</span>' + option.text;

                    return $badge;
                }
                select2Focus(eventLabel);
                eventLabel.wrap('<div class="position-relative"></div>').select2({
                    placeholder: 'Select value',
                    dropdownParent: eventLabel.parent(),
                    templateResult: renderBadges,
                    templateSelection: renderBadges,
                    minimumResultsForSearch: -1,
                    escapeMarkup: function(es) {
                        return es;
                    }
                });
            }

            // Event Guests (select2)
            if (eventGuests.length) {
                function renderGuestAvatar(option) {
                    if (!option.id) {
                        return option.text;
                    }
                    var $avatar =
                        "<div class='d-flex flex-wrap align-items-center'>" +
                        "<div class='avatar avatar-xs me-2'>" +
                        "<img src='" +
                        assetsPath +
                        'img/avatars/' +
                        $(option.element).data('avatar') +
                        "' alt='avatar' class='rounded-circle' />" +
                        '</div>' +
                        option.text +
                        '</div>';

                    return $avatar;
                }
                select2Focus(eventGuests);
                eventGuests.wrap('<div class="position-relative"></div>').select2({
                    placeholder: 'Select value',
                    dropdownParent: eventGuests.parent(),
                    closeOnSelect: false,
                    templateResult: renderGuestAvatar,
                    templateSelection: renderGuestAvatar,
                    escapeMarkup: function(es) {
                        return es;
                    }
                });
            }

            // Event start (flatpicker)
            if (eventStartDate) {
                var start = eventStartDate.flatpickr({
                    enableTime: true,
                    altFormat: 'Y-m-dTH:i:S',
                    minDate: "today",
                    onReady: function(selectedDates, dateStr, instance) {
                        if (instance.isMobile) {
                            instance.mobileInput.setAttribute('step', null);
                        }
                    }
                });
            }

            // Event end (flatpicker)
            if (eventEndDate) {
                var end = eventEndDate.flatpickr({
                    enableTime: true,
                    altFormat: 'Y-m-dTH:i:S',
                    minDate: "today",
                    onReady: function(selectedDates, dateStr, instance) {
                        if (instance.isMobile) {
                            instance.mobileInput.setAttribute('step', null);
                        }
                    }
                });
            }

            // Inline sidebar calendar (flatpicker)
            if (inlineCalendar) {
                inlineCalInstance = inlineCalendar.flatpickr({
                    monthSelectorType: 'static',
                    inline: true
                });
            }

            let isEditMode = false;

            // Event click function
            function eventClick(info) {
                eventToUpdate = info.event;
                isEditMode = true;
                if (eventToUpdate.url) {
                    info.jsEvent.preventDefault();
                    window.open(eventToUpdate.url, '_blank');
                }
                bsAddEventModal.show();
                // For update event set modal title text: Update Event
                if (modalTitle) {
                    modalTitle.innerHTML = 'Update Event';
                }
                btnSubmit.innerHTML = 'Update';
                btnSubmit.classList.add('btn-update-event');
                btnSubmit.classList.remove('btn-add-event');
                btnDeleteEvent.classList.remove('d-none');

                eventTitle.value = eventToUpdate.title;
                start.setDate(eventToUpdate.start, true, 'Y-m-d');
                // eventToUpdate.allDay === true ? (allDaySwitch.checked = true) : (allDaySwitch.checked =
                //     false);
                eventToUpdate.end !== null ?
                    end.setDate(eventToUpdate.end, true, 'Y-m-d') :
                    end.setDate(eventToUpdate.start, true, 'Y-m-d');
                eventLabel.val(eventToUpdate.extendedProps.calendar).trigger('change');
                eventToUpdate.extendedProps.location !== undefined ?
                    (eventLocation.value = eventToUpdate.extendedProps.location) :
                    null;
                eventToUpdate.extendedProps.guests !== undefined ?
                    eventGuests.val(eventToUpdate.extendedProps.guests).trigger('change') :
                    null;
                eventToUpdate.extendedProps.description !== undefined ?
                    (eventDescription.value = eventToUpdate.extendedProps.description) :
                    null;
                eventToUpdate.extendedProps.medico !== undefined ?
                    (eventMedico.value = eventToUpdate.extendedProps.medico) :
                    null;
                eventToUpdate.extendedProps.paciente !== undefined ?
                    (eventPaciente.value = eventToUpdate.extendedProps.paciente) :
                    null;
                eventToUpdate.extendedProps.box !== undefined ?
                    (eventBox.value = eventToUpdate.extendedProps.box) :
                    null;
                eventToUpdate.extendedProps.sucursal !== undefined ?
                    (eventSucursal.value = eventToUpdate.extendedProps.sucursal) :
                    null;
                eventToUpdate.extendedProps.especialidad !== undefined ?
                    (eventEspecialidad.value = eventToUpdate.extendedProps.especialidad) :
                    null;
                eventToUpdate.extendedProps.comentarios !== undefined ?
                    (eventComentario.value = eventToUpdate.extendedProps.comentarios) :
                    null;
                eventToUpdate.extendedProps.motivo !== undefined ?
                    (eventMotivo.value = eventToUpdate.extendedProps.motivo) :
                    null;

                // // Call removeEvent function
                // btnDeleteEvent.addEventListener('click', e => {
                //   removeEvent(parseInt(eventToUpdate.id));
                //   // eventToUpdate.remove();
                //   bsAddEventModal.hide();
                // });
            }

            // Modify modal toggler
            function modifyToggler() {
                const fcSidebarToggleButton = document.querySelector('.fc-sidebarToggle-button');
                fcSidebarToggleButton.classList.remove('fc-button-primary');
                fcSidebarToggleButton.classList.add('d-lg-none', 'd-inline-block', 'ps-0');
                while (fcSidebarToggleButton.firstChild) {
                    fcSidebarToggleButton.firstChild.remove();
                }
                fcSidebarToggleButton.setAttribute('data-bs-toggle', 'modal');
                fcSidebarToggleButton.setAttribute('data-overlay', '');
                fcSidebarToggleButton.setAttribute('data-target', '#addEventModal');
                fcSidebarToggleButton.insertAdjacentHTML('beforeend',
                    '<i class="mdi mdi-menu mdi-24px text-body"></i>');
            }

            // Filter events by calender
            function selectedCalendars() {
                let selected = [],
                    filterInputChecked = [].slice.call(document.querySelectorAll('.input-filter:checked'));

                filterInputChecked.forEach(item => {
                    selected.push(item.getAttribute('data-value'));
                });

                return selected;
            }

            // --------------------------------------------------------------------------------------------------
            // AXIOS: fetchEvents
            // * This will be called by fullCalendar to fetch events. Also this can be used to refetch events.
            // --------------------------------------------------------------------------------------------------
            async function fetchEvents(info, successCallback) {
                try {
                    let response = await fetch('/api/citas');
                    if (response.ok) {
                        let data = await response.json();
                        console.log('Data recibida:', data);

                        // Si 'data' es un arreglo, procesamos los eventos directamente
                        let events = data.map(cita => ({
                            id: cita.id,
                            url: '', // Puedes agregar una URL si lo necesitas
                            title: cita
                                .title, // Asumiendo que 'title' existe en los datos de la cita
                            start: cita
                                .start, // Asegúrate de que 'start' esté en el formato adecuado
                            end: cita
                                .end, // Asegúrate de que 'end' esté en el formato adecuado
                            // allDay: false, // Por si no hay valor de allDay
                            description: cita.description,
                            medico: cita.medico_id,
                            paciente: cita.paciente_id,
                            box: cita.box_id,
                            // direction: 1,
                            extendedProps: {
                                calendar: estadosCita[cita
                                    .estado] // Mapea el estado (1) a "Atendido"
                            }
                        }));

                        // Imprime los eventos después de haberlos cargado
                        console.log('Eventos:', events);

                        // Asegúrate de que 'selectedCalendars' devuelva un array con los calendarios seleccionados
                        let calendars = selectedCalendars();

                        // Filtra los eventos de acuerdo con los calendarios seleccionados
                        let selectedEvents = events.filter(event => {
                            return calendars.includes(event.extendedProps.calendar
                                .toLowerCase());
                        });

                        // Llama al callback con los eventos filtrados
                        successCallback(selectedEvents);
                    } else {
                        console.error('Error al cargar las citas');
                    }
                } catch (error) {
                    console.error('Error en la solicitud:', error);
                }
            }

            // Init FullCalendar
            // ------------------------------------------------
            // Obtener los días deshabilitados desde PHP (convertidos a JSON)
            let diasNoAtiende = @json($horarios);

            // Mapear nombres de días a números según FullCalendar
            let diasMap = {
                'Domingo': 0, 'Lunes': 1, 'Martes': 2, 'Miércoles': 3, 
                'Jueves': 4, 'Viernes': 5, 'Sábado': 6
            };
            let diasDeshabilitados = diasNoAtiende.map(dia => diasMap[dia]);

            let calendar = new Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                views: {
                    timeGridWeek: {
                        titleFormat: { year: 'numeric', month: 'short', day: 'numeric' }, // Formato del título
                        slotMinTime: "08:00:00", // Hora mínima (ejemplo: 8 AM)
                        slotMaxTime: "18:00:00", // Hora máxima (ejemplo: 6 PM)
                        slotDuration: "00:30:00", // Intervalos de 30 minutos
                        nowIndicator: true, // Línea indicadora del tiempo actual
                        allDaySlot: false, // Ocultar "Todo el día"
                        eventContent: function(arg) {
                            // Personaliza el contenido del evento
                            let numberLabel = document.createElement('div');
                            numberLabel.innerHTML = `<span class="event-number">${arg.event.extendedProps.number}</span>`;
                            let arrayOfDomNodes = [ numberLabel ];
                            return { domNodes: arrayOfDomNodes };
                        }
                    }
                },   

                events: fetchEvents,
                plugins: [dayGridPlugin, interactionPlugin, listPlugin, timegridPlugin],
                editable: true,
                dragScroll: true,
                dayMaxEvents: 2,
                eventResizableFromStart: true,
                locale: 'es',
                customButtons: {
                    sidebarToggle: {
                        text: 'Sidebar'
                    }
                },
                headerToolbar: {
                    start: 'sidebarToggle, prev,next, title',
                    end: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
                },
                direction: 1,
                initialDate: new Date(),
                navLinks: true,
                validRange: { 
                    start: new Date() // Bloquea días pasados 
                },
                eventClassNames: function({ event: calendarEvent }) {
                    const colorName = calendarsColor[calendarEvent._def.extendedProps.calendar];
                    return ['fc-event-' + colorName];
                },
                dateClick: function(info) {
                    let date = moment(info.date).format('YYYY-MM-DD');
                    // Bloquear selección si es un día en el que el médico NO atiende
                    if (diasDeshabilitados.includes(info.date.getDay())) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Día no disponible',
                            text: 'Este día el médico no atiende.',
                            confirmButtonColor: '#d33'
                        });
                        return;
                    }
                    resetValues();
                    bsAddEventModal.show();
                    if (modalTitle) {
                        modalTitle.innerHTML = 'Add Event';
                    }
                    btnSubmit.innerHTML = 'Add';
                    btnSubmit.classList.remove('btn-update-event');
                    btnSubmit.classList.add('btn-add-event');
                    btnDeleteEvent.classList.add('d-none');
                    eventStartDate.value = date;
                    eventEndDate.value = date;
                },
                eventClick: function(info) {
                    eventClick(info);
                },
                datesSet: function() {
                    modifyToggler();
                },
                viewDidMount: function() {
                    modifyToggler();
                },
                buttonText: {
                    today: 'Hoy',
                    month: 'Mes',
                    week: 'Semana',
                    day: 'Día',
                    list: 'Lista'
                }
            });


            // Render calendar
            calendar.render();
            // Modify modal toggler
            modifyToggler();

            const eventForm = document.getElementById('eventForm');
            const fv = FormValidation.formValidation(eventForm, {
                    fields: {
                        eventTitle: {
                            validators: {
                                notEmpty: {
                                    message: 'Please enter event title '
                                }
                            }
                        },
                        eventStartDate: {
                            validators: {
                                notEmpty: {
                                    message: 'Please enter start date '
                                }
                            }
                        },
                        eventEndDate: {
                            validators: {
                                notEmpty: {
                                    message: 'Please enter end date '
                                }
                            }
                        }
                    },
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger(),
                        bootstrap5: new FormValidation.plugins.Bootstrap5({
                            // Use this for enabling/changing valid/invalid class
                            eleValidClass: '',
                            rowSelector: function(field, ele) {
                                // field is the field name & ele is the field element
                                return '.mb-4';
                            }
                        }),
                        submitButton: new FormValidation.plugins.SubmitButton(),
                        // Submit the form when all fields are valid
                        // defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
                        autoFocus: new FormValidation.plugins.AutoFocus()
                    }
                })
                .on('core.form.valid', function() {
                    // Jump to the next step when all fields in the current step are valid
                    isFormValid = true;
                })
                .on('core.form.invalid', function() {
                    // if fields are invalid
                    isFormValid = false;
                });

            // Modal Toggle Btn
            if (btnToggleModal) {
                btnToggleModal.addEventListener('click', e => {
                    btnCancel.classList.remove('d-none');
                });
            }

            // Add Event
            // ------------------------------------------------
            function addEvent(eventData) {
                // ? Add new event data to current events object and refetch it to display on calender
                // ? You can write below code to AJAX call success response

                currentEvents.push(eventData);
                calendar.refetchEvents();

                // ? To add event directly to calender (won't update currentEvents object)
                // calendar.addEvent(eventData);
            }

            // Update Event
            // ------------------------------------------------
            function updateEvent(eventData) {
                // ? Update existing event data to current events object and refetch it to display on calender
                // ? You can write below code to AJAX call success response
                eventData.id = parseInt(eventData.id);
                currentEvents[currentEvents.findIndex(el => el.id === eventData.id)] =
                    eventData; // Update event by id
                calendar.refetchEvents();

                // ? To update event directly to calender (won't update currentEvents object)
                // let propsToUpdate = ['id', 'title', 'url'];
                // let extendedPropsToUpdate = ['calendar', 'guests', 'location', 'description'];

                // updateEventInCalendar(eventData, propsToUpdate, extendedPropsToUpdate);
            }

            // Remove Event
            // ------------------------------------------------

            function removeEvent(eventId) {
                console.log("Intentando eliminar el evento con ID:", eventId);

                fetch('/eliminar-reserva', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ cita_id: eventId })
                })
                .then(response => response.json())
                .then(data => {
                    console.log("Respuesta del servidor:", data);

                    if (data.message === 'Cita eliminada correctamente') {
                        const event = calendar.getEventById(eventId);
                        if (event) {
                            console.log("Evento encontrado y eliminado en la UI.");
                            event.remove(); // Elimina el evento del calendario sin recargar
                        } else {
                            console.warn("No se encontró el evento en FullCalendar.");
                        }

                         // Asegura que el calendario se actualice
                    } else {
                        console.error('Error al eliminar la cita:', data.message);
                    }
                    calendar.refetchEvents();
                })
                .catch(error => console.error('Error en la solicitud:', error));
            }


            // Add new event
            // ------------------------------------------------
            btnSubmit.addEventListener('click', async e => {
                if (isFormValid) {
                    // Función para formatear la fecha en "YYYY-MM-DD HH:MM:SS"
                    function formatDate(dateString) {
                        let date = new Date(dateString);
                        let year = date.getFullYear();
                        let month = String(date.getMonth() + 1).padStart(2, '0');
                        let day = String(date.getDate()).padStart(2, '0');
                        let hours = String(date.getHours()).padStart(2, '0');
                        let minutes = String(date.getMinutes()).padStart(2, '0');
                        let seconds = String(date.getSeconds()).padStart(2, '0');
                        return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
                    }

                    // Crear el objeto con los datos del evento
                    let eventData = {
                        title: eventTitle.value,
                        start: formatDate(eventStartDate.value),
                        end: formatDate(eventEndDate.value),
                        description: eventDescription.value,
                        medico_id: parseInt(eventMedico.value),
                        paciente_id: parseInt(eventPaciente.value),
                        sucursal_id: parseInt(eventSucursal.value), // Nuevo
                        especialidad_id: parseInt(eventEspecialidad.value), // Nuevo
                        box_id: parseInt(eventBox.value),
                        estado: eventLabelValue, // Valor predeterminado según la BDD
                        comentarios: eventComentario.value, // Evitar valores null
                        motivo: eventMotivo.value // Evitar valores null
                    };

                    console.log(eventData);

                    try {
                        let csrfToken = document.querySelector('meta[name="csrf-token"]').content;

                        if (isEditMode) {
                            // Si estás en modo edición, actualizar el evento
                            eventData.id = eventToUpdate.id; // Asegúrate de incluir el ID del evento a editar
                            let response = await fetch(`/actualizar-reserva/${eventData.id}`, {
                                method: 'PUT', // O 'PATCH'
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken
                                },
                                body: JSON.stringify(eventData)
                            });

                            console.log(response.ok);

                            if (!response.ok) {
                                let errorData = await response.json();
                                console.error('Errores de validación:', errorData);
                                return;
                            }

                            let data = await response.json();
                            console.log('Cita actualizada:', data);

                            // Actualizar la vista del calendario
                            updateEvent({
                                id: data.id, // ID del evento actualizado
                                title: data.title,
                                start: data.start,
                                end: data.end,
                                description: data.description,
                                medico_id: data.medico_id,
                                paciente_id: data.paciente_id,
                                sucursal_id: data.sucursal_id, // Nuevo
                                especialidad_id: data.especialidad_id, // Nuevo
                                box_id: data.box_id,
                                estado: data.estado,
                                comentarios: data.comentarios,
                                motivo: data.motivo,
                                extendedProps: {
                                    calendar: 'Atendido'
                                }
                            });
                        } else {
                            // Si no estás en modo edición, crear un nuevo evento
                            let response = await fetch('/guardar-reserva', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken
                                },
                                body: JSON.stringify(eventData)
                            });

                            console.log(response.ok);

                            if (!response.ok) {
                                let errorData = await response.json();
                                console.error('Errores de validación:', errorData);
                                return;
                            }

                            let data = await response.json();
                            console.log('Cita creada:', data);

                            // Agregar el nuevo evento al calendario
                            addEvent({
                                id: data.id, // ID generado por la base de datos
                                title: data.title,
                                start: data.start,
                                end: data.end,
                                description: data.description,
                                medico_id: data.medico_id,
                                paciente_id: data.paciente_id,
                                sucursal_id: data.sucursal_id, // Nuevo
                                especialidad_id: data.especialidad_id, // Nuevo
                                box_id: data.box_id,
                                estado: data.estado,
                                comentarios: data.comentarios,
                                motivo: data.motivo,
                                extendedProps: {
                                    calendar: 'Atendido'
                                }
                            });
                        }

                        bsAddEventModal.hide();
                    } catch (error) {
                        console.error('Error en la solicitud:', error);
                    }
                }
            });




            // Call removeEvent function
            btnDeleteEvent.addEventListener('click', e => {
                removeEvent(parseInt(eventToUpdate.id));
                calendar.refetchEvents()
                bsAddEventModal.hide();
            });

            // Reset event form inputs values
            // ------------------------------------------------
            function resetValues() {
                eventEndDate.value = '';
                eventStartDate.value = '';
                eventTitle.value = '';
                eventDescription.value = '';
                eventMedico.value = '';
                eventPaciente.value = '';
                eventBox.value = '';
                eventSucursal.value = '';
                eventEspecialidad.value = '';
                eventComentario.value = '';
                eventMotivo.value = '';
                isEditMode = false;

            }

            // When modal hides reset input values
            addEventModal.addEventListener('hidden.bs.modal', function() {
                resetValues();
            });

            // Hide left sidebar if the right sidebar is open
            btnToggleModal.addEventListener('click', e => {
                if (modalTitle) {
                    modalTitle.innerHTML = 'Add Event';
                }
                btnSubmit.innerHTML = 'Add';
                btnSubmit.classList.remove('btn-update-event');
                btnSubmit.classList.add('btn-add-event');
                btnDeleteEvent.classList.add('d-none');
                appCalendarSidebar.classList.remove('show');
                appOverlay.classList.remove('show');
            });

            // Calender filter functionality
            // ------------------------------------------------
            if (selectAll) {
                selectAll.addEventListener('click', e => {
                    if (e.currentTarget.checked) {
                        document.querySelectorAll('.input-filter').forEach(c => (c.checked = 1));
                    } else {
                        document.querySelectorAll('.input-filter').forEach(c => (c.checked = 0));
                    }
                    calendar.refetchEvents();
                });
            }

            if (filterInput) {
                filterInput.forEach(item => {
                    item.addEventListener('click', () => {
                        document.querySelectorAll('.input-filter:checked').length < document
                            .querySelectorAll('.input-filter').length ?
                            (selectAll.checked = false) :
                            (selectAll.checked = true);
                        calendar.refetchEvents();
                    });
                });
            }

            document.addEventListener('DOMContentLoaded', function() {
                const inlineCalInstance = new FullCalendar.Calendar(document.getElementById(
                    'inline-calendar'), {
                    // configuración aquí
                });
                inlineCalInstance.render();

                // Ahora puedes acceder a la propiedad config de inlineCalInstance
                if (inlineCalInstance && inlineCalInstance.config) {
                    inlineCalInstance.config.onChange.push(function(date) {
                        calendar.changeView(calendar.view.type, moment(date[0]).format(
                            'YYYY-MM-DD'));
                        modifyToggler();
                        appCalendarSidebar.classList.remove('show');
                        appOverlay.classList.remove('show');
                    });
                } else {
                    console.error('inlineCalInstance no está inicializado o no tiene config');
                }
            });
        })();
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>