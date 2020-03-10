<div class="container-fluid">
    <header class="row d-flex justify-content-around align-items-center">
        <img id="logo" src="<?php echo base_url('assets/img/logo2.png') ?>" class="img-fluid">
        <a href="<?php echo base_url('Admin_c/index/' . $liga) ?>">Inicio</a>
        <a href="<?php echo base_url('Admin_c/gestEquipo/' . $liga) ?>">Gestionar Equipos</a>
        <a href="<?php echo base_url('Admin_c/gestJugadores/' . $liga) ?>">Gestionar Jugadores</a>
        <a href="<?php echo base_url('Admin_c/partidos/' . $liga) ?>">Partidos</a>
        <a href="#"><img src="<?php echo base_url('assets/img/perfil.png') ?>" class="img-fluid rounded-circle"></a>
        <a href="<?php echo base_url('Admin_c/cerrarsesion') ?>"><img src="<?php echo base_url('assets/img/cerrarsesion2.png') ?>" class="img-fluid rounded-circle"></a>
    </header>