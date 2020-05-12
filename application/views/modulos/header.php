<div class="container-fluid">
    <style>
        .dropdown:hover>.dropdown-menu {
            display: block;
            position: absolute;
            transition: all 0.5s;
        }

        .dropdown>.dropdown-toggle:active {
            /*Without this, clicking will make it sticky*/
            pointer-events: none;
        }

        .dropdown-menu {
            margin: -0.125rem 0 0;
        }
    </style>
    <script>
        $(document).ready(function() {
            //Añadimos animación para mostrar el menu de notificaciones
            $('.dropdown').on('show.bs.dropdown', function() {
                $(this).find('.dropdown-menu').first().stop(true, true).slideDown().delay(280);
            });

            // Añadimos animación al ocultar el menu de notificaciones
            $('.dropdown').on('hide.bs.dropdown', function() {
                $(this).find('.dropdown-menu').first().stop(true, true).delay(50).slideUp();
            });
        });
    </script>
    <header class="row d-flex justify-content-around align-items-center">
        <img id="logo" src="<?php echo base_url('assets/img/logo2.png') ?>" class="img-fluid">
        <?php
        //Los enlaces varían según el tipo de cuenta
        switch ($_SESSION['tipo_cuenta']):
            case 'Jugador': ?>
                <a href="<?php echo base_url('Usuario_c/') ?>">Inicio</a>
                <a href="<?php echo base_url('Usuario_c/clasificacion/') ?>">Clasificación</a>
                <a href="<?php echo base_url('Usuario_c/estadisticas/') ?>">Tus estadísticas</a>
                <a href="<?php echo base_url('Usuario_c/partidos/') ?>">Partidos</a>
                <a href="#"><img src="<?php echo base_url("assets/uploads/perfiles/pordefecto.png") ?>" class="img-fluid rounded-circle" id='perfil'></a>
                <a href="<?php echo base_url('Usuario_c/cerrarsesion') ?>"><img src="<?php echo base_url('assets/img/cerrarsesion2.png') ?>" class="img-fluid rounded-circle"></a>
                <?php break; ?>
            <?php
            case 'Entrenador': ?>
                <a href="<?php echo base_url('Usuario_c/') ?>">Inicio</a>
                <a href="<?php echo base_url('Usuario_c/listaJugadores/') ?>">Jugadores de la Liga</a>
                <a href="<?php echo base_url('Usuario_c/partidos/') ?>">Partidos</a>
                <a href="<?php echo base_url('Usuario_c/clasificacion/') ?>">Clasificación</a>
                <a href="<?php echo base_url('Usuario_c/notificaciones/') ?>"> Notificaciones (<?= $numeroNotif ?>)</a>
                <a href="#"><img src="<?php echo base_url("assets/uploads/perfiles/pordefecto.png") ?>" class="img-fluid rounded-circle" id='perfil'></a>
                <a href="<?php echo base_url('Usuario_c/cerrarsesion') ?>"><img src="<?php echo base_url('assets/img/cerrarsesion2.png') ?>" class="img-fluid rounded-circle"></a>
                <?php break; ?>
            <?php
            case 'Administrador': ?>
                <a href="<?php echo base_url('Admin_c/index/' . $liga) ?>">Inicio</a>
                <a href="<?php echo base_url('Admin_c/gestEquipo/' . $liga) ?>">Gestionar Equipos</a>
                <a href="<?php echo base_url('Admin_c/gestJugadores/' . $liga) ?>">Gestionar Jugadores</a>
                <a href="<?php echo base_url('Admin_c/partidos/' . $liga) ?>">Partidos</a>
                <a href="#"><img src="<?php echo base_url('assets/img/perfil.png') ?>" class="img-fluid rounded-circle" id='perfil'></a>
                <a href="<?php echo base_url('Admin_c/cerrarsesion') ?>"><img src="<?php echo base_url('assets/img/cerrarsesion2.png') ?>" class="img-fluid rounded-circle"></a>
                <?php break; ?>
        <?php endswitch; ?>
    </header>