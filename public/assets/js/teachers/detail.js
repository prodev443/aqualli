$('#deletePhotoBtn').click(function (e) {
    e.preventDefault()
    Swal.fire({
        title: 'Deseas eliminar la fotografía',
        text: "El archivo se eliminará del servidor",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            let data = {
                id: document.getElementById('teacher-id').value
            }
            deleteJSON(data, `${base_url}/teachers/resources/delete_photo`).then(() => {
                Swal.fire(
                    'Operación exitosa',
                    'El profesor ha sido eliminado',
                    'success'
                )
            }).catch(() => {
                Swal.fire(
                    'Error',
                    'No se pudo completar la solicitud',
                    'error'
                )
            }).finally(() => {
                $('#deletePhotoBtn').remove()
                $('#photo').remove()
            })
        }
    })
})

$('#deleteCvBtn').click(function (e) {
    e.preventDefault()
    Swal.fire({
        title: '¿Deseas eliminar el currículum?',
        text: "El archivo se eliminará del servidor",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            let data = {
                id: document.getElementById('teacher-id').value
            }
            deleteJSON(data, `${base_url}/teachers/resources/delete_cv`).then(() => {
                Swal.fire(
                    'Operación exitosa',
                    'El profesor ha sido eliminado',
                    'success'
                )
            }).catch(() => {
                Swal.fire(
                    'Error',
                    'No se pudo completar la solicitud',
                    'error'
                )
            }).finally(() => {
                $('#cv-container').remove()
            })
        }
    })
})

document.addEventListener('DOMContentLoaded', function (e) {
    let teacher = document.getElementById('teacher-data').dataset
    var CalendarPage = function () { };
    CalendarPage.prototype.init = function () {

        var addEvent = $("#event-modal");
        var modalTitle = $("#modal-title");
        var formEvent = $("#form-event");
        var selectedEvent = null;
        var calendarEl = document.getElementById('teacher-calendar');

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
                addEvent.modal('show');
                formEvent[0].reset();
                selectedEvent = info.event;
                $("#event-id").val(selectedEvent.id);
                $("#event-startTime").val(msToTime(selectedEvent._def.recurringDef.typeData
                    .startTime.milliseconds));
                $("#event-daysOfWeek").val(selectedEvent._def.recurringDef.typeData
                    .daysOfWeek);
                var option = new Option(selectedEvent._def.extendedProps.courseName,
                    selectedEvent._def.extendedProps.courseId, true, true);
                $('#course_id').append(option).trigger('change');
                $('#group').val(selectedEvent._def.extendedProps.groupName);
                modalTitle.text('Detalles de clase reservada');
            },
            dateClick: function (info) { },
            events: `${base_url}/teachers/resources/get/schedule/${teacher.id}`
        });

    }

    //init
    $.CalendarPage = new CalendarPage, $.CalendarPage.Constructor = CalendarPage
    $.CalendarPage.init()
    $.CalendarPage.calendar.render()

    document.getElementById('vertical-menu-btn').addEventListener('click', function (e) {
        $.CalendarPage.calendar.updateSize()
    })
})