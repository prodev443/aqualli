/**
 * Init script
 * View: app\Views\students\edit.php
 * Dependencies: Select2
 */

// Botón de actualización
$('#saveBtn').click(function(e) {
    e.preventDefault()
    url = `${base_url}/students/resources/insert`
    postForm('student-form', url, true, function() {
        window.location = `${base_url}/students`
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