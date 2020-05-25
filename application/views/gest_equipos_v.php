<script>
    let baseurl = "<?php echo base_url() ?>";
    let liga_actual = "<?php echo $liga ?>";
    let npartidos = "<?= $nPartidosLiga ?>"
</script>
<script src="<?php echo base_url('assets/js/') ?>gestEquipos.js"></script>
<div class="row" id="contenedor">
    <table class="table table-hover">
        <thead>
            <tr class="text-center">
                <th scope="col">Equipo</th>
                <th scope="col">Pabellón</th>
                <th scope="col">Ciudad</th>
                <th scope="col">Escudo</th>
                <th scope="col">Acción</th>
            </tr>
        </thead>
        <tbody>
            <tr class="text-center" id="tr_form">
                <form method="post" id="formulario" enctype="multipart/form-data">
                    <td><input type="text" name="equipo" id="equipo" class="form-control datos"></td>
                    <td><input type="text" name="pabellon" id="pabellon" class="form-control datos"></td>
                    <td><input type="text" name="ciudad" id="ciudad" class="form-control datos"></td>
                    <td><input type="file" name="escudo" id="escudo" class="datos" required></td>
                    <input type="hidden" name="liga" value="<?php echo $liga ?>">
                    <td><button id="añadir">
                            <i class="fas fa-plus añadir"></i>
                        </button>
                    </td>
                </form>
            </tr>
            <?php foreach ($equipos as $equipo) : ?>
                <tr class='text-center datos'>
                    <td class='d-none idequipo'><?= $equipo->id ?></td>
                    <td class='equipo'>
                        <p data-tippy-content='Haga click para editar el campo' class='dato_td' contenteditable='true'><?= $equipo->equipo ?> </p>
                    </td>
                    <td class='pabellon'>
                        <p data-tippy-content='Haga click para editar el campo' class='dato_td' contenteditable='true'> <?= $equipo->pabellon ?> </p>
                    </td>
                    <td class='ciudad'>
                        <p data-tippy-content='Haga click para editar el campo' class='dato_td' contenteditable='true'> <?= $equipo->ciudad ?> </p>
                    </td>
                    <td class="td-escudo"><img data-toggle='modal' data-target='#modalCambiarEscudo' src='<?= base_url($equipo->escudo_ruta) ?> ' data-id='<?= $equipo->escudo_ruta ?>' data-tippy-content='Haga click para cambiar el escudo' class='dato_td escudo'>
                    </td>
                    <td><i data-tippy-content='Borrar Equipo' class='fas fa-trash-alt eliminar'></i></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script>
    //Si se va a enviar el formulario con el equipo a añadir
    $("#formulario").on("submit", function(evento) {
        evento.preventDefault();
        //Si todavía no se ha generado los enfrentamientos
        if (npartidos == 0) {
            $.ajax({
                type: "post",
                url: baseurl + "GestionEquipos_c/obtenerNumEquipos/" + liga_actual,
                success: function(dato_devuelto) {
                    //Si llegamos al tope de equipo añadimos la clase que nos hará
                    //que no podamos añadir mas equipos
                    if (dato_devuelto >= 9) {
                        $("#formulario").addClass("max-equipos");
                    } else {
                        $("#formulario").removeClass("max-equipos");
                    }
                },
            });


            //Si hay algun input vacío añadimos clase error
            $("input.form-control").each(function(evento) {
                if ($(this).val() == "") {
                    $(this).addClass("is-invalid");
                } else {
                    $(this).removeClass("is-invalid");
                }
            });

            //Si no hay ninguna clase error en los inputs enviamos el formulario por ajax
            if (!$("#equipo").hasClass("is-invalid") && !$("#pabellon").hasClass("is-invalid") && !$("#ciudad").hasClass("is-invalid") && $("#formulario").hasClass("max-equipos") == false) {
                $.ajax({
                    url: "<?php echo base_url() ?>" + "GestionEquipos_c/enviarEquipo ",
                    type: "POST",
                    //El Objeto formdata nos permite transmitir nuestros datos en una codificación multipart/form-data
                    //Además que nos facilita bastante la subida de archivos a través de un <input type="file">
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        let equipo = JSON.parse(response);
                        $("tbody").append("<tr class='text-center datos'><td id='id' class='d-none'>" + equipo.id + "</td><td class='equipo'><p data-tippy-content='Haga click para editar el campo' class='dato_td' contenteditable='true' >" + equipo.equipo + "</p></td><td class='pabellon'><p data-tippy-content='Haga click para editar el campo' class='dato_td' contenteditable='true'>" + equipo.pabellon + "</p></td><td class='ciudad'><p data-tippy-content='Haga click para editar el campo' class='dato_td' contenteditable='true'>" + equipo.ciudad + "</p></td><td class='td-escudo'><img  data-toggle='modal' data-target='#modalCambiarEscudo' src='" + baseurl + equipo.escudo_ruta + "' data-id='" + equipo.escudo_ruta + "' data-tippy-content='Haga click para cambiar el escudo' class='dato_td escudo'></td><td><i data-tippy-content='Borrar Equipo' class='fas fa-trash-alt eliminar'></i></td></tr>")

                        //Añadimos las acciones al nuevo equipo añadido

                        ajaxContentEditable();
                        ajaxEliminarEquipo();

                        //Si clickamos en un escudo que aparezca el modal creado con el formulario y añadimos la url de la imagen antigua
                        $(".escudo").on("click", function() {
                            $(".modal-body #idImagen").val($(this).data('id'));
                        });

                        //Añadimos tooltip a los .dato_td y i.eliminar
                        tippy('.dato_td');
                        tippy('i.eliminar', {
                            followCursor: 'horizontal',
                        });

                        //Si presionamos enter en el contenteditable te genera <br> así que
                        //voy a hacer que si lo presionas pierda el foco.
                        $('p[contenteditable]').keydown(function(e) {
                            if (e.keyCode === 13) {
                                $(this).blur();
                            }
                        });

                        $.notify({
                            title: '<strong class="">¡Equipo añadido correctamente!</strong><br>',
                            message: 'El equipo se ha guardado correctamente en nuestra base de datos.'
                        }, {
                            type: 'success'
                        });
                    }
                });

                //Una vez enviamos vaciamos los inputs
                $("input.datos").each(function(evento) {
                    $(this).val("");
                })
            } else {
                //Si hay error se muestra
                Swal.fire({
                    backdrop: false,
                    icon: 'error',
                    title: 'Ooops....',
                    text: 'Solo puedes añadir como máximo 10 equipos',
                })
            }
        } else {
            Swal.fire({
                icon: 'error',
                title: '¡La liga ya ha empezado!',
                text: 'No puedes añadir equipos, los enfrentamientos ya fueron generados.',
                backdrop: false,
            })
        }
    });
