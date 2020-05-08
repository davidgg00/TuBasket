<div class="row border mx-auto flex-wrap" id="contenedor">
    <script>
        $(document).ready(function() {
            $("button#generarLiga").on("click", function(evento) {
                window.location.href = "<?php echo base_url('Partidos_c/generarLiga/' . $liga) ?>";
            })
            $(".btn-reset").on("click", function(evento) {
                $(this).parentsUntil("tbody").find(".resultado").html(" - ");

                console.log($(this).data('id'))
                $.post("<?php echo base_url('Partidos_c/resetPartido') ?>", {
                    idPartido: $(this).data('id')
                });
            })
        });

        let partidos = <?php echo json_encode($partidos); ?>;
        //Creo unas variables para controlar el numero de la jornada y que cree una tabla nueva cada x partidos
        let jornada = 1;
        let npartido = 0;
        //Si la cuenta es de tipo jugador esta variable almacenará "disabled" y se le introducirá a los inputs de fecha y hora para 
        //que los jugadores y entrenadores no puedan cambiar los datos del encuentro
        $disabled = ('<?php echo $_SESSION['tipo_cuenta'] ?>' == "Jugador" || '<?php echo $_SESSION['tipo_cuenta'] ?>' == "Entrenador") ? "disabled" : "";
        //En el caso de que el numero de equipos sea 8 o 10
        switch (<?= ($nequipos) ?>) {
            case 8:
                for (let partido of partidos) {
                    //Si la cuenta es de tipo jugador la fila de modificar o resetear partido no debe de aparecer.
                    $thaccion = ('<?php echo $_SESSION['tipo_cuenta'] ?>' == "Admin") ? "<th class='th-acccion'>Acción</th>" : "";
                    $accion = ('<?php echo $_SESSION['tipo_cuenta'] ?>' == "Admin") ? "<td class='td-accion'><i class='fas fa-edit' data-id='" + partido.id + "' data-tippy-content='Haga click para escribir resultado'></i><i class='fas fa-sync btn-reset' data-id='" + partido.id + "'></i></td>" : "";

                    //Volteamos fecha debido al formato
                    let fechaArray = partido.fecha.split('-');
                    let fecha = fechaArray[2] + '-' + fechaArray[1] + '-' + fechaArray[0];
                    //Creamos una variable que almacene el resultado directamente
                    resultado_completo = partido.resultado_local + " - " + partido.resultado_visitante

                    //Si el partido es divisible entre 4 crear un nuevo div porque es nueva jornada (Solo funciona con ligas de 8 equipos)
                    if (npartido % 4 == 0 || npartido == 0) {
                        $("#contenedor").append("<div class='jornada col-6 mt-2 table-responsive '><table class='table table-hover m-0 h-100 w-100'><thead><tr class='d-flex justify-content-center'><th colspan='6'>JORNADA " + jornada + "</th></tr><tr class='text-center d-flex'><th class='th-local text-center'>Local</th><th class='th-resultado text-center'>Resultado</th><th class='th-visitante text-center'>Visitante</th><th class='th-fecha'>Fecha</th><th class='th-hora'>Hora</th></th>" + $thaccion + "</tr></thead><tbody  id='jornada" + jornada + "'><tr class='text-center d-flex'><td class='td-local'>" + partido.equipo_local + "</td><td class='td-resultado'>" + resultado_completo + "</td><td class='td-visitante'>" + partido.equipo_visitante + "</td><td class='td-fecha'><input type='text' id='" + partido.id + "' class='datepick w-100 mx-auto' value='" + fecha + "' " + $disabled + "></td><td class='td-hora'><input id='" + partido.id + "' class='hora w-100 mx-auto text-center ' type='time' step='60' value='" + partido.hora + "'" + $disabled + "></td></td>" + $accion + "</tr></tbody></table></div>")
                        jornada++;
                    } else {
                        $("tbody").last().append("<tr class='text-center d-flex'><td class='d-flex align-items-center justify-content-center td-local'>" + partido.equipo_local + "</td><td class='d-flex align-items-center justify-content-center td-resultado'>" + resultado_completo + "</td><td class='d-flex align-items-center justify-content-center td-visitante'>" + partido.equipo_visitante + "</td><td class='d-flex align-items-center justify-content-center td-fecha'><p contenteditable='true'><input type='text' class='datepick w-100  mx-auto' id='" + partido.id + "' value='" + fecha + "' " + $disabled + "></p></td><td class='d-flex align-items-center justify-content-center td-hora'><input id='" + partido.id + "' class='hora w-100 mx-auto text-center ' type='time' step='60' value='" + partido.hora + "' " + $disabled + "></td></td>" + $accion + "</tr>")
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
                    $("#contenedor").append("<div class='jornada col-6 mt-2 table-responsive '><table class='table table-hover m-0 h-100'><thead><tr class='text-center'><th colspan='6'>JORNADA " + jornada + "</th></tr><tr class='text-center'><th class='td-local'>Local</th><th class='td-resultado'>Resultado</th><th class='td-visitante'>Visitante</th><th class='td-fecha'>Fecha</th><th class='td-hora'>Hora</th></th>" + $thaccion + "</tr></thead><tbody  id='jornada" + jornada + "'><tr class='text-center'><td>" + partido.equipo_local + "</td><td class='resultado'>" + resultado_completo + "</td><td>" + partido.equipo_visitante + "</td><td><input type='text' id='" + partido.id + "' class='datepick w-100  mx-auto' value='" + fecha + "' " + $disabled + "></td><td><input id='" + partido.id + "' class='hora w-100 mx-auto text-center ' type='time' step='60' value='" + partido.hora + "'" + $disabled + "></td></td>" + $accion + "</tr></tbody></table></div>");
                    jornada++;
                } else {
                    $("tbody").last().append("<tr class='text-center'><td>" + partido.equipo_local + "</td><td class='resultado'>" + resultado_completo + "</td><td>" + partido.equipo_visitante + "</td><td><p contenteditable='true'><input type='text' class='datepick w-100  mx-auto' id='" + partido.id + "' value='" + fecha + "' " + $disabled + "></p></td><td><input id='" + partido.id + "' class='hora w-100 mx-auto ' type='time' step='1' value='" + partido.hora + "'" + $disabled + "></td></td>" + $accion + "</tr>")
                }
                npartido++;
                break;
        }

        $(".fa-edit").on("click", function() {
            id = $(this).data('id');
            //Al hacer click te redirige al partido.
            window.location.href = "<?php echo base_url('Admin_c/partido/' . $liga) ?>" + "/" + id + "";
        });

        //Añadimos el tooltip al .fa-edit
        tippy('.fa-edit');

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