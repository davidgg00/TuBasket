$(document).ready(function () {
    $(".alert-danger").hide();
    //Añadimos la clase active al primer item del carrusel nada mas que cargue
    //la página para que haya solo un elemento activo. (Si lo hacemos en el bucle)
    //Se ponen todos con esa clase y no funcionará el carrusel correctamente
    $(".carousel-item:first").addClass("active");
    $("#btn-guardarclave").on("click", function (evento) {
        //Si la clave antigua NO está vacía
        if ($("#claveAntigua").val() != "") {
            if ($("#claveAntigua").val() == $("#claveNueva").val()) {
                $(".alert-danger").html("Las contraseñas no pueden ser iguales");
                $(".alert-danger").fadeIn();
            } else {
                if ($("#claveNueva").val().length > 5) {
                    $("#span-claveNueva").html("&nbsp;");
                    $.post(baseurl + "Perfiles_c/cambiarClave", {
                        claveAntigua: $("#claveAntigua").val(),
                        claveNueva: $("#claveNueva").val(),
                        cuenta: tipocuenta,
                        username: username
                    },
                        function (dato_devuelto) {
                            console.log(dato_devuelto)
                            if (dato_devuelto == "Error") {
                                $(".alert-danger").html("Contraseña actual incorrecta");
                                $(".alert-danger").fadeIn();
                            } else {
                                $(".alert-danger").fadeOut();
                                $("#modalPassword").modal('hide');
                                //Mostramos alerta correcta
                                Swal.fire({
                                    backdrop: false,
                                    icon: 'success',
                                    title: 'Contraseña Actualizada',
                                    text: 'La contraseña se cambió correctamente.',
                                })
                            }
                        }
                    );
                    $("#claveAntigua").val("");
                    $("#claveNueva").val("");
                } else {
                    $(".alert-danger").html("La contraseña nueva debe de tener minimo 6 caracteres");
                    $(".alert-danger").fadeIn();
                }
            }
        }
    })
});