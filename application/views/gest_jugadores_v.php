<script>
    function getJugadoresSinConfirmar() {
        //Creamos Ajax por GET para obtener los jugadores que no están validados en la plataforma
        $.get("<?php echo base_url('Ajax_c/obtenerJugadoresSinConfirmar/' . $liga) ?>",
            function(dato_devuelto) {
                //Lo parseamos.
                let jugadores = JSON.parse(dato_devuelto);
                //Y los mostramos después del thead
                for (let dato of jugadores) {
                    $("thead.alert-warning").after("<tr><th scope='row'>" + dato.username + "</th><td>" + dato.email + "</td><td>" + dato.apenom + "</td><td>" + dato.fecha_nac + "</td> <td>" + dato.nombre_equipo + "</td><td class='d-flex justify-content-around'><i class='fas fa-check-square' id='aceptar' data-username='" + dato.username + "'></i><i class='fas fa-window-close' id='denegar' data-username='" + dato.username + "'></i></td> </tr>");
                }
                $("#aceptar").on("click", function(evento) {
                    $.get(window.location.origin + "/TuBasket/Ajax_c/aceptarJugador/" + $(this).data('username'), );
                    $(this).parent().parent().remove();
                    getJugadoresSinConfirmar();
                    $("tbody").html("");
                    getJugadoresConfirmados();
                })

                $("#denegar").on("click", function(evento) {
                    $(this).parent().parent().remove();
                    $.get(window.location.origin + "/TuBasket/Ajax_c/eliminarJugador/" + $(this).data('username'), );
                })
            }
        );
    }

    function getJugadoresConfirmados() {
        //Creamos Ajax por GET para obtener los jugadores que están validados en la plataforma
        $.get("<?php echo base_url('Ajax_c/obtenerJugadoresConfirmados/' . $liga) ?>",
            function(dato_devuelto) {
                //Lo parseamos.
                let jugadores = JSON.parse(dato_devuelto);
                //Y los mostramos después del tbody
                for (let dato of jugadores) {
                    $("tbody").append("<tr><th scope='row'>" + dato.username + "</th><td>" + dato.email + "</td><td>" + dato.apenom + "</td><td>" + dato.fecha_nac + "</td> <td>" + dato.nombre_equipo + "</td></tr>");
                }
            }
        );
    }
    getJugadoresSinConfirmar();
    getJugadoresConfirmados();
</script>
<div class="row">
    <table class="mx-auto table table-striped table-light table-bordered table-hover col-12">
        <h2 class="mx-auto alert alert-warning mb-0">USUARIOS PENDIENTES DE ACEPTAR</h2>
        <thead class="alert-warning">
            <tr>
                <th scope="col">Username</th>
                <th scope="col">Email</th>
                <th scope="col">Apellidos y Nombre</th>
                <th scope="col">Fecha nacimiento</th>
                <th scope="col">Equipo</th>
                <th scope="col">Acción</th>
            </tr>
        </thead>
    </table>
    <table class="table table-striped table-light table-bordered table-hover col-12">
        <h2 class="alert alert-dark text-center mb-0 mx-auto">USUARIOS DE LA LIGA</h2>
        <thead class="thead-dark">
            <tr>
                <th scope="col">Username</th>
                <th scope="col">Email</th>
                <th scope="col">Apellidos y Nombre</th>
                <th scope="col">Fecha nacimiento</th>
                <th scope="col">Equipo</th>
            </tr>
        </thead>
        <tbody class="text-center">
        </tbody>
    </table>
</div>