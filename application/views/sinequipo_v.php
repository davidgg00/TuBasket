<script>
    $.get("<?= base_url('Usuario_C/obtenerJugadoresEquiposLiga/' . $_SESSION['liga']) ?>",
        function(dato_devuelto) {
            let nJugadoresEquipo = JSON.parse(dato_devuelto);
            for (equipo of nJugadoresEquipo) {
                if (equipo.equipo != null) {
                    if (equipo.total == 10) {
                        $("a" + "[data-id=" + equipo.equipo + "]").removeAttr('href');
                        $("a" + "[data-id=" + equipo.equipo + "]").attr('data-tippy-content', 'Equipo lleno.');
                        console.log($("a" + "[data-id=" + equipo.equipo + "]").children()[0]);
                        $("a" + "[data-id=" + equipo.equipo + "]").children().css('opacity', '0.5');
                    } else {
                        $("a" + "[data-id=" + equipo.equipo + "]").attr('data-tippy-content', 'Unete a este equipo haciendo click');
                    }
                }
            }
            tippy('a');
        }
    );
</script>
<div class="container-fluid border">
    <header class="row d-flex justify-content-around align-items-center">
        <img id="logo" src="<?php echo base_url('assets/img/logo2.png') ?>" class="img-fluid">
    </header>
    <div class="row w-75 d-flex justify-content-center align-items-center mx-auto">
        <div class=" w-75 border d-flex flex-wrap justify-content-between mt-0 pt-0" id="contenedor">
            <h2 class="w-100 text-center">Elige un Equipo</h2>
            <div id="lista_equipos">
                <?php
                foreach ($equipos as $equipo) : ?>
                    <div class="equipo d-inline-block float-left">
                        <a data-id="<?= $equipo->id ?>" class="d-flex justify-content-center align-items-center" href="<?php echo base_url('Usuario_c/unirseEquipo/') . $equipo->id . "/" . $_SESSION['username'] ?>"><img src="<?php echo base_url($equipo->escudo_ruta) ?>" class="img-fluid"></a>
                        <p class="w-100 text-center mb-0"><?= $equipo->equipo ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <footer class="row d-flex justify-content-center align-items-center">
        <h5>Derechos de autor: David Guisado González</h5>
    </footer>