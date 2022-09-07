/**
 * Init script
 * View: app\Views\courses\edit.php
 */

// Botón de actualización
$('#course-form').submit(function(e) {
    e.preventDefault()
    url = `${base_url}/courses/resources/insert`
    postForm('course-form', url, true, function() {
        window.location = `${base_url}/courses`
    })
})