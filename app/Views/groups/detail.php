<?php 
$this->setVar('title', 'Detalle');
$this->setVar('pagetitle', 'Grupo');
$this->setVar('css_styles', array(
    'assets/libs/sweetalert2/sweetalert2.min.css',
    'assets/libs/fullcalendar/main.min.css',
    'assets/libs/bootstrap/icons/bootstrap-icons.css',
    'assets/libs/select2/css/select2.min.css',
    'assets/libs/select2/bootstrap-5-theme/select2-bootstrap-5-theme.min.css',
    'assets/libs/select2/bootstrap-5-theme/select2-bootstrap-5-theme.rtl.min.css',

));
$this->setVar('scripts', array(
    'assets/libs/sweetalert2/sweetalert2.min.js',
    'assets/libs/fullcalendar/main.min.js',
    'assets/libs/fullcalendar/locales/es.js',
    'assets/libs/select2/js/select2.min.js',
    'assets/custom/js/ajax.js', // AJAX requests con token
));
?>
<?= $this->extend('layouts/main');?>
<?= $this->section('content');?>

<!-- Formulario Horario del grupo -->
<div class="row">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="card-title mb-4">Datos del Grupo</h4>
                </div>
                <div class="col-sm-6">
                    <div class="d-flex flex-row-reverse bd-highlight">
                        <div class="p-2 bd-highlight">
                            <a href="<?=base_url('groups')?>"><i class="bx bx-arrow-back"></i> Regresar</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="mb-3">
                    <a href="<?=base_url('groups/edit/'.$group['id'])?>" class="btn btn-success btn-label">
                        <i class="bx bxs-pencil label-icon"></i> Editar
                    </a>
                </div>
                <form id="group_form">
                    <input type="hidden" name="id" value="<?= $group['id'] ?>">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="name" class="form-label">Grupo</label>
                                <input type="text" class="form-control" name="name" id="name"
                                    value="<?= $group['name'] ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="observations" class="form-label">Observaciones</label>
                                <textarea class="form-control" name="observations" id="observations" rows="3"
                                    readonly><?= $group['observations'] ?></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Termina formulario del grupo -->

<!-- Inicia ventana modal -->
<div class="modal fade" id="event-modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header py-3 px-4 border-bottom-0">
                <h5 class="modal-title" id="modal-title">Clase</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body p-4">
                <form class="needs-validation" name="event-form" id="form-event" novalidate>
                    <input id="event-id" type="hidden">
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label">Clase</label>
                                <input class="form-control" placeholder="" type="text" name="title" id="event-title"
                                    required value="" />
                                <div class="invalid-feedback">Nombre de la clase</div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="course_id" class="form-label">Curso</label>
                            <select class="select2-search form-select" data-live-search="true" name="course_id"
                                id="course_id" required>
                                <option disabled selected value> -- Seleccione un curso -- </option>
                            </select>
                            <div class="invalid-feedback">Seleccione un curso de la lista</div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label">Hora</label>
                                <select class="form-control form-select" name="startTime" id="event-startTime" required>
                                    <option disabled selected value> -- Seleccione una hora -- </option>
                                    <option value="07:00:00">07:00:00</option>
                                    <option value="08:00:00">08:00:00</option>
                                    <option value="09:00:00">09:00:00</option>
                                    <option value="10:00:00">10:00:00</option>
                                    <option value="11:00:00">11:00:00</option>
                                    <option value="12:00:00">12:00:00</option>
                                    <option value="13:00:00">13:00:00</option>
                                    <option value="14:00:00">14:00:00</option>
                                    <option value="15:00:00">15:00:00</option>
                                    <option value="16:00:00">16:00:00</option>
                                    <option value="17:00:00">17:00:00</option>
                                    <option value="18:00:00">18:00:00</option>
                                    <option value="19:00:00">19:00:00</option>
                                    <option value="20:00:00">20:00:00</option>
                                    <option value="21:00:00">21:00:00</option>
                                </select>
                                <div class="invalid-feedback">Seleccione una hora válida</div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label">Día</label>
                                <select class="form-control form-select" name="daysOfWeek" id="event-daysOfWeek"
                                    required>
                                    <!-- <option disabled selected value> -- Selecciona el día -- </option> -->
                                    <option value="0">Domingo</option>
                                    <option value="1">Lunes</option>
                                    <option value="2">Martes</option>
                                    <option value="3">Miércoles</option>
                                    <option value="4">Jueves</option>
                                    <option value="5">Viernes</option>
                                    <option value="6">Sábado</option>
                                </select>
                                <div class="invalid-feedback">Selecione un día válido</div>
                            </div>
                        </div>
                    </div>
                    <div class="btn-group">
                        <button type="submit" class="btn btn-success btn-label" id="btn-save-event">
                            <i class="bx bx-save label-icon"></i>Guardar
                        </button>
                    </div>
                    <div class="btn-group">
                    <button type="button" class="btn btn-danger btn-label" id="btn-delete-event">
                            <i class="bx bx-trash label-icon"></i>Eliminar
                        </button>
                    </div>
                </form>
            </div>
        </div> <!-- end modal-content-->
    </div>
