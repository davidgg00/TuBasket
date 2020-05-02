<!-- Modal del perfil -->
<script>
    $(document).ready(function() {
        let hoy = new Date();
        $("#modal_date").attr('min', hoy.getFullYear() - 100 + "-" + ("0" + (hoy.getMonth() + 1)).slice(-2) + "-" + hoy.getDate())
        $("#modal_date").attr('max', hoy.getFullYear() - 18 + "-" + ("0" + (hoy.getMonth() + 1)).slice(-2) + "-" + hoy.getDate())
    });
</script>
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
                <form method="POST" enctype="multipart/form-data" id="formUpdatePerfil">
                    <label for="apenom">Foto de perfil</label>
                    <input type="file" name="fotoperfil" id="fotoperfil">
                    <label for="apenom">Apellidos y Nombre</label>
                    <input type="text" name="apenom" id="" value='<?= $_SESSION['apenom'] ?>'>
                    <label for="apenom">Email</label>
                    <input type="text" name="email" id="" value='<?= $_SESSION['email'] ?>'>
                    <label for="apenom">Fecha de Nacimiento</label>
                    <input type="date" id="modal_date" name="fecha_nac" id="" value='<?= $_SESSION['fecha_nac']; ?>'>
                    <label for="previsualizacion" class="d-block mx-auto">Previsualización de la foto de perfil</label>
                    <img src="" name="previsualizacion" id="previsualizacion" class="w-100 h-50 img-fluid rounded-circle" alt="">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button id='btn-guardarcambios' type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
<footer class="row d-flex justify-content-center align-items-center">
    <h5>Derechos de autor: David Guisado González</h5>
</footer>
</div>




</html>