<style>
    i.fa-ban {
        cursor: pointer;
    }
</style>
<script>
    let base_url = '<?= base_url() ?>';
</script>
<script src="<?php echo base_url('assets/js/admin.js') ?>"></script>

<div class="container d-flex h-100">
    <div class="row align-items-center justify-content-center w-100">
        <div id="panel" class="row col-10 h-75 d-flex justify-content-center p-10 rounded">
            <div id="titulo" class="row col-12 d-flex justify-content-center align-items-center">
                <h2>¡Bienvenido <?= $_SESSION['username'] ?>!</h2>
            </div>
            <div id="opciones" class="row d-flex justify-content-around align-items-center">
                <div class="opcion col-3 text-center p-2 d-flex justify-content-center flex-wrap" data-toggle='modal' data-target='#miModal' id="crearligadiv">
                    <img src="<?php echo base_url('assets/img/balon.png') ?>" alt="Balon" class="img-fluid align-self-center" id="balon">
                    <p class="w-100 mt-1 font-weight-bold">Crear Liga</p>
                </div>
                <div class="opcion col-3 text-center p-2 d-flex justify-content-center flex-wrap" id="divgestionliga">
                    <img src="<?php echo base_url('assets/img/jugador.png') ?>" alt="Balon" class="img-fluid align-self-center" id="balon">
                    <p class="w-100 mt-1 font-weight-bold">Gestionar Liga</p>
                </div>
                <div class="opcion col-3 text-center p-2 d-flex justify-content-center">
                    <a href="admin_c/cerrarsesion" class="">
                        <img src="<?php echo base_url('assets/img/cerrarsesion.png') ?>" alt="Balon" class="img-fluid align-self-center" id="balon">
                        <p class="w-100 mt-1 font-weight-bold">Cerrar Sesión</p>
                    </a>
                </div>
            </div>
            <div id="pie" class="row col-12 justify-content-center align-items-center">
                <img src="<?php echo base_url('assets/img/logo2.png') ?>" class="img-fluid mx-auto" alt="Logo TuBasket">
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="miModal" tabindex="-1" role="dialog" aria-labelledby="miModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titulo_modal">Crear Liga</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="formCrearLiga">
                    <label for="nombre">Nombre de la Liga:</label>
                    <input id="nombre" name="nombre" type="text" placeholder="Nombre de liga" id="nombreLiga" required />
                    <label for="contrasenia">Contraseña de la Liga:</label>
                    <input id="contrasenia" name="contrasenia" type="password" placeholder="Contraseña Liga" required />
                    <label for="administrador">Administrador de la liga:</label>
                    <input name="administrador" id="administrador" type="text" value="<?php echo $_SESSION['username'] ?>" disabled />
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" form="formCrearLiga" onclick="crearLiga(); return false;" class="btn btn-primary">Crear Liga</button>
            </div>
        </div>
    </div>
</div>