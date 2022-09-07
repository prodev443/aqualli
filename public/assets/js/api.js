let base_url = window.location.origin
let csrf = null
document.addEventListener('DOMContentLoaded', function (e) {
    csrf = document.getElementById('csrf').dataset
})

/**
 * HTTP POST FormData
 * @param {FormData} sendData
 * @param {string} url
 * @returns {any}
 */
function postData(sendData, url) {
    return new Promise((resolve, reject) => {
        let status = true
        sendData.append(csrf.name, csrf.hash)
        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: url,
            data: sendData,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 800000,
            error: function (e) {
                console.log("ERROR : ", e);
                status = false
            }
        }).done(function (data, textStatus, jqXHR) {
            csrf.hash = jqXHR.responseJSON.token
            resolve()
        }).fail(function (jqXHR, textStatus, errorThrown) {
            csrf.hash = jqXHR.responseJSON.token
            reject()
        })
    })
}

/**
 * HTTP DELETE JSON
 * @param {object} sendJSON
 * @param {string} url
 * @returns {any}
 */
function deleteJSON(sendJSON, url) {
    return new Promise((resolve, reject) => {
        let xheaders = { 'X-Requested-With': 'XMLHttpRequest' }
        xheaders[csrf.header] = csrf.hash
        $.ajax({
            type: "DELETE",
            url: url,
            headers: xheaders,
            data: sendJSON,
            cache: false,
            timeout: 800000,
            error: function (e) {
                console.log("ERROR : ", e);
            }
        }).done(function (data, textStatus, jqXHR) {
            csrf.hash = jqXHR.responseJSON.token
            resolve()
        }).fail(function (jqXHR, textStatus, errorThrown) {
            csrf.hash = jqXHR.responseJSON.token
            reject()
        })
    })
}

function postForm(formId, url, alert = true, callback = null) {
    let form = document.getElementById(formId)
    let sendData = new FormData(form)
    postData(sendData, url).then(() => {
        if(alert) {
            Swal.fire({
                title: 'Solicitud completada',
                icon: 'success',
                text: 'Se completó el procesamiento de datos',
                confirmButtonText: 'Ok',
            })
        }
    }).catch(() => {
        if(alert) {
            Swal.fire({
                title: 'Error',
                icon: 'success',
                text: 'No se completó el procesamiento de datos',
                confirmButtonText: 'Ok',
            })
        }
    }).finally(() => {
        if (callback instanceof Function) {
            callback()
        }
    })
}

function deleteForm(formId, url, alert = true, callback = null) {
    let form = document.getElementById(formId)
    let sendData = new FormData(form)
    deleteData(sendData, url).then(() => {
        if(alert) {
            Swal.fire({
                title: 'Solicitud completada',
                icon: 'success',
                text: 'Se completó el procesamiento de datos',
                confirmButtonText: 'Ok',
            })
        }
    }).catch(() => {
        if(alert) {
            Swal.fire({
                title: 'Error',
                icon: 'success',
                text: 'No se completó el procesamiento de datos',
                confirmButtonText: 'Ok',
            })
        }
    }).finally(() => {
        if (callback instanceof Function) {
            callback()
        }
    })
}