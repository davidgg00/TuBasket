$(document).ready(function () {
    $("#divgestionliga").on("click", function (evento) {
        obtenerLigas();
    });

    $("#crearligadiv").on("click", function () {
        $("#nombreLiga").val("");
        $("#contrasenia").val("");
        $(".alert-danger").remove();
        //Creamos AJAX que nos devuelva el NÚMERO de ligas que tiene la cuenta administrador.
        //Si tiene mas de 3, mostrará un error diciendo que has superado el numero de ligas creadas por cuenta.
        $.ajax({
            type: "get",
            url: base_url + "Admin_c/obtenerNLigas",
            success: function (numeroligas) {
                //Si el numero de liga es menos que 2 que se muestre el modal con el formulario, de lo contrario que se muestre un error
                if (numeroligas <= 2) {
                    $("#modalCrearLiga").modal('show');
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: '¡Ligas Completas!',
                        text: 'Has superado el máximo de ligas creadas (3), para crear otra deberá antes borrar una.',
                        backdrop: false,
                    })
                }
            }
        });
    })
});
function obtenerLigas() {
    //Este ajax nos trae de vuelta un listado con las ligas y si ha terminado la liga, el ganador.
    $.ajax({
        type: "get",
        url: base_url + "Admin_c/obtenerLigas",
        success: function (dato_devuelto) {
            let datos = JSON.parse(dato_devuelto);
            let mihtml = "";
            for (dato of datos) {

                console.log(dato);
                mihtml += "<div class='card'><div class='card-header'>";
                mihtml += "<a href='" + base_url + "Admin_c/index/" + dato.nombre + "'>" + dato.nombre + "</a><i id='" + dato.nombre + "' class='borrarLiga fas fa-ban float-right'></i>";
                mihtml += "</div><div class='card-body'>Ganador: ";
                mihtml += dato.ganador == null ? "" : dato.ganador;
                mihtml += "</div></div>";
            }
            Swal.fire({
                title: '<strong>Elige la liga</strong>',
                icon: '',
                html: mihtml,
                showCloseButton: true,
                showConfirmButton: false,
                focusConfirm: false,
                allowOutsideClick: true
            })
            //Cuando se haga click en el icono de borrar una liga
            $(".borrarLiga").on("click", function (evento) {
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
                    if (result.value) {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Liga Borrada!',
                            text: 'Has borrado la liga correctamente.',
                            backdrop: false,
                        }).then(() => {
                            $.ajax({
                                type: "POST",
                                url: base_url + "Admin_c/borrarLiga",
                                data: { liga: $(this).attr('id') },
                            })
                        })
                    }
                })
            })
        }
    });
}

//Función que creará la liga por ajax.
function crearLiga() {
    $(".alert-danger").remove();
    //Si los campos nombre de liga y contraseña no están vacíos
    if ($("#contrasenia").val() && $("#nombreLiga").val()) {
        if ($("#contrasenia").val().length < 5 && $("#nombreLiga").val().length < 5) {
            $("<div class='alert alert-danger' role='alert'>La contraseña de liga y el nombre de liga deben de tener mínimo 5 caracteres!</div>").hide().prependTo(".modal-body").fadeIn("slow");
        } else if ($("#nombreLiga").val().length < 5) {
            $("<div class='alert alert-danger' role='alert'>El nombre de liga debe de tener mínimo 5 caracteres!</div>").hide().prependTo(".modal-body").fadeIn("slow");
        } else if ($("#contrasenia").val().length < 5) {
            $("<div class='alert alert-danger' role='alert'>La contraseña de liga deben de tener mínimo 5 caracteres!</div>").hide().prependTo(".modal-body").fadeIn("slow");
        } else {
            let liga = $("#nombreLiga").val();
            let password = $("#contrasenia").val();
            let administrador = $("#administrador").val();
            $.post(base_url + "Admin_c/crear_liga", { "liga": liga, "password": password, "administrador": administrador },
                function (dato_devuelto) {
                    //Si devolvemos "Existe", mostramos error con sweetalert
                    if (dato_devuelto == "Existe") {
                        Swal.fire({
                            backdrop: false,
                            icon: 'error',
                            title: 'Ooops....',
                            text: 'Esa liga ya existe, prueba a crear una con otro nombre',
                        }, function () {
                            //Cuando se cierre el modal del formulario hacemos que se vuelva a abrir.
                            $("#crearligadiv").click()
                        })
                        //Si devuelve "Creada" mostramos sweetAlert success
                    } else if (dato_devuelto == "Creada") {
                        //Cerramos modal
                        $('#modalCrearLiga').modal('toggle');
                        //Mostramos alerta correcta
                        Swal.fire({
                            backdrop: false,
                            icon: 'success',
                            title: 'Liga creada con éxito....',
                            text: 'Puede acceder a su liga en el apartado Gestionar Liga',
                        })
                    }
                }
            );
        }
    }
}

