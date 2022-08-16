<?php 
$this->setVar('title', 'Lista');
$this->setVar('pagetitle', 'Grupos');
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
                <a type="button" class="btn btn-info waves-effect btn-label waves-light" href="<?=base_url('groups/create')?>">
                    <i class='bx bx-plus label-icon'></i></i> Nuevo Grupo
                </a>
                <br><br>
                <!-- tabulator -->
                <div class="row col-12 table-responsive">
                    <div id="groups_table"></div>
                </div>                

            </div>
        </div>
    </div>
</div>

<script>
    let groups_table;
    let current_course_id;

    // Tabla
    $(document).ready(() => {
        groups_table = new Tabulator("#groups_table", {
            ajaxURL: "<?=esc(base_url('groups/resources/get'),'js')?>",
            layout: "fitDataFill",
            pagination:true,
            paginationSize:10,
            columns: [
                {
                    title: "Grupo",
                    field: "name",
                    headerFilter:"input",
                    formatter:function(cell){
                        let base_url = '<?=base_url('groups/detail')?>'
                        let id = cell.getRow().getData().id
                        let html = '<a href="'+base_url + '/' + id +'" style="color: blue;">' + cell.getValue() + '</a>'
                        return html
                    },
                },
            ],
        });
    })
</script>
<?= $this->endSection(); ?>