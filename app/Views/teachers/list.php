<?php 
$this->setVar('title', 'Lista');
$this->setVar('pagetitle', 'Profesores');
$this->setVar('css_styles', array(
    'assets/libs/tabulator/css/tabulator_bootstrap3.min.css',
    'assets/libs/tabulator/css/tabulator_custom.css',

));
$this->setVar('scripts', array(
    'assets/libs/tabulator/js/tabulator.min.js',
));
?>
<?= $this->extend('layouts/main');?>
<?= $this->section('content');?>
<div class="row">
    
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <a type="button" class="btn btn-info waves-effect btn-label waves-light" href="<?=base_url('teachers/create')?>">
                    <i class='bx bx-plus label-icon'></i></i>Profesor
                </a>
                <br><br>
                <!-- tabulator -->
                <div class="row col-12 table-responsive">
                    <div id="teachers_table"></div>
                </div>                

            </div>
        </div>
    </div> <!-- end col -->
</div>
<script>
    let teachers_table = null;

    // Tabla
    $(document).ready(() => {
        teachers_table = new Tabulator("#teachers_table", {
            ajaxURL: "<?=esc(base_url('teachers/resources/get'),'js')?>",
            layout: "fitDataFill",
            pagination:true,
            paginationSize:10,
            columns: [
                {
                    title: "Nombre",
                    field: "first_name",
                    headerFilter:"input",
                    formatter:function(cell){
                        let id = cell.getRow().getData().id
                        let html = '<a style="color: blue;" href="<?= esc(base_url('teachers/detail')) ?>/'+ id +'">' + cell.getValue() + '</a>'
                        return html
                    },
                },
                {
                    title: "Apellido P.",
                    field: "last_name",
                    headerFilter:"input",
                },
                {
                    title: "Apellido M.",
                    field: "second_last_name",
                    headerFilter:"input",
                },
                {
                    title: "Correo",
                    field: "email",
                    hozAlign: "center",
                    headerFilter:"input",
                    formatter: function(cell){
                        return '<a href="mailto:'+cell.getValue()+'">'+cell.getValue()+"</a>"
                    }
                },
                {
                    title: "Teléfono",
                    field: "phone_number",
                    hozAlign: "center",
                    headerFilter:"input"

                },
                {
                    title: "Móvil",
                    field: "mobile_number",
                    hozAlign: "center",
                    headerFilter:"input"

                },
                {
                    title: "Activo",
                    field: "is_active",
                    formatter:"tickCross",
                    hozAlign: "center",
                    headerFilter:"tickCross",
                    headerFilterParams:{"tristate":true},
                    headerFilterEmptyCheck:function(value){return value === null},
                },
            ],
            locale:true,
            langs:{
                "es-mx":{
                    "columns":{
                        "name":"Nombre", //replace the title of column name with the value "Name"
                    },
                    "data":{
                        "loading":"Cargando", //data loader text
                        "error":"Error", //data error text
                    },
                    "pagination":{
                        "first":"Primera", //text for the first page button
                        "last":"Última",
                        "prev":"Anterior",
                        "next":"Siguiente",
                        "counter":{
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
</script>
<?= $this->endSection(); ?>