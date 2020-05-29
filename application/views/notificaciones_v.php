<script>
    let baseurl = '<?= base_url() ?>';
    let notificaciones = '<?= json_encode($fichajes) ?>';
    let username = '<?= $_SESSION['username'] ?>'
    let equipo = '<?= $_SESSION['equipo'] ?>'
</script>
<script src="<?php echo base_url('assets/js/notificaciones.js') ?>"></script>
<div class="row justify-content-center" id="informacion">
    <section class="col-10 d-flex flex-wrap align-content-space-around justify-content-center">
        <h4 class="mt-2 text-center w-100">Notificaciones</h4>
        <div id="notificacionesWrapper" class="col-12">

        </div>
        <div id="paginacion" class="w-100"></div>
    </section>
</div>