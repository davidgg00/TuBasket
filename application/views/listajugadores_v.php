<script>
    $(document).ready(function() {

        //si se hace click en un td que no tiene la clase comparar (no se clicka en un checkbox)
        $("tr td").on("click", function(evento) {
            if (!$(this).hasClass('comparar')) {
                //Te redirija a las estadísticas individuales del jugador clickado
                window.location.href = "<?= base_url('Usuario_c/estadisticas/') ?>" + $(this).parent().children(':first').html();
            }
        })

        //Al intentar comparar jugadores
        $("#compararJugadores").on("submit", function(evento) {
            //Creamos un array
            let jugadores = [];
            $("tr td").each(function(index, elemento) {
                if ($(elemento).hasClass('comparar') && $(elemento).children().is(':checked')) {
                    //pillamos el username del jugador que está en un td:hidden en la misma fila y primera posición y lo guardamos.
                    jugadores.push($(elemento).parent().children(':first').html());
                }
            });

            //Si se han seleccionado menos de 2 jugadores o más de 2 jugadores aparecerán distintos errores
            if (jugadores.length < 0 || jugadores.length < 2 || jugadores.length == 3) {
                evento.preventDefault();
                if (jugadores.length == 0 || jugadores.length < 2) {
                    $("#alerta-comparar").html("Tienes que comparar dos jugadores.");
                    $("#alerta-comparar").slideDown(500);
                } else {
                    $("#alerta-comparar").html("Solo puedes comparar como máximo dos jugadores.");
                    $("#alerta-comparar").slideDown(500);
                }

                //Quitamos error.
                window.setTimeout(function() {
                    $("#alerta-comparar").fadeTo(500, 0).slideUp(800, function() {
                        $(this).css('opacity', '');
                    });
                }, 3000);
            }
        })
    });
</script>
<style>
    tr td:hover {
        cursor: pointer;
    }

    td.comparar:hover {
        cursor: auto;
    }

    td img {
        width: 110px;
        height: 120px;
    }

    #alerta-comparar {
        display: none;
    }
</style>
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