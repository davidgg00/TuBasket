<script>
    let idpartido = '<?= $id ?>';
    let liga_actual = '<?= $liga ?>';
    let base_url = '<?= base_url() ?>';
    let tipocuenta = '<?= $_SESSION['tipo_cuenta'] ?>';
</script>
<div class="row border mx-auto bg-white d-flex">
    <div id="contenedor-equipos" class="w-75 mx-auto mt-2 mb-2">
        <div id="equipos" class="mx-auto w-100 h-100 d-flex justify-content-center">
            <div class='equipo d-flex justify-content-center flex-wrap align-items-center'><img id='<?= $equipos->id_local ?>' class='img-fluid' src="<?= base_url($equipos->escudo_local) ?>">
                <p class='w-100 text-center'><?= $equipos->equipo_local ?></p> <span id="<?= $equipos->id_local ?>" data-id='<?= $equipos->equipo_local ?>'></span>
            </div>
            <div class='equipo d-flex justify-content-center flex-wrap'><img id='img-vs' class='img-fluid' src='<?= base_url('assets/img/vs.png') ?>'></div>
            <div class='equipo d-flex justify-content-center flex-wrap align-items-center'><img id='<?= $equipos->id_visitante ?>' class='img-fluid' src="<?= base_url($equipos->escudo_visitante) ?>">
                <p class='w-100 text-center'><?= $equipos->equipo_visitante ?></p><span id="<?= $equipos->id_visitante ?>" data-id='<?= $equipos->equipo_visitante ?>'></span>
            </div>
        </div>
    </div>
    <div id="jugadores_stats" class="text-center mx-auto">
        <table id="tabla_stats" class="col-11 mx-auto" border="1">
            <thead>
                <tr class='text-center'>
                    <th class="w-25">Jugador</th>
                    <th>Equipo</th>
                    <th>Triples Metidos</th>
                    <th>Tiros de 2 Metidos</th>
                    <th>Tiros libres metidos</th>
                    <th>Tapones</th>
                    <th>Robos</th>
                </tr>
            </thead>

            <tbody>
                <?php $disabled = ($_SESSION['tipo_cuenta'] == "Jugador" || $_SESSION['tipo_cuenta'] == "Entrenador") ? "disabled" : "";
                foreach ($jugadores as $jugador) :
                    $valuetriples = isset($jugador->triples_metidos) ? $jugador->triples_metidos : "0";
                    $valuetiros2 = isset($jugador->tiros_2_metidos) ? $jugador->tiros_2_metidos : "0";
                    $valuetiroslibres = isset($jugador->tiros_libres_metidos) ? $jugador->tiros_libres_metidos : "0";
                    $tapones = isset($jugador->tapones) ? $jugador->tapones : "0";
                    $robos = isset($jugador->robos) ? $jugador->robos : "0"; ?>
                    <tr>
                        <td class='d-none'><?= $jugador->username ?></td>
                        <td class='datos'><?= $jugador->apenom ?></td>
                        <td class='datos'><?= $jugador->equipo ?></td>
                        <td><input <?= $disabled ?> value="<?= $valuetriples ?>" data-equipo="<?= $jugador->equipo ?>" min=' 0' class='w-50' class='w-50' size='10' type='number' name='triples'></td>
                        <td><input <?= $disabled ?> value="<?= $valuetiros2 ?>" data-equipo="<?= $jugador->equipo ?>" min='0' class='w-50' size='10' type='number' name='tiros2'></td>
                        <td><input <?= $disabled ?> value="<?= $valuetiroslibres ?>" data-equipo="<?= $jugador->equipo ?>" min='0' class='w-50' size='10' type='number' name='tiroslibres'></td>
                        <td><input <?= $disabled ?> value="<?= $tapones ?>" data-equipo="<?= $jugador->equipo ?>" min='0' class='w-50' size='10' type='number' name='tapones'></td>
                        <td><input <?= $disabled ?> value="<?= $robos ?>" data-equipo="<?= $jugador->equipo ?>" min='0' class='w-50' size='10' type='number' name='robos'></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>

        </table>
    </div>
    <script src="<?php echo base_url('assets/js/partido.js'); ?>"></script>
</div>