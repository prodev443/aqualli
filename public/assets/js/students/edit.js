/**
 * Init script
 * View: app\Views\students\edit.php
 * Dependencies: Select2
 */

// Obtención del grupo
let student = document.getElementById('student-data').dataset
let group = document.getElementById('group-data').dataset

fetch(`${base_url}/groups/resources/get/${group.id}`).then((response) => {
    return response.json()
}).then((group) => {
    let groupIdSelect = $('#group_id')
    let option = new Option(group.name, group.id, true, true);
    groupIdSelect.append(option).trigger('change');
})
// Termina obtención del grupo

// Botón de actualización
$('#updateBtn').click(function(e) {
    e.preventDefault()
    url = `${base_url}/students/resources/update`
    postForm('student-form', url, true, function() {
        window.location = `${base_url}/students/detail/${student.id}`
    })
})

// Botón de eliminación
$('#deleteBtn').click(function(e) {
    e.preventDefault()
    let url = `${base_url}/students/resources/delete`
    
    let sendJSON = {
        id: student.id
    }
    
    deleteJSON(sendJSON, url).then(() =>{
        Swal.fire({
            title: 'Alumno eliminado',
            icon: 'success',
            text: 'Proceso completado',
            confirmButtonText: 'Ok',
        })
        window.location = `${base_url}/students`
    }).catch(() => {
        Swal.fire({
            title: 'Error',
            icon: 'error',
            text: 'Ocurrió un error del sistema',
            confirmButtonText: 'Ok',
        })
    })
})

document.addEventListener('DOMContentLoaded', function(){
    $('#group_id').select2({
        theme: 'bootstrap-5',
        ajax: {
            url: `${base_url}/groups/resources/select2`,
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
})