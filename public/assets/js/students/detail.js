// Alumnos
let base_url = window.location.origin
let student_id = document.getElementById('student-data').dataset.id
let coursesTable = null

// Obtención del grupo
let group_id = document.getElementById('group_id-data').dataset.group_id
let url = `${base_url}/groups/resources/get/${group_id}`

fetch(url).then((response) => {
    return response.json()
}).then((group) => {
    document.getElementById('group').setAttribute('value', group.name)
})
// Termina obtención del grupo

// Función para eliminar la foto del alumno
function deletePhoto() {
    let delete_url = `${base_url}/students/resources/delete_photo`
    deleteInput(delete_url).then((data) => {
        if (data.errors === undefined) {
            $('#photo').remove()
            $('#delete_photo_btn').remove()
        }
    })
}

// Tabla de cursos y calificaciones
document.addEventListener('DOMContentLoaded', function (e) {
    coursesTable = new Tabulator("#courses-table", {
        ajaxURL: `${base_url}/students/resources/courses/${student_id}`,
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
                    let record = {
                        student_id: data.student_id,
                        course_id: data.course_id,
                        score: cell.getValue()
                    }
                    if(data.score_id == null){
                        postJSONData(record, insert_url)
                    } else {
                        record.id = data.score_id
                        postJSONData(record, update_url)
                    }
                    coursesTable.replaceData()
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