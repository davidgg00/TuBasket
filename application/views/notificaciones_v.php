<div class="row justify-content-center" id="informacion">
    <section class="col-10 d-flex flex-wrap" id="proxpartido">
        <?php
        foreach ($fichajes_pendientes as $fichaje) :
        ?>
            <div class="notificacion border border-dark col-12 h-25">
                <h5><?= $fichaje->solicitante ?> desea realizar un intercambio</h5>
                <h4>Quiere a <?= $fichaje->pide ?></h4>
                <h4>Ofrece a <?= $fichaje->ofrece ?></h4>
                <i class="fas fa-check" data-idfichaje="<?= $fichaje->idfichaje ?>"></i>
                <i class="fas fa-times float-right" data-idfichaje="<?= $fichaje->idfichaje ?>"></i>
            </div>
        <?php endforeach; ?>
    </section>
</div>
<script>
    $(".fa-check").on("click", function(evento) {
        //Al hacer click en aceptar aceptamos el fichaje y por ajax hacemos un UPDATE a la tabla fichajes
        $.post("<?= base_url('Usuario_c/aceptarFichaje') ?>", {
            idfichaje: $(this).data('idfichaje'),
        })

        //y borramos la propuesta de fichaje al usuario
        $(this).parent().remove();
    })

    $(".fa-times").on("click", function(evento) {
        //Al hacer click en denegar, cancelamos el fichaje y por ajax hacemos un UPDATE a la tabla fichajes
        $.post("<?= base_url('Usuario_c/rechazarFichaje') ?>", {
            idfichaje: $(this).data('idfichaje'),
        })

        //y borramos la propuesta de fichaje al usuario
        $(this).parent().remove();
    })
</script>