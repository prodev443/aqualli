// Botón de creación
$('#group-form').submit(function(e) {
    e.preventDefault()
    url = `${base_url}/groups/resources/insert`
    postForm('group-form', url, true, function() {
        window.location = `${base_url}/groups`
    })
})