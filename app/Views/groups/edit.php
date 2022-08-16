<?php 
$this->setVar('title', 'Editar');
$this->setVar('pagetitle', 'Grupos');
$this->setVar('css_styles', array(
    'assets/libs/sweetalert2/sweetalert2.min.css',

));
$this->setVar('scripts', array(
    'assets/libs/sweetalert2/sweetalert2.min.js',
    'assets/custom/js/ajax.js', // AJAX requests con token
));
?>
<?= $this->extend('layouts/main');?>
<?= $this->section('content');?>
<!-- Formulario Curso -->
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
            <form id="group_form">
              <input type="hidden" name="id" value="<?= $group['id'] ?>">
              <div class="row">
                  <div class="col-md-4">
                      <div class="mb-3">
                        <label for="name" class="form-label">Grupo</label>
                        <input type="text" class="form-control" name="name" id="name" value="<?= $group['name'] ?>">
                      </div>
                  </div>
                  <div class="col-md-4">
                      <div class="mb-3">
                        <label for="observations" class="form-label">Observaciones</label>
                        <textarea class="form-control" name="observations" id="observations" rows="3"><?= $group['observations'] ?></textarea>
                      </div>
                  </div>
                  <div class="col-md-4">
                  </div>
              </div>

              <div>
                  <button type="button"
                      onclick="postForm('group_form', '<?=esc(base_url('groups/resources/update'),'js')?>', '<?=esc(base_url('groups'),'js')?>')"
                      class="btn btn-success">
                      <i class="bx bxs-save"></i> Guardar
                  </button>
              </div>
            </form>
        </div>
        <!-- end card body -->
    </div>
</div>
<script>
$(document).ready(
    function() {
        tokenize('<?=csrf_token()?>', '<?=csrf_header()?>', '<?=csrf_hash()?>')
    }
)
</script>
<?= $this->endSection(); ?>