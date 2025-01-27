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
                        <button class="btn btn-primary btn-toggle-sidebar" data-bs-toggle="offcanvas"
                            data-bs-target="#addEventSidebar" aria-controls="addEventSidebar">
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
                        <small class="text-small text-muted text-uppercase align-middle">Filter</small>
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
                <!-- FullCalendar Offcanvas -->
                <div class="offcanvas offcanvas-end event-sidebar" tabindex="-1" id="addEventSidebar"
                    aria-labelledby="addEventSidebarLabel">
                    <div class="offcanvas-header border-bottom">
                        <h5 class="offcanvas-title" id="addEventSidebarLabel">Add Event</h5>
                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                            aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
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
                            {{-- <div class="mb-3">
                                <label class="switch">
                                    <input type="checkbox" class="switch-input allDay-switch" />
                                    <span class="switch-toggle-slider">
                                        <span class="switch-on"></span>
                                        <span class="switch-off"></span>
                                    </span>
                                    <span class="switch-label">All Day</span>
                                </label>
                            </div> --}}
                            {{-- <div class="form-floating form-floating-outline mb-4">
                                <input type="url" class="form-control" id="eventURL" name="eventURL"
                                    placeholder="https://www.google.com" />
                                <label for="eventURL">Event URL</label>
                            </div> --}}
                            {{-- <div class="form-floating form-floating-outline mb-4 select2-primary">
                                <select class="select2 select-event-guests form-select" id="eventGuests"
                                    name="eventGuests" multiple>
                                    <option data-avatar="1.png" value="Jane Foster">Jane Foster</option>
                                    <option data-avatar="3.png" value="Donna Frank">Donna Frank</option>
                                    <option data-avatar="5.png" value="Gabrielle Robertson">Gabrielle Robertson</option>
                                    <option data-avatar="7.png" value="Lori Spears">Lori Spears</option>
                                    <option data-avatar="9.png" value="Sandy Vega">Sandy Vega</option>
                                    <option data-avatar="11.png" value="Cheryl May">Cheryl May</option>
                                </select>
                                <label for="eventGuests">Add Guests</label>
                            </div> --}}
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

                            {{--
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="text" class="form-control" id="eventLocation" name="eventLocation"
                                    placeholder="Enter Location" />
                                <label for="eventLocation">Location</label>
                            </div> --}}
                            <div class="form-floating form-floating-outline mb-4">
                                <textarea class="form-control" name="eventDescription" id="eventDescription"></textarea>
                                <label for="eventDescription">Description</label>
                            </div>
                            <div class="mb-3 d-flex justify-content-sm-between justify-content-start my-4 gap-2">
                                <div class="d-flex">
                                    <button type="submit" class="btn btn-primary btn-add-event me-sm-2 me-1">Add</button>
                                    <button type="reset" class="btn btn-outline-secondary btn-cancel me-sm-0 me-1"
                                        data-bs-dismiss="offcanvas">Cancel</button>
                                </div>
                                <button class="btn btn-outline-danger btn-delete-event d-none">Delete</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /Calendar & Modal -->
        </div>
    </div>
@endsection
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script>
    // document.addEventListener('DOMContentLoaded', function() {
    //     let calendarEl = document.getElementById('calendar');

    //     let calendar = new FullCalendar.Calendar(calendarEl, {
    //         initialView: 'dayGridMonth'
    //     });

    //     calendar.render();
    // });
