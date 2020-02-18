<div class="row align-items-center justify-content-center w-100 ">
    <div class="formulario col-5 p-10px shadow-lg">
        <div id=" logo" class="row">
            <img src="logo2.png" class="img-fluid mx-auto" alt="Logo TuBasket">
        </div>
        <form action="<?php echo base_url() . 'login_c/iniciarsesion' ?>" method="POST">
            <div class="form-group text-center w-50 mx-auto input-group mb-3">
                <label for="exampleInputEmail1" class="col-12">Username</label>
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-user"></i></span>
                </div>
                <input type="text" name="username" class="form-control" placeholder="Escriba su Username..." aria-label="Username" aria-describedby="basic-addon1" required>
            </div>
            <div class="form-group text-center mx-auto w-50 mx-auto input-group mb-3">
                <label for="exampleInputPassword1" class="col-12">Contraseña</label>
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
                </div>
                <input type="password" name="password" class="form-control" placeholder="Escriba su contraseña..." aria-label="Username" aria-describedby="basic-addon1" required>
            </div>
            <div class="form-group mx-auto text-center w-25">
                <button type="submit" class="btn btn-lg btn-block ">Ingresar</button>
            </div>
            <div class="form-group mx-auto text-center w-50">
                <p class="text-dark">¿Aún no tienes cuenta?</p>
                <a href=" <?php echo base_url('/registro_c') ?>">Regístrate</a>
            </div>
        </form>
    </div>
</div>