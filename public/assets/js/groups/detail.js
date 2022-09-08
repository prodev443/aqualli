/**
 * Inicializa la vista de detalle del grupo
 * Vista: app\Views\groups\detail.php
 */
let teacher = null
$(document).ready(
    function () {
        teacher = document.getElementById('teacher-data').dataset
        let groupInfo = document.getElementById('group-info').dataset

        fetch(`${base_url}/teachers/resources/get/${teacher.id}`).then((response) => {
            return response.json()
        }).then((teacherA) => {
            let teacherName = `${teacherA.first_name} ${teacherA.last_name} ${teacherA.second_last_name}`
            let option = new Option(teacherName, teacherA.id, true, true);
            $('#teacher_id').append(option).trigger('change');
        })

        var CalendarPage = function () { };
        CalendarPage.prototype.init = function () {

            var addEvent = $("#event-modal");
            var modalTitle = $("#modal-title");
            var formEvent = $("#form-event");
            var selectedEvent = null;
            var forms = document.getElementsByClassName('needs-validation');

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
                eventTimeFormat: {
                    hour: '2-digit',
                    minute: '2-digit'
                },
                windowResize: function (view) {
                    var newView = getInitialView();
                    calendar.changeView(newView);
                },
                eventDidMount: function (info) {
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
                eventClick: function (info) {
                    $('#btn-delete-event').css('display', 'block')
                    addEvent.modal('show');
                    formEvent[0].reset();
                    selectedEvent = info.event;
                    $("#event-id").val(selectedEvent.id);
                    $("#event-startTime").val(msToTime(selectedEvent._def.recurringDef.typeData
                        .startTime.milliseconds));
                    $("#event-daysOfWeek").val(selectedEvent._def.recurringDef.typeData
                        .daysOfWeek);
                    var option = new Option(selectedEvent._def.extendedProps.course,
                        selectedEvent._def.extendedProps.course_id, true, true);
                    $('#course_id').append(option).trigger('change');
                    modalTitle.text('Actualizar clase reservada');
                },
                dateClick: function (info) {
                    $('#btn-delete-event').css('display', 'none')
                    addNewEvent(info);
                    modalTitle.text('Registrar nueva clase');
                    document.getElementById('event-daysOfWeek').value = info.date.getDay()
                },
                events: `${base_url}/schedules/groups/get/${groupInfo.id}`
            });

            // Funciones del CRUD

            function addNewEvent(info) {
                selectedEvent = null
                formEvent.trigger('reset')
                formEvent.removeClass("was-validated");
                $('#event-id').val(null);
                $('#course_id').val(null).trigger('change');
                addEvent.modal('show');
                modalTitle.text('Agregar Evento');
            }

            $(formEvent).on('submit', function (ev) {
                ev.preventDefault();
                var startTime = $('#event-startTime').val()
                var daysOfWeek = $('#event-daysOfWeek').val()
                var course_id = $('#course_id').find(':selected').val()

                var temp_event = {
                    startTime: startTime,
                    daysOfWeek: daysOfWeek,
                    className: "bg-info",
                    course_id: course_id,
                    group_id: `${groupInfo.id}`
                }

                // validation
                if (forms[0].checkValidity() === false) {
                    forms[0].classList.add('was-validated');
                } else {
                    if (selectedEvent) { // Actualización de un evento
                        temp_event.id = $("#event-id").val()
                        postJSON(temp_event, `${base_url}/schedules/resources/update`).then(
                            () => {
                                selectedEvent = null
                                calendar.refetchEvents()
                                calendar.updateSize()
                            })
                    } else { // Inserción de un nuevo evento
                        postJSON(temp_event, `${base_url}/schedules/resources/insert`).then(
                            () => {
                                calendar.refetchEvents()
                                calendar.updateSize()
                            })
                    }
                    addEvent.modal('hide');
                }
            });

            $("#btn-delete-event").on('click', function (e) {
                if (selectedEvent) {
                    let event = {
                        'id': selectedEvent.id
                    }
                    deleteJSON(event, `${base_url}/schedules/resources/delete`).then((
                        result) => {
                        if (result !== false) {
                            selectedEvent.remove();
                            selectedEvent = null;
                        }
                    })
                    addEvent.modal('hide');
                }
            });

            $("#btn-new-event").on('click', function (e) {
                $('#btn-delete-event').css('display', 'none')
                addNewEvent({
                    date: new Date(),
                    allDay: true
                });
            });

        }
        
        //init
        $.CalendarPage = new CalendarPage, $.CalendarPage.Constructor = CalendarPage
        $.CalendarPage.init()
        $.CalendarPage.calendar.render()

        document.getElementById('vertical-menu-btn').addEventListener('click', function (e) {
            $.CalendarPage.calendar.updateSize()
        })

        $('#course_id').select2({
            theme: 'bootstrap-5',
            ajax: {
                url: `${base_url}/courses/resources/select2`,
                dataType: 'json',
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
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