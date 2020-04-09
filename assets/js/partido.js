

//Llamada ajax que también se ejecuta nada mas abrir el documento 
//Que nos muestra las imagenes de los equipos y sus nombres
$.ajax({
    type: "POST",
    url: base_url + "Partidos_c/getPartido/" + idpartido,
    success: function (response) {
        let dato = JSON.parse(response);
        $("#equipos").append("<div class='equipo d-flex justify-content-center flex-wrap align-items-center'><img id='" + dato.id_local + "' class='img-fluid' src=" + base_url + dato.escudo_local + " > <p class='w-100 text-center'>" + dato.equipo_local + "</p> <input value='0' type='number' class='w-25 mx-auto' disabled id='" + dato.id_local + "' data-id='" + dato.equipo_local + "'></div>");
        $("#equipos").append("<div class='equipo d-flex justify-content-center flex-wrap align-items-center'><img id='" + dato.id_visitante + "' class='img-fluid' src=" + base_url + dato.escudo_visitante + " > <p class='w-100 text-center'>" + dato.equipo_visitante + "</p> <input value='0' type='number' class='w-25 mx-auto' disabled id='" + dato.id_visitante + "' data-id='" + dato.equipo_visitante + "'></div>");
        $("div.equipo:first-child").after("<div class='equipo d-flex justify-content-center flex-wrap'><img class='img-fluid' src='" + base_url + "assets/img/vs.png'></div> ")
    }
});

