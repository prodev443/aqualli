/**
 * Init script
 * View: app\Views\students\create.php
 * Dependencies: Select2
 */

let base_url = window.location.origin
$('#group_id').select2({
    theme: 'bootstrap-5',
    ajax: {
        url: `${base_url}/groups/resources/select2`,
        dataType: 'json',
        processResults: function(data) {
            return {
                results: $.map(data, function(item) {
                    return {
                        text: item.name,
                        id: item.id
                    }
                })
            };
        }
    }
});