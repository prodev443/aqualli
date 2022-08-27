<?php 
$this->setVar('title', 'Lista');
$this->setVar('pagetitle', 'Administración de Permisos');
$this->setVar('css_styles', array(
    'assets/libs/tabulator/css/tabulator_bootstrap3.min.css',
    'assets/libs/tabulator/css/tabulator_custom.css',

));
$this->setVar('scripts', array(
    'assets/libs/tabulator/js/tabulator.min.js',
    'assets/js/roles/list.js',
));
?>
<?= $this->extend('layouts/main');?>
<?= $this->section('content');?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Lista de Roles</h4>
                <p class="card-title-desc">Selecciona un Rol para editar sus permisos</p>

                <div id="roles-table"></div>

            </div>
        </div>
    </div> <!-- end col -->
</div>
<?= $this->endSection(); ?>