</script>
<!-- Modal -->
<div class="modal fade" id="modalCambiarEscudo" tabindex="-1" role="dialog" aria-labelledby="modalCambiarEscudo" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titulo_modal">Cambiar Escudo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Para enviar archivos debe especificarse el valor del atributo enctype =  "multipart/form-data" -->
                <form method="post" id="formulario_imagen" enctype="multipart/form-data">
                    <label for="exampleFormControlFile1">Selecciona la imagen</label>
                    <input type="file" class="form-control-file" id="fileEscudo" name="escudo_nuevo" required>
                    <input type="hidden" name="idImagen" id="idImagen">
                    <input type="hidden" name="idEquipo" id="idEquipo">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" form="formulario_imagen" onclick="enviarEscudo()" data-dismiss="modal" class="btn btn-primary">Insertar Escudo</button>
            </div>
            <script>
                function enviarEscudo() {
                    console.log($(this));
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url("GestionEquipos_c/cambiarImgEquipo") ?>",
                        data: new FormData(document.getElementById("formulario_imagen")),
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            d = new Date();
                            let escudos = JSON.parse(response);
                            //Cambiamos el src en el DOM y el data-id
                            $("img[src*='" + escudos.escudoAntiguo + "']").removeAttr('data-id');
                            $("img[src*='" + escudos.escudoAntiguo + "']").data('id', escudos.escudoNuevo);
                            //Agrego una marca de tiempo a la URL para refrescar la imagen ya que va a tener el mismo nombre y alomejor la misma extensión
                            //Entonces, al cambiar la URL el navegador no pilla la imagen por caché
                            $("img[src*='" + escudos.escudoAntiguo + "']").attr('src', '<?= base_url() ?>' + escudos.escudoNuevo + "?" + d.getTime());

                            //Notificamos que se cambió el escudo correctamente
                            $.notify({
                                title: '<strong class="">¡Escudo cambiado correctamente!</strong><br>',
                                message: 'El escudo del equipo se ha guardado correctamente en nuestra base de datos.'
                            }, {
                                type: 'success'
                            });
                        }
                    });
                }
            </script>
        </div>
    </div>
</div>