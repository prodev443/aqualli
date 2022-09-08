teacher = null
// Actualización
$('#group-form').submit(function(e) {
    e.preventDefault()
    let group = document.getElementById('group-data').dataset
    url = `${base_url}/groups/resources/update`
    postForm('group-form', url, true, function() {
        window.location = `${base_url}/groups/detail/${group.id}`
    })
})

document.addEventListener('DOMContentLoaded', function(){
    teacher = document.getElementById('teacher-data').dataset
    fetch(`${base_url}/teachers/resources/get/${teacher.id}`).then((response) => {
        $('#teacher_id').select2({
            theme: 'bootstrap-5',
            ajax: {
                url: `${base_url}/teachers/resources/select2`,
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
        return response.json()
    }).then((teacherA) => {
        let teacherName = `${teacherA.first_name} ${teacherA.last_name} ${teacherA.second_last_name}`
        let option = new Option(teacherName, teacherA.id, true, true);
        $('#teacher_id').append(option).trigger('change');
    })
})