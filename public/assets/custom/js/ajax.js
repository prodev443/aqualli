let csrfname = null // Nombre del Token
let csrftoken = null; // Hash del Token
let csrfheader = null; // Nombre de cabecera del token

// Esta función debe ejecutarse primero y solo una ocasión para obtener el primer token
function tokenize(name, header, token) {
    csrfname = name
    csrfheader = header
    csrftoken = token
}

function serializeFormData(form_id) {
    let data = $(form_id).serializeArray()
    let form_data = new FormData()
    $.each(data, function () {
        form_data.append(this.name, this.value || "")
    });
    return form_data
}

function postReq(data, post_url, dataType = 'text json') {
    return $.ajax(
        post_url, {
        method: 'post',
        data: data,
        dataType: dataType,
    }
    ).done(function (data) {
        csrftoken = data.token;
        return Promise.resolve(data)
    }).fail(function (jqXHR, textStatus, errorThrown) {
        return Promise.reject(textStatus)
    })
}

/** Envío POST de JSON
 * Description
 * @param {JSON} data
 * @param {string} post_url
 * @returns {object} Promise
 */
function postJSONData(data, post_url, success_title = 'Datos guardados', success_text = 'Actualización existosa') {
    data[csrfname] = csrftoken
    return postReq(data, post_url).then((data) => {
        if (data.errors !== undefined) {
            for (var i in data.errors) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.errors[i],
                })
            }
        } else {
            Swal.fire({
                icon: 'success',
                title: success_title,
                text: success_text,
            })
        }
        return Promise.resolve(data)
    }).catch((textStatus) => {
        return Promise.reject(textStatus)
    })
}

/**
 * Eliminación por DELETE
 * @param {JSON} data
 * @param {string} delete_url
 * @returns {object} Promise
 */
function deleteJSONData(data, delete_url) {
    return new Promise((resolve, reject) => {
        let xheaders = { 'X-Requested-With': 'XMLHttpRequest' }
        xheaders[csrfheader] = csrftoken
        const request = () => {
            return new Promise((resolve, reject) => {
                $.ajax(
                    delete_url,
                    {
                        method: 'delete',
                        headers: xheaders,
                        data: data,
                        success: function (data, status) {
                            csrftoken = data.token;
                            resolve(data)
                        },
                        error: function (jqXHR, textStatus) {
                            console.log(jqXHR)
                            console.log(textStatus);
                        }
                    }
                )
            })
        }

        Swal.fire({
            title: '¿Quieres eliminar?',
            text: "¡No podrás recuperar la información!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {
                request().then((data) => {
                    if (data.errors !== undefined) {
                        for (var i in data.errors) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: data.errors[i],
                            })
                        }
                        reject(data)
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Datos guardados',
                            text: 'Eliminación existosa',
                        })
                        resolve(data)
                    }
                })
            } else {
                resolve(false) // Indica que se completó la solicitud sin eliminar datos
            }
        })
    })
}

/** Envío POST de FormData
 * Description
 * @param {FormData} data
 * @param {string} post_url
 * @returns {object} Promise
 */
function postData(data, post_url) {
    return new Promise((resolve, reject) => {

        data.append(csrfname, csrftoken)

        const request = () => {
            return new Promise((resolve, reject) => {
                $.ajax(
                    post_url, {
                    method: 'post',
                    data: data,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function (data, status) {
                        csrftoken = data.token;
                        resolve(data)
                    },
                    error: function (jqXHR, textStatus) {
                        console.log(textStatus);
                    }
                }
                )
            })
        }

        request().then((data) => {
            if (data.errors !== undefined) {
                for (var i in data.errors) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.errors[i],
                    })
                }
                reject()
            } else {
                Swal.fire({
                    icon: 'success',
                    title: 'Datos guardados',
                    text: 'Actualización existosa',
                })
                resolve()
            }
        })
    })
}

/**
 * Eliminación por DELETE
 * @param {object} data
 * @param {string} delete_url
 * @returns {object} Promise
 */
function deleteData(data, delete_url) {
    return new Promise((resolve, reject) => {
        let xheaders = { 'X-Requested-With': 'XMLHttpRequest' }
        xheaders[csrfheader] = csrftoken
        const request = () => {
            return new Promise((resolve, reject) => {
                $.ajax(
                    delete_url,
                    {
                        method: 'delete',
                        headers: xheaders,
                        data: data,
                        success: function (data, status) {
                            csrftoken = data.token;
                            resolve(data)
                        },
                        error: function (jqXHR, textStatus) {
                            console.log(jqXHR)
                            console.log(textStatus);
                        }
                    }
                )
            })
        }

        Swal.fire({
            title: '¿Quieres eliminar?',
            text: "¡No podrás recuperar la información!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {
                request().then((data) => {
                    if (data.errors !== undefined) {
                        for (var i in data.errors) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: data.errors[i],
                            })
                        }
                        reject(data)
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Datos guardados',
                            text: 'Eliminación existosa',
                        })
                        resolve(data)
                    }
                })
            }
        })
    })
}

/**
 * Envía un formulario FormData por POST
 * @param {string} form_id '1'
 * @param {string} post_url '<?= base_url('') ?>'
 * @param {string} return_url '<?= base_url('') ?>'
 */
function postForm(form_id, post_url, return_url) {
    let data = new FormData(document.getElementById(form_id))
    postData(data, post_url).then(() => {
        if (return_url !== '') {
            window.location = return_url
        }
    })
}

// Envía un formulario en formato JSON por POST
function postJSONForm(form_id, post_url, return_url = null) {
    let data = $(form_id).serializeArray();
    const json = {};
    $.each(data, function () {
        json[this.name] = this.value || "";
    });

    json[csrfname] = csrftoken

    const request = () => {
        return new Promise((resolve, reject) => {
            $.ajax(
                post_url,
                {
                    method: 'post',
                    data: json,
                    success: function (data, status) {
                        csrftoken = data.token;
                        resolve(data)
                    },
                    error: function (jqXHR, textStatus) {
                        console.log(jqXHR);
                        console.log(textStatus);
                    }
                }
            )
        })
    }

    request().then((data) => {
        if (data.errors !== undefined) {
            for (var i in data.errors) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.errors[i],
                })
            }
        } else {
            Swal.fire({
                icon: 'success',
                title: 'Datos guardados',
                text: 'Actualización existosa',
            })
            if (return_url !== null) {
                window.setTimeout(function () {
                    window.location = return_url;
                }, 1000)
            }
        }
    })
}

/**
 * Envía el valor de un input por DELETE para borrarlo
 * @param {string} delete_url '<?= base_url('') ?>'
 * @param {string} return_url '<?= base_url('') ?>'
 * @param {string} id_field='id'
 */
function deleteInput(delete_url, return_url = '', id_field = 'id') {

    return new Promise((resolve, reject) => {
        let id = document.getElementById(id_field).value;
        data = {
            id: id
        }
        deleteData(data, delete_url).then((data) => {
            if (return_url !== '') {
                window.location = return_url
            }
            resolve(data)
        })
    })

}