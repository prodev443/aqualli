<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <title><?= $title ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="" name="description" />
    <meta content="Samuel Alderete Rayón" name="author" />

    <!-- Bootstrap Css -->
    <link href="<?=base_url('assets/css/bootstrap.min.css')?>" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="<?=base_url('assets/css/icons.min.css')?>" rel="stylesheet" type="text/css" />

    <!-- App Css-->
    <link href="<?=base_url('assets/css/app.min.css')?>" id="app-style" rel="stylesheet" type="text/css" />

    <!-- Sweet Alert 2 -->
    <link rel="stylesheet" href="<?= base_url('assets/libs/sweetalert2/sweetalert2.min.css',) ?>">

    <!-- Estilos personalizados -->
    <link href="<?=base_url('assets/custom/css/styles.css')?>" rel="stylesheet" type="text/css" />

    <!-- Carga de estilos adicionales por vista -->
    <?php if(isset($css_styles) && is_array($css_styles)): ?>
    <?php foreach ($css_styles as $style): ?>
    <link href="<?=base_url($style)?>" rel="stylesheet" type="text/css" />
    <?php endforeach; ?>
    <?php endif; ?>

    <script src="<?=base_url('assets/libs/jquery/jquery.min.js')?>"></script>
    <script src="<?=base_url('assets/libs/sweetalert2/sweetalert2.min.js')?>"></script>
    <script src="<?=base_url('assets/js/api.js')?>"></script>

</head>

<body data-sidebar="dark">
    <div id="csrf"
        data-name="<?= csrf_token() ?>"
        data-header="<?= csrf_header() ?>"
        data-hash="<?= csrf_hash() ?>">
    </div>
    <!-- Begin page -->
    <div id="layout-wrapper">

        <!-- topbar -->
        <?= view_cell('\App\Libraries\GUIHelper::genTopbar') ?>

        <!-- sidebar -->
        <?= view_cell('\App\Libraries\GUIHelper::genSidebar') ?>


        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <!-- page_title -->
                    <?php $params = array( 'title' => $title, 'pagetitle' => $pagetitle); ?>
                    <?= view_cell('\App\Libraries\GUIHelper::genPageTitle', $params) ?>

                    <?= $this->renderSection('content') ?>

                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <!-- Footer -->
            <?= view_cell('\App\Libraries\GUIHelper::genFooter') ?>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- PHP //view_cell('\App\Libraries\GUIHelper::genRightSidebar') -->

    <script src="<?=base_url('assets/libs/bootstrap/js/bootstrap.bundle.min.js')?>"></script>
    <script src="<?=base_url('assets/libs/metismenu/metisMenu.min.js')?>"></script>
    <script src="<?=base_url('assets/libs/simplebar/simplebar.min.js')?>"></script>
    <script src="<?=base_url('assets/libs/node-waves/waves.min.js')?>"></script>

    <?= $this->include('application/js-script') ?>

    <!-- App js -->
    <script src="<?=base_url('assets/js/app.js')?>"></script>

    <!-- Carga de javascript adicional por vista -->
    <?php if(isset($scripts) && is_array($scripts)): ?>
    <?php foreach ($scripts as $script): ?>
    <script src="<?=base_url($script)?>"></script>
    <?php endforeach; ?>
    <?php endif; ?>

</body>

</html>