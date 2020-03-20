<div class="row justify-content-center align-items-center h-100" id="clasificacion">
    <table class="table table-bordered bg-white text-center">
        <thead>
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
            foreach ($clasificacion as $posic => $equipo) {
                $posic++;
                echo "<tr>";
                echo "<td>$posic</td>";
                echo "<td>$equipo->equipo</td>";
                echo "<td>$equipo->partidos_ganados</td>";
                echo "<td>$equipo->partidos_perdidos</td>";
                echo "<td>$equipo->puntos_favor</td>";
                echo "<td>$equipo->puntos_contra</td>";
                echo "<td>$equipo->puntos_clasificacion</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>