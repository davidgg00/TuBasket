<script>
    $.ajax({
        type: "POST",
        url: "<?php echo base_url('Usuario_c/getJugadoresEquipo/') ?>",
        data: "data",
        dataType: "dataType",
        success: function(response) {
            let jugadores = JSON.parse(response);
            console.log(jugadores);
        }
    });
    $(document).ready(function() {
        $("#ofrecerFichaje").on("click", function(evento) {
            if ('<?php echo (!empty($entrenador->Entrenador)) ?>' != "") {
                $("#modalFichaje").modal("show");
            } else {
                Swal.fire({
                    backdrop: false,
                    icon: 'error',
                    title: 'Ooops....',
                    text: 'El entrenador del jugador que deseas fichar no está dado de alta en la plataforma.',
                })
            }
        });
    });
</script>
<div class="row justify-content-center flex-start h-100" id="wrapper-stats">
    <div class="col-10 h-75 d-flex flex-start flex-wrap mt-2" id="estadisticas">
        <div id="foto" class="w-100 text-center">
            <img src="<?= base_url($datos_user->imagen) ?>" class="img-fluid rounded-circle" alt="">
        </div>
        <div id="estadistica_media" class="w-50">
            <h2 class="text-center">Estadísticas Media</h2>
            <h4>Triples metidos: <?= ($estadisticas->triples > -1) ?  $estadisticas->triples / $estadisticas->partidos_jugados : "N/A"; ?></h4>
            <h4>Tiros de 2 metidos: <?= ($estadisticas->tiros_2 > -1) ? $estadisticas->tiros_2 / $estadisticas->partidos_jugados : "N/A"; ?></h4>
            <h4>Tiros libres metidos: <?= ($estadisticas->tiros_libres > -1) ? $estadisticas->tiros_libres / $estadisticas->partidos_jugados : "N/A"; ?></h4>
            <h4>Tapones: <?= ($estadisticas->tapones > -1) ? $estadisticas->tapones / $estadisticas->partidos_jugados : "N/A"; ?></h4>
            <h4>Robos: <?= ($estadisticas->robos > -1) ? $estadisticas->robos / $estadisticas->partidos_jugados : "N/A"; ?></h4>
        </div>
        <div id="estadistica_total" class="w-50">
            <h2 class="text-center">Estadisticas Totales</h2>
            <h4>Triples metidos: <?= ($estadisticas->triples > -1) ? $estadisticas->triples : "N/A" ?></h4>
            <h4>Tiros de 2 metidos: <?= ($estadisticas->tiros_2 > -1) ? $estadisticas->tiros_2 : "N/A" ?></h4>
            <h4>Tiros libres metidos: <?= ($estadisticas->tiros_libres > -1) ? $estadisticas->tiros_libres : "N/A" ?></h4>
            <h4>Tapones: <?= ($estadisticas->tapones > -1) ? $estadisticas->tapones : "N/A" ?></h4>
            <h4>Robos: <?= ($estadisticas->robos > -1) ? $estadisticas->robos : "N/A" ?></h4>
        </div>
        <h3 class="mx-auto mt-3">Estadisticas por partidos</h3>
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
                        if ($partido->id_local === $_SESSION['equipo'] && isset($partido->id_local)) {
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

        <!--La opción de ofrecer fichaje saldrá solo si el jugador que vas a seleccionar NO está en tu equipo-->
        <?php if (isset($datos_user->equipo) && $_SESSION['equipo'] != $datos_user->equipo) : ?>
            <img src="<?php echo base_url('assets/img/ofrecerfichaje.jpg'); ?>" alt="" id="ofrecerFichaje" class="mx-auto" data-toggle="modal">
        <?php endif; ?>
        <div class="modal fade" id="modalFichaje" tabindex="-1" role="dialog" aria-labelledby="modalFichaje" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="titulo_modal">Ofrecer un fichaje</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" id="formCrearLiga" class="text-center">
                            <h3>Fichar a</h3>
                            <h4 id="nombreFichaje" data-entrenador="<?= $entrenador->Entrenador ?>"><?= $jugador ?></h4>
                            <h3>por</h3>
                            <select name="jugadores" id="jugadores">
                                <?php foreach ($tusJugadores as $Jugador) :
                                    if ($Jugador->tipo == "Jugador") :
                                ?>
                                        <option value="<?= $Jugador->username ?>"><?= $Jugador->apenom ?></option>
                                <?php endif;
                                endforeach; ?>
                            </select>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" form="formCrearLiga" onclick="ofrecerFichaje(); return false;" class="btn btn-primary">Ofrecer Fichaje</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function ofrecerFichaje() {
        console.log($("#nombreFichaje").html());
        $.ajax({
            type: "POST",
            url: "<?= base_url('Fichajes_c/OfrecerFichaje'); ?>",
            data: {
                //Enviamos el username del jugador que queremos fichar, el id de su equipo actual y el username del jugador que ofrece
                jugadorAFichar: $("#nombreFichaje").html(),
                entrenadorRecibe: $("#nombreFichaje").data("entrenador"),
                jugadorOfrecido: $("#jugadores").val()
            },
            success: function(response) {
                console.log(response);
                if (response == "Error") {
                    Swal.fire({
                        backdrop: false,
                        icon: 'error',
                        title: 'Ooops....',
                        text: 'Ya has realizado este fichaje y está PENDIENTE. Cuando haya algún cambio se le notificará',
                    })
                    //Cerramos modal
                    $('#modalFichaje').modal('toggle');
                } else {
                    //Mostramos alerta correcta
                    Swal.fire({
                        backdrop: false,
                        icon: 'success',
                        title: 'Petición de fichaje realizada con éxito',
                        text: 'Cuando el equipo contrario decida si aceptar o denegar la propuesta, se le notificará.',
                    })
                    //Cerramos modal
                    $('#modalFichaje').modal('toggle');
                }
            }
        });

    }
</script>