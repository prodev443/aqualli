// Actualización
$('#group-form').submit(function(e) {
    e.preventDefault()
    let group = document.getElementById('group-data').dataset
    url = `${base_url}/groups/resources/update`
    postForm('group-form', url, true, function() {
        window.location = `${base_url}/groups/detail/${group.id}`
    })
})