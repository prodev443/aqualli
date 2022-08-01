<?php
$this->setVar('title', 'Detalle');
$this->setVar('pagetitle', 'Alumnos');
$this->setVar('css_styles', array(
    'assets/libs/tabulator/css/tabulator_bootstrap3.min.css',
    'assets/libs/tabulator/css/tabulator_custom.css',
    'assets/libs/sweetalert2/sweetalert2.min.css',
));
$this->setVar('scripts', array(
    'assets/libs/sweetalert2/sweetalert2.min.js',
    'assets/custom/js/ajax.js', // AJAX requests con token
    'assets/libs/tabulator/js/tabulator.min.js',
    'assets/custom/js/table_library.js', // Funciones para tabulator
    'assets/custom/js/popups.js',
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
                    <h4 class="card-title mb-4">Datos del Alumno</h4>
                </div>
                <div class="col-sm-6">
                    <div class="d-flex flex-row-reverse bd-highlight">
                        <div class="p-2 bd-highlight">
                            <a href="<?=base_url('students')?>"><i class="bx bx-arrow-back"></i> Regresar</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" id="nav-tabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="details-tab" data-bs-toggle="tab" data-bs-target="#details"
                        type="button" role="tab" aria-controls="details" aria-selected="true">Detalles</button>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane active" id="details" role="tabpanel" aria-labelledby="details-tab">
                    <br>
                    <?= $this->include('students/detail/detail_form.php'); ?>
                </div>
            </div>
        </div>
        <!-- end card body -->
    </div>
</div>
<script>
$(document).ready(
    function() {
        tokenize('<?=csrf_token()?>', '<?=csrf_header()?>', '<?=csrf_hash()?>')

        documents_table = new Tabulator("#documents-table", {
            ajaxURL: "<?=esc(base_url('students/documents/'.$student['id']),'js')?>/",
            layout: "fitDataFill",
            // responsiveLayout:true,
            columns: [{
                    formatter: "rowSelection",
                    titleFormatter: "rowSelection",
                    headerSort: false
                },
                {
                    title: "Documento",
                    field: "name",
                    headerFilter: "input",
                    formatter: function(cell) {
                        let id = cell.getRow().getData().id
                        let html =
                            '<a href="<?= esc(base_url('students/documents/download'), 'js') ?>/' +
                            id + '">' + cell.getValue() + '</a>'
                        return html
                    },
                },
                {
                    title: "Decripción",
                    field: "description",
                    headerFilter: "input",
                },
                {
                    title: "Acciones",
                    hozAlign: "center",
                    formatter: function(cell) {
                        let id = cell.getRow().getData().id
                        let html =
                            '<button type=\'button\' class="btn btn-success btn-rounded waves-effect waves-light" onclick="editDocument(\'' +
                            id + '\')"><i class="bx bx-pencil"></i></a>'
                        return html
                    },
                },
            ],
        });
    }
)

// Alumnos

function deletePhoto() {
    let delete_url = '<?=esc(base_url('students/resources/delete_photo'),'js')?>'
    deleteInput(delete_url).then((data) => {
        if (data.errors === undefined) {
            $('#photo').remove()
            $('#delete_photo_btn').remove()
        }
    })
}

// Documentos

function addDocument() {
    let pageURL = '<?=base_url('students/documents/create/'.$student['id'])?>'
    createPopup(pageURL, 'Nuevo Documento', 500, 400)
}

function editDocument(id) {
    let pageURL = '<?=base_url('students/documents/edit')?>/' + id
    createPopup(pageURL, 'Editar Documento', 500, 400)
}

function uploadDocument(doc_form) {
    let post_url = '<?= esc(base_url('students/documents/insert'), 'js') ?>'
    postData(doc_form, post_url).then(() => {
        documents_table.replaceData()
    })

}

function updateDocument(doc_form) {
    let post_url = '<?= esc(base_url('students/documents/update'), 'js') ?>'
    postData(doc_form, post_url).then(() => {
        documents_table.replaceData()
    })

}

function deleteSelectedDocuments(data) {
    let collection = [];
    data.forEach(element => {
        let aux = {
            'id': element,
        }
        collection.push(aux)
    });

    collection = {
        records: collection
    }

    deleteData(collection, '<?=base_url('students/documents/delete')?>').then(() => {
        documents_table.replaceData()
    })
}
</script>
<?= $this->endSection(); ?>