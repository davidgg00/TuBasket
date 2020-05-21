<div class="row border mx-auto flex-wrap paginacionWrapper" id="contenedor">
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

            // Si el numero de equipos no es el correcto, el boton de generar ligas está disabled
            if (<?= $nequipos ?> == 8 || <?= $nequipos ?> == 10) {
                $("#btn-generarLiga").on("click", function(evento) {
                    window.location.href = "<?= base_url('Partidos_c/generarLiga/' . $liga) ?>";
                });
            } else {
                $("#btn-generarLiga").prop('disabled', true);
            }

        });

        let partidos = <?php echo json_encode($partidos); ?>;
        //Creo unas variables para controlar el numero de la jornada y que cree una tabla nueva cada x partidos
        let jornada = 1;
        let npartido = 0;
        //Si la cuenta es de tipo jugador esta variable almacenará "disabled" y se le introducirá a los inputs de fecha y hora para 
        //que los jugadores y entrenadores no puedan cambiar los datos del encuentro
        $disabled = ('<?php echo $_SESSION['tipo_cuenta'] ?>' == "Jugador" || '<?php echo $_SESSION['tipo_cuenta'] ?>' == "Entrenador") ? "disabled" : "";

        //Dependiendo de si hay 8 o 10 equipos habrá 4 o 5 partidos por jornada.
        switch (<?= ($nequipos) ?>) {
            case 8:
                for (let partido of partidos) {
                    //Si la cuenta es de tipo jugador la fila de modificar o resetear partido no debe de aparecer.
                    $thaccion = ('<?php echo $_SESSION['tipo_cuenta'] ?>' == "Administrador") ? "<th>Acción</th>" : "";
                    $accion = ('<?php echo $_SESSION['tipo_cuenta'] ?>' == "Administrador") ? "<td><i class='fas fa-edit' data-id='" + partido.id + "' data-tippy-content='Haga click para escribir resultado'></i><i class='fas fa-sync btn-reset' data-id='" + partido.id + "'></i></td>" : "";

                    //Volteamos fecha debido al formato que tiene PHPMYADMIN
                    let fechaArray = partido.fecha.split('-');
                    let fecha = fechaArray[2] + '-' + fechaArray[1] + '-' + fechaArray[0];
                    //Creamos una variable que almacene el resultado directamente
                    resultado_completo = partido.resultado_local + " - " + partido.resultado_visitante

                    //Si el partido es divisible entre 4 crear un nuevo div porque es nueva jornada
                    if (npartido % 4 == 0 || npartido == 0) {
                        $("#contenedor").append("<div class='itemPaginacion jornada mt-2 table-responsive p-0'><table class='table table-hover'><thead><tr><th colspan='6'>JORNADA " + jornada + "</th></tr><tr><th>Local</th><th>Resultado</th><th>Visitante</th><th id='fecha'>Fecha</th><th>Hora</th>" + $thaccion + "</tr></thead><tbody  id='jornada" + jornada + "'><tr><td>" + partido.equipo_local + "</td><td>" + resultado_completo + "</td><td>" + partido.equipo_visitante + "</td><td><input type='text' id='" + partido.id + "' class='datepick w-100 mx-auto' value='" + fecha + "' " + $disabled + "></td><td><input id='" + partido.id + "' class='hora w-100 mx-auto text-center ' type='time' step='60' value='" + partido.hora + "'" + $disabled + "></td></td>" + $accion + "</tr></tbody></table></div>")
                        jornada++;
                    } else {
                        $("tbody").last().append("<tr><td>" + partido.equipo_local + "</td><td>" + resultado_completo + "</td><td>" + partido.equipo_visitante + "</td><td><input type='text' id='" + partido.id + "' class='datepick w-100 mx-auto' value='" + fecha + "' " + $disabled + "></td><td><input id='" + partido.id + "' class='hora w-100 mx-auto text-center ' type='time' step='60' value='" + partido.hora + "' " + $disabled + "></td></td>" + $accion + "</tr>")
                    }
                    npartido++;
                }
                break;

            case 10:
                for (let partido of partidos) {
                    //Si la cuenta es de tipo jugador la fila de modificar o resetear partido no debe de aparecer.
                    $thaccion = ('<?php echo $_SESSION['tipo_cuenta'] ?>' == "Administrador") ? "<th>Acción</th>" : "";
                    $accion = ('<?php echo $_SESSION['tipo_cuenta'] ?>' == "Administrador") ? "<td><i class='fas fa-edit' data-id='" + partido.id + "' data-tippy-content='Haga click para escribir resultado'></i><i class='fas fa-sync btn-reset' data-id='" + partido.id + "'></i></td>" : "";

                    //Volteamos fecha debido al formato que tiene PHPMYADMIN
                    let fechaArray = partido.fecha.split('-');
                    let fecha = fechaArray[2] + '-' + fechaArray[1] + '-' + fechaArray[0];
                    //Creamos una variable que almacene el resultado directamente
                    resultado_completo = partido.resultado_local + " - " + partido.resultado_visitante

                    //Si el partido es divisible entre 4 crear un nuevo div porque es nueva jornada
                    if (npartido % 5 == 0 || npartido == 0) {
                        $("#contenedor").append("<div class='itemPaginacion jornada mt-2 table-responsive p-0'><table class='table table-hover'><thead><tr><th colspan='6'>JORNADA " + jornada + "</th></tr><tr><th>Local</th><th>Resultado</th><th>Visitante</th><th id='fecha'>Fecha</th><th>Hora</th>" + $thaccion + "</tr></thead><tbody  id='jornada" + jornada + "'><tr><td>" + partido.equipo_local + "</td><td>" + resultado_completo + "</td><td>" + partido.equipo_visitante + "</td><td><input type='text' id='" + partido.id + "' class='datepick w-100 mx-auto' value='" + fecha + "' " + $disabled + "></td><td><input id='" + partido.id + "' class='hora w-100 mx-auto text-center ' type='time' step='60' value='" + partido.hora + "'" + $disabled + "></td></td>" + $accion + "</tr></tbody></table></div>")
                        jornada++;
                    } else {
                        $("tbody").last().append("<tr><td>" + partido.equipo_local + "</td><td>" + resultado_completo + "</td><td>" + partido.equipo_visitante + "</td><td><input type='text' id='" + partido.id + "' class='datepick w-100 mx-auto' value='" + fecha + "' " + $disabled + "></td><td><input id='" + partido.id + "' class='hora w-100 mx-auto text-center ' type='time' step='60' value='" + partido.hora + "' " + $disabled + "></td></td>" + $accion + "</tr>")
                    }
                    npartido++;
                }
                break;
        }

        //Añadimos acciones a los botones de acciones
        $(".fa-edit").on("click", function() {
            var id = $(this).data('id');
            //Antes de editar un partido, si el equipo no tiene el numero de jugadores minimo no podrá ser editado.
            $.get("<?= base_url('Partidos_c/getNJugadoresPartido/') ?>" + id,
                function(njugadores) {
                    let njugadoresEncuentro = JSON.parse(njugadores);
                    if (njugadoresEncuentro[0].totalEquipo >= 5 && njugadoresEncuentro[1].totalEquipo >= 5) {
                        //Redirigimos al partido.

                        window.location.href = "<?php echo base_url('Admin_c/partido/' . $liga) ?>" + "/" + id + "";
                    } else {
                        Swal.fire({
                            backdrop: false,
                            icon: 'error',
                            title: 'Ooops....',
                            text: 'Algún equipo (o ambos) no tiene como mínimo 5 jugadores en su plantilla.',
                        })
                    }
                },
            );


        });

        //Añadimos el tooltip al .fa-edit
        tippy('.fa-edit');

        //Añadimos el datepick y un ajax si cambia el admin la fecha
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

        //Si cambia la hora se envía un ajax
        $(".hora").on("change", function(evento) {
            $.post("<?= base_url('Partidos_c/cambiarHora') ?>", {
                    idPartido: $(this).attr('id'),
                    hora: $(this).val()
                },
                function(dato_devuelto) {
                    console.log(dato_devuelto);
                },
            );
        });
    </script>
    <!--Si la liga no se ha generado-->
    <?php if (count($partidos) == 0) : ?>
        <table class="table table-bordered">
            <div class="alert alert-warning d-block mx-auto mt-3" role="alert">
                Para generar una liga se necesita tener 8 o 10 equipos.
            </div>
            <h3 class="mx-auto w-100 text-center">Equipos Actuales</h3>
            <!--Si se ha añadido algún equipo los mostramos-->
            <?php if (count($equipos) > 0) : ?>
                <?php
                for ($i = 0; $i < count($equipos); $i++) : ?>
                    <tr>
                        <td><img src="<?= base_url($equipos[$i]->escudo_ruta) ?>" alt="" class=""></td>
                        <td>
                            <p><?= $equipos[$i]->equipo ?></p>
                        </td>
                        <?php if (isset($equipos[$i + 1])) : $i++ ?>
                            <td><img src="<?= base_url($equipos[$i]->escudo_ruta) ?>" alt="" class=""></td>
                            <td>
                                <p><?= $equipos[$i]->equipo ?></p>
                            </td>
                        <?php endif; ?>

                    </tr>
                <?php endfor; ?>
            <?php else : ?>
                <tr>
                    <td><img src="<?php echo base_url('assets/img/escudo-por-defecto.png') ?>" alt="" class=""></td>
                    <td>
                        <p>Añade equipos en el apartado "Gestionar Equipos"</p>
                    </td>
                    <td><img src="<?php echo base_url('assets/img/escudo-por-defecto.png') ?>" alt="" class=""></td>
                    <td>
                        <p>Añade equipos en el apartado "Gestionar Equipos"</p>
                    </td>
                </tr>
            <?php endif; ?>
        </table>
    <?php endif; ?>

    <?php
    //Si no hay ningún partido mostramos opción de generar partidos
    if (count($partidos) == 0) : ?>
        <button type="button" class="btn btn-secondary mx-auto" id="btn-generarLiga">Generar liga</button>
    <?php endif; ?>
    <?php //Si la liga se ha generado que aparezca la paginación, de lo contrario que no aparezca.
    if (count($partidos) != 0) : ?>
        <div id=" pagination-container" class="w-50 d-flex mx-auto align-self-end justify-content-center">
            <p class='paginacionCursor' id="beforePagination">
                < </p> <p class='paginacionCursor' id="afterPagination">>
            </p>
        </div>
    <?php endif; ?>
</div>