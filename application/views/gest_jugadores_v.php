<script>
    $(document).ready(function() {
        $(".aceptar").on("click", function(evento) {
            $.get(window.location.origin + "/TuBasket/GestionJugadores_c/aceptarJugador/" + $(this).data('username'), );
            let html = "<tr class='itemPaginacion'><th scope='row'>" + $(this).parent().parent().children().eq(0).html() + "</th><td>" + $(this).parent().parent().children().eq(1).html() + "</td><td>" + $(this).parent().parent().children().eq(2).html() + "</td><td>" + $(this).parent().parent().children().eq(3).html() + "</td><td>" + $(this).parent().parent().children().eq(4).html() + "</td></tr>"
            $("#jugadores_confirmados").append(html);
            $(this).parent().parent().remove();
            console.log(html);
        });
        $(".denegar").on("click", function(evento) {
            $.get(window.location.origin + "/TuBasket/GestionJugadores_c/eliminarJugador/" + $(this).data('username'), );
            $(this).parent().parent().remove();
        })

        //Añadimos tooltip a los .aceptar y .denegar
        tippy('.aceptar, .denegar');
    });
</script>

<div class="row">
    <?php if (count($jugadoresSinConfirmar) > 0) : ?>
        <div id="listaJugadoresSinConfirmar" class="listaJugadores d-flex flex-column mx-auto h-25">
            <table class="mx-auto table table-striped table-light table-hover col-12">
                <h2 class="mx-auto w-10 alert alert-warning mb-0">USUARIOS PENDIENTES DE VALIDAR</h2>
                <thead class="alert-warning" id="jugadores_sinConfirmar">
                    <tr>
                        <th scope="row">Username</th>
                        <th scope="col">Email</th>
                        <th scope="col">Apellidos y Nombre</th>
                        <th scope="col">Fecha nacimiento</th>
                        <th scope="col">Equipo</th>
                        <th scope="col">Acción</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($jugadoresSinConfirmar as $jugador) : ?>
                        <tr>
                            <td><?= $jugador->username ?></td>
                            <td><?= $jugador->email ?></td>
                            <td><?= $jugador->apenom ?></td>
                            <td><?= $jugador->fecha_nac ?></td>
                            <td><?= $jugador->nombre_equipo ?></td>
                            <td class='d-flex justify-content-around p-3'><i data-tippy-content='Aceptar Jugador' class='d-block h-100 tippy fas fa-check-square aceptar' id='aceptar' data-username='<?= $jugador->username ?>'></i><i data-tippy-content='Denegar Jugador' class='d-block fas fa-window-close denegar' id='denegar' data-username='<?= $jugador->username ?>'></i></td>
                        </tr>
                    <?php
                    endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
    <div id="listaJugadoresConfirmados" class="listaJugadores d-flex flex-column mx-auto h-100">
        <h2 class="alert alert-dark text-center mb-0 mx-auto">USUARIOS DE LA LIGA</h2>
        <table class="mx-auto table table-striped table-light table-hover col-12">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Username</th>
                    <th scope="col">Email</th>
                    <th scope="col">Apellidos y Nombre</th>
                    <th scope="col">Fecha nacimiento</th>
                    <th scope="col">Equipo</th>
                </tr>
            </thead>
            <tbody class="text-center paginacionWrapper" id="jugadores_confirmados">
                <?php foreach ($jugadoresConfirmados as $jugador) : ?>
                    <tr class='itemPaginacion'>
                        <th scope='row'><?= $jugador->username ?></th>
                        <td><?= $jugador->email ?></td>
                        <td><?= $jugador->apenom ?></td>
                        <td><?= $jugador->fecha_nac ?></td>
                        <td><?= $jugador->nombre_equipo ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div id="pagination-container" class="w-50 d-flex mx-auto align-self-end justify-content-center">
        <p class='paginacionCursor' id="beforePagination">
            < </p> <p class='paginacionCursor' id="afterPagination">>
        </p>
    </div>

</div>