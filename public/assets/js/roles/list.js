/**
 * Inicializa la vista de roles
 * Vista: app\Views\system\list_roles.php
 */

let base_url = window.location.origin
let rolesTable = new Tabulator("#roles-table", {
    ajaxURL: `${base_url}/system/resources/roles`,
    layout: "fitDataFill",
    pagination: true,
    paginationSize: 20,
    columns: [
        {
            title: "Rol",
            field: "role",
            headerFilter: "input",
            formatter: function (cell) {
                let id = cell.getRow().getData().id
                let url = `${base_url}/system/roles/${id}`
                return html = `<a href="${url}" style="color: blue;">${cell.getValue()}</a>`
            },
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