</div>
<!-- Termina modal-->

<!-- Sección del calendario de clases -->
<div class="row">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="mb-3">
                    <button class="btn btn-primary btn-label" id="btn-new-event">
                        <i class="mdi mdi-plus-circle-outline label-icon"></i>Clase
                    </button>
                </div>
            </div>
            <div class="row">
                <div id="calendar"></div>
            </div>
        </div>
    </div>
</div>
<!-- Termina sección del calendario de clases -->

<script>
$(document).ready(
    function() {
        tokenize('<?=csrf_token()?>', '<?=csrf_header()?>', '<?=csrf_hash()?>')

        var CalendarPage = function() {};
        CalendarPage.prototype.init = function() {

                var addEvent = $("#event-modal");
                var modalTitle = $("#modal-title");
                var formEvent = $("#form-event");
                var selectedEvent = null;
                var newEventData = null;
                var forms = document.getElementsByClassName('needs-validation');
                var eventObject = null;

                function msToTime(s) {
                    // Pad to 2 or 3 digits, default is 2
                    function pad(n, z) {
                        z = z || 2;
                        return ('00' + n).slice(-z);
                    }

                    var ms = s % 1000;
                    s = (s - ms) / 1000;
                    var secs = s % 60;
                    s = (s - secs) / 60;
                    var mins = s % 60;
                    var hrs = (s - mins) / 60;

                    return pad(hrs) + ':' + pad(mins) + ':' + pad(secs);
                }

                function timeToMs(time) {
                    let timeArray = time.split(':')
                    let seconds = timeArray[0] * 60 * 60; // segundos de las horas
                    seconds += timeArray[1] * 60; // segundos de los minutos
                    seconds += timeArray[2]; // segundos
                    seconds *= 1000
                    return seconds
                }
                var calendarEl = document.getElementById('calendar');

                // Define la dimensión del calendario en base a las dimensiones del dipositivo
                function getInitialView() {
                    if (window.innerWidth >= 768 && window.innerWidth < 1200) {
                        return 'timeGridWeek';
                    } else if (window.innerWidth <= 768) {
                        return 'listMonth';
                    } else {
                        return 'dayGridMonth';
                    }
                }

                let calendar = this.calendar = new FullCalendar.Calendar(calendarEl, {
                    locale: 'es',
                    firstDay: 0,
                    editable: false,
                    droppable: true,
                    selectable: true,
                    initialView: getInitialView(),
                    themeSystem: 'bootstrap5',
                    height: 650,
                    windowResize: function(view) {
                        var newView = getInitialView();
                        calendar.changeView(newView);
                    },
                    eventDidMount: function(info) {
                        if (info.event.extendedProps.status === 'done') {

                            // Change background color of row
                            info.el.style.backgroundColor = 'red';

                            // Change color of dot marker
                            var dotEl = info.el.getElementsByClassName('fc-event-dot')[0];
                            if (dotEl) {
                                dotEl.style.backgroundColor = 'white';
                            }
                        }
                    },
                    headerToolbar: {
                        left: 'prev,next,today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
                    },
                    eventClick: function(info) {
                        $('#btn-delete-event').css('display', 'block')
                        addEvent.modal('show');
                        formEvent[0].reset();
                        selectedEvent = info.event;
                        $("#event-id").val(selectedEvent.id);
                        $("#event-title").val(selectedEvent.title);
                        $("#event-startTime").val(msToTime(selectedEvent._def.recurringDef.typeData
                            .startTime.milliseconds));
                        $("#event-daysOfWeek").val(selectedEvent._def.recurringDef.typeData
                            .daysOfWeek);
                        var option = new Option(selectedEvent._def.extendedProps.course_name,
                            selectedEvent._def.extendedProps.course_id, true, true);
                        $('#course_id').append(option).trigger('change');
                        modalTitle.text('Actualizar clase reservada');
                    },
                    dateClick: function(info) {
                        $('#btn-delete-event').css('display', 'none')
                        addNewEvent(info);
                        modalTitle.text('Registrar nueva clase');
                        document.getElementById('event-daysOfWeek').value = info.date.getDay()
                    },
                    events: '<?= base_url('schedules/groups/get/'.$group['id'])?>'
                });

                // Funciones del CRUD

                function addNewEvent(info) {
                    addEvent.modal('show');
                    formEvent.removeClass("was-validated");
                    formEvent[0].reset();
                    $("#event-title").val();
                    $('#event-category').val();
                    modalTitle.text('Add Event');
                    newEventData = info;
                }

                $(formEvent).on('submit', function(ev) {
                    ev.preventDefault();
                    var inputs = $('#form-event :input');
                    var title = $("#event-title").val();
                    var startTime = $('#event-startTime').val()
                    var daysOfWeek = $('#event-daysOfWeek').val()
                    var course_id = $('#course_id').find(':selected').val()

                    var temp_event = {
                        title: title,
                        startTime: startTime,
                        daysOfWeek: daysOfWeek,
                        className: "bg-info",
                        course_id: course_id,
                        group_id: '<?= $group['id'] ?>'
                    }

                    // validation
                    if (forms[0].checkValidity() === false) {
                        forms[0].classList.add('was-validated');
                    } else {
                        if (selectedEvent) { // Actualización de un evento
                            temp_event.id = $("#event-id").val()
                            postJSONData(temp_event, '<?=base_url('schedules/resources/update')?>').then(
                                () => {
                                    selectedEvent = null
                                    calendar.refetchEvents()
                                    calendar.updateSize()
                                })
                        } else { // Inserción de un nuevo evento
                            postJSONData(temp_event, '<?=base_url('schedules/resources/insert')?>').then(
                                () => {
                                    calendar.refetchEvents()
                                    calendar.updateSize()
                                })
                        }
                        addEvent.modal('hide');
                    }
                });

                $("#btn-delete-event").on('click', function(e) {
                    if (selectedEvent) {
                        let event = {
                            'id': selectedEvent.id
                        }
                        deleteJSONData(event, '<?=base_url('schedules/resources/delete')?>').then((
                            result) => {
                            if (result !== false) {
                                selectedEvent.remove();
                                selectedEvent = null;
                            }
                        })
                        addEvent.modal('hide');
                    }
                });

                $("#btn-new-event").on('click', function(e) {
                    $('#btn-delete-event').css('display', 'none')
                    addNewEvent({
                        date: new Date(),
                        allDay: true
                    });
                });

            },
            //init
            $.CalendarPage = new CalendarPage, $.CalendarPage.Constructor = CalendarPage

        $.CalendarPage.init()
        $.CalendarPage.calendar.render()

        $('#course_id').select2({
            theme: 'bootstrap-5',
            ajax: {
                url: '<?=base_url('courses/resources/select2')?>',
                dataType: 'json',
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.name,
                                id: item.id
                            }
                        })
                    };
                }
            }
        });

    }
)
</script>
<?= $this->endSection(); ?>