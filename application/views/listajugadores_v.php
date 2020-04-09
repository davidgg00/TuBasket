<script>
    $(document).ready(function() {
        $("tr").on("click", function(evento) {
            window.location.href = "<?= base_url('Usuario_c/estadisticas/') ?>" + $(this).children(':first').html();
            console.log($(this).children(':first').html());
        })
    });
</script>
<style>
    tr:hover {
        cursor: pointer;
    }

    td img {
        width: 100px;
    }
</style>
<div class="row justify-content-center flex-start h-100 bg-white">
    <table class="col-12 table">
        <tr>
            <th>Foto</th>
            <th>Apellidos y Nombre</th>
            <th>Fecha de nacimiento</th>
            <th>Equipo</th>
        </tr>
        <?php
        //Mostramos las estadísticas de cada jugador si no es del mismo equipo que el entrenador
        foreach ($jugadores as $jugador) :
            if ($jugador->equipo != $_SESSION['equipo']) :
        ?>
                <tr class="text-center">
                    <td style="display:none;"><?= $jugador->username ?></td>
                    <td>
                        <!--Foto del jugador que se implementará mas tarde-->
                        <img class="img-fluid" src="https://e00-marca.uecdn.es/assets/multimedia/imagenes/2019/01/01/15463451815652.jpg" alt="">
                    </td>
                    <td><?= $jugador->apenom ?></td>
                    <td><?= $jugador->fecha_nac ?></td>
                    <td><?= $jugador->nombre_equipo ?></td>
                </tr>
        <?php
            endif;
        endforeach; ?>
    </table>
</div>