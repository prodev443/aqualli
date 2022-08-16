<?php 
$this->setVar('title', 'Detalle');
$this->setVar('pagetitle', 'Grupo');
$this->setVar('css_styles', array(
    'assets/libs/sweetalert2/sweetalert2.min.css',
    'assets/libs/fullcalendar/main.min.css',
    'assets/libs/bootstrap/icons/bootstrap-icons.css',
    'assets/libs/select2/css/select2.min.css',
    'assets/libs/select2/bootstrap-5-theme/select2-bootstrap-5-theme.min.css',
    'assets/libs/select2/bootstrap-5-theme/select2-bootstrap-5-theme.rtl.min.css',

));
$this->setVar('scripts', array(
    'assets/libs/sweetalert2/sweetalert2.min.js',
    'assets/libs/fullcalendar/main.min.js',
    'assets/libs/select2/js/select2.min.js',
    'assets/custom/js/ajax.js', // AJAX requests con token
));
?>
<?= $this->extend('layouts/main');?>
<?= $this->section('content');?>
<!-- Formulario Alumno -->
<div class="row">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="card-title mb-4">Datos del Grupo</h4>
                </div>
                <div class="col-sm-6">
                    <div class="d-flex flex-row-reverse bd-highlight">
                        <div class="p-2 bd-highlight">
                            <a href="<?=base_url('groups')?>"><i class="bx bx-arrow-back"></i> Regresar</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Nav tabs -->
            <ul class="nav nav-tabs" id="nav-tabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="details-tab" data-bs-toggle="tab" data-bs-target="#details"
                        type="button" role="tab" aria-controls="details" aria-selected="true">Detalles</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="schedule-tab" data-bs-toggle="tab" data-bs-target="#schedule"
                        type="button" role="tab" aria-controls="schedule" aria-selected="true">Horario</button>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane active" id="details" role="tabpanel" aria-labelledby="details-tab">
                    <br>
                    <?= $this->include('groups/detail/detail_form.php'); ?>
                </div>
                <div class="tab-pane" id="schedule" role="tabpanel" aria-labelledby="schedule-tab">
                    <br>
                    <?= $this->include('groups/detail/schedule.php'); ?>
                </div>
            </div>
        </div>
        <!-- end card body -->
    </div>
</div>
<script>

    $(document).ready(
        function () {
            tokenize('<?=csrf_token()?>', '<?=csrf_header()?>', '<?=csrf_hash()?>')
        }
    )

</script>
<?= $this->endSection(); ?>