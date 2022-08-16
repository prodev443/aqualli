<?php
$this->setVar('title', 'Crear');
$this->setVar('pagetitle', 'Usuarios');
$this->setVar('css_styles', array(
    'assets/libs/select2/css/select2.min.css',
    'assets/libs/sweetalert2/sweetalert2.min.css',
    'assets/libs/select2/bootstrap-5-theme/select2-bootstrap-5-theme.min.css',
    'assets/libs/select2/bootstrap-5-theme/select2-bootstrap-5-theme.rtl.min.css',
));
$this->setVar('scripts', array(
    'assets/libs/select2/js/select2.min.js',
    'assets/libs/sweetalert2/sweetalert2.min.js',
    'assets/custom/js/ajax.js',
));
?>
<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <h4 class="card-title mb-4">Registro de nuevo usuario</h4>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex flex-row-reverse bd-highlight">
                            <div class="p-2 bd-highlight">
                                <a href="<?=base_url('users')?>"><i class="bx bx-arrow-back"></i> Regresar</a>
                            </div>
                        </div>
                    </div>
                </div>
                <form id="user_form">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="role_id" class="form-label">Rol</label>
                                <select id="role_id" name="role_id" class="select2-search form-select" data-live-search="true">
                                    <?php
                                    if (session()->get('role') === 'admin') {
                                        $condition = [];
                                    } else {
                                        $condition = ['roles.id !=' => 1];
                                    }
                                    $roles_model = new \App\Models\RolesModel();
                                    $roles = $roles_model->where($condition)->findAll();
                                    foreach($roles as $role):
                                    ?>
                                    <option data-tokens="<?=$role['role']?>" value="<?=$role['id']?>" ><?=$role['description']?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="formrow-email-input" class="form-label">Email</label>
                                <input type="email" class="form-control" id="formrow-email-input"
                                    placeholder="Correo electrónico" name="email">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                              <label for="phone" class="form-label">Teléfono</label>
                              <input type="tel" class="form-control" name="phone" id="phone">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <div class="d-sm-none d-md-block" style="height: 27.5px;"></div>
                                <div class="form-check">
                                    <input type="hidden" name="is_active" value="0">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" checked>
                                    <label class="form-check-label" for="is_active">
                                        Activo
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="formrow-password-input" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="formrow-password-input"
                                    placeholder="Contraseña" name="password">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="passconf" class="form-label">Confirmar contraseña</label>
                                <input type="password" class="form-control" id="passconf" placeholder="Contraseña" name="passconf">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <div style="height: 27.5px;"></div>
                                <button id="save_button" type="button" class="btn btn-primary btn-label" onclick="postForm('user_form', '<?=esc(base_url('users/resources/insert'),'js')?>', '<?=esc(base_url('users'),'js')?>')">
                                    <i class="bx bxs-save label-icon"></i>&nbsp;Registrar
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- end card body -->
        </div>
        <!-- end card -->
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