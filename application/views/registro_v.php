<script>
    let base_url = '<?= base_url() ?>';
</script>
<script src="<?php echo base_url('assets/js/registro.js') ?>"></script>

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
                        <button type="submit" id="btn-registro" class="btn btn-lg btn-block w-25 mx-auto btn-secondary">Registrate</button>
                    </div>
                    <div class="form-group mx-auto text-center ">
                        <p class="text-dark">¿Tienes cuenta?</p>
                        <a href="<?php echo base_url() ?>">Inicia sesión</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>