$('#teacher-form').submit(function (e) {
    e.preventDefault()
    postForm('teacher-form', `${base_url}/teachers/resources/insert`, true, function () {
        window.location = `${base_url}/teachers`
    })
})