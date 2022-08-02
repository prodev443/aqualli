<?php 
$this->setVar('title', 'Registro');
$this->setVar('pagetitle', 'Cursos');
$this->setVar('css_styles', array(
    'assets/libs/sweetalert2/sweetalert2.min.css',
    'assets/libs/select2/css/select2.min.css',
    'assets/libs/select2/bootstrap-5-theme/select2-bootstrap-5-theme.min.css',
    'assets/libs/select2/bootstrap-5-theme/select2-bootstrap-5-theme.rtl.min.css',

));
$this->setVar('scripts', array(
    'assets/libs/sweetalert2/sweetalert2.min.js',
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
                    <h4 class="card-title mb-4">Datos del Curso</h4>
                </div>
                <div class="col-sm-6">
                    <div class="d-flex flex-row-reverse bd-highlight">
                        <div class="p-2 bd-highlight">
                            <a href="<?=base_url('courses')?>"><i class="bx bx-arrow-back"></i> Regresar</a>
                        </div>
                    </div>
                </div>
            </div>
            <form id="course_form">
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label id="code_label" for="code" class="form-label">Código</label>
                            <input id="code" name="code" type="text" class="form-control" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                          <label for="name" class="form-label">Nombre</label>
                          <input type="text" class="form-control" name="name" id="name">
                        </div>
                    </div>
                    <div class="col-md-4">
                      <div class="mb-3">
                        <label for="description" class="form-label">Descripción</label>
                        <textarea class="form-control" name="description" id="description" rows="3"></textarea>
                      </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-check mb-3">
                            <input id="is_active" name="is_active" type="checkbox" class="form-check-input" value="" />
                            <label id="is_active_label" class="form-label" for="is_active">Activo</label>
                        </div>
                    </div>
                </div>

                <div>
                    <button type="button" onclick="postForm('course_form', '<?=esc(base_url('courses/resources/insert'),'js')?>', '<?=esc(base_url('courses'),'js')?>')" class="btn btn-success">
                        <i class="bx bxs-save"></i> Registrar
                    </button>
                </div>
            </form>
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