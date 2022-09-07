let students_table;

$(document).ready(() => {
    students_table = new Tabulator("#students_table", {
        ajaxURL: `${base_url}/students/resources/get`,
        layout: "fitDataFill",
        pagination: true,
        paginationSize: 20,
        columns: [
            {
                title: "Nombre",
                field: "first_name",
                headerFilter: "input",
                formatter: function (cell) {
                    let url = `${base_url}/students/detail`
                    let id = cell.getRow().getData().id
                    return `<a href="${url}/${id}" style="color: blue;">${cell.getValue()}</a>`
                },
            },
            {
                title: "Apellido P.",
                field: "last_name",
                headerFilter: "input",
            },
            {
                title: "Apellido M.",
                field: "second_last_name",
                headerFilter: "input",
            },
            {
                title: "Correo",
                field: "email",
                hozAlign: "left",
                headerFilter: "input",
                formatter: function (cell) {
                    return `<a href="mailto:${cell.getValue()}">${cell.getValue()}</a>`
                }
            },
            {
                title: "Teléfono",
                field: "phone_number",
                hozAlign: "left",
                headerFilter: "input"

            },
            {
                title: "Móvil",
                field: "mobile_number",
                hozAlign: "left",
                headerFilter: "input"

            },
            {
                title: "Activo",
                field: "is_active",
                formatter: "tickCross",
                hozAlign: "center",
                headerFilter: "tickCross",
                headerFilterParams: { "tristate": true },
                headerFilterEmptyCheck: function (value) { return value === null },
            },
        ],
        locale: true,
        langs: {
            "es-mx": {
                "columns": {
                    "name": "Nombre", //replace the title of column name with the value "Name"
                },
                "data": {
                    "loading": "Cargando", //data loader text
                    "error": "Error", //data error text
                },
                "pagination": {
                    "first": "Primera", //text for the first page button
                    "last": "ültima",
                    "prev": "Anterior",
                    "next": "Siguiente",
                    "counter": {
                        "showing": "Mostrando",
                        "of": "de",
                        "rows": "registros",
                        "pages": "páginas",
                    }
                },
            }
        },
    });
})