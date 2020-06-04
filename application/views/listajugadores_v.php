<script>
    let baseurl = '<?= base_url() ?>';
</script>
<script src="<?php echo base_url('assets/js/listajugadores.js') ?>"></script>

<body>
    <div class="row justify-content-center flex-start h-100 bg-white">
        <div class="alert alert-danger mb-0" id="alerta-comparar" role="alert">
        </div>
        <table class="col-12 table">
            <form class="paginacionWrapper" action="<?= base_url('Usuario_c/estadisticas/') ?>" id="compararJugadores" method="POST">
                <thead>
                    <tr>
                        <th class="p-0">Foto</th>
                        <th class="p-0">Apellidos y Nombre</th>
                        <th class="p-0">Fecha de nacimiento</th>
                        <th class="p-0">Equipo</th>
                        <th class="p-0"><button type="submit" class="btn btn-success" id="btn-comparar">Comparar</button></th>
                    </tr>
                </thead>
                <tbody class="paginacionWrapper">
                    <?php
                    //Mostramos los datos de cada jugador que está en la liga
                    foreach ($jugadores as $jugador) :
                        if ($jugador->tipo == "Jugador") :
                    ?>
                            <tr class="text-center itemPaginacion">
                                <td style="display:none;"><?= $jugador->username ?></td>
                                <td>
                                    <img class="rounded-circle" src="<?= base_url($jugador->foto_perfil) ?>" alt="">
                                </td>
                                <td><?= $jugador->apenom ?></td>
                                <td><?= $jugador->fecha_nac ?></td>
                                <td><?= $jugador->nombre_equipo ?></td>
                                <td class="comparar">
                                    <input type="checkbox" name="jugador[]" value="<?= $jugador->username ?>">
                                </td>
                            </tr>
                    <?php
                        endif;
                    endforeach; ?>
                </tbody>
            </form>
        </table>
        <div id="pagination-container" class="w-50 d-flex mx-auto align-self-end justify-content-center">
            <p class='paginacionCursor' id="beforePagination">
                < </p> <p class='paginacionCursor' id="afterPagination">>
            </p>
        </div>
    </div>
</body>