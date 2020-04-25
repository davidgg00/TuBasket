<script>
    let idpartido = '<?= $id ?>';
    let liga_actual = '<?= $liga ?>';
    let base_url = '<?= base_url() ?>';
    let tipocuenta = '<?= $_SESSION['tipo_cuenta'] ?>';
</script>

<div class="row border mx-auto bg-white d-flex">
    <div id="cargando" class="w-50 h-50 mx-auto"><img src='https://media2.giphy.com/media/3oEjI6SIIHBdRxXI40/200.gif' id='carga' class='w-100'></div>
    <div id="contenedor-equipos" class="w-75 mx-auto mt-2 mb-2">
        <div id="equipos" class="mx-auto w-100 h-100 d-flex justify-content-center"></div>
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

            </tbody>

        </table>
    </div>
    <script src="<?php echo base_url('assets/js/partido.js'); ?>"></script>
</div>