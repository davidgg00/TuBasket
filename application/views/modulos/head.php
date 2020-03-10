<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TuBasket</title>
    <link rel="icon" type="image/png" href="assets/img/logo.png">
    <script src="<?= base_url() . "assets/js/jquery-3.4.1.min.js" ?>"></script>
    <script src="<?= base_url() . "assets/js/popper.min.js" ?>">
    </script>
    <script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css') ?>">
    <?php if (isset($css)) : ?>
        <?php foreach ($css as $hoja) : ?>
            <link rel="stylesheet" href="<?= base_url('assets/css/' . $hoja . '.css') ?>">
        <?php endforeach; ?>
    <?php endif; ?>
    <script src="<?= base_url() . "assets/js/efectoform.js" ?>"></script>
    <script src="https://kit.fontawesome.com/bebbcbf4a0.js" crossorigin="anonymous"></script>

    <!-------------------------------------------LIBRERÍAS VEX PARA LAS ALERTAS Y FORMULARIOS------------------------------->

    <script src="<?= base_url('assets/js/vex-master/dist/js/vex.combined.min.js') ?>"></script>
    <script>
        vex.defaultOptions.className = 'vex-theme-os'
    </script>
    <link rel="stylesheet" href="<?= base_url('assets/js/vex-master/dist/css/vex.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/js/vex-master/dist/css/vex-theme-os.css') ?>">
    <!--Sweet Alert-->
    <script src="<?php echo base_url('assets/js/sweetalert2.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/sweetalert.js') ?>"></script>
    <!--PAGINATION-->
    <script src="<?php echo base_url('assets/js/pagination.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery.bootpag.min.js') ?>"></script>
</head>