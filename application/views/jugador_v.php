<div class="row justify-content-center flex-start h-100" id="wrapper-stats">
    <div class="col-10 h-75 d-flex flex-start flex-wrap mt-2" id="estadisticas">
        <div id="foto" class="w-100 text-center">
            <!--Foto que será implementada en los perfiles mas tarde-->
            <img src="<?= base_url($datos_user->imagen) ?>" class="img-fluid" alt="">
        </div>
        <div id="estadistica_media" class="w-50">
            <h2 class="text-center">Estadísticas Media</h2>
            <h4>Triples metidos: <?= $estadisticas->triples / $estadisticas->partidos_jugados ?></h4>
            <h4>Tiros de 2 metidos: <?= $estadisticas->tiros_2 / $estadisticas->partidos_jugados ?></h4>
            <h4>Tiros libres metidos: <?= $estadisticas->tiros_libres / $estadisticas->partidos_jugados ?></h4>
            <h4>Tapones: <?= $estadisticas->tapones / $estadisticas->partidos_jugados ?></h4>
            <h4>Robos: <?= $estadisticas->robos / $estadisticas->partidos_jugados ?></h4>
        </div>
        <div id="estadistica_total" class="w-50">
            <h2 class="text-center">Estadisticas Totales</h2>
            <h4>Triples metidos: <?= $estadisticas->triples ?></h4>
            <h4>Tiros de 2 metidos: <?= $estadisticas->tiros_2 ?></h4>
            <h4>Tiros libres metidos: <?= $estadisticas->tiros_libres ?></h4>
            <h4>Tapones: <?= $estadisticas->tapones ?></h4>
            <h4>Robos: <?= $estadisticas->robos ?></h4>
        </div>
        <h3 class="mx-auto mt-3">Estadisticas partidos</h3>
        <div id="partidos" class="col-12">
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
                    <?php
                    foreach ($stats_ind as $partido) {
                        if ($partido->id_local === $_SESSION['equipo']) {
                            echo "<td>$partido->equipo_visitante</td>";
                        } else {
                            echo "<td>$partido->equipo_local</td>";
                        }
                        echo "<td>$partido->triples_metidos</td>";
                        echo "<td>$partido->tiros_2_metidos</td>";
                        echo "<td>$partido->tiros_libres_metidos</td>";
                        echo "<td>$partido->tapones</td>";
                        echo "<td>$partido->robos</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>