<script>
    let base_url = "<?= base_url() ?>";
    let tipo_cuenta = "<?= $_SESSION['tipo_cuenta'] ?>";
    let nequipos = <?= $nequipos ?>;
    let liga = "<?= $liga ?>";
    let partidos = <?php echo json_encode($partidos); ?>;
</script>
<script src="<?php echo base_url('assets/js/partidos.js') ?>"></script>
<div class="row border mx-auto" id="contenedor">
    <div id="calendarioWrapper" class="d-flex flex-wrap align-items-start">
        <!--Si la liga no se ha generado-->
        <?php if (count($partidos) == 0) : ?>
            <table class="table table-bordered" id="equiposActuales">
                <div class="alert alert-warning d-block mx-auto mt-3" role="alert">
                    Para generar una liga se necesita tener 8 o 10 equipos.
                </div>
                <h3 class="mx-auto w-100 text-center">Equipos Actuales</h3>
                <!--Si se ha añadido algún equipo los mostramos-->
                <?php if (count($equipos) > 0) : ?>
                    <?php
                    for ($i = 0; $i < count($equipos); $i++) : ?>
                        <tr>
                            <td><img src="<?= base_url($equipos[$i]->escudo_ruta) ?>" alt="" class=""></td>
                            <td class="nombreEquipo">
                                <p><?= $equipos[$i]->equipo ?></p>
                            </td>
                            <?php if (isset($equipos[$i + 1])) : $i++ ?>
                                <td><img src="<?= base_url($equipos[$i]->escudo_ruta) ?>" alt="" class=""></td>
                                <td class="nombreEquipo">
                                    <p><?= $equipos[$i]->equipo ?></p>
                                </td>
                            <?php endif; ?>

                        </tr>
                    <?php endfor; ?>
                <?php else : ?>
                    <tr>
                        <td><img src="<?php echo base_url('assets/img/escudo-por-defecto.png') ?>" alt="" class=""></td>
                        <td>
                            <p>Añade equipos en el apartado "Gestionar Equipos"</p>
                        </td>
                        <td><img src="<?php echo base_url('assets/img/escudo-por-defecto.png') ?>" alt="" class=""></td>
                        <td>
                            <p>Añade equipos en el apartado "Gestionar Equipos"</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </table>
        <?php endif; ?>

        <?php
        //Si no hay ningún partido mostramos opción de generar partidos
        if (count($partidos) == 0) : ?>
            <button type="button" class="btn btn-secondary mx-auto" id="btn-generarLiga">Generar liga</button>
        <?php endif; ?>
    </div>
    <div id="paginacion" class="mx-auto h-25"></div>
</div>

<style>
    <?php if ($_SESSION["tipo_cuenta"] != "Administrador") : ?>table tr.partido:hover {
        cursor: pointer;
    }

    <?php endif; ?>
</style>