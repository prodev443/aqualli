<?php 
$this->setVar('title', 'Lista');
$this->setVar('pagetitle', 'Alumnos');
$this->setVar('css_styles', array(
    'assets/libs/tabulator/css/tabulator_bootstrap3.min.css',
    'assets/libs/tabulator/css/tabulator_custom.css',

));
$this->setVar('scripts', array(
    'assets/libs/tabulator/js/tabulator.min.js',
    'assets/js/students/list.js',
));
?>
<?= $this->extend('layouts/main');?>
<?= $this->section('content');?>
<div class="row">
    
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <a type="button" class="btn btn-info waves-effect btn-label waves-light" href="<?=base_url('students/create')?>">
                    <i class='bx bx-plus label-icon'></i></i> Registrar Alumno
                </a>
                <br><br>
                <!-- tabulator -->
                <div class="row col-12 table-responsive">
                    <div id="students_table"></div>
                </div>                

            </div>
        </div>
    </div> <!-- end col -->
</div>
<?= $this->endSection(); ?>