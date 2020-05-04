<script>
    $(document).ready(function() {
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
        $("#username").on("keyup", function(evento) {
            //si hay mas de 5 caracteres comprobamos el username
            if ($(this).val().length >= 6) {
                $.get("<?php echo base_url() . "registro_c/comprobar_username" ?>", {
                        "username": $(this).val()
                    },
                    function(dato_devuelto) {
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
        $("#email").on("keyup", function(evento) {
            //si hay mas de 5 caracteres y contiene un @ comprobamos el email
            if ($(this).val().length >= 6 && $(this).val().indexOf("@") != -1) {
                $.get("<?php echo base_url() . "registro_c/comprobar_email" ?>", {
                        "email": $(this).val()
                    },
                    function(dato_devuelto) {
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
        $("#tipo-cuenta").on("change", function(evento) {
            //Si el tipo de cuenta es jugador o entrenador
            if ($("#tipo-cuenta option:selected").val() == "jugador" || $("#tipo-cuenta option:selected").val() == "Entrenador") {
                //Quitamos el display none de los campos "nombre de liga" y "contraseña de liga"
                $("#group-liga").removeClass("d-none");
                $("#group-ligaclave").removeClass("d-none");
                //Evento submit del formulario que comprueba (por AJAX) primero si la liga y la contraseña de la liga son correctas
                $("form").submit(function(evento) {
                    evento.preventDefault();
                    //si hay mas de 5 caracteres
                    if ($("#nombreliga").val().length >= 6) {
                        $.get("<?php echo base_url() . "registro_c/comprobar_liga" ?>", {
                                "liga": $("#nombreliga").val(),
                                "clave": $("#clave_liga").val()
                            },
                            function(dato_devuelto) {
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
</script>

<body>
    <div class="container d-flex h-100">
        <div class="row align-items-center justify-content-center w-100">
            <div class="formulario col-7 p-10x shadow-lg">
                <div id="logo" class="row">
                    <img src="<?php echo base_url('assets/img/logo2.png') ?>" class="img-fluid mx-auto" alt="Logo TuBasket">
                </div>
                <form action="<?php echo base_url() . "registro_c/registrar_user" ?>" class="d-flex flex-wrap" method="POST">
                    <div class="col-lg-6 col-sm-12">
                        <div class="form-group text-center mx-auto input-group mb-0 m-b-error">
                            <label for="exampleInputEmail1" class="col-12">Username</label>
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="fas fa-user"></i></span>
                            </div>
                            <input tabindex="1" type="text" autofocus required id="username" name="username" minlength="6" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                            <span class="text-danger" id="error-username">&nbsp</span>
                        </div>
                        <div class="form-group text-center mx-auto input-group mb-4 mt-0">
                            <label for="exampleInputPassword1" class="col-12">Contraseña</label>
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
                            </div>
                            <input type="password" tabindex="3" required name="password" class="form-control" placeholder="Contraseña" aria-label="Username" aria-describedby="basic-addon1">
                        </div>
                        <div class="form-group text-center mx-auto input-group mb-4">
                            <label for="exampleInputEmail1" class="col-12">Fecha de Nacimiento</label>
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="far fa-calendar-alt"></i></span>
                            </div>
                            <input type="date" id="fecha_nac" tabindex="5" required name="fecha_nac" class="form-control" placeholder="Fecha de Nacimiento" aria-label="Username" aria-describedby="basic-addon1">
                        </div>
                        <div class="form-group text-center mx-auto input-group mb-4 d-none" id="group-liga">
                            <label for="exampleInputEmail1" class="col-12">Nombre de Liga</label>
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="fas fa-basketball-ball"></i> </span>
                            </div>
                            <input type="text" tabindex="7" id="nombreliga" minlength="6" name="nombre_liga" class="form-control" placeholder="Nombre de liga" aria-label="Username" aria-describedby="basic-addon1">
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        <div class="form-group text-center mx-auto input-group mb-0 m-b-error">
                            <label for="exampleInputEmail1" class="col-12">Email</label>
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">@</span>
                            </div>
                            <input type="email" tabindex="2" required id="email" name="email" class="form-control" id="inputDNI" placeholder="Email">
                            <span class="text-danger" id="error-email">&nbsp</span>
                        </div>
                        <div class="form-group text-center mx-auto input-group mb-4 mt-0">
                            <label for="exampleInputEmail1" class="col-12">Nombre completo</label>
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="fas fa-id-card"></i></span>
                            </div>
                            <input type="text" tabindex="4" required name="apenom" class="form-control" placeholder="Apellidos y Nombre" aria-label="Username" aria-describedby="basic-addon1">
                        </div>
                        <div class="form-group text-center mx-auto input-group mb-4">
                            <label for="exampleInputPassword1" class="col-12">Tipo de cuenta </label>
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="fas fa-user-circle"></i></span>
                            </div>
                            <select name="tipocuenta" id="tipo-cuenta" class="col-10 custom-select" tabindex="6">
                                <option value="administrador" class="text-center" id="administrador">Administrador</option>
                                <option value="jugador" id="jugador">Jugador</option>
                                <option value="Entrenador" id="Entrenador">Entrenador</option>
                            </select>
                        </div>
                        <div class="form-group text-center mx-auto input-group mb-4 d-none" id="group-ligaclave">
                            <label for="exampleInputEmail1" class="col-12">Contraseña de Liga</label>
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
                            </div>
                            <input tabindex="8" type="password" id="clave_liga" name="clave_liga" class="form-control" placeholder="Clave de liga" aria-label="Username" aria-describedby="basic-addon1">
                        </div>
                    </div>
                    <div class=" form-group mx-auto text-center col-10 ">
                        <span class="text-danger" id="error-liga">&nbsp</span>
                        <button type="submit" id="btn-registro" class="btn btn-lg btn-block w-25 mx-auto">Registrate</button>
                    </div>
                    <div class="form-group mx-auto text-center ">
                        <p class="text-dark">¿Tienes cuenta?</p>
                        <a href="<?php echo base_url() ?>">Inicia sesión</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h4 class="modal-title">Elige tu equipo</h4>
                </div>
                <div class="modal-body">
                    <?php foreach ($variable as $key) : ?>
                        # code...
                    <?php endforeach; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
    <button id="abrirModal" type="button" hidden class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button>
</body>

</html>