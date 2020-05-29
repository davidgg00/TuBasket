$(document).ready(function () {

    //si se hace click en un td que no tiene la clase comparar (no se clicka en un checkbox)
    $("tr td").on("click", function (evento) {
        if (!$(this).hasClass('comparar')) {
            //Te redirija a las estadísticas individuales del jugador clickado
            window.location.href = baseurl + "Usuario_c/estadisticas/" + $(this).parent().children(':first').html();
        }
    })

    //Al intentar comparar jugadores
    $("#compararJugadores").on("submit", function (evento) {
        //Creamos un array
        let jugadores = [];
        $("tr td").each(function (index, elemento) {
            if ($(elemento).hasClass('comparar') && $(elemento).children().is(':checked')) {
                //pillamos el username del jugador que está en un td:hidden en la misma fila y primera posición y lo guardamos.
                jugadores.push($(elemento).parent().children(':first').html());
            }
        });

        //Si se han seleccionado menos de 2 jugadores o más de 2 jugadores aparecerán distintos errores
        if (jugadores.length < 0 || jugadores.length < 2 || jugadores.length == 3) {
            evento.preventDefault();
            if (jugadores.length == 0 || jugadores.length < 2) {
                $("#alerta-comparar").html("Tienes que comparar dos jugadores.");
                $("#alerta-comparar").slideDown(500);
            } else {
                $("#alerta-comparar").html("Solo puedes comparar como máximo dos jugadores.");
                $("#alerta-comparar").slideDown(500);
            }

            //Quitamos error.
            window.setTimeout(function () {
                $("#alerta-comparar").fadeTo(500, 0).slideUp(800, function () {
                    $(this).css('opacity', '');
                });
            }, 3000);
        }
    })
});