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