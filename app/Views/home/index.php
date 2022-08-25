<?php
$this->setVar('title', 'Inicio');
$this->setVar('pagetitle', 'Dashboard');
?>
<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>
<h1>Bienvenido al sistema de gestión de Aqualli</h1>
<?= $this->endSection(); ?>