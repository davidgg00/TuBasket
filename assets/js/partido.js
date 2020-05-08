







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
    if (tipocuenta != 'Jugador') {
        $("table").after("<button id='boton' type='button' class='btn btn-outline-success btn-lg mx-auto'>Guardar Partido</button>");
    } else {
        $("table").after("<button id='btn-volver' type='button' class='btn btn-outline-info btn-lg'>Volver Partido</button>");
    }

    //Creamos evento al boton de volver partido
    $("#btn-volver").on("click", function (evento) {
        location.href = base_url + "Admin_c/partidos/" + liga_actual;
    })

    //Creamos evento al boton de enviar para enviar los datos del partido
    $("#boton").on("click", function (evento) {

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
        $.post(base_url + "Partidos_c/enviarResultado/" + idpartido, {
            miform: miArray
        });

        //Enviamos el resultado del encuentro por AJAX
        $.post(base_url + "Partidos_c/insertarResultadoEquipos", {
            //Cogemos el total de puntos de cada equipo, el id y la liga
            equipolocal: $(".equipo:first-child span").html(),
            equipovisitante: $(".equipo:last-child span").html(),
            id: idpartido,
            liga: liga_actual
        },
            function (dato_devuelto) {
                //Si nos devuelve Insertado es que ha funcionado correctamente y mostramos SWAL
                if (dato_devuelto == "Insertado") {
                    Swal.fire({
                        backdrop: false,
                        icon: 'success',
                        title: '¡Los datos han sido guardados correctamente!',
                        text: 'Puede ir a la sección Partidos para ver que aparece correctamente.',
                    })
                }
            }
        );
    })
});

function sumarMarcador() {
    let totalLocal = 0;
    let totalVisitante = 0;
    //Y no está disabled (los marcadores)
    $("input:not([disabled])").each(function () {
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
        console.log(totalLocal);
        console.log(totalVisitante);
        $(".equipo:first-child span").text(totalLocal);
        $(".equipo:last-child span").text(totalVisitante);
    })
}