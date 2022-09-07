/**
 * Init script
 * View: app\Views\courses\edit.php
 * Dependencies: Select2
 */

let course = document.getElementById('course-data').dataset

// Botón de actualización
$('#course-form').submit(function (e) {
    e.preventDefault()
    url = `${base_url}/courses/resources/update`
    postForm('course-form', url, true, function () {
        window.location = `${base_url}/courses/detail/${course.id}`
    })
})

$('#deleteBtn').click(function (e) {
    e.preventDefault()
    Swal.fire({
        title: 'Deseas eliminar al alumno',
        text: "No se puede restaurar el registro",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            let url = `${base_url}/courses/resources/delete`

            let sendJSON = {
                id: course.id
            }

            deleteJSON(sendJSON, url).then(() => {
                Swal.fire({
                    title: 'Alumno eliminado',
                    icon: 'success',
                    text: 'Proceso completado',
                    confirmButtonText: 'Ok',
                })
                window.location = `${base_url}/courses`
            }).catch(() => {
                Swal.fire({
                    title: 'Error',
                    icon: 'error',
                    text: 'Ocurrió un error del sistema',
                    confirmButtonText: 'Ok',
                })
            })
        }
    })
})