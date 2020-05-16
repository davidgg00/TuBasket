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

    <!--bootstrap-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="<?= base_url('assets/css/mdb.min.css') ?>">
    <script src="<?php echo base_url('assets/js/mdb.js') ?>"></script>
    <?php if (isset($css)) : ?>
        <?php foreach ($css as $hoja) : ?>
            <link rel="stylesheet" href="<?= base_url('assets/css/' . $hoja . '.css') ?>">
        <?php endforeach; ?>
    <?php endif; ?>
    <script src="<?= base_url() . "assets/js/efectoform.js" ?>"></script>
    <script src="https://kit.fontawesome.com/bebbcbf4a0.js" crossorigin="anonymous"></script>

    <!-------------------------------------------LIBRERÍAS PARA LAS ALERTAS Y FORMULARIOS Y MÁS------------------------------->
    <!--Sweet Alert-->
    <script src="<?php echo base_url('assets/js/sweetalert2.js') ?>"></script>
    <!--PAGINATION-->
    <script src="<?php echo base_url('assets/js/pagination.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery.bootpag.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/HZpagination.js') ?>"></script>
    <!--Jquery UI-->
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
    <script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
    <!-- Production -->
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://unpkg.com/tippy.js@6"></script>
</head>