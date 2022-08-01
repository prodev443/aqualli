<?php 
$this->setVar('title', 'Detalle');
$this->setVar('pagetitle', 'Roles');
$this->setVar('css_styles', array(
    'assets/libs/datatables/datatables.min.css',
    'assets/libs/tabulator/css/tabulator_bootstrap3.min.css',
    'assets/libs/tabulator/css/tabulator_custom.css',
    'assets/libs/select2/css/select2.min.css',
    'assets/libs/sweetalert2/sweetalert2.min.css'
));
$this->setVar('scripts', array(
    'assets/libs/datatables/datatables.min.js',
    'assets/libs/tabulator/js/tabulator.min.js',
    'assets/libs/select2/js/select2.min.js',
    'assets/libs/sweetalert2/sweetalert2.min.js',
));
?>
<?= $this->extend('layouts/main');?>
<?= $this->section('content');?>
<div class="row">
    
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                
                <h4 class="card-title">Permisos de <?= $record['description'] ?></h4>
                <form class="row row-cols-lg-auto g-3 align-items-center">
                    <div class="col-12">
                        <label class="visually-hidden" for="module_selector">Selecciona módulo</label>
                        <select id="module_selector" class="select2-search form-select" data-live-search="true">
                            <?php foreach($modules as $module): ?>
                            <option data-tokens="<?=$module['module_tag']?>" value="<?=$module['id']?>" ><?=$module['module_tag']?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                    <div class="col-12">
                        <button type="button" class="btn btn-info btn-addon btn-md m-b-10 m-l-5" onclick="addPermission()">
                            <i class="ti-package"></i>Agregar módulo
                        </button>
                    </div>
                    <div class="col-12">
                        <button type="button" class="btn btn-danger btn-addon btn-md m-b-10 m-l-5" onclick="deleteRows()">
                            <i class="ti-trash"></i>Eliminar selección
                        </button>
                    </div>
                    <div class="col-12">
                        <button type="button" class="btn btn-success btn-addon btn-md m-b-10 m-l-5"
                            onclick="saveRows()">
                            <i class="ti-save"></i>Guardar
                        </button>
                    </div>
                </form>
                
                <br><br>
                <!-- tabulator -->
                <div class="row col-12 table-responsive">
                    <div id="example-table"></div>
                </div>                

            </div>
        </div>
    </div> <!-- end col -->
</div>
<script>
    let token = '<?=csrf_hash()?>';
    let table;

    // In your Javascript (external .js resource or <script> tag)
    $(document).ready(function() {
        $('.select2-search').select2();
    });

    $(document).ready(() => {
        table = new Tabulator("#example-table", {
            ajaxURL: "<?=esc(base_url('system/resources/permissions/'.$record['id']),'js')?>",
            layout: "fitDataFill", //fit columns to width of table (optional)
            minHeight: 300,
            // responsiveLayout:"hide",
            columns: [ //Define Table Columns
                {formatter:"rowSelection", titleFormatter:"rowSelection", align:"center", headerSort:false},
                {
                    title: "Módulo",
                    field: "module_tag",
                },
                {
                    title: "Ver",
                    field: "see",
                    hozAlign: "center",
                    formatter:"tickCross",
                    editor:"tickCross",
                    editorParams:{
                        trueValue:"1",
                        falseValue:"0",
                    }
                },
                {
                    title: "Crear",
                    field: "create",
                    editor: false,
                    hozAlign: "center",
                    formatter:"tickCross",
                    editor:"tickCross",
                    editorParams:{
                        trueValue:"1",
                        falseValue:"0",
                    }
                },
                {
                    title: "Editar",
                    field: "edit",
                    editor: false,
                    hozAlign: "center",
                    formatter:"tickCross",
                    editor:"tickCross",
                    editorParams:{
                        trueValue:"1",
                        falseValue:"0",
                    }
                },
                {
                    title: "Eliminar",
                    field: "delete",
                    editor: false,
                    hozAlign: "center",
                    formatter:"tickCross",
                    editor:"tickCross",
                    editorParams:{
                        trueValue:"1",
                        falseValue:"0",
                    }
                },
                {
                    title: "Solo propietario",
                    field: "propietary_only",
                    editor: false,
                    hozAlign: "center",
                    formatter:"tickCross",
                    editor:"tickCross",
                    editorParams:{
                        trueValue:"1",
                        falseValue:"0",
                    }
                },
                {
                    title: "Solo asignado",
                    field: "assigned_only",
                    editor: false,
                    hozAlign: "center",
                    formatter:"tickCross",
                    editor:"tickCross",
                    editorParams:{
                        trueValue:"1",
                        falseValue:"0",
                    }
                },
            ],
        });
    })

    function saveRows() {
        // Obtiene los datos actuales de la tabla
        let data = {};
        data.items = table.getData()
        data.<?=csrf_token();?> = token
        const updateData = () => {
            return new Promise((resolve, reject) => {
                $.ajax('<?=base_url('system/resources/permissions/save')?>',
                    {
                        data: data,
                        method: "POST",
                        success: function (data, status, settings) {
                            token = data.token
                            if(data.errors !== undefined){
                                Swal.fire(
                                {
                                    position: 'top-end',
                                    icon: 'error',
                                    title: 'Error',
                                    text: data.errors,
                                    showConfirmButton: false,
                                    timer: 700
                                }
                            )
                            } else {
                                Swal.fire(
                                {
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Datos actualizados',
                                    showConfirmButton: false,
                                    timer: 700
                                }
                            )
                            }
                            resolve()
                        },
                        error: function(data,status,settings){
                            console.log(status)
                        }
                    }
                )
            })
        }

        updateData().then(() => {
            // Actualiza la tabla
            table.replaceData() //Recarga ajax data desde ajaxURL
        })
    }

    function deleteRows(){
        // Obtiene los datos actuales de la tabla
        let data = {}
        let server_records = []
        data.<?=csrf_token();?> = token
        items = table.getSelectedRows()
        items.forEach(element => {
            if (element.getData().id !== undefined) {
                server_records.push(element.getData())
            }
            element.delete()
        });
        if(server_records.length <= 0){
            return
        } else {
            data.items = server_records
            $.ajax('<?=base_url('system/resources/permissions/delete')?>',
                {
                    data: data,
                    method: "POST",
                    success: function (data, status, settings) {
                        token = data.token
                        Swal.fire(
                            {
                                position: 'top-end',
                                icon: 'success',
                                title: 'Datos actualizados',
                                showConfirmButton: false,
                                timer: 700
                            }
                        )
                    },
                    error: function(data,status,settings){
                        console.log(status)
                    }
                }
            )
        }
    }

    function addPermission() {
        let row_data = {}
        row_data.module_id = $('#module_selector').val()
        row_data.module_tag = $('#module_selector').find(":selected").text()
        table.addRow({
            role_id:'<?=esc($record['id'],'js')?>',
            module_id:row_data.module_id,
            module_tag:row_data.module_tag,
            see:1,
            create:1,
            edit:1,
            delete:1,
            propietary_only:1,
            assigned_only:0,
        });
    }
</script>
<?= $this->endSection(); ?>