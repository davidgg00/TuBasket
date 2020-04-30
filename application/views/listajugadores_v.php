<script>
    $(document).ready(function() {
        //si se hace click en un td que no tiene la clase comparar (porque tiene el checkbox)
        $("tr td").on("click", function(evento) {
            if (!$(this).hasClass('comparar')) {
                //Te redirija a las estadísticas individuales
                window.location.href = "<?= base_url('Usuario_c/estadisticas/') ?>" + $(this).parent().children(':first').html();
            }
        })

        //Si se clicka el botón comparar recorremos todos los td y comprobaremos si está checkeado
        $("#btn-comparar").on("click", function(evento) {
            let jugadores = [];
            $("tr td").each(function(index, elemento) {
                if ($(elemento).hasClass('comparar') && $(elemento).children().is(':checked')) {
                    //pillamos el username del jugador que está en un td:hidden en la misma fila y primera posición y lo guardamos en un array.
                    jugadores.push($(elemento).parent().children(':first').html());
                }
            });

            if (jugadores.length > 1 && jugadores.length <= 4) {
                console.log(jugadores);
                window.location.href = "<?= base_url('Usuario_c/estadisticas/') ?>" + $(jugadores);
            }
        });
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
        width: 100px;
    }
</style>
<div class="row justify-content-center flex-start h-100 bg-white">
    <table class="col-12 table">
        <form action="<?= base_url('Usuario_c/estadisticas/') ?>" method="POST">
            <tr>
                <th>Foto</th>
                <th>Apellidos y Nombre</th>
                <th>Fecha de nacimiento</th>
                <th>Equipo</th>
                <th><input type="submit" class="btn btn-success" value="Comparar"></th>
            </tr>
            <?php
            //Mostramos los datos de cada jugador que está en la liga
            foreach ($jugadores as $jugador) :
                if ($jugador->tipo == "Jugador") :
            ?>
                    <tr class="text-center">
                        <td style="display:none;"><?= $jugador->username ?></td>
                        <td>
                            <img class="img-fluid" src="<?= base_url($jugador->foto_perfil) ?>" alt="">
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
        </form>
    </table>
</div>