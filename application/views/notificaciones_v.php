<style>
    .notificacion img {
        width: 130px;
        height: 150px;
    }

    .fa-arrow-right {
        font-size: 5em;
    }

    .jugadores {
        width: 80%;
    }

    .accion {
        width: 90%;
    }

    i.fa-check {
        font-size: 20px;
    }

    i.fa-times {
        font-size: 22px;
    }

    .denegar {
        padding: 10px 12px;
    }

    .aceptar {
        padding: 10px;
    }
</style>
<script>
    $(document).ready(function() {

        $(".notificacion").each(function() {

            if ($(this).data('estado') != "PENDIENTE") {

                $.post("<?= base_url('Notificaciones_c/leerTodasNotificaciones') ?>", {
                        idfichaje: $(this).data('idfichaje'),
                        equipo: <?= $_SESSION['equipo'] ?>,
                        equipo_solicitante: $(this).data('equipo_solicitante')
                    },
                    function(dato_devuelto) {
                        console.log(dato_devuelto);
                        console.log("hey");
                    },
                    "dataType"
                );
            }
        });
    });
</script>
<div class="row justify-content-center" id="informacion">
    <section class="col-10" id="proxpartido">
        <?php
        foreach ($fichajes as $n => $fichaje) : ?>
            <div class="notificacion border border-dark col-12 text-center p-3" data-equipo_solicitante="<?= $fichaje->idEquipoSolicitante ?>" data-estado="<?= $fichaje->estado ?>" data-idfichaje="<?= $fichaje->idfichaje ?>">
                <?php if ($fichaje->estado == "PENDIENTE") : ?>
                    <?php if ($fichaje->idEquipoRecibe == $_SESSION['equipo']) : ?>
                        <h5>El <?= $fichaje->equipoSolicitante ?> desea realizar un intercambio</h5>
                        <div class="d-flex align-items-center justify-content-between w-75 mx-auto border fotos">
                            <img src="<?= base_url($fichaje->img_jugador_ofrece) ?>" class="img-fluid rounded-circle" alt="">
                            <i class="fas fa-arrow-right "></i>
                            <img src="<?= base_url($fichaje->img_jugador_pide) ?>" class="img-fluid rounded-circle" alt="">
                        </div>
                        <div class="jugadores d-flex align-items-center justify-content-between mx-auto border">
                            <h4 class="d-inline"><?= $fichaje->pide ?></h4>
                            <h4 class="d-inline"><?= $fichaje->ofrece ?></h4>
                        </div>
                        <div class="mt-2 accion d-flex justify-content-between mx-auto d-flex">
                            <div class="aceptar bg-success d-flex justify-content-center align-items-center">
                                <i class="fas fa-check" data-idfichaje="<?= $fichaje->idfichaje ?>"></i>
                            </div>
                            <div class="denegar bg-danger d-flex justify-content-center align-items-center">
                                <i class="fas fa-times float-right" data-idfichaje="<?= $fichaje->idfichaje ?>"></i>
                            </div>
                        </div>
                    <?php else : ?>
                        <h5><?= $n += 1 ?>. El fichaje a <?= $fichaje->equipoRecibe ?> (<?= $fichaje->pide ?> -> <?= $fichaje->ofrece ?>) está <?= $fichaje->estado ?></h5>
                    <?php endif; ?>
                <?php else : ?>
                    <?php if ($fichaje->idEquipoRecibe == $_SESSION['equipo']) : ?>
                        <h5><?= $n += 1 ?>. Has <?= $fichaje->estado ?> la propuesta del <?= $fichaje->equipoSolicitante ?>(<?= $fichaje->pide ?> -> <?= $fichaje->ofrece ?>)</h5>
                    <?php else : ?>
                        <h5><?= $n += 1 ?>. El <?= $fichaje->equipoRecibe ?> te ha <?= $fichaje->estado ?> la propuesta del (<?= $fichaje->pide ?> -> <?= $fichaje->ofrece ?>)</h5>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </section>
</div>
<script>
    $(".aceptar").on("click", function(evento) {
        //Al hacer click en aceptar aceptamos el fichaje y por ajax hacemos un UPDATE a la tabla fichajes
        $.post("<?= base_url('Fichajes_c/aceptarFichaje') ?>", {
            idfichaje: $(this).children().data('idfichaje'),
        })

        //y borramos la propuesta de fichaje al usuario
        $(this).parent().parent().fadeOut('slow');
    })

    $(".denegar").on("click", function(evento) {
        //Al hacer click en denegar, cancelamos el fichaje y por ajax hacemos un UPDATE a la tabla fichajes
        $.post("<?= base_url('Fichajes_c/rechazarFichaje') ?>", {
            idfichaje: $(this).children().data('idfichaje'),
        })

        //y borramos la propuesta de fichaje al usuario
        $(this).parent().parent().fadeOut('slow');
        setTimeout(function() {
            window.location.reload(1);
        }, 1000);
    })
</script>