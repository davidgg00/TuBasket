<script>
    let baseurl = "<?php echo base_url() ?>";
    let liga_actual = "<?php echo $liga ?>";
</script>
<script src="<?php echo base_url('assets/js/') ?>gestEquipos.js"></script>
<script>
    mostrarEquipo();
</script>
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
        </tbody>
    </table>
</div>
<script>
    //Si se va a enviar el formulario
    $("#formulario").on("submit", function(evento) {
        evento.preventDefault();
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
                url: "<?php echo base_url() ?>" + "GestionEquipos_c/enviarEquipo",
                type: "POST",
                //El Objeto formdata nos permite transmitir nuestros datos en una codificación multipart/form-data
                //Además que nos facilita bastante la subida de archivos a través de un <input type="file">
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log(response);
                    $("tr.datos").remove();
                    mostrarEquipo();
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
    });
</script>
<!-- Modal -->
<div class="modal fade" id="miModal" tabindex="-1" role="dialog" aria-labelledby="miModal" aria-hidden="true">
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
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" form="formulario_imagen" onclick="enviarEscudo()" data-dismiss="modal" class="btn btn-primary">Insertar Escudo</button>
            </div>
            <script>
                function enviarEscudo() {
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url("GestionEquipos_c/cambiarImgEquipo") ?>",
                        data: new FormData(document.getElementById("formulario_imagen")),
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            console.log(response);
                            $("tr.datos").remove();
                            mostrarEquipo();
                        }
                    });
                }
            </script>
        </div>
    </div>
</div>