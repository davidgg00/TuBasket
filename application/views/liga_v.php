<div class="container-fluid">
    <header class="row d-flex justify-content-around align-items-center">
        <img id="logo" src="<?php echo base_url('assets/img/logo2.png') ?>" class="img-fluid">
        <a href="#">Inicio</a>
        <a href="#">Gestionar Equipos</a>
        <a href="#">Gestionar Jugadores</a>
        <a href="#">Partidos</a>
        <a href="#">Perfil</a>
        <a href="<?php echo base_url('liga_c/cerrarsesion') ?>">Salir</a>
    </header>
    <div class="row col-10 float-right" id="informacion">
        <section class="col-10 d-flex flex-wrap justify-content-center align-items-center" id="proxpartido">
            <div id="partido" class="col-12 h-75 d-flex justify-content-center flex-wrap">
                <h3 class="col-12 text-center">Liga: <?= $liga ?></h3>
                <h3 class="col-12 text-center">Próximo Partido</h3>
                <div id="imagenes" class="col-12 d-flex justify-content-around h-50">
                    <img src="<?php echo base_url('assets/img/escudoejemplo.png') ?>" class="img-fluid">
                    <img src="<?php echo base_url('assets/img/vs.png') ?>" class="img-fluid">
                    <img src="<?php echo base_url('assets/img/escudoejemplo.png') ?>" class="img-fluid">
                </div>
                <p id="lugar" class="col-12">Lugar: Pabellon X</p>
                <p id="fecha" class="col-12">Fecha: 18/03/2020</p>
                <p id="hora" class="col-12">Hora: 12:00</p>
            </div>
        </section>
        <aside class="col-2 h-25 d-flex justify-content-center flex-wrap align-items-center">
            <p class="col-12">¡Bienvenido <?= $_SESSION["username"] ?>!</p>
            <p class="col-12">Cuenta: <?= $_SESSION["tipo_cuenta"] ?></p>
            <p class="col-12">Liga: <?= $liga ?></p>
        </aside>
    </div>
    <footer class="row col-12 d-flex justify-content-center align-items-center">
        <h5>Derechos de autor: David Guisado González</h5>
    </footer>
</div>