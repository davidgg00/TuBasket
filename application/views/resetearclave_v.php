<script>
    $(document).ready(function() {
        $("#cambiarClave").on("submit", function(evento) {
            $("#error-clave").html("&nbsp");
            evento.preventDefault();
            //Si NO son iguales las claves, lanzamos error, de lo contrario enviamos formulario
            if ($("#clave").val() != $("#clave2").val()) {
                $("#error-clave").html("Las contraseñas no coinciden")
            } else {
                $(this).unbind('submit').submit();
            }
        })
    });
</script>

<body>
    <div class="container d-flex h-100">
        <div class="row align-items-center justify-content-center w-100">
            <div class="formulario col-5 p-10x shadow-lg">
                <div id="logo" class="row">
                    <img src="<?php echo base_url('assets/img/logo2.png') ?>" class="img-fluid mx-auto" alt="Logo TuBasket">
                </div>
                <form action="<?php echo base_url() . "RecuperarClave_c/cambiarClave" ?>" class="d-flex flex-wrap justify-content-center" method="POST" id="cambiarClave">
                    <div class="col-8">
                        <div class="form-group text-center mx-auto input-group mb-0 m-b-error">
                            <label for="exampleInputEmail1" class="col-12">Nueva contraseña</label>
                            <div class="input-group-prepend mb-4">
                                <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
                            </div>
                            <input tabindex="1" type="password" autofocus required id="clave" name="clave" minlength="6" class="form-control mb-4" placeholder="Escriba la nueva contraseña" aria-label="clave" aria-describedby="basic-addon1">
                            <label for="exampleInputEmail1" class="col-12">Repite la nueva contraseña</label>
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
                            </div>
                            <input tabindex="1" type="password" autofocus required id="clave2" name="clave2" minlength="6" class="form-control" placeholder="Repita la nueva contraseña" aria-label="clave" aria-describedby="basic-addon1">
                            <span class="text-danger" id="error-clave">&nbsp</span>
                            <input type="hidden" name="email" value="<?= $email ?>">
                        </div>
                    </div>
                    <div class="form-group mx-auto text-center col-10 d-flex flex-wrap justify-content-center">
                        <button type="submit" id="btn-registro" class="btn btn-lg btn-block w-50 mx-auto btn-success">Resetear</button>
                    </div>
                    <div class="form-group mx-auto text-center">
                        <p class="text-dark">¿Tienes cuenta?</p>
                        <a href="<?php echo base_url() ?>">Inicia sesión</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>