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
    'assets/js/groups/list.js',
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
                <div class="row col-12">
                    <div id="groups-container" class="d-flex flex-wrap gap-2"></div>
                </div>                

            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>