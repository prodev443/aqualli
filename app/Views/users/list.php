<?php 
$this->setVar('title', 'Lista de Usuarios');
$this->setVar('pagetitle', 'Usuarios');
$this->setVar('css_styles', array(
    'assets/libs/tabulator/css/tabulator_bootstrap3.min.css',
    'assets/libs/tabulator/css/tabulator_custom.css',
));
$this->setVar('scripts', array(
    'assets/libs/tabulator/js/tabulator.min.js',
));
?>
<?= $this->extend('layouts/main');?>
<?= $this->section('content');?>
<div class="row">
    
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <a type="button" class="btn btn-info waves-effect btn-label waves-light" href="<?=base_url('users/create')?>">
                    <i class='bx bx-plus label-icon'></i></i> Crear Usuario
                </a>
                <br><br>
                <!-- tabulator -->
                <div class="row col-12 table-responsive">
                    <div id="users_table"></div>
                </div>                

            </div>
        </div>
    </div> <!-- end col -->
</div>
<script>
    let token = '<?=csrf_hash()?>';
    let users_table;

    $(document).ready(() => {
        users_table = new Tabulator("#users_table", {
            ajaxURL: "<?=esc(base_url('users/resources/list'),'js')?>",
            layout: "fitDataFill",
            pagination:true,
            paginationSize:10,
            columns: [                
                {
                    title: "Correo / Usuario",
                    field: "email",
                    hozAlign: "left",
                    headerFilter:"input",
                    formatter:"link",
                    formatterParams:{
                        labelField:"email",
                        urlPrefix:"",
                        target:"",
                        url: function(cell){
                            data = cell.getRow().getData()
                            let url = '<?=esc(base_url('users/detail'),'js')?>' + '/' + data.id
                            return url
                        }
                    }
                },
                {
                    title: "Rol",
                    field: "role",
                    hozAlign: "left",
                    headerFilter:"input"
                },
                {
                    title: "Activo",
                    field: "is_active",
                    formatter:"tickCross",
                    hozAlign: "center",
                    headerFilter:"tickCross",
                    headerFilterParams:{"tristate":true},
                    headerFilterEmptyCheck:function(value){return value === null},
                },
            ],
        });
    })

    function save() {
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

    function deleteUsers(){
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
                    },
                    error: function(data,status,settings){
                        console.log(status)
                    }
                }
            )
        }
    }
</script>
<?= $this->endSection(); ?>