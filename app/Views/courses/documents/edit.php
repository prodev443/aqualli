<?php
$this->setVar('title', 'Editar Documento');
$this->setVar('pagetitle', 'Información del Documento');
$this->setVar('css_styles', array(
));
$this->setVar('scripts', array(
));
?>
<?= $this->extend('layouts/popup'); ?>
<?= $this->section('content'); ?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Información del Documento</h4>

                <form id="doc-form">
                    <input type="hidden" name="id" value="<?= $document['id'] ?>">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                              <label for="name" class="form-label">Nombre</label>
                              <input type="text" class="form-control" name="name" id="name" aria-describedby="h-name" value="<?= $document['name'] ?>">
                              <small id="h-name" class="form-text text-muted">Nombre del archivo con extensión</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                              <label for="description" class="form-label">Descripción del Documento</label>
                              <textarea class="form-control" name="description" id="description" rows="3"><?= $document['description'] ?></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                              <label for="document" class="form-label">Archivo</label>
                              <input type="text" class="form-control" value="<?= $document['name'] ?>" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-primary" onclick="sendDocument()">Actualizar</button>
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
        function () {
            $('textarea').keyup(
                function(e) {
                    this.value = this.value.toUpperCase()
                }
            )
        }
    );

    function sendDocument() {
        let form_element = document.getElementById('doc-form')
        let doc_form = new FormData(form_element);
        window.close()
        window.opener.updateDocument(doc_form)
    }

</script>
<?= $this->endSection(); ?>