<?php 
$this->setVar('title', 'Registro');
$this->setVar('pagetitle', 'Cursos');
$this->setVar('css_styles', array());
$this->setVar('scripts', array(
    'assets/js/courses/create.js',
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
            <form id="course-form">
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
                    <button type="submit" class="btn btn-success btn-label">
                        <i class="bx bxs-save label-icon"></i>Registrar
                    </button>
                </div>
            </form>
        </div>
        <!-- end card body -->
    </div>
</div>
<?= $this->endSection(); ?>