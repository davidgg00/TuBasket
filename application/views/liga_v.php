<script>
    $.post("<?php echo base_url('Admin_c/getPartidosCarrusel/' . $liga) ?>",
        function(dato_devuelto) {
            let datos = JSON.parse(dato_devuelto);
            for (let dato of datos) {
                console.log(dato.escudo_local);
                $(".carousel-inner").append("<div class='carousel-item text-center'><img class='float-left d-inline-block img-fluid' src='<?= base_url() ?>" + dato.escudo_local + "' alt='First slide'><img class='img-fluid  d-inline-block' src='<?= base_url() ?>" + "assets/img/vs.png' alt='First slide'><img class='img-fluid  d-inline-block float-right' src='<?= base_url() ?>" + dato.escudo_visitante + "' alt='First slide'></div>");
            }
            $(".carousel-item:first").addClass("active");
        },
    );
</script>
<div class="row justify-content-end" id="informacion">
    <section class="col-8 d-flex flex-wrap justify-content-center align-items-center" id="proxpartido">
        <div id="partido" class="col-12 h-75 d-flex justify-content-center flex-wrap">
            <h3 class="col-12 text-center">Liga: <?= $liga ?></h3>
            <h3 class="col-12 text-center">Próximo Partido</h3>
            <div id="carouselExampleControls" class="carousel slide w-75" data-ride="carousel">
                <div class='carousel-inner border border-primary'>
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
        </div>
    </section>
    <aside class="col-2 h-25 d-flex justify-content-center flex-wrap align-items-center">
        <p class="col-12">¡Bienvenido <?= $_SESSION["username"] ?>!</p>
        <p class="col-12">Cuenta: <?= $_SESSION["tipo_cuenta"] ?></p>
        <p class="col-12">Liga: <?= $liga ?></p>
    </aside>
</div>