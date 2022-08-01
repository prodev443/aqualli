<!DOCTYPE html>
<html lang="es">

    <head>
        <meta charset="utf-8" />
        <title><?= $title ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="" name="description" />
        <meta content="Samuel Alderete Rayón" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="<?=base_url('assets/images/favicon_feda.png')?>">

        <!-- Bootstrap Css -->
        <link href="<?=base_url('assets/css/bootstrap.min.css')?>" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="<?=base_url('assets/css/icons.min.css')?>" rel="stylesheet" type="text/css" />

        <!-- App Css-->
        <link href="<?=base_url('assets/css/app.min.css')?>" id="app-style" rel="stylesheet" type="text/css" />
        
        <!-- Estilos personalizados -->
        <link href="<?=base_url('assets/custom/css/styles.css')?>" rel="stylesheet" type="text/css" />

        <!-- Carga de estilos adicionales por vista -->
        <?php if(isset($css_styles) && is_array($css_styles)): ?>
            <?php foreach ($css_styles as $style): ?>
                <link href="<?=base_url($style)?>" rel="stylesheet" type="text/css" />
            <?php endforeach; ?>
        <?php endif; ?>

        <script src="<?=base_url('assets/libs/jquery/jquery.min.js')?>"></script>

    </head>

    <body data-sidebar="dark">

        <?= $this->renderSection('content') ?>
        
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