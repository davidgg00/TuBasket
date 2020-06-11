$(document).ready(function () {
    notificaciones = JSON.parse(notificaciones);
    //Creamos otro array con las notificaciones para la numeración de la paginación
    let fichajes = notificaciones;
    console.log(notificaciones[0].idfichaje);
    let n = 1;
    $("#paginacion").pagination({
        dataSource: notificaciones,
        pageSize: 6,
        callback: function (notificaciones) {
            $(".notificacion").remove();
            for (let notificacion of notificaciones) {
                if (notificacion.idfichaje == fichajes[0].idfichaje) {
                    n = 1;
                }
                let html = "<div class='notificacion col-12 text-center itemPaginacion' data-estado='" + notificacion.estado + "' data-idfichaje='" + notificacion.idfichaje + "'>";
                if (notificacion.estado == "PENDIENTE") {
                    if (notificacion.EntrenadorRecibe == username) {
                        html += "<h5 class='text-center'>El '" + notificacion.equipoSolicitante + "' desea realizar un intercambio</h5>";
                        html += "<div class='d-flex align-items-center justify-content-between w-75 mx-auto fotos'><img src='" + baseurl + notificacion.img_jugador_pide + "' class='img-fluid rounded-circle'><i class='fas fa-arrow-right'></i><img src='" + baseurl + notificacion.img_jugador_ofrece + "' class='img-fluid rounded-circle'></div>";
                        html += "<div class='jugadores d-flex align-items-center justify-content-between mx-auto'><h4 class='d-inline'>" + notificacion.pide + "</h4><h4 class='d-inline'>" + notificacion.ofrece + "</h4></div>";
                        html += "<div class='mt-2 accion d-flex justify-content-between mx-auto d-flex'><div class='aceptar bg-success d-flex justify-content-center align-items-center'><i class='fas fa-check' data-idfichaje='" + notificacion.idfichaje + "'></i></div><div class='denegar bg-danger d-flex justify-content-center align-items-center'><i class='fas fa-times float-right' data-idfichaje='" + notificacion.idfichaje + "'></i></div></div>";
                        html += "</div>";

                    } else {
                        html += "<h5><span>" + n + ".</span>El fichaje (" + notificacion.pide + " -> " + notificacion.ofrece + ") está " + notificacion.estado + "</h5>";
                    }
                } else {
                    if (notificacion.EntrenadorRecibe == username) {
                        html += "<h5><span>" + n + ".</span> Has " + notificacion.estado + " la propuesta del " + notificacion.equipoSolicitante + "(" + notificacion.pide + " -> " + notificacion.ofrece + ")</h5>";
                    } else {
                        html += "<h5><span>" + n + ".</span>La propuesta del (" + notificacion.pide + " -> " + notificacion.ofrece + ") ha sido " + notificacion.estado + "</h5>"
                    }
                }
                html += "</div>";
                $("#notificacionesWrapper").append(html);
                n++;
                $(".aceptar").on("click", function (evento) {
                    //Al hacer click en aceptar aceptamos el fichaje y por ajax hacemos un UPDATE a la tabla fichajes
                    $.post(baseurl + "Fichajes_c/aceptarFichaje", {
                        idfichaje: $(this).children().data('idfichaje'),
                    })

                    //y borramos la propuesta de fichaje al usuario
                    $(this).parent().parent().fadeOut('slow');
                })

                $(".denegar").on("click", function (evento) {
                    //Al hacer click en denegar, cancelamos el fichaje y por ajax hacemos un UPDATE a la tabla fichajes
                    $.post(baseurl + "Fichajes_c/rechazarFichaje", {
                        idfichaje: $(this).children().data('idfichaje'),
                    })

                    //y borramos la propuesta de fichaje al usuario
                    $(this).parent().parent().fadeOut('slow');
                    setTimeout(function () {
                        window.location.reload(1);
                    }, 1000);
                });
            }
        }
    })
    $(".aceptar").on("click", function (evento) {
        //Al hacer click en aceptar aceptamos el fichaje y por ajax hacemos un UPDATE a la tabla fichajes
        $.post(baseurl + "Fichajes_c/aceptarFichaje", {
            idfichaje: $(this).children().data('idfichaje'),
        })
        //y borramos la propuesta de fichaje al usuario
        $(this).parent().parent().fadeOut('slow');
        //Recargamos la página
        setTimeout(function () {
            window.location.reload(1);
        }, 1000);
    })

    $(".denegar").on("click", function (evento) {
        //Al hacer click en denegar, cancelamos el fichaje y por ajax hacemos un UPDATE a la tabla fichajes
        $.post(baseurl + "Fichajes_c/rechazarFichaje", {
            idfichaje: $(this).children().data('idfichaje'),
        })

        //y borramos la propuesta de fichaje al usuario
        $(this).parent().parent().fadeOut('slow');
        setTimeout(function () {
            window.location.reload(1);
        }, 1000);
    });

    $(".notificacion").each(function () {

        if ($(this).data('estado') != "PENDIENTE") {
            $.post(baseurl + "Notificaciones_c/leerTodasNotificaciones", {
                idfichaje: $(this).data('idfichaje'),
                equipo: equipo,
                equipo_solicitante: $(this).data('equipo_solicitante')
            });
        }
    });
});