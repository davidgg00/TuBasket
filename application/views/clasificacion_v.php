<div class="row justify-content-center align-items-start h-100" id="clasificacion">
    <table class="table table-bordered bg-white text-center">
        <thead>
            <tr>
                <th colspan="7">
                    <H3>CLASIFICACION</H3>
                </th>
            </tr>
            <tr>
                <th scope="col">Posición</th>
                <th scope="col">Equipo</th>
                <th scope="col">PG</th>
                <th scope="col">PP</th>
                <th scope="col">PF</th>
                <th scope="col">PC</th>
                <th scope="col">Puntos</th>
            </tr>
        </thead>
        <tbody>
            <?php
            //Insertamos la clasificación.
            foreach ($clasificacion as $posic => $equipo) {
                $posic++;
                echo "<tr>";
                echo "<td><p>$posic</p></td>";
                echo "<td><img src='" . base_url($equipo->escudo_ruta) . "' class='ml-2'><p class='nombreEquipo'>$equipo->equipo</p></td>";
                echo "<td><p>$equipo->partidos_ganados</p></td>";
                echo "<td><p>$equipo->partidos_perdidos</p></td>";
                echo "<td><p>$equipo->puntos_favor</p></td>";
                echo "<td><p>$equipo->puntos_contra</p></td>";
                echo "<td><p>$equipo->puntos_clasificacion</p></td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>