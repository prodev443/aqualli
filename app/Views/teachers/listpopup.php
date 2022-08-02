<?php 
$this->setVar('title', 'Lista');
$this->setVar('pagetitle', 'Profesores');
$this->setVar('css_styles', array(
    'assets/libs/tabulator/css/tabulator_bootstrap3.min.css',
    'assets/libs/tabulator/css/tabulator_custom.css',
    'assets/libs/sweetalert2/sweetalert2.min.css'

));
$this->setVar('scripts', array(
    'assets/libs/tabulator/js/tabulator.min.js',
    'assets/libs/sweetalert2/sweetalert2.min.js',
    'assets/custom/js/table_library.js', // Funciones paqra tabulator
));
?>
<?= $this->extend('layouts/popup');?>
<?= $this->section('content');?>
<div class="row">
    
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <a type="button" class="btn btn-info waves-effect btn-label waves-light" onclick="selectRows(teachers_table, windowCallback)">
                    <i class='bx bx-plus label-icon'></i></i> Seleccionar
                </a>
                <br><br>
                <!-- tabulator -->
                <div class="row col-12 table-responsive">
                    <div id="teachers-table"></div>
                </div>                

            </div>
        </div>
    </div> <!-- end col -->
</div>
<script>
    let teachers_table;
    let current_teacher_id;

    // Tabla
    $(document).ready(() => {
        teachers_table = new Tabulator("#teachers-table", {
            ajaxURL: "<?=esc(base_url('teachers/resources/get'),'js')?>",
            layout: "fitDataFill",
            pagination:true,
            paginationSize:10,
            maxHeight: '400',
            columns: [
                {formatter:"rowSelection", titleFormatter:"rowSelection", headerSort:false},
                {
                    title: "Nombre",
                    field: "first_name",
                    headerFilter:"input",
                },
                {
                    title: "Apellido",
                    field: "last_name",
                    headerFilter:"input",
                },
                {
                    title: "Correo",
                    field: "email",
                    hozAlign: "center",
                    headerFilter:"input"

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
        });
    })

    function windowCallback(data){
        window.close(); // Close the current popup
        window.opener.teachersPopupCallback(data); //Call callback function 
    }
</script>
<?= $this->endSection(); ?>