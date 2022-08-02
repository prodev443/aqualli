<?php 
$this->setVar('title', 'Lista');
$this->setVar('pagetitle', 'Cursos');
$this->setVar('css_styles', array(
    'assets/libs/tabulator/css/tabulator_bootstrap3.min.css',
    'assets/libs/tabulator/css/tabulator_custom.css',
    'assets/libs/sweetalert2/sweetalert2.min.css'

));
$this->setVar('scripts', array(
    'assets/libs/tabulator/js/tabulator.min.js',
    'assets/libs/sweetalert2/sweetalert2.min.js',
));
?>
<?= $this->extend('layouts/main');?>
<?= $this->section('content');?>
<div class="row">
    
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <a type="button" class="btn btn-info waves-effect btn-label waves-light" href="<?=base_url('courses/create')?>">
                    <i class='bx bx-plus label-icon'></i></i> Nuevo Curso
                </a>
                <br><br>
                <!-- tabulator -->
                <div class="row col-12 table-responsive">
                    <div id="courses_table"></div>
                </div>                

            </div>
        </div>
    </div> <!-- end col -->
</div>

<script>
    let courses_table;
    let current_course_id;

    // Tabla
    $(document).ready(() => {
        courses_table = new Tabulator("#courses_table", {
            ajaxURL: "<?=esc(base_url('courses/resources/get'),'js')?>",
            layout: "fitDataFill",
            pagination:true,
            paginationSize:10,
            columns: [
                {
                    title: "Código",
                    field: "code",
                    headerFilter:"input",
                    formatter:function(cell){
                        let base_url = '<?=base_url('courses/detail')?>'
                        let id = cell.getRow().getData().id
                        let html = '<a href="'+base_url + '/' + id +'" style="color: blue;">' + cell.getValue() + '</a>'
                        return html
                    },
                },
                {
                    title: "Curso",
                    field: "name",
                    headerFilter:"input",
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
</script>
<?= $this->endSection(); ?>