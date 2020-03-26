<div class="row border mx-auto flex-wrap" id="contenedor">
    <script>
        $(document).ready(function() {
            $("button#generarLiga").on("click", function(evento) {
                window.location.href = "<?php echo base_url('Partidos_c/generarLiga/' . $liga) ?>";
            })
        });

        let partidos = <?php echo json_encode($partidos); ?>;
        //Creo unas variables para controlar el numero de la jornada y que cree una tabla nueva cada x partidos
        let jornada = 1;
        let npartido = 0;
        //Si la cuenta es de tipo jugador esta variable almacenará "disabled" y se le introducirá a los inputs de fecha y hora para 
        //que los jugadores no puedan cambiar los datos del encuentro
        $disabled = ('<?php echo $_SESSION['tipo_cuenta'] ?>' == "Jugador") ? "disabled" : "";
        //En el caso de que el numero de equipos sea 8 o 10
        switch (<?= ($nequipos) ?>) {
            case 8:
                for (let partido of partidos) {
                    //Volteamos fecha debido al formato
                    let fechaArray = partido.fecha.split('-');
                    let fecha = fechaArray[2] + '-' + fechaArray[1] + '-' + fechaArray[0];
                    //Creamos una variable que almacene el resultado directamente
                    resultado_completo = partido.resultado_local + " - " + partido.resultado_visitante

                    //Si el partido es divisible entre 4 crear un nuevo div porque es nueva jornada (Solo funciona con ligas de 8 equipos)
                    if (npartido % 4 == 0 || npartido == 0) {
                        $("#contenedor").append("<div class='jornada col-6 mt-2 table-responsive '><table class='table table-hover m-0 h-100'><thead><tr class='text-center'><th colspan='5'>JORNADA " + jornada + "</th></tr><tr class='text-center'><th>Local</th><th>Resultado</th><th>Visitante</th><th class='w-25'>Fecha</th><th>Hora</th></th></tr></thead><tbody  id='jornada" + jornada + "'><tr class='text-center'><td>" + partido.equipo_local + "</td><td class='resultado' data-id='" + partido.id + "' data-tippy-content='Haga click para escribir resultado'>" + resultado_completo + "</td><td>" + partido.equipo_visitante + "</td><td><input type='text' id='" + partido.id + "' class='datepick w-100 mx-auto' value='" + fecha + "' " + $disabled + "></td><td><input id='" + partido.id + "' class='hora w-100 mx-auto' type='time' step='1' value='" + partido.hora + "'" + $disabled + "></td></td></tr></tbody></table></div>")
                        jornada++;
                    } else {
                        $("tbody").last().append("<tr class='text-center'><td>" + partido.equipo_local + "</td><td class='resultado' data-id='" + partido.id + "' data-tippy-content='Haga click para escribir resultado'>" + resultado_completo + "</td><td>" + partido.equipo_visitante + "</td><td><p contenteditable='true'><input type='text' class='datepick w-100 mx-auto' id='" + partido.id + "' value='" + fecha + "' " + $disabled + "></p></td><td><input id='" + partido.id + "' class='hora w-100 mx-auto' type='time' step='1' value='" + partido.hora + "' " + $disabled + "></td></td></tr>")
                    }
                    npartido++;
                }
                break;

            case 10:
                //Volteamos fecha debido al formato
                let fechaArray = partido.fecha.split('-');
                let fecha = fechaArray[2] + '-' + fechaArray[1] + '-' + fechaArray[0];
                //Creamos una variable que almacene el resultado directamente
                resultado_completo = partido.resultado_local + " - " + partido.resultado_visitante

                //Si el partido es divisible entre 5 crear un nuevo div porque es nueva jornada (Solo funciona con ligas de 8 equipos)
                if (npartido % 5 == 0 || npartido == 0) {
                    $("#contenedor").append("<div class='jornada col-6 mt-2 table-responsive '><table class='table table-hover m-0 h-100'><thead><tr class='text-center'><th colspan='5'>JORNADA " + jornada + "</th></tr><tr class='text-center'><th>Local</th><th>Resultado</th><th>Visitante</th><th class='w-25'>Fecha</th><th>Hora</th></th></tr></thead><tbody  id='jornada" + jornada + "'><tr class='text-center'><td>" + partido.equipo_local + "</td><td class='resultado' data-id='" + partido.id + "' data-tippy-content='Haga click para escribir resultado'>" + resultado_completo + "</td><td>" + partido.equipo_visitante + "</td><td><input type='text' id='" + partido.id + "' class='datepick w-100 mx-auto' value='" + fecha + "' " + $disabled + "></td><td><input id='" + partido.id + "' class='hora w-100 mx-auto' type='time' step='1' value='" + partido.hora + "'" + $disabled + "></td></td></tr></tbody></table></div>")
                    jornada++;
                } else {
                    $("tbody").last().append("<tr class='text-center'><td>" + partido.equipo_local + "</td><td class='resultado' data-id='" + partido.id + "' data-tippy-content='Haga click para escribir resultado'>" + resultado_completo + "</td><td>" + partido.equipo_visitante + "</td><td><p contenteditable='true'><input type='text' class='datepick w-100 mx-auto' id='" + partido.id + "' value='" + fecha + "' " + $disabled + "></p></td><td><input id='" + partido.id + "' class='hora w-100 mx-auto' type='time' step='1' value='" + partido.hora + "'" + $disabled + "></td></td></tr>")
                }
                npartido++;
                break;
        }

        $("td.resultado").on("click", function() {
            id = $(this).data('id');
            window.location.href = "<?php echo base_url('Partidos_c/resultadoPartido/' . $liga) ?>" + "/" + id + "";
        });

        //Añadimos tooltip al resultado
        tippy('.resultado');

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
    </script>
</div>