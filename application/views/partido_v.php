<script>
    let idpartido = '<?= $id ?>';
    let liga_actual = '<?= $liga ?>';
    let base_url = '<?= base_url() ?>';
</script>
<script src="<?php echo base_url('assets/js/partido.js'); ?>"></script>

<div class="row border mx-auto bg-white d-flex">
    <div id="equipos" class="mx-auto w-75 d-flex justify-content-center mt-2 mb-2">
    </div>
    <div id="jugadores_stats" class="d-flex justify-content-center flex-wrap w-100">
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

            </tbody>

        </table>
    </div>
</div>