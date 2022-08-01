// Obtiene el campo id del las filas seleccionadas
// El campo id proviene de la fuente de datos de tabulator
function selectRows(table, callback){
    // Obtiene los datos actuales de la tabla
    let data = []
    records = table.getSelectedRows()
    records.forEach(element => {
        data.push(element.getData().id)
    });

    if(typeof callback === 'function'){
        callback(data)
    }
}