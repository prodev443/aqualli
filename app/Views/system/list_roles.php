<?php 
$this->setVar('title', 'Lista');
$this->setVar('pagetitle', 'Administración de Permisos');
$this->setVar('css_styles', array(
    'assets/libs/datatables/datatables.min.css'
));
$this->setVar('scripts', array(
    'assets/libs/datatables/datatables.min.js',
));
?>
<?= $this->extend('layouts/main');?>
<?= $this->section('content');?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Lista de Roles</h4>
                <p class="card-title-desc">Selecciona un Rol para editar sus permisos</p>

                <div id="data-table" class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="roles" class="table table-bordered dt-responsive nowrap w-100 dataTable no-footer dtr-inline" aria-describedby="datatable_info" style="width: 1006px;">
                                <thead>
                                    <tr>
                                        <th>Rol</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div> <!-- end col -->
</div>

<script>
    let table;
    $(document).ready(
        function () {
            table = $('#roles').DataTable({
                ajax: {
                    "url": "<?=esc(base_url('system/resources/roles'),'js')?>",
                    "type": "GET",
                    "dataSrc": ""
                },
                deferRender: true,
                columns: [
                    {
                        data: "description"
                    },
                ],
                responsive: true,
                columnDefs: [{
                    targets: [0],
                    className: 'dt-left'
                }, ],
                "rowCallback": function (row, data) {
                    $('td:eq(0)', row).html('<a href="<?=esc(base_url('system/roles/'),'js')?>/' + data.id + '">' + data.description + '</a>');
                },
                dom: 'lBfrtip',
                buttons: [],
                "language": {
                    "search": "Buscar:",
                    "lengthMenu": "Mostrar _MENU_ registros por página",
                    "zeroRecords": "No se encontraron resultados",
                    "info": "Página _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay registros disponibles",
                    "infoFiltered": "(Filtrado de _MAX_ registros)",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    },
                }
            });
        }
    );
</script>
<?= $this->endSection(); ?>