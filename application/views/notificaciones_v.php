<script>
    $(document).ready(function() {
        let notificaciones = '<?= json_encode($fichajes) ?>';
        notificaciones = JSON.parse(notificaciones);
        //Creamos otro array con las notificaciones para la numeración de la paginación
        let fichajes = notificaciones;
        console.log(notificaciones[0].idfichaje);
        let n = 1;
        $("#paginacion").pagination({
            dataSource: notificaciones,
            pageSize: 6,
            callback: function(notificaciones) {
                $(".notificacion").remove();
                for (let notificacion of notificaciones) {
                    if (notificacion.idfichaje == fichajes[0].idfichaje) {
                        n = 1;
                    }
                    let html = "<div class='notificacion col-12 text-center p-3 itemPaginacion' data-estado='" + notificacion.estado + "' data-idfichaje='" + notificacion.idfichaje + "'>";
                    if (notificacion.estado == "PENDIENTE") {
                        if (notificacion.EntrenadorRecibe == '<?= $_SESSION['username'] ?>') {
                            html += "<h5 class='text-center'>El '" + notificacion.equipoSolicitante + "' desea realizar un intercambio</h5>";
                            html += "<div class='d-flex align-items-center justify-content-between w-75 mx-auto fotos'><img src='<?= base_url() ?>" + notificacion.img_jugador_ofrece + "' class='img-fluid rounded-circle'><i class='fas fa-arrow-right'></i><img src='<?= base_url() ?>" + notificacion.img_jugador_pide + "' class='img-fluid rounded-circle'></div>";
                            html += "<div class='jugadores d-flex align-items-center justify-content-between mx-auto'><h4 class='d-inline'>" + notificacion.pide + "</h4><h4 class='d-inline'>" + notificacion.ofrece + "</h4></div>";
                            html += "<div class='mt-2 accion d-flex justify-content-between mx-auto d-flex'><div class='aceptar bg-success d-flex justify-content-center align-items-center'><i class='fas fa-check' data-idfichaje='" + notificacion.idfichaje + "'></i></div><div class='denegar bg-danger d-flex justify-content-center align-items-center'><i class='fas fa-times float-right' data-idfichaje='" + notificacion.idfichaje + "'></i></div></div>";
                            html += "</div>";

                        } else {
                            html += "<h5><span>" + n + ".</span>El fichaje (" + notificacion.pide + " -> " + notificacion.ofrece + ") está " + notificacion.estado + "</h5>";
                        }
                    } else {
                        if (notificacion.EntrenadorRecibe == '<?= $_SESSION['username'] ?>') {
                            html += "<h5><span>" + n + ".</span> Has " + notificacion.estado + " la propuesta del " + notificacion.equipoSolicitante + "(" + notificacion.pide + " -> " + notificacion.ofrece + ")</h5>";
                        } else {
                            html += "<h5><span>" + n + ".</span>La propuesta del (" + notificacion.pide + " -> " + notificacion.ofrece + ") ha sido " + notificacion.estado + "</h5>"
                        }
                    }
                    html += "</div>";
                    $("#notificacionesWrapper").append(html);
                    n++;
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
                    });
                }
            }
        })
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
        });

        $(".notificacion").each(function() {

            if ($(this).data('estado') != "PENDIENTE") {
                $.post("<?= base_url('Notificaciones_c/leerTodasNotificaciones') ?>", {
                    idfichaje: $(this).data('idfichaje'),
                    equipo: <?= $_SESSION['equipo'] ?>,
                    equipo_solicitante: $(this).data('equipo_solicitante')
                });
            }
        });
    });
</script>
<div class="row justify-content-center" id="informacion">
    <section class="col-10 d-flex flex-wrap align-content-space-around justify-content-center">
        <h4 class="mt-2 text-center w-100">Notificaciones</h4>
        <div id="notificacionesWrapper" class="col-12">

        </div>
        <div id="paginacion" class="w-100"></div>
    </section>
</div>