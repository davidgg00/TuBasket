$(document).ready(function () {
    //Cuando el documento se cargue que ejecute estas funciones

    ajaxContentEditable();

    ajaxEliminarEquipo();

    //Si clickamos en un escudo que aparezca el modal creado con el formulario y añadimos la url de la imagen antigua
    $(".escudo").on("click", function () {
        $(".modal-body #idImagen").val($(this).data('id'));
        $(".modal-body #idEquipo").val($(this).parent().parent().find(">:first-child").html());
    });

    //Añadimos tooltip a los .dato_td y i.eliminar
    tippy('.dato_td');
    tippy('i.eliminar', {
        followCursor: 'horizontal',
    });

    //Si presionamos enter en el contenteditable te genera <br> así que
    //voy a hacer que si lo presionas pierda el foco.
    $('p[contenteditable]').keydown(function (e) {
        if (e.keyCode === 13) {
            $(this).blur();
        }
    });

    //Función que comprueba el numero de equipos que hay nada mas meternos en la pestaña
    //Si hay 10 como máximo, no permitiremos meter más.
    comprobarMaxEquipos();

});


function comprobarMaxEquipos() {
    $.ajax({
        type: "post",
        url: baseurl + "GestionEquipos_c/obtenerNumEquipos/" + liga_actual,
        success: function (dato_devuelto) {
            if (dato_devuelto >= 10) {
                $("#formulario").addClass("max-equipos");
            } else {
                $("#formulario").removeClass("max-equipos");
            }
        },
    });
}

//Función que nos permite crear el envio del ContentEditable a la base de datos por AJAX
function ajaxContentEditable() {
    var contenidoAnterior;
    $("p").on("focus", function (evento) {
        contenidoAnterior = $(this).html()
    });

    //Una vez que se quite el foco del parrafo
    $("p").on("blur", function (evento) {
        //Si se ha cambiado el contenido del contenteditable
        if (contenidoAnterior != $(this).html()) {
            //Si se ha cambiado algo se lanza ajax y notificación
            //Se crea un ajax ejecuta el método ModificarEquipo de GestionEquipos_c
            //Y se envía el contenido, el campo que se ha cambiado y el equipo
            $.ajax({
                type: "post",
                url: baseurl + "GestionEquipos_c/modificarEquipo",
                data: {
                    contenido: $(this).html(),
                    campo: $(this).parent().attr('class'),
                    equipo: $(this).parent().parent().children().eq(0).html()
                }, success: function () {
                    $.notify({
                        title: '<strong class="">¡Información cambiada correctamente!</strong><br>',
                        message: 'La infomación del equipo se ha guardado correctamente en nuestra base de datos.'
                    }, {
                        type: 'success'
                    });
                }
            });
        }
    })
}

//Función que nos permite eliminar un Equipo de la base de datos por AJAX
function ajaxEliminarEquipo() {
    $(".eliminar").on("click", function (evento) {
        //Si todavía no se ha generado los enfrentamientos
        if (npartidos == 0) {
            //Aparece una confirmacion de que si quiere eliminar el equipo
            Swal.fire({
                title: '¿Estás seguro de que quieres borrar la Liga?',
                text: "¡Una ve que la elimines no podrás recuperarla!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Confirmar',
                backdrop: false,
            }).then((result) => {
                console.log($(this).parent().parent().find("td.td-escudo"));
                var imgEquipo = $(this).parent().parent().find("td.td-escudo").children().data('id');
                console.log(imgEquipo);
                if (result.value) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Equipo Borrado!',
                        text: 'Has borrado el equipo correctamente.',
                        backdrop: false,
                    }).then(() => {
                        //Al hacer click en eliminar guardamos la id del equipo a borrar y la fila (tr)
                        //Se ejecuta el método eliminarEquipo de GestionEquipos_c y borramos el tr.
                        let idEquipo = $(this).parent().parent().children().eq(0).html();
                        let fila = $(this).parent().parent();

                        $.ajax({
                            type: "post",
                            url: baseurl + "GestionEquipos_c/eliminarEquipo",
                            data: {
                                id: idEquipo,
                                rutaImagen: imgEquipo
                            },
                            success: function (response) {
                                $(fila).remove();
                                console.log(response);
                                console.log(imgEquipo);
                            }
                        });
                    })
                }
            })
        } else {
            Swal.fire({
                icon: 'error',
                title: '¡La liga ya ha empezado!',
                text: 'No puedes borrar a un equipo cuando la liga ya está empezada',
                backdrop: false,
            })
        }


        //Si había 10 equipos (los máximos), no se podía añadir más pero al borrar uno
        //Comprobamos por ajax el numero de equipos de la liga, si es menor que 10 
        //Quitamos la clase max-equipos

        comprobarMaxEquipos();
    })
}


