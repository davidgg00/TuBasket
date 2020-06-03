







$(document).ready(function () {
    //nada mas que cargue el documento ejecutar la funcion sumarMarcador por si se va a editar unas estadísticas que el marcador no aparezca a 0
    sumarMarcador();

    //Si hay un cambio en un input de las estadísticas de los jugadores
    $("input").change(function (e) {
        $(this).attr('value', $(this).val());
        //Ejecutamos funcion sumarMarcador()
        sumarMarcador();
    })

    //Si el tipo de cuenta es administrador, aparecerá un botón para guardar partido, de lo contrario, un botón para volver
    if (tipocuenta == 'Administrador') {
        $("table").after("<button id='boton' type='button' class='btn btn-outline-success btn-lg mx-auto'>Guardar Partido</button>");
    } else {
        $("table").after("<button id='btn-volver' type='button' class='btn btn-outline-info btn-lg'>Volver al Calendario</button>");
    }

    //Creamos evento al boton de volver partido
    $("#btn-volver").on("click", function (evento) {
        location.href = base_url + "Admin_c/partidos/" + liga_actual;
    })

    //Creamos evento al boton de enviar para enviar los datos del partido
    $("#boton").on("click", function (evento) {

        //SI EL RESULTADO NO ES EMPATE, SE GUARDA LOS DATOS DEL PARTIDO
        if ($(".equipo:first-child span").html() != $(".equipo:last-child span").html()) {
            //Enviamos una notificación al usuario que, se están guardando los datos del partido.
            var notify = $.notify('<strong>Guardando los datos del partido</strong> No cierres la página...', {
                allow_dismiss: false,
                showProgressbar: true,
            });

            //Este array guardará los <td> con la información que queremos
            let miArray = [];

            //por cada td
            $.each($("tr td"), function () {
                //Si el td tiene un hijo (si tiene un input) guardamos en el array el valor del hijo (el valor del input)
                if ($(this).children().length > 0) {
                    miArray.push($(this).children().val());
                } else {
                    /*Si no hay hijo, es que hay texto,
                    * Pero si tiene la clase d-none es que lleva el USERNAME ya que lo tenemos escondido
                    * y lo necesitamos después para hacer la consulta */
                    if ($(this).hasClass("d-none")) {
                        miArray.push($(this).html());
                    }
                }
            });


            //Enviamos las estadísticas de lo usuarios por AJAX
            $.post(base_url + "Partidos_c/enviarResultado/" + idpartido + "/" + liga_actual, {
                miform: miArray
            }).done(function () {
                //Enviamos el resultado del encuentro por AJAX
                $.post(base_url + "Partidos_c/insertarResultadoEquipos/" + liga_actual, {
                    //Cogemos el total de puntos de cada equipo, el id y la liga
                    equipolocal: $(".equipo:first-child span").html(),
                    equipovisitante: $(".equipo:last-child span").html(),
                    id: idpartido,
                    liga: liga_actual
                }, function () {
                    setTimeout(function () {
                        notify.update({ 'type': 'success', 'message': '<strong>Estadísticas subidas</strong><br> El resultado ha sido correctamente subido a la plataforma.', delay: 10000 });
                    }, 1000);
                }
                );
            });



        } else {
            Swal.fire({
                icon: 'error',
                title: '¡Resultado Erróneo!',
                text: 'Un partido no puede quedar empate. Tiene que haber ganador SI o SI.',
                backdrop: false,
            })
        }
    })

    //Los inputs no podrán tener valores negativos.
    $(".stat").on("keypress", function (evento) {
        if (evento.keyCode == 45) {
            return false;
        }
    })

    //Número máximo 99
    $(".stat").on("keyup", function (evento) {
        if ($(this).val() >= 100) {
            $(this).val("99");
        }
    })
});
function sumarMarcador() {
    let totalLocal = 0;
    let totalVisitante = 0;
    //Y no está disabled (los marcadores)
    $("input:not(.d-none):not(.datos)").each(function () {
        //Miramos su atributo name y dependiendo de este se hace una acción u otra
        switch ($(this).attr('name')) {
            case "triples":
                //Si es el equipo local se añade la puntuación a este, sino al visitante
                if ($(this).data('equipo') == $(".equipo:first-child span").data('id')) {
                    let valor = parseInt($(this).val() * 3);
                    totalLocal += (parseInt(valor));
                } else {
                    let valor = parseInt($(this).val() * 3);
                    totalVisitante += parseInt(valor);
                }
                break;
            case "tiros2":
                //Si es el equipo local se añade la puntuación a este, sino al visitante
                if ($(this).data('equipo') == $(".equipo:first-child span").data('id')) {
                    let valor = parseInt($(this).val() * 2);
                    totalLocal += (parseInt(valor));
                } else {
                    let valor = parseInt($(this).val() * 2);
                    totalVisitante += parseInt(valor);
                }
                break;
            case "tiroslibres":
                //Si es el equipo local se añade la puntuación a este, sino al visitante
                if ($(this).data('equipo') == $(".equipo:first-child span").data('id')) {
                    let valor = parseInt($(this).val());
                    totalLocal += (parseInt(valor));

                } else {
                    let valor = parseInt($(this).val());
                    totalVisitante += parseInt(valor);
                }
                break;
        }
        //Añadimos el valor total a los marcadores
        $(".equipo:first-child span").text(totalLocal);
        $(".equipo:last-child span").text(totalVisitante);
    })
}