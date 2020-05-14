<div class="modal fade" id="modalPerfil" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Perfil</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data" id="formUpdatePerfil" class="border">
                    <label for="apenom">Apellidos y Nombre</label>
                    <input type="text" name="apenom" id="" value='<?= $_SESSION['apenom'] ?>'>
                    <label for="apenom">Email</label>
                    <input type="text" name="email" id="" value='<?= $_SESSION['email'] ?>'>
                    <label for="apenom">Fecha de Nacimiento</label>
                    <input type="date" id="modal_date" name="fecha_nac" id="" value='<?= $_SESSION['fecha_nac']; ?>'>
                    <label for="apenom">Foto de perfil</label>
                    <input type="file" name="fotoperfil" id="fotoperfil">
                    <label for="previsualizacion" class="d-block mx-auto">Previsualización de la foto de perfil</label>
                    <img src="" name="previsualizacion" id="previsualizacion" class="w-100 h-50 img-fluid rounded-circle d-block" alt="">
                    <label for="claveAntigua" class="d-none">Introduzca la clave actual</label>
                    <input type="text" name="claveAntigua" id="" class="d-none">
                    <label for="claveNueva" class="d-none">Introduzca la clave nueva</label>
                    <input type="text" name="claveNueva" id="" class="d-none">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button id='btn-guardarcambios' type="button" class="btn btn-primary">Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal del perfil -->
<script>
    $(document).ready(function() {
        $("#perfil").on("click", function(evento) {
            $("#modalPerfil").modal('show');
        })
        $("#fotoperfil").change(function() {
            console.log(this);
            previsualizarImagen(this);
        })

        $("#btn-guardarcambios").on("click", function(evento) {
            $.ajax({
                url: "<?php echo base_url('Perfiles_c/updateUsuario') ?>",
                type: "POST",
                //El Objeto formdata nos permite transmitir nuestros datos en una codificación multipart/form-data
                //Además que nos facilita bastante la subida de archivos a través de un <input type="file">
                data: new FormData(formUpdatePerfil),
                processData: false,
                contentType: false,
                success: function(response) {
                    /*si todo sale bien y se modifica la foto de perfil, se modificará tambien el $_SESSION['imagen']
                     **pero para que aparezca la foto habría que recargar la página así que vamos a modificar a mano la foto de perfil
                     **Y ya cuando se mueva por la página se le habrá actualizado el $_SESSION */
                    if (response != "") {
                        let url = "<?= base_url() ?>" + response;
                        console.log(response);
                        $('#foto-perfil').attr('src', url);
                    }
                    Swal.fire({
                        backdrop: false,
                        icon: 'success',
                        title: 'Perfil Actualizado',
                        text: 'Los datos del perfil se han actualizado correctamente',
                    })
                }
            });
            $("#modalPerfil").modal('hide');


        })

        function previsualizarImagen(input) {
            if (input.files[0]) {
                //Instanciamos el objeto FileReader que nos permite leer ficheros
                //almacenados en el cliente de forma asíncrona
                let reader = new FileReader();

                reader.onloadend = function(e) {
                    $('#previsualizacion').attr('src', e.target.result);
                }
                //Lee el contenido de la imagen que ha seleccionado el usuario y devuelve la 
                //información como una URL en base64
                reader.readAsDataURL(input.files[0]);
            }
        }

        let hoy = new Date();
        $("#modal_date").attr('min', hoy.getFullYear() - 100 + "-" + ("0" + (hoy.getMonth() + 1)).slice(-2) + "-" + hoy.getDate());
        $("#modal_date").attr('max', hoy.getFullYear() - 18 + "-" + ("0" + (hoy.getMonth() + 1)).slice(-2) + "-" + hoy.getDate());
    });
</script>
<footer class="row d-flex justify-content-center align-items-center">
    <h5>Derechos de autor: David Guisado González</h5>
</footer>
</div>




</html>