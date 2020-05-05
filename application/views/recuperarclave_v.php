<body>
    <div class="container d-flex h-100">
        <div class="row align-items-center justify-content-center w-100">
            <div class="formulario col-5 p-10x shadow-lg">
                <div id="logo" class="row">
                    <img src="<?php echo base_url('assets/img/logo2.png') ?>" class="img-fluid mx-auto" alt="Logo TuBasket">
                    <?php if (isset($_SESSION['error'])) : ?>
                        <div class="alert alert-danger mx-auto mb-0 w-75 text-center" role="alert">
                            <?= $_SESSION['error'] ?>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['acierto'])) : ?>
                        <div class="alert alert-success mx-auto mb-0" role="alert">
                            <?= $_SESSION['acierto'] ?>
                        </div>
                    <?php endif; ?>
                </div>
                <form action="<?php echo base_url() . "RecuperarClave_c/recuperarclave" ?>" class="d-flex flex-wrap justify-content-center" method="POST">
                    <div class="col-8">
                        <div class="form-group text-center mx-auto input-group mb-0 m-b-error">
                            <label for="exampleInputEmail1" class="col-12">Email</label>
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">@</span>
                            </div>
                            <input tabindex="1" type="text" autofocus required id="email" name="email" minlength="6" class="form-control" placeholder="Escriba su correo" aria-label="email" aria-describedby="basic-addon1">
                            <span class="text-danger" id="error-username">&nbsp</span>
                        </div>
                    </div>
                    <div class="form-group mx-auto text-center col-10 d-flex flex-wrap justify-content-center">
                        <button type="submit" id="btn-registro" class="btn btn-lg btn-block w-50 mx-auto">Resetear</button>
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