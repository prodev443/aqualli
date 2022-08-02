<?php
$this->setVar('title', 'Edición');
$this->setVar('pagetitle', 'Profesores');
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
    'assets/custom/js/upper.js', // Mayúsculas automáticas
));
?>
<?= $this->extend('layouts/main');?>
<?= $this->section('content');?>
<!-- Formulario Profesor -->
<div class="row">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="card-title mb-4">Datos del Profesor</h4>
                </div>
                <div class="col-sm-6">
                    <div class="d-flex flex-row-reverse bd-highlight">
                        <div class="p-2 bd-highlight">
                            <a href="<?=base_url('teachers')?>"><i class="bx bx-arrow-back"></i> Regresar</a>
                        </div>
                    </div>
                </div>
            </div>
            <form id="teacher-form">
                <input type="hidden" id="id" name="id" value="<?=$teacher['id']?>">
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="first_name" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" value="<?=$teacher['first_name']?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="last_name" class="form-label">Apellido Paterno</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" value="<?=$teacher['last_name']?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="second_last_name" class="form-label">Apellido Materno</label>
                            <input type="text" class="form-control" id="second_last_name" name="second_last_name" value="<?=$teacher['second_last_name']?>">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="address_line" class="form-label">Dirección</label>
                            <textarea class="form-control" id="address_line" name="address_line" ><?=$teacher['address_line']?></textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="address_postal_code" class="form-label">C.P.</label>
                            <input type="text" class="form-control" id="address_postal_code" name="address_postal_code" value="<?=$teacher['address_postal_code']?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="address_city" class="form-label">Ciudad</label>
                            <input type="text" class="form-control" id="address_city" name="address_city" value="<?=$teacher['address_city']?>">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="mobile_number" class="form-label">Móvil</label>
                            <input type="tel" class="form-control" id="mobile_number" name="mobile_number" value="<?=$teacher['mobile_number']?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="phone_number" class="form-label">Teléfono</label>
                            <input type="tel" class="form-control" id="phone_number" name="phone_number" value="<?=$teacher['phone_number']?>">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?=$teacher['email']?>">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="birthdate" class="form-label">Fecha de nacimiento</label>
                            <input type="date" class="form-control" id="birthdate" name="birthdate" value="<?=$teacher['birthdate']?>">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="cv" class="form-label">Fotografía <?= !empty($teacher['photo_path']) ? "| Este profesor tiene una foto" : "" ?></label>
                            <input type="file" class="form-control" id="photo" name="photo">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="cv" class="form-label">Currículum Vitae <?= !empty($teacher['cv_path']) ? "| Actual: {$teacher['cv_name']}" : "" ?></label>
                            <input type="file" class="form-control" id="cv" name="cv">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="mb-3">
                        <input type="checkbox" class="form-check-input" name="is_active" <?=($teacher['is_active'] == 1) ? 'checked' : ''?> value="1">
                        <label for="is_active" class="form-label">Activo</label>
                    </div>
                </div>

                <div>
                    <button type="button" onclick="postForm('teacher-form', '<?=esc(base_url('teachers/resources/update'),'js')?>', '<?=esc(base_url('teachers'),'js')?>')" class="btn btn-success">
                        <i class="bx bxs-save"></i> Guardar
                    </button>
                    <button type="button" onclick="deleteInput('<?=esc(base_url('teachers/resources/delete'),'js')?>', '<?=esc(base_url('teachers'),'js')?>')" class="btn btn-danger">
                        <i class="bx bx-trash"></i> Eliminar
                    </button>
                </div>
            </form>
        </div>
        <!-- end card body -->
    </div>
</div>
<script>

    $(document).ready(function() {
        tokenize('<?=csrf_token()?>', '<?=csrf_header()?>', '<?=csrf_hash()?>')
    })


</script>
<?= $this->endSection(); ?>