<div class="container-fluid d-flex align-items-center justify-content-center h-100">
    <div class="row w-75 border d-flex justify-content-center align-items-center">
        <div class=" w-75 border d-flex flex-wrap justify-content-between mt-0 pt-0" id="lista_equipos">
            <h2 class="w-100 text-center">Elige un Equipo</h2>
            <?php foreach ($equipos as $equipo) : ?>
                <div class="equipo d-flex justify-content-center flex-wrap">
                    <a class="d-flex justify-content-center align-items-center" href="<?php echo base_url('Jugador_c/unirseEquipo/') . $equipo->id . "/" . $_SESSION['username'] ?>"><img src="<?php echo base_url($equipo->escudo_ruta) ?>" title="Unirse al <?= $equipo->equipo ?>" class="img-fluid"></a>
                    <p class="w-100 text-center mb-0"><?= $equipo->equipo ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>