</script>
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
                addEventSidebar = document.getElementById('addEventSidebar'),
                appOverlay = document.querySelector('.app-overlay'),
                calendarsColor = {
                    Atendido: 'primary',
                    Atendiendose: 'danger',
                    Noasiste: 'warning',
                    Confirmado: 'success',
                    Espera: 'info'
                },
                offcanvasTitle = document.querySelector('.offcanvas-title'),
                btnToggleSidebar = document.querySelector('.btn-toggle-sidebar'),
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

                // allDaySwitch = document.querySelector('.allDay-switch'),
                selectAll = document.querySelector('.select-all'),
                filterInput = [].slice.call(document.querySelectorAll('.input-filter')),
                inlineCalendar = document.querySelector('.inline-calendar');

            let eventToUpdate,
                currentEvents =
                events, // Assign app-calendar-events.js file events (assume events from API) to currentEvents (browser store/object) to manage and update calender events
                isFormValid = false,
                inlineCalInstance;

            // Init event Offcanvas
            const bsAddEventSidebar = new bootstrap.Offcanvas(addEventSidebar);

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

            // Event click function
            function eventClick(info) {
                eventToUpdate = info.event;
                if (eventToUpdate.url) {
                    info.jsEvent.preventDefault();
                    window.open(eventToUpdate.url, '_blank');
                }
                bsAddEventSidebar.show();
                // For update event set offcanvas title text: Update Event
                if (offcanvasTitle) {
                    offcanvasTitle.innerHTML = 'Update Event';
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

                // // Call removeEvent function
                // btnDeleteEvent.addEventListener('click', e => {
                //   removeEvent(parseInt(eventToUpdate.id));
                //   // eventToUpdate.remove();
                //   bsAddEventSidebar.hide();
                // });
            }

            // Modify sidebar toggler
            function modifyToggler() {
                const fcSidebarToggleButton = document.querySelector('.fc-sidebarToggle-button');
                fcSidebarToggleButton.classList.remove('fc-button-primary');
                fcSidebarToggleButton.classList.add('d-lg-none', 'd-inline-block', 'ps-0');
                while (fcSidebarToggleButton.firstChild) {
                    fcSidebarToggleButton.firstChild.remove();
                }
                fcSidebarToggleButton.setAttribute('data-bs-toggle', 'sidebar');
                fcSidebarToggleButton.setAttribute('data-overlay', '');
                fcSidebarToggleButton.setAttribute('data-target', '#app-calendar-sidebar');
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
            let calendar = new Calendar(calendarEl, {
                initialView: 'dayGridMonth',
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
                navLinks: true, // can click day/week names to navigate views
                eventClassNames: function({
                    event: calendarEvent
                }) {
                    const colorName = calendarsColor[calendarEvent._def.extendedProps.calendar];
                    // Background Color
                    return ['fc-event-' + colorName];
                },
                dateClick: function(info) {
                    let date = moment(info.date).format('YYYY-MM-DD');
                    resetValues();
                    bsAddEventSidebar.show();

                    // For new event set offcanvas title text: Add Event
                    if (offcanvasTitle) {
                        offcanvasTitle.innerHTML = 'Add Event';
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
                //Opciones de texto para los botones de vista
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
            // Modify sidebar toggler
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

            // Sidebar Toggle Btn
            if (btnToggleSidebar) {
                btnToggleSidebar.addEventListener('click', e => {
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
                // ? Delete existing event data to current events object and refetch it to display on calender
                // ? You can write below code to AJAX call success response
                currentEvents = currentEvents.filter(function(event) {
                    return event.id != eventId;
                });
                calendar.refetchEvents();

                // ? To delete event directly to calender (won't update currentEvents object)
                // removeEventInCalendar(eventId);
            }

            // (Update Event In Calendar (UI Only)
            // ------------------------------------------------
            const updateEventInCalendar = (updatedEventData, propsToUpdate, extendedPropsToUpdate) => {
                const existingEvent = calendar.getEventById(updatedEventData.id);

                // --- Set event properties except date related ----- //
                // ? Docs: https://fullcalendar.io/docs/Event-setProp
                // dateRelatedProps => ['start', 'end', 'allDay']
                // eslint-disable-next-line no-plusplus
                for (var index = 0; index < propsToUpdate.length; index++) {
                    var propName = propsToUpdate[index];
                    existingEvent.setProp(propName, updatedEventData[propName]);
                }

                // --- Set date related props ----- //
                // ? Docs: https://fullcalendar.io/docs/Event-setDates
                existingEvent.setDates(updatedEventData.start, updatedEventData.end, {
                    // allDay: updatedEventData.allDay
                });

                // --- Set event's extendedProps ----- //
                // ? Docs: https://fullcalendar.io/docs/Event-setExtendedProp
                // eslint-disable-next-line no-plusplus
                for (var index = 0; index < extendedPropsToUpdate.length; index++) {
                    var propName = extendedPropsToUpdate[index];
                    existingEvent.setExtendedProp(propName, updatedEventData.extendedProps[propName]);
                }
            };

            // Remove Event In Calendar (UI Only)
            // ------------------------------------------------
            function removeEventInCalendar(eventId) {
                calendar.getEventById(eventId).remove();
            }

            // Add new event
            // ------------------------------------------------
            btnSubmit.addEventListener('click', async e => {
                if (isFormValid) {
                    let newEvent = {
                        title: eventTitle.value,
                        start: eventStartDate.value,
                        end: eventEndDate.value,
                        description: eventDescription.value,
                        medico_id: eventMedico.value,
                        paciente_id: eventPaciente.value,
                        box_id: eventBox.value,
                    };
                    console.log(newEvent);

                    try {
                        let csrfToken = document.querySelector('meta[name="csrf-token"]')
                            .content;

                        let response = await fetch('/api/citas', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify(newEvent)
                        });
                        console.log(response.ok);
                        // Comprobar si la respuesta es exitosa

                        if (!response.ok) {
                            let errorData = await response.json();
                            console.error('Errores de validación:', errorData);
                        }

                        if (response.ok) {
                            console.log('1');
                            let data = await response.json();
                            console.log('2');
                            console.log('Cita creada:', data);

                            // Opcional: actualizar la vista del calendario
                            addEvent({
                                // id: data.id, // ID generado por la base de datos
                                title: data.title,
                                start: data.start,
                                end: data.end,
                                description: data.description,
                                medico_id: data.medico,
                                paciente_id: data.paciente,
                                box_id: data.box,
                                extendedProps: {
                                    calendar: 'Atendido'
                                }
                            });
                            console.log(addEvent)

                            bsAddEventSidebar.hide();
                        } else {
                            console.error('Error al crear la cita:', response.statusText);
                        }
                    } catch (error) {
                        console.error('Error en la solicitud:', error);
                    }
                }
            });

            // Call removeEvent function
            // btnDeleteEvent.addEventListener('click', e => {
            //     removeEvent(parseInt(eventToUpdate.id));
            //     // eventToUpdate.remove();
            //     bsAddEventSidebar.hide();
            // });

            // Reset event form inputs values
            // ------------------------------------------------
            function resetValues() {
                eventEndDate.value = '';
                // eventUrl.value = '';
                eventStartDate.value = '';
                eventTitle.value = '';
                // eventLocation.value = '';
                // allDaySwitch.checked = false;
                // eventGuests.val('').trigger('change');
                eventDescription.value = '';
                eventMedico.value = '';
                eventPaciente.value = '';
                eventBox.value = '';

            }

            // When modal hides reset input values
            addEventSidebar.addEventListener('hidden.bs.offcanvas', function() {
                resetValues();
            });

            // Hide left sidebar if the right sidebar is open
            btnToggleSidebar.addEventListener('click', e => {
                if (offcanvasTitle) {
                    offcanvasTitle.innerHTML = 'Add Event';
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
