<div class="row justify-content-center align-items-center h-100" id="wrapper-stats">
    <div class="col-10 h-75 d-flex flex-start flex-wrap border border-dark" id="estadisticas">
        <div id="foto" class="w-100 text-center">
            <img src="https://e00-marca.uecdn.es/assets/multimedia/imagenes/2019/01/01/15463451815652.jpg" class="img-fluid" alt="">
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
        <div id="partidos">

        </div>
    </div>
</div>