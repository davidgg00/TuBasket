$(document).ready(function () {
    $("#divgestionliga").on("click", function (evento) {
        obtenerLigas();
    })
});
function obtenerLigas() {
    console.log(base_url);
    //Este ajax nos trae de vuelta un listado con las ligas y si ha terminado la liga el ganador.
    $.ajax({
        type: "get",
        url: base_url + "Admin_c/obtenerLigas",
        success: function (dato_devuelto) {
            let datos = JSON.parse(dato_devuelto);
            let mihtml = "";
            for (dato of datos) {
                mihtml += "<div class='card'><div class='card-header'>";
                mihtml += "<a href='" + base_url + "Admin_c/index/" + dato.nombre + "'>" + dato.nombre + "</a><i id='" + dato.nombre + "' class='borrarLiga fas fa-ban float-right'></i>";
                mihtml += "</div><div class='card-body'>Ganador:";
                mihtml += dato.ganador;
                mihtml += "</div></div>";
            }
            Swal.fire({
                backdrop: false,
                title: '<strong>Elige la liga</strong>',
                icon: '',
                html: mihtml,
                showCloseButton: true,
                showConfirmButton: false,
                focusConfirm: false,
            })
            //Cuando se haga click en el icono de borrar una liga
            $(".borrarLiga").on("click", function (evento) {
                console.log($(this).attr('id'));
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
    //Si los campos nombre de liga y contraseña no están vacíos abrimos ajax
    if ($("#contrasenia").val() && $("#nombre").val()) {

        let liga = $("#nombre").val();
        let password = $("#contrasenia").val();
        let administrador = $("#administrador").val();
        console.log(liga);
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
                    $('#miModal').modal('toggle');

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

