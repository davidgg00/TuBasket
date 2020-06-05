//Cuando se haya cargado el documento
$(document).ready(function () {
    //Si el número de partidos es mayor que 0 generamos paginacion
    if (partidos.length > 0) {
        calendario()
    }
    $("button#generarLiga").on("click", function (evento) {
        window.location.href = base_url + "Partidos_c/generarLiga/" + liga;
    })
    $(".btn-reset").on("click", function (evento) {
        $(this).parent().parent().children().eq(1).html(" - ");
        $.post(base_url + "Partidos_c/resetPartido", {
            idPartido: $(this).data('id')
        });
        $.notify({
            title: '<strong class="">¡Partido Reseteado!</strong><br>',
            message: 'El partido ahora mismo se encontrará como si no se hubiese jugado.'
        }, {
            type: 'success'
        });
    })

    // Si el numero de equipos no es el correcto, el boton de generar ligas está disabled
    if (nequipos == 8 || nequipos == 10) {
        $("#btn-generarLiga").on("click", function (evento) {
            window.location.href = base_url + "Partidos_c/generarLiga/" + liga;
        });
    } else {
        $("#btn-generarLiga").prop('disabled', true);
    }
});
function calendario() {
    //Creo unas variables para controlar el numero de la jornada y que cree una tabla nueva cada x partidos
    let jornada = 1;
    let npartido = 0;
    //Si la cuenta es de tipo jugador esta variable almacenará "disabled" y se le introducirá a los inputs de fecha y hora para 
    //que los jugadores y entrenadores no puedan cambiar los datos del encuentro
    let disabled = (tipo_cuenta == "Jugador" || tipo_cuenta == "Entrenador") ? "disabled" : "";
    //Dependiendo de si hay 8 o 10 equipos habrá 4 o 5 partidos por jornada.
    switch (nequipos) {
        case 8:
            $("#paginacion").pagination({
                dataSource: partidos,
                pageSize: 16,
                callback: function (partidosPaginacion, pagination) {
                    $("#calendarioWrapper").html("");
                    switch (pagination.pageNumber) {
                        case 1:
                            jornada = 1
                            break;

                        case 2:
                            jornada = 5
                            break;
                        case 3:
                            jornada = 9
                            break;
                        case 4:
                            jornada = 13
                            break;
                    }
                    for (let partido of partidosPaginacion) {

                        //Si la cuenta es de tipo jugador la fila de modificar o resetear partido no debe de aparecer.
                        let thaccion = (tipo_cuenta == "Administrador") ? "<th>Acción</th>" : "";
                        let accion = (tipo_cuenta == "Administrador") ? "<td><i class='fas fa-edit' data-id='" + partido.id + "' data-tippy-content='Haga click para escribir resultado'></i><i class='fas fa-sync btn-reset' data-id='" + partido.id + "'></i></td>" : "";
                        let colspan = (tipo_cuenta == "Administrador") ? "6" : "5";
                        //Volteamos fecha debido al formato que tiene PHPMYADMIN
                        let fechaArray = partido.fecha.split('-');
                        let fecha = fechaArray[2] + '-' + fechaArray[1] + '-' + fechaArray[0];
                        //Creamos una variable que almacene el resultado directamente
                        resultado_completo = partido.resultado_local + " - " + partido.resultado_visitante
                        //Si el partido es divisible entre 4 crear un nuevo div porque es nueva jornada
                        if (npartido % 4 == 0 || npartido == 0) {
                            $("#calendarioWrapper").append("<div class='jornada mt-2 table-responsive p-0'><table class='table table-hover'><thead><tr><th colspan='" + colspan + "'>JORNADA " + jornada + "</th></tr><tr><th>Local</th><th>Resultado</th><th>Visitante</th><th id='fecha'>Fecha</th><th>Hora</th>" + thaccion + "</tr></thead><tbody  id='jornada" + jornada + "'><tr class='partido'><td>" + partido.equipo_local + "</td><td data-id='" + partido.id + "'>" + resultado_completo + "</td><td>" + partido.equipo_visitante + "</td><td><input type='text' id='" + partido.id + "' class='datepick w-100 mx-auto' value='" + fecha + "' " + disabled + "></td><td><input id='" + partido.id + "' class='hora w-100 mx-auto text-center ' type='time' step='60' value='" + partido.hora + "'" + disabled + "></td></td>" + accion + "</tr></tbody></table></div>")
                            jornada++;
                        } else {
                            $("tbody").last().append("<tr class='partido'><td>" + partido.equipo_local + "</td><td data-id='" + partido.id + "'>" + resultado_completo + "</td><td>" + partido.equipo_visitante + "</td><td><input type='text' id='" + partido.id + "' class='datepick w-100 mx-auto' value='" + fecha + "' " + disabled + "></td><td><input id='" + partido.id + "' class='hora w-100 mx-auto text-center ' type='time' step='60' value='" + partido.hora + "' " + disabled + "></td></td>" + accion + "</tr>")
                        }
                        npartido++;
                    }
                }
            });

            break;

        case 10:
            $("#paginacion").pagination({
                dataSource: partidos,
                pageSize: 20,
                callback: function (partidosPaginacion, pagination) {
                    $("#calendarioWrapper").html("");
                    switch (pagination.pageNumber) {
                        case 1:
                            jornada = 1
                            break;

                        case 2:
                            jornada = 5
                            break;
                        case 3:
                            jornada = 9
                            break;
                        case 4:
                            jornada = 13
                            break;
                        case 5:
                            jornada = 17
                            break;
                    }
                    for (let partido of partidosPaginacion) {
                        //Si la cuenta es de tipo jugador la fila de modificar o resetear partido no debe de aparecer.
                        let thaccion = (tipo_cuenta == "Administrador") ? "<th>Acción</th>" : "";
                        let accion = (tipo_cuenta == "Administrador") ? "<td><i class='fas fa-edit' data-id='" + partido.id + "' data-tippy-content='Haga click para escribir resultado'></i><i class='fas fa-sync btn-reset' data-id='" + partido.id + "'></i></td>" : "";
                        let colspan = (tipo_cuenta == "Administrador") ? "6" : "5";
                        //Volteamos fecha debido al formato que tiene PHPMYADMIN
                        let fechaArray = partido.fecha.split('-');
                        let fecha = fechaArray[2] + '-' + fechaArray[1] + '-' + fechaArray[0];
                        //Creamos una variable que almacene el resultado directamente
                        resultado_completo = partido.resultado_local + " - " + partido.resultado_visitante
                        //Si el partido es divisible entre 4 crear un nuevo div porque es nueva jornada
                        if (npartido % 5 == 0 || npartido == 0) {
                            $("#calendarioWrapper").append("<div class='jornada mt-2 table-responsive p-0'><table class='table table-hover'><thead><tr><th colspan='" + colspan + "'>JORNADA " + jornada + "</th></tr><tr><th>Local</th><th>Resultado</th><th>Visitante</th><th id='fecha'>Fecha</th><th>Hora</th>" + thaccion + "</tr></thead><tbody  id='jornada" + jornada + "'><tr class='partido'><td>" + partido.equipo_local + "</td><td data-id='" + partido.id + "'>" + resultado_completo + "</td><td>" + partido.equipo_visitante + "</td><td><input type='text' id='" + partido.id + "' class='datepick w-100 mx-auto' value='" + fecha + "' " + disabled + "></td><td><input id='" + partido.id + "' class='hora w-100 mx-auto text-center ' type='time' step='60' value='" + partido.hora + "'" + disabled + "></td></td>" + accion + "</tr></tbody></table></div>")
                            jornada++;
                        } else {
                            $("tbody").last().append("<tr class='partido'><td>" + partido.equipo_local + "</td><td data-id='" + partido.id + "'>" + resultado_completo + "</td><td>" + partido.equipo_visitante + "</td><td><input type='text' id='" + partido.id + "' class='datepick w-100 mx-auto' value='" + fecha + "' " + disabled + "></td><td><input id='" + partido.id + "' class='hora w-100 mx-auto text-center ' type='time' step='60' value='" + partido.hora + "' " + disabled + "></td></td>" + accion + "</tr>")
                        }
                        npartido++;
                    }
                }
            });
            break;
    }
    //Añadimos acciones a los botones de acciones
    $(".fa-edit").on("click", function () {
        var id = $(this).data('id');
        //Antes de editar un partido, si el equipo no tiene el numero de jugadores minimo no podrá ser editado.
        $.get(base_url + "Partidos_c/getNJugadoresPartido/" + id,
            function (njugadores) {
                let njugadoresEncuentro = JSON.parse(njugadores);
                if (njugadoresEncuentro.length == "0") {
                    Swal.fire({
                        backdrop: false,
                        icon: 'error',
                        title: 'Ooops....',
                        text: 'Algún equipo (o ambos) no tiene como mínimo 5 jugadores en su plantilla.',
                    })
                } else {
                    if (njugadoresEncuentro[0].totalEquipo >= 5 && njugadoresEncuentro[1].totalEquipo >= 5) {
                        //Redirigimos al partido.
                        window.location.href = base_url + "Admin_c/partido/" + liga + "/" + id;
                    } else {
                        Swal.fire({
                            backdrop: false,
                            icon: 'error',
                            title: 'Ooops....',
                            text: 'Algún equipo (o ambos) no tiene como mínimo 5 jugadores en su plantilla.',
                        })
                    }
                }

            },
        );
    });

    //Añadimos el tooltip al .fa-edit
    tippy('.fa-edit');

    //Añadimos el datepick y un ajax si cambia el admin la fecha
    $(".datepick").datepicker({
        dateFormat: 'dd-mm-yy'
    });
    $(".datepick").on("change", function (evento) {
        //Volteamos fecha debido al formato
        let fechaArray = $(this).val().split('-');
        let fecha_val = fechaArray[2] + '-' + fechaArray[1] + '-' + fechaArray[0];
        $.post(base_url + "Partidos_c/cambiarFecha", {
            idPartido: $(this).attr('id'),
            fecha: fecha_val
        }
        );

        $.notify({
            title: '<strong class="">¡Fecha Guardada!</strong><br>',
            message: 'Fecha del partido guardada correctamente.'
        }, {
            type: 'success'
        });
    })

    //Si cambia la hora se envía un ajax
    $(".hora").on("change", function (evento) {
        $.post(base_url + "Partidos_c/cambiarHora", {
            idPartido: $(this).attr('id'),
            hora: $(this).val()
        }
        );
    });

    $(".hora").on("blur", function (evento) {
        $.notify({
            title: '<strong class="">¡Hora Guardada!</strong><br>',
            message: 'Hora del partido guardada correctamente.'
        }, {
            type: 'success'
        });
    })

    //al clickar en un partido te rederige al encuentro
    $("tr").on("click", function (evento) {
        if ($(this).children('td').length > 0 && tipo_cuenta != "Administrador") {
            let idpartido = $(this).children('td').eq(1).data('id');
            window.location.href = base_url + "Usuario_c/partido/" + liga + "/" + idpartido + "";
        }
    })
}