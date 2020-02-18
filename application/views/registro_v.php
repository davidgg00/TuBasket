<script>
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
<div class="row align-items-center justify-content-center w-100">
    <div class="formulario col-7 p-10x shadow-lg">
        <div id="logo" class="row">
            <img src="logo2.png" class="img-fluid mx-auto" alt="Logo TuBasket">
        </div>
        <form action="<?php echo base_url() . "registro_c/registrar_user" ?>" class="d-flex flex-wrap" method="POST">
            <div class="col-6">
                <div class="form-group text-center mx-auto input-group mb-3">
                    <label for="exampleInputEmail1" class="col-12">Username</label>
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-user"></i></span>
                    </div>
                    <input type="text" name="username" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                </div>
                <div class="form-group text-center mx-auto input-group mb-3">
                    <label for="exampleInputEmail1" class="col-12">Email</label>
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">@</span>
                    </div>
                    <input type="email" name="email" class="form-control" id="inputDNI" placeholder="Email">
                </div>
                <div class="form-group text-center mx-auto input-group mb-3">
                    <label for="exampleInputPassword1" class="col-12">Contraseña</label>
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
                    </div>
                    <input type="password" name="password" class="form-control" placeholder="Contraseña" aria-label="Username" aria-describedby="basic-addon1">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group text-center mx-auto input-group mb-3">
                    <label for="exampleInputEmail1" class="col-12">Fecha de Nacimiento</label>
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <input type="date" name="fecha_nac" class="form-control" placeholder="Fecha de Nacimiento" aria-label="Username" aria-describedby="basic-addon1">
                </div>
                <div class="form-group text-center mx-auto input-group mb-3">
                    <label for="exampleInputEmail1" class="col-12">Nombres y Apellidos</label>
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-id-card"></i></span>
                    </div>
                    <input type="text" name="apenom" class="form-control" placeholder="Apellidos y Nombre" aria-label="Username" aria-describedby="basic-addon1">
                </div>
                <!--                 <div class="form-group text-center mx-auto input-group mb-3">
                    <label for="exampleInputPassword1" class="col-12">Nombre Liga</label>
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-basketball-ball"></i></span>
                    </div>
                    <input type="text" name="nombre_liga" class="form-control" placeholder="Nombre de Liga" aria-label="Username" aria-describedby="basic-addon1">
                </div>
                <div class="form-group text-center mx-auto input-group mb-3">
                    <label for="exampleInputPassword1" class="col-12">Contraseña liga</label>
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
                    </div>
                    <input type="password" name="clave_liga" class="form-control" placeholder="Contraseña Liga" aria-label="Username" aria-describedby="basic-addon1">
                </div> -->
                <div class="form-group text-center mx-auto input-group mb-3">
                    <label for="exampleInputPassword1" class="col-12">Tipo de cuenta </label>
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-user-circle"></i></span>
                    </div>
                    <select name="tipocuenta" id="" class="col-10 custom-select">
                        <option value="administrador" class="text-center">Administrador</option>
                        <option value="jugador">Jugador</option>
                    </select>
                </div>
            </div>
            <div class=" form-group mx-auto text-center col-10 ">
                <button type="submit" class="btn btn-lg btn-block w-25 mx-auto">Registrate</button>
            </div>
            <div class="form-group mx-auto text-center ">
                <p class="text-dark">¿Tienes cuenta?</p>
                <a href="<?php echo base_url() ?>">Inicia sesión</a>
            </div>
        </form>
    </div>
</div>