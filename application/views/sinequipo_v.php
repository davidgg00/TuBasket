<script>
    $(document).ready(function() {
        $("#btn-volver").on("click", function(evento) {
            window.location.href = "<?= base_url(); ?>";
        });

        //Si la cuenta es de tipo entrenador vamos a hacer que los equipos que tengan ya entrenador NO ESTÉN DISPONIBLES
        if ('<?= $_SESSION['tipo_cuenta'] ?>' == "Entrenador") {
            //Esta llamada AJAX retorna los equipos que tienen ya entrenador.
            $.get("<?= base_url('Usuario_C/ObtenerNEntrenadores/' . $_SESSION['liga']) ?>",
                function(dato_devuelto) {
                    let dato = JSON.parse(dato_devuelto);
                    //Recorremos los enlaces de las imagenes y comparamos para saber cuales NO están disponibles
                    for (let equipo of dato) {
                        $('a').each(function() {
                            if ($(this).data('id') == equipo.equipo) {
                                $(this).removeAttr('href');
                                $(this).attr('data-tippy-content', 'Este equipo ya tiene entrenador.');
                                $(this).children().css('opacity', '0.5');
                            }
                        })
                    }
                    //Recorremos todos los A y que no tengan el atributo data-tippy-content
                    $('a').each(function() {
                        if (!$(this).attr('data-tippy-content')) {
                            $(this).attr('data-tippy-content', 'Unete a este equipo haciendo click');
                        }
                    });
                    tippy('a');

                }
            );
        } else {
            $.get("<?= base_url('Usuario_C/obtenerJugadoresEquiposLiga/' . $_SESSION['liga']) ?>",
                function(dato_devuelto) {
                    let nJugadoresEquipo = JSON.parse(dato_devuelto);
                    //Recorremos los enlaces de las imagenes y comparamos para saber cual equipo o equipos están llenos
                    for (equipo of nJugadoresEquipo) {
                        $('a').each(function() {
                            //Si está lleno añadimos atributos
                            if ($(this).data('id') == equipo.equipo && equipo.total == 10) {
                                $("a" + "[data-id=" + equipo.equipo + "]").removeAttr('href');
                                $("a" + "[data-id=" + equipo.equipo + "]").attr('data-tippy-content', 'Equipo lleno.');
                                $("a" + "[data-id=" + equipo.equipo + "]").children().css('opacity', '0.5');
                            }
                        });
                    }
                    //Los que no tengan los atributos añadidos, añadimos los atributos de que el equipo está disponible
                    $('a').each(function() {
                        if (!$(this).attr('data-tippy-content')) {
                            $(this).attr('data-tippy-content', 'Unete a este equipo haciendo click');
                        }
                    });
                    tippy('a');

                }
            );
        }
    });
</script>
<div class="container-fluid border">
    <?php print_r($_SESSION); ?>
    <header class="row d-flex justify-content-around align-items-center">
        <img id="logo" src="<?php echo base_url('assets/img/logo2.png') ?>" class="img-fluid">
    </header>
    <div class="row w-75 d-flex justify-content-center align-items-center mx-auto flex-column">
        <div class="alert alert-warning mb-0" role="alert">
            Si tu equipo no aparece, vuelve al login y pronto el administrador de la liga lo agregará.
        </div>
        <div class="w-75 border d-flex flex-wrap justify-content-between mt-0 pt-0" id="contenedor">
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
        <button type="button" id="btn-volver" class="btn btn-info align-self-bottom mt-4">Volver al login</button>
    </div>
    <footer class="row d-flex justify-content-center align-items-center">
        <h5>Derechos de autor: David Guisado González</h5>
    </footer>