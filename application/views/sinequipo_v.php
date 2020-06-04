<script>
    let base_url = "<?= base_url() ?>";
    let tipo_cuenta = "<?= $_SESSION['tipo_cuenta'] ?>";
    let liga = "<?= $_SESSION['liga'] ?>";
</script>
<script src="<?php echo base_url('assets/js/sinEquipo.js') ?>"></script>

<body>
    <div class="container-fluid border">
        <header class="row d-flex justify-content-around align-items-center">
            <img id="logo" src="<?php echo base_url('assets/img/logo2.png') ?>" class="img-fluid">
        </header>
        <div class="row w-75 d-flex justify-content-center align-items-center mx-auto flex-column">
            <div class="alert alert-warning mb-0" role="alert">
                Si tu equipo no aparece, vuelve al login y pronto el administrador de la liga lo agregará.
            </div>
            <div class="w-75 border d-flex flex-wrap justify-content-between mt-0 pt-0" id="contenedor">
                <h2 class="w-100 text-center">Elige un Equipo</h2>
                <div id="lista_equipos">
                    <?php
                    foreach ($equipos as $equipo) : ?>
                        <div class="equipo d-inline-block float-left">
                            <a data-id="<?= $equipo->id ?>" class="d-flex justify-content-center align-items-center" href="<?php echo base_url('Usuario_c/unirseEquipo/') . $equipo->id . "/" . $_SESSION['username'] ?>"><img src="<?php echo base_url($equipo->escudo_ruta) ?>" class="img-fluid"></a>
                            <p class="w-100 text-center mb-0"><?= $equipo->equipo ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <button type="button" id="btn-volver" class="btn btn-info align-self-bottom mt-4">Volver al login</button>
        </div>
</body>
<footer class="row d-flex justify-content-center align-items-center">
    <h5>Derechos de autor: David Guisado González</h5>
</footer>