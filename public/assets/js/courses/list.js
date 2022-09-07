let courses_table;

$(document).ready(() => {
    courses_table = new Tabulator("#courses-table", {
        ajaxURL: `${base_url}/courses/resources/get`,
        layout: "fitDataFill",
        pagination: true,
        paginationSize: 10,
        columns: [
            {
                title: "Código",
                field: "code",
                headerFilter: "input",
                formatter: function (cell) {
                    let url = `${base_url}/courses/detail`
                    let id = cell.getRow().getData().id
                    return `<a href="${url}/${id}" style="color: blue;">${cell.getValue()}</a>`
                },
            },
            {
                title: "Curso",
                field: "name",
                headerFilter: "input",
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
    });
})