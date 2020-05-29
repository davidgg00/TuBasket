$(document).ready(function () {
    //El botón de volver, al hacer click lo redirigimos al Login
    $("#btn-volver").on("click", function (evento) {
        window.location.href = base_url;
    });

    //Si la cuenta es de tipo entrenador vamos a hacer que los equipos que tengan ya entrenador NO ESTÉN DISPONIBLES
    if (tipo_cuenta == "Entrenador") {
        //Esta llamada AJAX retorna los equipos que tienen ya entrenador.
        $.get(base_url + "Usuario_C/ObtenerNEntrenadores/" + liga,
            function (dato_devuelto) {
                let dato = JSON.parse(dato_devuelto);
                //Recorremos los enlaces de las imagenes y comparamos para saber cuales NO están disponibles
                for (let equipo of dato) {
                    $('a').each(function () {
                        if ($(this).data('id') == equipo.equipo) {
                            $(this).removeAttr('href');
                            $(this).attr('data-tippy-content', 'Este equipo ya tiene entrenador.');
                            $(this).children().css('opacity', '0.5');
                        }
                    })
                }
                //Recorremos todos los A y que no tengan el atributo data-tippy-content
                $('a').each(function () {
                    if (!$(this).attr('data-tippy-content')) {
                        $(this).attr('data-tippy-content', 'Unete a este equipo haciendo click');
                    }
                });
                tippy('a');

            }
        );
    } else {
        $.get(base_url + 'Usuario_C/obtenerJugadoresEquiposLiga/' + liga,
            function (dato_devuelto) {
                console.log(dato_devuelto);
                let nJugadoresEquipo = JSON.parse(dato_devuelto);
                console.log(base_url + 'Usuario_C/obtenerJugadoresEquiposLiga/' + liga);
                //Recorremos los enlaces de las imagenes y comparamos para saber cual equipo o equipos están llenos
                for (equipo of nJugadoresEquipo) {
                    $('a').each(function () {
                        //Si está lleno añadimos atributos
                        if ($(this).data('id') == equipo.equipo && equipo.total == 10) {
                            $("a" + "[data-id=" + equipo.equipo + "]").removeAttr('href');
                            $("a" + "[data-id=" + equipo.equipo + "]").attr('data-tippy-content', 'Equipo lleno.');
                            $("a" + "[data-id=" + equipo.equipo + "]").children().css('opacity', '0.5');
                        }
                    });
                }
                //Los que no tengan los atributos añadidos, añadimos los atributos de que el equipo está disponible
                $('a').each(function () {
                    if (!$(this).attr('data-tippy-content')) {
                        $(this).attr('data-tippy-content', 'Unete a este equipo haciendo click');
                    }
                });
                tippy('a');

            }
        );
    }
});