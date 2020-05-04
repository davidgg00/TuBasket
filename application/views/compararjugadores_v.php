<div class="row justify-content-center flex-start h-100 bg-white">
    <?php
    //por cada elemento del array del POST['jugador'] mostramos sus estadisticas medias y totales
    //$estadisticas es un array que dentro tiene un objetos.
    foreach ($datos_user as $n => $jugador) : ?>
        <div class="w-50 estadistica_media d-flex justify-content-center flex-wrap">
            <h3 class="w-100 text-center"><?php echo $jugador->username ?></h3>
            <img src="<?= base_url($jugador->imagen) ?>" class="img-fluid w-25 mx-auto" alt="">
            <h2 class="text-center w-100">Estadísticas Media</h2>
            <h4 class="w-100 text-center">Triples metidos: <?= ($estadisticas[$n]->triples) ? $estadisticas[$n]->triples /  $estadisticas[$n]->partidos_jugados : "N/A"; ?></h4>
            <h4 class="w-100 text-center">Tiros de 2 metidos: <?= ($estadisticas[$n]->tiros_2) ? $estadisticas[$n]->tiros_2 /  $estadisticas[$n]->partidos_jugados : "N/A"; ?></h4>
            <h4 class="w-100 text-center">Tiros libres metidos: <?= ($estadisticas[$n]->tiros_libres) ? $estadisticas[$n]->tiros_libres /  $estadisticas[$n]->partidos_jugados : "N/A"; ?></h4>
            <h4 class="w-100 text-center">Tapones: <?= ($estadisticas[$n]->tapones) ?  $estadisticas[$n]->tapones /  $estadisticas[$n]->partidos_jugados : "N/A"; ?></h4>
            <h4 class="w-100 text-center">Robos: <?= ($estadisticas[$n]->robos) ? $estadisticas[$n]->robos /  $estadisticas[$n]->partidos_jugados : "N/A"; ?></h4>
        </div>
    <?php endforeach; ?>
    <?php foreach ($_POST['jugador'] as $n => $jugador) : ?>
        <div class="w-50 estadistica_total">
            <h2 class="text-center w-100">Estadisticas Totales</h2>
            <h4 class="w-100 text-center">Triples metidos: <?= ($estadisticas[$n]->triples) ? $estadisticas[$n]->triples : "N/A"; ?></h4>
            <h4 class="w-100 text-center">Tiros de 2 metidos: <?= ($estadisticas[$n]->tiros_2) ? $estadisticas[$n]->tiros_2 : "N/A";  ?></h4>
            <h4 class="w-100 text-center">Tiros libres metidos: <?= ($estadisticas[$n]->tiros_libres) ? $estadisticas[$n]->tiros_libres : "N/A"; ?></h4>
            <h4 class="w-100 text-center">Tapones: <?= ($estadisticas[$n]->tapones) ? $estadisticas[$n]->tapones : "N/A"; ?></h4>
            <h4 class="w-100 text-center">Robos: <?= ($estadisticas[$n]->robos) ? $estadisticas[$n]->robos : "N/A";  ?></h4>
        </div>
    <?php endforeach; ?>
    <?php foreach ($_POST['jugador'] as $n => $jugador) : ?>

        <div id="partidos" class="w-50">
            <h2 class="text-center">Estadisticas Partidos</h2>
            <table class="table table-bordered bg-white text-center">
                <thead>
                    <tr>
                        <th scope="col">Equipo</th>
                        <th scope="col">Triples</th>
                        <th scope="col">Tiros de 2</th>
                        <th scope="col">Tiros libres</th>
                        <th scope="col">Tapones</th>
                        <th scope="col">Robos</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($stats_ind[$n] as $partido) :
                    ?>
                        <tr>
                            <?php if ($partido->id_local === $_SESSION['equipo']) : ?>
                                <td><?= $partido->equipo_visitante ?></td>
                            <?php else : ?>
                                <td><?= $partido->equipo_local ?></td>
                            <?php endif; ?>
                            <td><?= $partido->triples_metidos ?></td>
                            <td><?= $partido->tiros_2_metidos ?></td>
                            <td><?= $partido->tiros_libres_metidos ?></td>
                            <td><?= $partido->tapones ?></td>
                            <td><?= $partido->robos ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endforeach; ?>
</div>