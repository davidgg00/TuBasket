<div class="container-fluid">
    <header class="row d-flex justify-content-around align-items-center">
        <img id="logo" src="<?php echo base_url('assets/img/logo2.png') ?>" class="img-fluid">
        <?php
        //Los enlaces varían según el tipo de cuenta
        switch ($_SESSION['tipo_cuenta']):
            case 'Jugador': ?>
                <a href="<?php echo base_url('Usuario_c/index/') ?>">Inicio</a>
                <a href="<?php echo base_url('Usuario_c/clasificacion/' . $liga) ?>">Clasificación</a>
                <a href="<?php echo base_url('Usuario_c/estadisticas/') ?>">Tus estadísticas</a>
                <a href="<?php echo base_url('Usuario_c/partidos/' . $liga) ?>">Partidos</a>
                <a href="#"><img src="<?php echo base_url($_SESSION['imagen']) ?>" class="img-fluid rounded-circle" id='perfil'></a>
                <a href="<?php echo base_url('Usuario_c/cerrarsesion') ?>"><img src="<?php echo base_url('assets/img/cerrarsesion2.png') ?>" class="img-fluid rounded-circle"></a>
                <?php break; ?>
            <?php
            case 'Entrenador': ?>
                <a href="<?php echo base_url('Usuario_c/') ?>">Inicio</a>
                <a href="<?php echo base_url('Usuario_c/listaJugadores/') ?>">Jugadores de la Liga</a>
                <a href="<?php echo base_url('Usuario_c/tusJugadores/') ?>">Tus Jugadores</a>
                <a href="<?php echo base_url('Usuario_c/partidos/') ?>">Partidos</a>
                <a href="<?php echo base_url('Usuario_c/clasificacion/') ?>">Clasificación</a>
                <a href="#"><img src="<?php echo base_url($_SESSION['imagen']) ?>" class="img-fluid rounded-circle" id='perfil'></a>
                <a href="<?php echo base_url('Usuario_c/cerrarsesion') ?>"><img src="<?php echo base_url('assets/img/cerrarsesion2.png') ?>" class="img-fluid rounded-circle"></a>
                <?php break; ?>
            <?php
            case 'Admin': ?>
                <a href="<?php echo base_url('Admin_c/index/' . $liga) ?>">Inicio</a>
                <a href="<?php echo base_url('Admin_c/gestEquipo/' . $liga) ?>">Gestionar Equipos</a>
                <a href="<?php echo base_url('Admin_c/gestJugadores/' . $liga) ?>">Gestionar Jugadores</a>
                <a href="<?php echo base_url('Admin_c/partidos/' . $liga) ?>">Partidos</a>
                <a href="#"><img src="<?php echo base_url('assets/img/perfil.png') ?>" class="img-fluid rounded-circle" id='perfil'></a>
                <a href="<?php echo base_url('Admin_c/cerrarsesion') ?>"><img src="<?php echo base_url('assets/img/cerrarsesion2.png') ?>" class="img-fluid rounded-circle"></a>
                <?php break; ?>
        <?php endswitch; ?>
    </header>
    <script>
        $(document).ready(function() {
            $("#perfil").on("click", function(evento) {
                $("#modalPerfil").modal('show');
            })
            $("#fotoperfil").change(function() {
                previsualizarImagen(this);
            })

            $("#btn-guardarcambios").on("click", function(evento) {
                $.ajax({
                    url: "<?php echo base_url() ?>" + "Usuario_c/updateUsuario",
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
                        $('#perfil').attr('src', response)
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
        });
    </script>