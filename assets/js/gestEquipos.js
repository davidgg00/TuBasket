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
    //voy a hacer que si lo presionas pierda el foco y si la cadena es mayor de 25 también.
    $('p[contenteditable]').keydown(function (e) {
        if (e.keyCode === 13 || $(this).text().length >= 25 && e.keyCode != 8) {
            $(this).blur();
        }
    });

    //Función que comprueba el numero de equipos que hay nada mas meternos en la pestaña
    //Si hay 10 como máximo, no permitiremos meter más.
    comprobarMaxEquipos();

    //Si se va a enviar el formulario con el equipo a añadir
    $("#formulario").on("submit", function (evento) {
        console.log($("#escudo"));
        evento.preventDefault();
        //Si todavía no se ha generado los enfrentamientos
        if (npartidos == 0) {
            $.ajax({
                type: "post",
                url: baseurl + "GestionEquipos_c/obtenerNumEquipos/" + liga_actual,
                success: function (dato_devuelto) {
                    //Si llegamos al tope de equipo añadimos la clase que nos hará
                    //que no podamos añadir mas equipos
                    if (dato_devuelto >= 9) {
                        $("#formulario").addClass("max-equipos");
                    } else {
                        $("#formulario").removeClass("max-equipos");
                    }
                },
            });


            //Si hay algun input vacío añadimos clase error
            $("input.form-control").each(function (evento) {
                if ($(this).val() == "") {
                    $(this).addClass("is-invalid");
                } else {
                    $(this).removeClass("is-invalid");
                }
            });

            //Comprobamos extension img
            if ($("#escudo").val().split('.').pop().toUpperCase() != "PNG" && $("#escudo").val().split('.').pop().toUpperCase() != "JPG") {
                $("#escudo").addClass("is-invalid");
            } else {
                $("#escudo").removeClass("is-invalid");
            }

            //Si no hay ninguna clase error en los inputs enviamos el formulario por ajax
            if (!$("#equipo").hasClass("is-invalid") && !$("#pabellon").hasClass("is-invalid") && !$("#escudo").hasClass("is-invalid") && !$("#ciudad").hasClass("is-invalid") && $("#formulario").hasClass("max-equipos") == false) {
                $.ajax({
                    url: baseurl + "GestionEquipos_c/enviarEquipo ",
                    type: "POST",
                    //El Objeto formdata nos permite transmitir nuestros datos en una codificación multipart/form-data
                    //Además que nos facilita bastante la subida de archivos a través de un <input type="file">
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        console.log(response);
                        let equipo = JSON.parse(response);
                        console.log(equipo);
                        $("tbody").append("<tr class='text-center datos'><td id='id' class='d-none'>" + equipo.id + "</td><td class='equipo'><p data-tippy-content='Haga click para editar el campo' class='dato_td' contenteditable='true' >" + equipo.equipo + "</p></td><td class='pabellon'><p data-tippy-content='Haga click para editar el campo' class='dato_td' contenteditable='true'>" + equipo.pabellon + "</p></td><td class='ciudad'><p data-tippy-content='Haga click para editar el campo' class='dato_td' contenteditable='true'>" + equipo.ciudad + "</p></td><td class='td-escudo'><img  data-toggle='modal' data-target='#modalCambiarEscudo' src='" + baseurl + equipo.escudo_ruta + "' data-id='" + equipo.escudo_ruta + "' data-tippy-content='Haga click para cambiar el escudo' class='dato_td escudo'></td><td><i data-tippy-content='Borrar Equipo' class='fas fa-trash-alt eliminar'></i></td></tr>")

                        //Añadimos las acciones al nuevo equipo añadido

                        ajaxContentEditable();
                        ajaxEliminarEquipo();

                        //Si clickamos en un escudo que aparezca el modal creado con el formulario y añadimos la url de la imagen antigua
                        $(".escudo").on("click", function () {
                            $(".modal-body #idImagen").val($(this).data('id'));
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

                        $.notify({
                            title: '<strong class="">¡Equipo añadido correctamente!</strong><br>',
                            message: 'El equipo se ha guardado correctamente en nuestra base de datos.'
                        }, {
                            type: 'success'
                        });
                    }
                });

                //Una vez enviamos vaciamos los inputs
                $("input.datos").each(function (evento) {
                    $(this).val("");
                })
            } else if (($("#equipo").hasClass("is-invalid") || $("#pabellon").hasClass("is-invalid") || $("#ciudad").hasClass("is-invalid")) && !$("#formulario").hasClass("max-equipos")) {
                //Si es que hay algun error de que hay algún campo vacío.
                Swal.fire({
                    backdrop: false,
                    icon: 'error',
                    title: 'Ooops....',
                    text: "Hay algún campo vacío. Rellenelo para insertar el Equipo."
                })
            } else if ($("#escudo").hasClass("is-invalid")) {
                //Si el escudo no tiene una extensión correcta.
                Swal.fire({
                    backdrop: false,
                    icon: 'error',
                    title: 'Ooops....',
                    text: 'La extensión del escudo no es correcta. Prueba con un .jpg o .png',
                })
            } else {
                //Si ya hay 10 equipos.
                Swal.fire({
                    backdrop: false,
                    icon: 'error',
                    title: 'Ooops....',
                    text: 'Solo puedes añadir como máximo 10 equipos',
                })
            }
        } else {
            Swal.fire({
                icon: 'error',
                title: '¡La liga ya ha empezado!',
                text: 'No puedes añadir equipos, los enfrentamientos ya fueron generados.',
                backdrop: false,
            })
        }
    });
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
                title: '¿Estás seguro de que quieres borrar el equipo?',
                text: "¡Una vez que lo elimines no podrás recuperarlo!",
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
                                $(fila).fadeOut();
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


