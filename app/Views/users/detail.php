<?php
$this->setVar('title', 'Detalle');
$this->setVar('pagetitle', 'Usuarios');
$this->setVar('css_styles', array(
    'assets/libs/select2/css/select2.min.css',
    'assets/libs/sweetalert2/sweetalert2.min.css'
));
$this->setVar('scripts', array(
    'assets/libs/select2/js/select2.min.js',
    'assets/libs/sweetalert2/sweetalert2.min.js',
    'assets/custom/js/ajax.js',
    'assets/custom/js/popups.js',
));
?>
<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>
<div class="row">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="card-title mb-4">Datos del Usuario</h4>
                </div>
                <div class="col-sm-6">
                    <div class="d-flex flex-row-reverse bd-highlight">
                        <div class="p-2 bd-highlight">
                            <a href="<?=base_url('users')?>"><i class="bx bx-arrow-back"></i> Regresar</a>
                        </div>
                    </div>
                </div>
            </div>

            <form>
                <!-- enlaces -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <a type="button" class="btn btn-success btn-label"
                                href="<?=base_url('users/edit').'/'.$user['id']?>">
                                <i class="mdi mdi-pencil label-icon"></i>&nbsp;Editar
                            </a>&nbsp;
                            <!-- Pendiente la función para mostrar un popup de actualización del password -->
                            <button type="button" class="btn btn-info btn-label" onclick="createPopup('<?= esc(base_url('users/update_password/'.$user['id'])) ?>', 'Actualización de la contraseña', 500, 500)">
                                <i class="bx bxs-key label-icon"></i>&nbsp;Actualizar contraseña
                            </button>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="id" id="id" value="<?=$user['id']?>">
                <div class="row">
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="role_id" class="form-label">Rol</label>
                            <select id="role_id" name="role_id" class="select2-search form-select"
                                data-live-search="true" disabled>
                                <?php
                                    $roles_model = new \App\Models\RolesModel();
                                    $roles = $roles_model->findAll();
                                    foreach($roles as $role):
                                    ?>
                                <?php if($role['id'] == $user['role_id']):?>
                                <option data-tokens="<?=$role['role']?>" value="<?=$role['id']?>" selected>
                                    <?=$role['description']?></option>
                                <?php else:?>
                                <option data-tokens="<?=$role['role']?>" value="<?=$role['id']?>">
                                    <?=$role['description']?></option>
                                <?php endif;?>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="formrow-email-input" class="form-label">Email</label>
                            <input type="email" class="form-control" id="formrow-email-input"
                                placeholder="Correo electrónico" name="email" value="<?=$user['email']?>" disabled>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                          <label for="phone" class="form-label">Teléfono</label>
                          <input type="tel" class="form-control" name="phone" id="phone" value="<?= $user['phone'] ?>" readonly >
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                    <?= $user['is_active'] == 1 ? 'checked' : '' ?> disabled>
                                <label class="form-check-label" for="is_active">
                                    Activo
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- end card body -->
    </div>
    <!-- end card -->
</div>
<script>
$(document).ready(
    function() {
        tokenize('<?=csrf_token()?>', '<?=csrf_header()?>', '<?=csrf_hash()?>')
    }
)
</script>
<?= $this->endSection(); ?>