/**
 * Init script
 * View: app\Views\students\edit.php
 * Dependencies: Select2
 */

let base_url = window.location.origin

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

// Obtención del grupo
let group_id = document.getElementById('group_id-data').dataset.group_id
let url = `${base_url}/groups/resources/get/${group_id}`

fetch(url).then((response) => {
    return response.json()
}).then((group) => {
    let groupIdSelect = $('#group_id')
    let option = new Option(group.name, group.id, true, true);
    groupIdSelect.append(option).trigger('change');
})
// Termina obtención del grupo