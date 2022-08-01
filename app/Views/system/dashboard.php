<?php
$this->setVar('title', 'main');
$this->setVar('pagetitle', 'main');
?>
<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>
<h1>Hola mundo</h1>
<?= $this->endSection(); ?>