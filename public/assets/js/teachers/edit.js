$('#sendBtn').click(function (e) {
    e.preventDefault()
    postForm('teacher-form', `${base_url}/teachers/resources/update`)
})

$('#deleteBtn').click(function (e) {
    e.preventDefault()
    Swal.fire({
        title: 'Deseas eliminar al profesor',
        text: "No se puede restaurar el registro",
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
            deleteJSON(data, `${base_url}/teachers/resources/delete`).then(() => {
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
                window.location = `${base_url}/teachers`
            })
        }
    })
})