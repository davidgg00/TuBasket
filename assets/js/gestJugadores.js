$(document).ready(function () {
    $(".aceptar").on("click", function (evento) {
        $.get(baseurl + "GestionJugadores_c/aceptarJugador/" + $(this).data('username'));
        let html = "<tr class='itemPaginacion'><th scope='row'>" + $(this).parent().parent().children().eq(0).html() + "</th><td>" + $(this).parent().parent().children().eq(1).html() + "</td><td>" + $(this).parent().parent().children().eq(2).html() + "</td><td>" + $(this).parent().parent().children().eq(3).html() + "</td><td>" + $(this).parent().parent().children().eq(4).html() + "</td><td><i data-tippy-content='Borrar Equipo' class='fas fa-trash-alt borrarJugador'></i></td></tr>"
        $("#jugadores_confirmados").append(html);
        $(this).parent().parent().remove();
        if ($("#listaJugadoresSinConfirmar table tbody").children().length == 0) {
            $("#listaJugadoresSinConfirmar").stop().fadeOut('slow', function (evento) {
                $(this).removeClass("d-flex");
                $(this).css('display', 'none')
            });
        }
        //Añadimos accion al borrado de jugadores
        $(".borrarJugador").on("click", function (evento) {
            Swal.fire({
                title: '¿Estás seguro de que quieres borrar el usuario?',
                text: "¡Una vez que lo elimines no podrás recuperarlo!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Confirmar',
                backdrop: false,
            }).then((result) => {
                if (result.value) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Jugador Borrado!',
                        text: 'Has borrado el jugador correctamente.',
                        backdrop: false,
                    }).then(() => {
                        //Enviamos el username
                        $.post(window.location.origin + "/TuBasket/GestionJugadores_c/eliminarJugador/" + $(this).parent().parent().children(":first").html());
                        //quitamos el el tr del DOM y recargamos la paginación.
                        $(this).parent().parent().remove();
                        $(".activePagination").click();
                    })
                }
            })
        })
    });
    $(".denegar").on("click", function (evento) {
        $.get(baseurl + "GestionJugadores_c/eliminarJugador/" + $(this).data('username'));
        $(this).parent().parent().remove();
        if ($("#listaJugadoresSinConfirmar table tbody").children().length == 0) {
            $("#listaJugadoresSinConfirmar").stop().fadeOut('slow', function (evento) {
                $(this).removeClass("d-flex");
                $(this).css('display', 'none')
            });
        }
    })

    //Añadimos tooltip a los .aceptar y .denegar
    tippy('.aceptar, .denegar');

    //Añadimos accion al borrado de jugadores
    $(".borrarJugador").on("click", function (evento) {
        Swal.fire({
            title: '¿Estás seguro de que quieres borrar el usuario?',
            text: "¡Una vez que lo elimines no podrás recuperarlo!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Confirmar',
            backdrop: false,
        }).then((result) => {
            if (result.value) {
                Swal.fire({
                    icon: 'success',
                    title: '¡Jugador Borrado!',
                    text: 'Has borrado el jugador correctamente.',
                    backdrop: false,
                }).then(() => {
                    //Enviamos el username
                    $.post(window.location.origin + "/TuBasket/GestionJugadores_c/eliminarJugador/" + $(this).parent().parent().children(":first").html());
                    //quitamos el el tr del DOM y recargamos la paginación.
                    $(this).parent().parent().remove();
                    $(".activePagination").click();
                })
            }
        })
    })
});