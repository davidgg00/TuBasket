<script>
    function getJugadoresSinConfirmar() {
        //Creamos Ajax por GET para obtener los jugadores que no están validados en la plataforma
        $.get("<?php echo base_url('GestionJugadores_c/obtenerJugadoresSinConfirmar/' . $liga) ?>",
            function(dato_devuelto) {
                //Lo parseamos.
                let jugadores = JSON.parse(dato_devuelto);
                //Y los mostramos después del thead
                for (let dato of jugadores) {
                    $("thead.alert-warning").after("<tr><th scope='row'>" + dato.username + "</th><td>" + dato.email + "</td><td>" + dato.apenom + "</td><td>" + dato.fecha_nac + "</td> <td>" + dato.nombre_equipo + "</td><td class='d-flex justify-content-around'><i data-tippy-content='Aceptar Jugador' class='tippy fas fa-check-square aceptar' id='aceptar' data-username='" + dato.username + "'></i><i data-tippy-content='Denegar Jugador' class='fas fa-window-close denegar' id='denegar' data-username='" + dato.username + "'></i></td> </tr>");
                }
                $(".aceptar").on("click", function(evento) {
                    $.get(window.location.origin + "/TuBasket/GestionJugadores_c/aceptarJugador/" + $(this).data('username'), );
                    $(this).parent().parent().remove();
                    $("#jugadores_confirmados").html("");
                    getJugadoresConfirmados();
                })
                $(".denegar").on("click", function(evento) {
                    $.get(window.location.origin + "/TuBasket/GestionJugadores_c/eliminarJugador/" + $(this).data('username'), );
                    $(this).parent().parent().remove();
                })
            }
        );
    }

    function template(jugadores) {
        let html;
        for (let dato of jugadores) {
            html += "<tr><th scope='row'>" + dato.username + "</th><td>" + dato.email + "</td><td>" + dato.apenom + "</td><td>" + dato.fecha_nac + "</td> <td>" + dato.nombre_equipo + "</td></tr>"
        }
        return html;
    }

    function getJugadoresConfirmados() {
        //Creamos paginacion con ajax
        $("#paginacion").pagination({
            dataSource: function(done) {
                $.ajax({
                    type: "GET",
                    url: "<?php echo base_url('GestionJugadores_c/obtenerJugadoresConfirmados/' . $liga) ?>",
                    success: function(response) {
                        //Lo parseamos.
                        let jugadores = JSON.parse(response);
                        done(jugadores);
                    }
                });
            },
            locator: 'items',
            pageSize: 10,
            callback: function(data, pagination) {
                var html = template(data);
                $("#jugadores_confirmados").html(html)
            }
        })
    }
    $(document).ready(function() {
        getJugadoresSinConfirmar();
        getJugadoresConfirmados();
    });
</script>

<div class="row">
    <table class="mx-auto table table-striped table-light table-bordered table-hover col-10">
        <h2 class="mx-auto w-10 alert alert-warning mb-0">USUARIOS PENDIENTES DE VALIDAR</h2>
        <thead class="alert-warning" id="jugadores_sinConfirmar">
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
    <table class="mx-auto table table-striped table-light table-bordered table-hover col-10">
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
        <tbody class="text-center" id="jugadores_confirmados">
        </tbody>
    </table>
    <div id="paginacion" class="col-10 mx-auto">
    </div>
</div>