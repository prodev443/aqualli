<!-- Popup View -->
<?php
$this->setVar('title', 'Actualizar contraseña');
$this->setVar('pagetitle', 'Información del usuario');
$this->setVar('css_styles', array(
));
$this->setVar('scripts', array(
));
?>
<?= $this->extend('layouts/popup'); ?>
<?= $this->section('content'); ?>
<div class="row">
    <div class="card col-12">
        <div class="card-body">
            <h4 class="card-title">Actualización de la contraseña del usuario: <a href="mailto:<?= $user['email'] ?>"><?= $user['email'] ?></a></h4>
            <form id="password_form" class="row">
                
                <input type="hidden" name="id" value="<?= $user['id'] ?>">

                <div class="row">
                    <div class="col-12">
                        <div class="mb-3">
                        <label for="password" class="form-label">Nueva contraseña</label>
                        <input type="password"
                            class="form-control" name="password" id="password" aria-describedby="helpId" placeholder="">
                        <small id="helpId" class="form-text text-muted">Requerido</small>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-3">
                        <label for="passconf" class="form-label">Confirmar nueva contraseña</label>
                        <input type="password"
                            class="form-control" name="passconf" id="passconf" aria-describedby="helpId" placeholder="">
                        <small id="helpId" class="form-text text-muted">Requerido</small>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <button type="button" class="btn btn-primary btn-label" onclick="send(document.getElementById('password_form'))">
                            <i class="label-icon bx bx-save"></i>&nbsp;Guardar
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
<script>
    function send(form) {
        let data = new FormData(form)
        let url = '<?= esc(base_url('users/resources/update'), 'js') ?>'
        window.close()
        window.opener.postData(data, url)
    }
</script>
<?= $this->endSection(); ?>