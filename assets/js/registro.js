$(document).ready(function () {
    /*
    Nada mas cargar el documento pondremos un minimo y un máximo de edad.
    El mínimo es 18 años así que calculamos desde el día de hoy 18 años
    El máximo 100 años, así que calculamos desde el dia de hoy 100 años
     */
    let hoy = new Date();
    $("#fecha_nac").attr('min', hoy.getFullYear() - 100 + "-" + ("0" + (hoy.getMonth() + 1)).slice(-2) + "-" + ("0" + hoy.getDate()).slice(-2))
    $("#fecha_nac").attr('max', hoy.getFullYear() - 18 + "-" + ("0" + (hoy.getMonth() + 1)).slice(-2) + "-" + ("0" + hoy.getDate()).slice(-2))
    $("#fecha_nac").val(hoy.getFullYear() - 18 + "-" + ("0" + (hoy.getMonth() + 1)).slice(-2) + "-" + ("0" + hoy.getDate()).slice(-2));

    //Creamos evento on keyup para comprobar username
    $("#username").on("keyup", function (evento) {
        //si hay mas de 5 caracteres comprobamos el username
        if ($(this).val().length >= 6) {
            $.get(base_url + "registro_c/comprobar_username", {
                "username": $(this).val()
            },
                function (dato_devuelto) {
                    console.log(dato_devuelto);
                    //Si devuelve existe ponemos el input invalido, mostramos span y el submit está desactivado
                    if (dato_devuelto == "Existe") {
                        $("#username").addClass("is-invalid");
                        $("#error-username").html("Username no disponible");
                        $(".m-b-error").removeClass("mb-4");
                        $("#btn-registro").prop('disabled', true);
                    } else {
                        //De lo contrario quitamos la clave invalido al input y ponemos el submit en enabled
                        $("#username").removeClass("is-invalid");
                        $("#error-username").html("&nbsp");
                        //Si aparte de que el username sea válido el email también lo es, habilitamos el submit del envio
                        if (!$("#email").hasClass("is-invalid")) {
                            $("#btn-registro").prop('disabled', false);
                        }
                    }
                }
            );
        }
    })

    //Creamos evento on keyup para comprobar email
    $("#email").on("keyup", function (evento) {
        //si hay mas de 5 caracteres y contiene un @ comprobamos el email
        if ($(this).val().length >= 6 && $(this).val().indexOf("@") != -1) {
            $.get(base_url + "registro_c/comprobar_email", {
                "email": $(this).val()
            },
                function (dato_devuelto) {
                    console.log(dato_devuelto);
                    //Si devuelve existe ponemos el input invalido, mostramos span y el submit está desactivado
                    if (dato_devuelto == "Existe") {
                        $("#email").addClass("is-invalid");
                        $("#error-email").html("Email no disponible");
                        $(".m-b-error").removeClass("mb-4");
                        $("#btn-registro").prop('disabled', true);
                    } else {
                        //De lo contrario quitamos la clave invalido al input y ponemos el submit en enabled
                        $("#email").removeClass("is-invalid");
                        $("#error-email").html("&nbsp");
                        //Si aparte de que el email sea válido el username también lo es, habilitamos el submit del envio
                        if (!$("#username").hasClass("is-invalid")) {
                            $("#btn-registro").prop('disabled', false);
                        }
                    }
                }
            );
        }
    })

    //Evento que muestra o esconde cambos segun el tipo de cuenta que tengas
    $("#tipo-cuenta").on("change", function (evento) {
        //Si el tipo de cuenta es jugador o entrenador
        if ($("#tipo-cuenta option:selected").val() == "jugador" || $("#tipo-cuenta option:selected").val() == "Entrenador") {
            //Quitamos el display none de los campos "nombre de liga" y "contraseña de liga"
            $("#group-liga").removeClass("d-none");
            $("#group-ligaclave").removeClass("d-none");
            //Evento submit del formulario que comprueba (por AJAX) primero si la liga y la contraseña de la liga son correctas
            $("form").submit(function (evento) {
                evento.preventDefault();
                //si hay mas de 5 caracteres
                if ($("#nombreliga").val().length >= 6) {
                    $.get(base_url + "registro_c/comprobar_liga", {
                        "liga": $("#nombreliga").val(),
                        "clave": $("#clave_liga").val()
                    },
                        function (dato_devuelto) {
                            //Si devuelve incorrecto mostramos error.
                            if (dato_devuelto == "Incorrecto") {
                                $("#nombreliga, #clave_liga").addClass("is-invalid");
                                $("#error-liga").html("Liga o contraseña incorrectas");
                                $(".m-b-error").removeClass("mb-4");
                            } else {
                                //De lo contrario quitamos la clave invalido al input y ponemos el submit en enabled
                                $("#nombreliga, #clave_liga").removeClass("is-invalid");
                                $("#error-liga").html("&nbsp");
                                $("form").unbind('submit').submit();
                            }
                        },
                    );
                }
            })
        } else {
            //Si la cuenta era de tipo administrador estos campos no son necesarios
            $("#group-liga").addClass("d-none");
            $("#group-ligaclave").addClass("d-none");
        }
    })
});