<div class="row border mx-auto flex-wrap" id="contenedor">
    <script>
        $(document).ready(function() {
            $("button#generarLiga").on("click", function(evento) {
                window.location.href = "<?php echo base_url('Partidos_c/generarLiga/' . $liga) ?>";
            })
        });
        $.post("<?php echo base_url('Partidos_c/mostrarPartidos') ?>", {
                liga: "<?php echo $liga ?>"
            },
            function(dato_devuelto) {
                if (dato_devuelto == "[]") {
                    $("#contenedor").append("<h2 class='w-100 text-center'>NO SE HA INICIADO LA LIGA</h2><button id='generarLiga'>Generar Liga</button>");
                } else {
                    let partidos = JSON.parse(dato_devuelto);
                    //Creo unas variables para controlar el numero de la jornada y que cree una tabla nueva cada x partidos
                    let jornada = 1;
                    let npartido = 0;
                    for (let partido of partidos) {
                        //Si existe un resultado, que se muestre, sino que en vez del resultado te muestre un botón que te lleve al hacer click a escribir los datos del partido
                        partido.resultado_local > 0 ? resultado_completo = partido.resultado_local + " - " + partido.resultado_visitante : resultado_completo = "<button class='btn-resultado' data-id='" + partido.id + "'>Escribir Resultado</button>"
                        if (npartido % 4 == 0 || npartido == 0) {
                            $("#contenedor").append("<div class='jornada col-6 mt-2 table-responsive '><table class='table table-hover'><thead><tr class='text-center'><th colspan='5'>JORNADA " + jornada + "</th></tr><tr class='text-center'><th>Local</th><th>Resultado</th><th>Visitante</th><th class='w-25'>Fecha</th><th>Hora</th></th></tr></thead><tbody  id='jornada" + jornada + "'><tr class='text-center'><td>" + partido.equipo_local + "</td><td>" + resultado_completo + "</td><td>" + partido.equipo_visitante + "</td><td>" + partido.fecha + "</td><td>" + partido.hora + "</td></td></tr></tbody></table></div>")
                            jornada++;
                        } else {
                            $("tbody").last().append("<tr class='text-center'><td>" + partido.equipo_local + "</td><td>" + resultado_completo + "</td><td>" + partido.equipo_visitante + "</td><td><p contenteditable='true'>" + partido.fecha + "</p></td><td>" + partido.hora + "</td></td></tr>")
                        }
                        npartido++;

                    }
                }
                $(".btn-resultado").on("click", function() {
                    id = $(this).data('id');
                    window.location.href = "<?php echo base_url('Partidos_c/resultadoPartido/' . $liga) ?>" + "/" + id + "";
                });
            },
        );
    </script>
</div>