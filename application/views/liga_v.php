<script>
    $(document).ready(function() {
        //Añadimos la clase active al primer item del carrusel nada mas que cargue
        //la página para que haya solo un elemento activo. (Si lo hacemos en el bucle)
        //Se ponen todos con esa clase y no funcionará el carrusel correctamente
        $(".carousel-item:first").addClass("active");
    });
</script>
<div class="row justify-content-end" id="informacion">
    <section class="col-8 d-flex flex-wrap justify-content-center align-items-center" id="proxpartido">
        <div id="carouselExampleControls" class="carousel slide w-100 border border-dark" data-ride="carousel">
            <div class="carousel-inner">
                <h3 class="col-12 text-center">Liga: <?= $liga ?></h3>
                <h3 class="col-12 text-center">Próximos Partidos</h3>
                <?php foreach ($proxPartidos as $partido) : ?>
                    <div class="carousel-item">
                        <div id="imagenes" class="col-12 d-flex justify-content-around h-50">
                            <img src="<?php echo base_url($partido->escudo_local) ?>" class="img-fluid">
                            <img src="<?php echo base_url('assets/img/vs.png') ?>" class="img-fluid">
                            <img src="<?php echo base_url($partido->escudo_visitante) ?>" class="img-fluid">
                        </div>
                        <p id="lugar" class="col-12 text-center">Jornada: <?= $partido->jornada ?></p>
                        <p id="fecha" class="col-12 text-center">Fecha: <?= date("d-m-Y", strtotime($partido->fecha)) ?></p>
                        <p id="hora" class="col-12 text-center">Hora: <?= $partido->hora ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </section>
    <aside class="col-2 h-25 d-flex justify-content-center flex-wrap align-items-center">
        <p class="col-12">¡Bienvenido <?= $_SESSION["username"] ?>!</p>
        <p class="col-12">Cuenta: <?= $_SESSION["tipo_cuenta"] ?></p>
        <p class="col-12">Liga: <?= $liga ?></p>
    </aside>
</div>