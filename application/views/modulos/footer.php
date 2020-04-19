<!-- Modal del perfil -->
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
                    <input type="text" name="email" id="" value='<?= $datos_user->email ?>'>
                    <label for="apenom">Fecha de Nacimiento</label>
                    <input type="date" name="fecha_nac" id="" value='<?= $datos_user->fecha_nac ?>'>
                    <label for="previsualizacion" class="d-block mx-auto">Previsualización de la foto de perfil</label>
                    <img src="<?php echo base_url($_SESSION['imagen']) ?>" class="img-fluid rounded-circle w-25 d-block mx-auto" id="previsualizacion">
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