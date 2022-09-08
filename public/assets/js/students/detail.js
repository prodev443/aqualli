// Alumnos
let student = document.getElementById('student-data').dataset
let coursesTable = null

// Obtención del grupo
let group = document.getElementById('group-data').dataset
let url = `${base_url}/groups/resources/get/${group.id}`

fetch(url).then((response) => {
    return response.json()
}).then((group) => {
    document.getElementById('group').setAttribute('value', group.name)
})
// Termina obtención del grupo

// Función para eliminar la foto del alumno
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
                id: student.id
            }
            deleteJSON(data, `${base_url}/students/resources/delete_photo`).then(() => {
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

/**
 * * Tabla de cursos y calificaciones
 * TODO: Actualizar el callback de la edición de la celda para Calificación
 */
document.addEventListener('DOMContentLoaded', function (e) {
    coursesTable = new Tabulator("#courses-table", {
        ajaxURL: `${base_url}/students/resources/courses/${student.id}`,
        layout: "fitDataFill",
        pagination: true,
        paginationSize: 20,
        columns: [
            {
                title: "Código",
                field: "course_code",
                headerFilter: "input",
                formatter: function (cell) {
                    let course_id = cell.getRow().getData().course_id
                    let url = `${base_url}/courses/detail/${course_id}`
                    let html = `<a href="${url}" style="color: blue;">${cell.getValue()}</a>`
                    return html
                },
            },
            {
                title: "Curso",
                field: "course_name",
                headerFilter: "input",
            },
            {
                title: "Calificación",
                field: "score",
                headerFilter: "input",
                hozAlign: "center",
                tooltip:"Edite la calificación desde la tabla",
                formatter: function (cell) {
                    if (cell.getValue() == null) {
                        return 'No calificado'
                    } else {
                        return cell.getValue()
                    }
                },
                editor: "number", editorParams: {
                    min: 0,
                    max: 10,
                    step: 0.5,
                    elementAttributes: {
                        maxlength: "10",
                    },
                    selectContents: true,
                    verticalNavigation: "table",
                },
                cellEdited:function(cell){
                    let data = cell.getRow().getData()
                    let insert_url = `${base_url}/scores/resources/insert`
                    let update_url = `${base_url}/scores/resources/update`
                    let record = new FormData()
                    record.append('student_id', data.student_id)
                    record.append('course_id', data.course_id)
                    record.append('score', cell.getValue())
                    if(data.score_id == null){
                        postData(record, insert_url).then(() => {
                            coursesTable.replaceData()
                        })
                    } else {
                        record.append('id', data.score_id)
                        postData(record, update_url).then((data) => {
                            coursesTable.replaceData()
                        })
                    }
                },
            },
        ],
        locale: true,
        langs: {
            "es-mx": {
                "columns": {
                    "name": "Nombre",
                },
                "data": {
                    "loading": "Cargando",
                    "error": "Error",
                },
                "pagination": {
                    "first": "Primera",
                    "last": "ültima",
                    "prev": "Anterior",
                    "next": "Siguiente",
                    "counter": {
                        "showing": "Mostrando",
                        "of": "de",
                        "rows": "registros",
                        "pages": "páginas",
                    }
                },
            }
        },
    });
})

document.addEventListener('DOMContentLoaded', function (e) {
    var CalendarPage = function () { };
    CalendarPage.prototype.init = function () {

        var addEvent = $("#event-modal");
        var modalTitle = $("#modal-title");
        var formEvent = $("#form-event");
        var selectedEvent = null;
        var calendarEl = document.getElementById('student-calendar');

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
                var option = new Option(selectedEvent._def.title,
                    selectedEvent._def.extendedProps.courseId, true, true);
                $('#course_id').append(option).trigger('change');
                modalTitle.text('Detalles de clase reservada');
            },
            dateClick: function (info) { },
            events: `${base_url}/students/resources/get/schedule/${student.id}`
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

// document.addEventListener('DOMContentLoaded', function (e) {
//     document.getElementById('gen-user-btn').addEventListener('click', function (e) {
//         let post_url = `${base_url}/`
//         let updateStudentUrl = `${base_url}/`
//         let record = {
//             first_name: document.getElementById('first_name').value,
//             first_last_name: document.getElementById('last_name').value,
//             second_last_name: document.getElementById('second_last_name').value,
//             email: document.getElementById('email').value,
//             is_active: '1',
//             phone: document.getElementById('mobile_number').value,
//         }

//         postJSONData(data, post_url,'Usuario nuevo registrado', 'Se ha creado un nuevo usuario').then((user) => {
//             let student = {
//                 student_id: student_id,
//                 assigned_to: user.id
//             }
//             return Promise.resolve(student)
//         }).then((student) => {
//             postJSONData(student, updateStudentUrl,'Alumno actualizado', 'Alumno asignado al nuevo usuario')
//             .then().catch((textStatus) => {
//                 console.log(textStatus);
//             })
//         })
//         .catch((textStatus) => {
//             console.log(textStatus);
//         })
//     })
// })