<?php
$this->setVar('title', 'Detalle');
$this->setVar('pagetitle', 'Profesores');
$this->setVar('css_styles', array());
$this->setVar('scripts', array(
    'assets/js/teachers/detail.js'
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
                <input type="hidden" id="teacher-id" value="<?= $teacher['id'] ?>">
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <a class="btn btn-success btn-label" href="<?= base_url('teachers/edit/'.$teacher['id']) ?>">
                                <i class="bx bxs-pencil label-icon"></i> Editar
                            </a>&nbsp;
                            <?php if (! empty($teacher['photo_path'])): ?>
                            <button id="deletePhotoBtn" type="button" class="btn btn-danger btn-label">
                                <i class="bx bxs-trash label-icon"></i>Eliminar fotografía
                            </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php if (! empty($teacher['photo_path'])): ?>
                <div class="row" id="photo">
                    <div class="col-md-3">
                        <img src="<?= base_url('teachers/resources/getphoto/'.$teacher['id'])?>" class="img-thumbnail" onerror="this.style.display='none'" width="75px">
                    </div>
                </div>
                <?php endif; ?>
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="first_name" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" value="<?=$teacher['first_name']?>" readonly >
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="last_name" class="form-label">Apellidos Paterno</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" value="<?=$teacher['last_name']?>" readonly >
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="second_last_name" class="form-label">Apellido Materno</label>
                            <input type="text" class="form-control" id="second_last_name" name="second_last_name" value="<?=$teacher['second_last_name']?>" readonly >
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="address_line" class="form-label">Dirección</label>
                            <textarea class="form-control" id="address_line" name="address_line"  readonly ><?=$teacher['address_line']?></textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="address_postal_code" class="form-label">C.P.</label>
                            <input type="text" class="form-control" id="address_postal_code" name="address_postal_code" value="<?=$teacher['address_postal_code']?>" readonly >
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="address_city" class="form-label">Ciudad</label>
                            <input type="text" class="form-control" id="address_city" name="address_city" value="<?=$teacher['address_city']?>" readonly >
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="mobile_number" class="form-label">Móvil</label>
                            <input type="tel" class="form-control" id="mobile_number" name="mobile_number" value="<?=$teacher['mobile_number']?>" readonly >
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="phone_number" class="form-label">Teléfono</label>
                            <input type="tel" class="form-control" id="phone_number" name="phone_number" value="<?=$teacher['phone_number']?>" readonly >
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?=$teacher['email']?>" readonly >
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="birthdate" class="form-label">Fecha de nacimiento</label>
                            <input type="date" class="form-control" id="birthdate" name="birthdate" value="<?=$teacher['birthdate']?>" readonly >
                        </div>
                    </div>
                </div>

                <div id="cv-container" class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="cv" class="form-label">Currículum Vitae</label>
                            <?php if (! empty($teacher['cv_path'])) : ?>
                                <div id="cv" class="d-flex">
                                    <a type="button" href="<?= base_url('teachers/resources/getcv/'.$teacher['id']) ?>" class="btn btn-info btn-label">
                                        <i class="bx bx-file label-icon"></i> Descargar CV
                                    </a>&nbsp;
                                    <button id="deleteCvBtn" type="button" class="btn btn-danger btn-label">
                                        <i class="bx bxs-trash label-icon"></i> Eliminar CV
                                    </button>
                                </div>
                            <?php else : ?>
                                <p class="form-control">Archivo no disponible</p>
                            <?php endif ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="mb-3">
                        <input type="checkbox" class="form-check-input" name="is_active" <?=($teacher['is_active'] == 1) ? 'checked' : ''?> disabled>
                        <label for="is_active" class="form-label">Activo</label>
                    </div>
                </div>

            </form>
        </div>
        <!-- end card body -->
    </div>
</div>
<?= $this->endSection(); ?>