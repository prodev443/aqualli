<?php
$this->setVar('title', 'Añadir Documento');
$this->setVar('pagetitle', 'Información de Documento');
$this->setVar('css_styles', array(
));
$this->setVar('scripts', array(
    'assets/custom/js/upper.js', // Mayúsculas automáticas
));
?>
<?= $this->extend('layouts/popup'); ?>
<?= $this->section('content'); ?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Información de Facturación</h4>

                <form id="doc-form">
                    <input type="hidden" name="course_id" value="<?= $course_id ?>">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                              <label for="description" class="form-label">Descripción del Documento</label>
                              <textarea class="form-control" name="description" id="description" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                              <label for="document" class="form-label">Archivo</label>
                              <input type="file" class="form-control" name="document" id="document">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-primary" onclick="sendDocument()">Subir</button>
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

    function sendDocument() {
        let form_element = document.getElementById('doc-form')
        let doc_form = new FormData(form_element);
        window.close()
        window.opener.uploadDocument(doc_form)
    }

</script>
<?= $this->endSection(); ?>