//Función que nos permite crear el envio del ContentEditable a la base de datos por AJAX
function ajaxContentEditable() {
    $("p").on("blur", function (evento) {
        $.ajax({
            type: "post",
            url: baseurl + "GestionEquipos_c/modificarEquipo",
            data: {
                contenido: $(this).html(),
                campo: $(this).parent().attr('class'),
                equipo: $(this).parent().parent().children().eq(0).html()
            }
        });
    })
}

//Función que nos permite eliminar un Equipo de la base de datos por AJAX
function ajaxEliminarEquipo() {
    $(".eliminar").on("click", function (evento) {
        let idEquipo = $(this).parent().parent().children().eq(0).html();
        let fila = $(this).parent().parent();
        $.ajax({
            type: "post",
            url: baseurl + "GestionEquipos_c/eliminarEquipo",
            data: {
                id: idEquipo
            },
            success: function (response) {
                $(fila).remove();
            }
        });
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
    })
}


//Función que lista los equipos de la base de datos y ejecuta las demás funciones que hay en el archivo
function mostrarEquipo() {
    $.ajax({
        type: "get",
        url: baseurl + "GestionEquipos_c/obtenerEquipos/" + liga_actual,
        liga: liga_actual,
        success: function (dato_devuelto) {
            let datos = JSON.parse(dato_devuelto);
            for (let dato of datos) {
                $("tbody").append("<tr class='text-center datos'><td id='id' class='d-none'>" + dato.id + "</td><td class='equipo'><p data-tippy-content='Haga click para editar el campo' class='dato_td' contenteditable='true' >" + dato.equipo + "</p></td><td class='pabellon'><p data-tippy-content='Haga click para editar el campo' class='dato_td' contenteditable='true'>" + dato.pabellon + "</p></td><td class='ciudad'><p data-tippy-content='Haga click para editar el campo' class='dato_td' contenteditable='true'>" + dato.ciudad + "</p></td><td><img  data-toggle='modal' data-target='#miModal   ' src='" + baseurl + dato.escudo_ruta + "' id='" + dato.escudo_ruta + "' data-tippy-content='Haga click para cambiar el escudo' class='dato_td img-fluid escudo'></td><td><i data-tippy-content='Borrar Equipo' class='fas fa-trash-alt eliminar'></i></td></tr>")
            }
            //Si presionamos enter en el contenteditable te genera <br> así que
            //vamos a hacer que si presionamos enter no haga nada
            $('p[contenteditable]').keydown(function (e) {
                if (e.keyCode === 13) {
                    return false;
                }
            });
            ajaxContentEditable();
            ajaxEliminarEquipo();
            $(".escudo").on("click", function () {
                $(".modal-body #idImagen").val($(this).attr('id'));
            });
        }
    });
}

//Función que comprueba el numero de equipos que hay.
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