//Ajax que se ejecuta nada mas cargar la página que te muestra la tabla con los usuarios 
//que han jugado el partido
$.ajax({
    type: "POST",
    url: base_url + "Partidos_c/getJugadoresPartidos/" + idpartido,
    success: function (response) {
        let datos = JSON.parse(response);
        let disabled = tipocuenta == 'Jugador' || tipocuenta == 'Entrenador' ? " disabled " : "";
        //Creamos el html y lo añadimos después del tbody
        let valuetriples, valuetiros2, valuetiroslibres, tapones, robos;
        for (let dato of datos) {
            valuetriples = dato.triples_metidos ? dato.triples_metidos : "0";
            valuetiros2 = dato.tiros_2_metidos ? dato.tiros_2_metidos : "0";
            valuetiroslibres = dato.tiros_libres_metidos ? dato.tiros_libres_metidos : "0";
            tapones = dato.tapones ? dato.tapones : "0";
            robos = dato.robos ? dato.robos : "0";

            //Si el id del equipo es igual que el del local, que el html haga prepend al tbody de lo contrario append
            //Esto se hace para que salgan siempre primero los jugadores locales antes que los visitantes.
            if (dato.idequipo == $(".equipo:nth-child(1) img").attr('id')) {
                let html = "<tr class='text-center'>";
                html += "<td class='d-none'>" + dato.username + "</td><td class='datos'> " + dato.apenom + "</td><td class='datos'>" + dato.equipo + "</td><td><input " + disabled + " value='" + valuetriples + "' data-equipo='" + dato.equipo + "' min='0' class='w-50' class='w-50' size='10' type='number' name='triples'></td><td><input " + disabled + " value='" + valuetiros2 + "' data-equipo='" + dato.equipo + "' min='0' class='w-50' size='10' type='number' name='tiros2'></td><td><input " + disabled + " value='" + valuetiroslibres + "' data-equipo='" + dato.equipo + "' min='0' class='w-50' size='10' type='number' name='tiroslibres'></td><td><input " + disabled + " value='" + tapones + "' data-equipo='" + dato.equipo + "' min='0' class='w-50' size='10' type='number' name='tapones'></td><td><input " + disabled + "value='" + robos + "' data-equipo='" + dato.equipo + "' min='0' class='w-50' size='10' type='number' name='robos'></td>"
                html += "</tr>";
                $("tbody").prepend(html);
            } else {
                let html = "<tr class='text-center'>";
                html += "<td class='d-none'>" + dato.username + "</td><td class='datos'> " + dato.apenom + "</td><td class='datos'>" + dato.equipo + "</td><td><input " + disabled + " value='" + valuetriples + "' data-equipo='" + dato.equipo + "' min='0' class='w-50' class='w-50' size='10' type='number' name='triples'></td><td><input " + disabled + " value='" + valuetiros2 + "' data-equipo='" + dato.equipo + "' min='0' class='w-50' size='10' type='number' name='tiros2'></td><td><input " + disabled + " value='" + valuetiroslibres + "' data-equipo='" + dato.equipo + "' min='0' class='w-50' size='10' type='number' name='tiroslibres'></td><td><input " + disabled + " value='" + tapones + "' data-equipo='" + dato.equipo + "' min='0' class='w-50' size='10' type='number' name='tapones'></td><td><input " + disabled + "value='" + robos + "' data-equipo='" + dato.equipo + "' min='0' class='w-50' size='10' type='number' name='robos'></td>"
                html += "</tr>";
                $("tbody").append(html);
            }

        }

        //Si el tipo de cuenta es administrador, aparecerá un botón para guardar partido, de lo contrario, un botón para volver
        if (tipocuenta != 'Jugador') {
            $("table").after("<button id='boton' type='button' class='btn btn-outline-success btn-lg'>Guardar Partido</button>");
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
            $.each($("tr td"), function () {
                //Si el td tiene un hijo (input) guardamos en el array el valor del hijo
                if ($(this).children().length > 0) {
                    miArray.push($(this).children().val());
                } else {
                    //Si no hay hijo, es que hay texto, pero solo queremos el username que lo tenemos escondido (porque no lo veia necesario ponerlo)
                    if ($(this).hasClass("d-none")) {
                        miArray.push($(this).html());
                    }
                }
            });
            //Enviamos los datos por post
            $.post(base_url + "Partidos_c/enviarResultado/" + idpartido, {
                miform: miArray
            });

            //Creamos ajax para insertar simplemente el resultado del equipo, no el de los jugadores
            $.post(base_url + "Partidos_c/insertarResultadoEquipos", {
                //Cogemos el total de puntos de cada equipo, el id y la liga
                equipolocal: $(".equipo:first-child input").val(),
                equipovisitante: $(".equipo:last-child input").val(),
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

        //Si hay un cambio en un input
        $("input").change(function (e) {
            //Ejecutamos funcion sumarMarcador()
            sumarMarcador();
        })
        //Nada mas que termine el ajax ejecutamos la función de sumarMarcador porque puede ser que esté editando
        //Una estadística en concreto y entonces NO aparecerán las estadísticas a 0
        sumarMarcador();
    }
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
                if ($(this).data('equipo') == $(".equipo:first-child input").data('id')) {
                    let valor = parseInt($(this).val() * 3);
                    totalLocal += (parseInt(valor));
                } else {
                    let valor = parseInt($(this).val() * 3);
                    totalVisitante += parseInt(valor);
                }
                break;
            case "tiros2":
                //Si es el equipo local se añade la puntuación a este, sino al visitante
                if ($(this).data('equipo') == $(".equipo:first-child input").data('id')) {
                    let valor = parseInt($(this).val() * 2);
                    totalLocal += (parseInt(valor));
                } else {
                    let valor = parseInt($(this).val() * 2);
                    totalVisitante += parseInt(valor);
                }
                break;
            case "tiroslibres":
                //Si es el equipo local se añade la puntuación a este, sino al visitante
                if ($(this).data('equipo') == $(".equipo:first-child input").data('id')) {
                    let valor = parseInt($(this).val());
                    totalLocal += (parseInt(valor));

                } else {
                    let valor = parseInt($(this).val());
                    totalVisitante += parseInt(valor);
                }
                break;
        }
        //Añadimos el valor total a los marcadores
        $(".equipo:first-child input").val(totalLocal);
        $(".equipo:last-child input").val(totalVisitante);
    })
}