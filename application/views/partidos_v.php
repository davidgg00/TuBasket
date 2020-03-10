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
                        //Volteamos fecha debido al formato
                        let fechaArray = partido.fecha.split('-');
                        let fecha = fechaArray[2] + '-' + fechaArray[1] + '-' + fechaArray[0];

                        //Si existe un resultado, que se muestre, sino que en vez del resultado te muestre un botón que te lleve al hacer click a escribir los datos del partido
                        partido.resultado_local > 0 ? resultado_completo = partido.resultado_local + " - " + partido.resultado_visitante : resultado_completo = "<button class='btn-resultado' data-id='" + partido.id + "'>Escribir Resultado</button>"
                        if (npartido % 4 == 0 || npartido == 0) {
                            $("#contenedor").append("<div class='jornada col-6 mt-2 table-responsive '><table class='table table-hover'><thead><tr class='text-center'><th colspan='5'>JORNADA " + jornada + "</th></tr><tr class='text-center'><th>Local</th><th>Resultado</th><th>Visitante</th><th class='w-25'>Fecha</th><th>Hora</th></th></tr></thead><tbody  id='jornada" + jornada + "'><tr class='text-center'><td>" + partido.equipo_local + "</td><td>" + resultado_completo + "</td><td>" + partido.equipo_visitante + "</td><td><input type='text' id='" + partido.id + "' class='datepick w-100 mx-auto' value='" + fecha + "'></td><td><input id='" + partido.id + "' class='hora w-100 mx-auto' type='time' step='1' value='" + partido.hora + "'></td></td></tr></tbody></table></div>")
                            jornada++;
                        } else {
                            $("tbody").last().append("<tr class='text-center'><td>" + partido.equipo_local + "</td><td>" + resultado_completo + "</td><td>" + partido.equipo_visitante + "</td><td><p contenteditable='true'><input type='text' class='datepick w-100 mx-auto' id='" + partido.id + "' value='" + fecha + "'></p></td><td><input id='" + partido.id + "' class='hora w-100 mx-auto' type='time' step='1' value='" + partido.hora + "'></td></td></tr>")
                        }
                        npartido++;

                    }
                }
                $(".btn-resultado").on("click", function() {
                    id = $(this).data('id');
                    window.location.href = "<?php echo base_url('Partidos_c/resultadoPartido/' . $liga) ?>" + "/" + id + "";
                });
                $(".datepick").datepicker({
                    dateFormat: 'dd-mm-yy'
                });

                $(".datepick").on("change", function(evento) {
                    //Volteamos fecha debido al formato
                    let fechaArray = $(this).val().split('-');
                    let fecha_val = fechaArray[2] + '-' + fechaArray[1] + '-' + fechaArray[0];
                    $.post("<?= base_url('Partidos_c/cambiarFecha') ?>", {
                            idPartido: $(this).attr('id'),
                            fecha: fecha_val
                        },
                        function(dato_devuelto) {
                            console.log(dato_devuelto);
                        },
                    );
                })

                $(".hora").on("change", function(evento) {
                    $.post("<?= base_url('Partidos_c/cambiarHora') ?>", {
                            idPartido: $(this).attr('id'),
                            hora: $(this).val()
                        },
                        function(dato_devuelto) {
                            console.log(dato_devuelto);
                        },
                    );
                })
            },
        );
    </script>
</div>