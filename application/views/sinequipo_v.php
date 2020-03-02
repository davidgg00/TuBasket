<div class="container-fluid d-flex align-items-center justify-content-center h-100">
    <div class="row h-75 d-block" id="lista_equipos">
        <h3 class="w-100 text-center">Elige un equipo</h3>
        <div id="equipos" class="d-flex justify-content-around align-items-center flex-wrap">
            <?php
            foreach ($equipos as $equipo) : ?>
                <div class="equipo d-flex justify-content-center flex-wrap">
                    <a class="d-flex justify-content-center align-items-center" href="<?php echo base_url('Jugador_c/unirseEquipo/') . $equipo->id . "/" . $_SESSION['username'] ?>"><img src="<?php echo base_url('assets/uploads/escudos/' . $equipo->escudo_ruta) ?>" alt="Balon" class="img-fluid"></a>
                    <p class="w-100 text-center mb-0"><?= $equipo->equipo ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<a href="Jugador_c/cerrarsesion" class="">
    <img src="<?php echo base_url('assets/img/cerrarsesion.png') ?>" alt="Balon" class="img-fluid align-self-center" id="balon">
    <p class="w-100 mt-1 font-weight-bold">Cerrar Sesión</p>
</a>