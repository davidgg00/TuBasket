<script>
    let baseurl = '<?= base_url() ?>';
    let tipocuenta = "<?= $_SESSION['tipo_cuenta'] ?>";
    let username = "<?= $_SESSION['username'] ?>";
</script>
<script src="<?php echo base_url('assets/js/liga.js') ?>"></script>
<div class="row justify-content-end" id="informacion">
    <section class="col-8 d-flex flex-wrap justify-content-center align-items-center" id="proxpartido">
        <div id="carouselExampleControls" class="carousel slide w-100 border border-dark" data-ride="carousel">
            <div class="carousel-inner">
                <h3 class="col-12 text-center">Liga: <?= $liga ?></h3>
                <h3 class="col-12 text-center">Próximos Partidos</h3>
                <?php if (count($proxPartidos) > 0) :
                    foreach ($proxPartidos as $partido) : ?>
                        <div class="carousel-item">
                            <div id="partido" class="col-12 d-flex justify-content-around h-50">
                                <img src="<?php echo base_url($partido->escudo_local) ?>" class="img-fluid">
                                <img src="<?php echo base_url('assets/img/vs.png') ?>" class="img-fluid">
                                <img src="<?php echo base_url($partido->escudo_visitante) ?>" class="img-fluid">
                            </div>

                            <p id="lugar" class="col-12 text-center">Jornada: <?= $partido->jornada ?></p>
                            <?php if ($partido->fecha != "0000-00-00") : ?>
                                <p id="fecha" class="col-12 text-center">Fecha: <?= date("d-m-Y", strtotime($partido->fecha)) ?></p>
                            <?php else : ?>
                                <p id="fecha" class="col-12 text-center">Fecha: NO DECIDIDA</p>
                            <?php endif; ?>
                            <?php if (isset($partido->hora)) : ?>
                                <p id="hora" class="col-12 text-center">Hora: <?= date("d-m-Y", strtotime($partido->fecha)) ?></p>
                            <?php else : ?>
                                <p id="hora" class="col-12 text-center">Hora: NO DECIDIDA</p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach;
                else : ?>
                    <div class="carousel-item">
                        <div id="partido" class="col-12 d-flex justify-content-around h-50">
                            <img src="<?php echo base_url('assets/img/escudo-por-defecto.png') ?>" class="img-fluid">
                            <img src="<?php echo base_url('assets/img/vs.png') ?>" class="img-fluid">
                            <img src="<?php echo base_url('assets/img/escudo-por-defecto.png') ?>" class="img-fluid">
                        </div>
                        <?php if (isset($partido)) : ?>
                            <p id="lugar" class="col-12 text-center">Jornada: <?= $partido->jornada ?></p>
                            <p id="fecha" class="col-12 text-center">Fecha: <?= date("d-m-Y", strtotime($partido->fecha)) ?></p>
                            <p id="hora" class="col-12 text-center">Hora: <?= $partido->hora ?></p>
                        <?php else : ?>
                            <h4 class="col-12 text-center mt-4">¡Liga no empezada!</h4>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </section>
    <aside class="col-2 h-25 d-flex justify-content-center flex-wrap align-items-center">
        <?php if (isset($_SESSION['imagen'])) : ?>
            <img src="<?php echo base_url($_SESSION['imagen']) ?>" class="img-fluid rounded-circle" id='foto-perfil'>
        <?php else : ?>
            <img src="<?php echo base_url("assets/uploads/perfiles/pordefecto.png") ?>" class="img-fluid rounded-circle" id='foto-perfil'>
        <?php endif; ?>
        <p class="col-12">¡Bienvenido <?= $_SESSION["username"] ?>!</p>
        <p class="col-12">Cuenta: <?= $_SESSION["tipo_cuenta"] ?></p>
        <p class="col-12">Liga: <?= $liga ?></p>
        <button type="button" class="d-block btn btn-warning mx-auto mb-2" data-toggle="modal" data-target="#modalPassword">Cambiar Contraseña</button>
    </aside>
</div>
<!--Modal password-->
<div class="modal fade" id="modalPassword" tabindex="-1" role="dialog" aria-labelledby="modalPassword" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cambiar Contraseña</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>
            <div class="modal-body">
                <div class="alert alert-danger w-100" role="alert">
                    &nbsp;
                </div>
                <form method="POST" enctype="multipart/form-data" id="formUpdatePassword" class="mx-auto">
                    <img src="<?php echo base_url($_SESSION['imagen']) ?>" class="img-fluid rounded-circle w-25 d-block mx-auto mb-3" id='foto-perfil' alt="">
                    <div id="campos" class="d-flex flex-wrap justify-content-around">
                        <label for="claveAntigua">Introduzca la clave actual: </label>
                        <div id="error_clave" class="w-50 text-center mb-2">
                            <input type="password" name="claveAntigua" id="claveAntigua">
                            <span class="w-100 d-block text-danger" id="span-clave">&nbsp;</span>
                        </div>
                        <label for="claveNueva">Introduzca la clave nueva: </label>
                        <div id="claveIgual" class="mb-2 text-center w-50">
                            <input type="password" minlength="6" name="claveNueva" id="claveNueva" required>
                            <span class="w-100 d-block text-danger" id="span-claveNueva">&nbsp;</span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button id='btn-guardarclave' type="button" class="btn btn-primary">Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>