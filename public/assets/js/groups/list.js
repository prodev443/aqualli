/**
 * Init script
 * Vista: app\Views\groups\list.php
 */
let groupsContainer = document.getElementById('groups-container')

fetch(`${base_url}/groups/resources/get`).then((response) => { 
    return response.json()
}).then((groups) => {
    if (groups.length > 0) {
        // console.log(groups)
        groups.forEach(group => {
            let a = document.createElement('a')
            let span = document.createElement('span')
            span.textContent = `${group.name}`
            let link = `${base_url}/groups/detail/${group.id}`
            a.setAttribute('type', 'button')
            a.setAttribute('class', 'btn btn-primary waves-effect waves-light w-sm')
            a.setAttribute('href', link)
            a.appendChild(span)
            groupsContainer.appendChild(a)
        });
    }
})