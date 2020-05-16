<body>
    <div class="container d-flex h-100">
        <div class="row align-items-center justify-content-center w-100 ">
            <div class="formulario col-5 p-10px shadow-lg">
                <div id=" logo" class="row">
                    <img src="<?php echo base_url('assets/img/logo2.png') ?>" class="img-fluid mx-auto" alt="Logo TuBasket">
                    <?php if (isset($_SESSION['error'])) : ?>
                        <div class="alert alert-danger mx-auto mb-0" role="alert">
                            <?= $_SESSION['error'] ?>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['acierto'])) : ?>
                        <div class="alert alert-success mx-auto mb-0" role="alert">
                            <?= $_SESSION['acierto'] ?>
                        </div>
                    <?php endif; ?>
                </div>
                <form action="<?php echo base_url() . 'login_c/iniciarsesion' ?>" method="POST">
                    <div class="md-form w-50 mx-auto">
                        <i class="fas fa-user prefix"></i>
                        <input type="text" id="usernamecorreo" name="username" class="form-control">
                        <label for="usernamecorreo">Username o Correo</label>
                    </div>
                    <div class="md-form w-50 mx-auto">
                        <i class="fas fa-lock prefix"></i>
                        <input type="password" id="clave" name="password" class="form-control">
                        <label for="clave">Contraseña</label>
                    </div>
                    <div class="form-group mx-auto text-center w-25">
                        <button type="submit" class="btn btn-rounded btn-light-green">Ingresar</button>
                    </div>
                    <div class="form-group mx-auto text-center w-50 m-1">
                        <p class="text-dark">¿Aún no tienes cuenta?</p>
                        <a href=" <?php echo base_url('/registro_c') ?>">Regístrate</a>
                    </div>
                    <div class="form-group mx-auto text-center w-50 m-2">
                        <p class="text-dark">¿Has olvidado tu contraseña?</p>
                        <a href=" <?php echo base_url('/RecuperarClave_c') ?>">Recuperar contraseña</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>