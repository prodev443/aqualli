// Alumnos
let base_url = window.location.origin

// Obtención del grupo
let group_id = document.getElementById('group_id-data').dataset.group_id
let url = `${base_url}/groups/resources/get/${group_id}`

fetch(url).then((response) => {
    return response.json()
}).then((group) => {
    document.getElementById('group').setAttribute('value', group.name)
})
// Termina obtención del grupo

function deletePhoto() {
    let delete_url = `${base_url}/students/resources/delete_photo`
    deleteInput(delete_url).then((data) => {
        if (data.errors === undefined) {
            $('#photo').remove()
            $('#delete_photo_btn').remove()
        }
    })
}