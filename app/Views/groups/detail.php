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
    'assets/libs/select2/js/select2.min.js',
    'assets/custom/js/ajax.js', // AJAX requests con token
));
?>
<?= $this->extend('layouts/main');?>
<?= $this->section('content');?>
<!-- Formulario Alumno -->
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
                <div class="col-md-12">
                    <div class="mb-3">
                        <a href="<?=base_url('groups/edit/'.$group['id'])?>" class="btn btn-success btn-label">
                            <i class="bx bxs-pencil label-icon"></i> Editar
                        </a>
                    </div>
                </div>
            </div>
            <form id="group_form">
                <input type="hidden" name="id" value="<?= $group['id'] ?>">
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="name" class="form-label">Grupo</label>
                            <input type="text" class="form-control" name="name" id="name" value="<?= $group['name'] ?>"
                                readonly>
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
            <br>

            <div class="row">
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-grid">
                                <button class="btn font-16 btn-primary" id="btn-new-event"><i
                                        class="mdi mdi-plus-circle-outline"></i> Crear nuevo evento</button>
                            </div>

                            <div id="external-events" class="mt-2">
                                <br>
                                <p class="text-muted">Puedes arrastrar eventos predefinidos</p>
                                <div class="external-event fc-event bg-success" data-class="bg-success">
                                    <i class="mdi mdi-checkbox-blank-circle font-size-11 me-2"></i>Nueva planeación de
                                    eventos
                                </div>
                                <div class="external-event fc-event bg-info" data-class="bg-info">
                                    <i class="mdi mdi-checkbox-blank-circle font-size-11 me-2"></i>Reunión
                                </div>
                                <div class="external-event fc-event bg-warning" data-class="bg-warning">
                                    <i class="mdi mdi-checkbox-blank-circle font-size-11 me-2"></i>Reportes
                                </div>
                                <div class="external-event fc-event bg-danger" data-class="bg-danger">
                                    <i class="mdi mdi-checkbox-blank-circle font-size-11 me-2"></i>Nuevos Temas
                                </div>
                            </div>

                            <div class="row justify-content-center mt-5">
                                <img src="<?= base_url('assets/images/verification-img.png') ?>" alt=""
                                    class="img-fluid d-block">
                            </div>
                        </div>
                    </div>
                </div> <!-- end col-->

                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-body">
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div> <!-- end col -->

            </div>

            <div style='clear:both'></div>


            <!-- Add New Event MODAL -->
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
                                            <input class="form-control" placeholder="" type="text" name="title"
                                                id="event-title" required value="" />
                                            <div class="invalid-feedback">Nombre de la clase</div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="course_id" class="form-label">Curso</label>
                                        <select class="select2-search form-select" data-live-search="true"
                                            name="course_id" id="course_id" required>
                                            <option disabled selected value> -- Seleccione un curso -- </option>
                                        </select>
                                        <div class="invalid-feedback">Seleccione un curso de la lista</div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label">Hora</label>
                                            <select class="form-control form-select" name="startTime"
                                                id="event-startTime" required>
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
                                            <select class="form-control form-select" name="daysOfWeek"
                                                id="event-daysOfWeek" required>
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
                                <div class="row mt-2">
                                    <div class="col-6">
                                        <button type="button" class="btn btn-danger"
                                            id="btn-delete-event">Eliminar</button>
                                    </div>
                                    <div class="col-6 text-end">
                                        <button type="button" class="btn btn-light me-1"
                                            data-bs-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-success"
                                            id="btn-save-event">Guardar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div> <!-- end modal-content-->
                </div> <!-- end modal dialog-->
            </div>
            <!-- end modal-->
        </div>
        <!-- end card body -->
    </div>
</div>
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

                /* initialize the calendar */

                var date = new Date();
                var d = date.getDate();
                var m = date.getMonth();
                var y = date.getFullYear();
                
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

                // Muestra el formulario modal para insertar un nuevo evento
                function addNewEvent(info) {
                    addEvent.modal('show');
                    formEvent.removeClass("was-validated");
                    formEvent[0].reset();
                    $("#event-title").val();
                    $('#event-category').val();
                    modalTitle.text('Add Event');
                    newEventData = info;
                }

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
                    editable: true,
                    droppable: true,
                    selectable: true,
                    initialView: getInitialView(),
                    themeSystem: 'bootstrap5',
                    height: 650,
                    // responsive
                    // windowResize: function(view) {
                    //     var newView = getInitialView();
                    //     this.calendar.changeView(newView);
                    // },
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
                        left: 'prev,next today',
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
                    events: '<?= base_url('schedules/resources/get')?>'
                });

                /*Add new event*/
                // Form to add new event

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
                        course_id: course_id
                    }

                    // validation
                    if (forms[0].checkValidity() === false) {
                        forms[0].classList.add('was-validated');
                    } else {
                        if (selectedEvent) { // Actualización de un evento
                            temp_event.id = $("#event-id").val()
                            postJSONData(temp_event, '<?=base_url('schedules/resources/update')?>').then(
                                () => {
                                    calendar.refetchEvents()
                                })
                        } else { // Inserción de un nuevo evento
                            postJSONData(temp_event, '<?=base_url('schedules/resources/insert')?>').then(
                                () => {
                                    calendar.refetchEvents()
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

        // calendar.render()

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