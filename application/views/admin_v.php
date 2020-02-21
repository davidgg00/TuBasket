<div class="container d-flex h-100">
    <div class="row align-items-center justify-content-center w-100">
        <div id="panel" class="row col-10 h-75 d-flex justify-content-center p-10 rounded">
            <div id="titulo" class="row col-12 d-flex justify-content-center align-items-center">
                <h2>¡Bienvenido <?= $_SESSION['username'] ?>!</h2>
            </div>
            <div id="opciones" class="row d-flex justify-content-around align-items-center">
                <div class="opcion col-3 text-center p-2 d-flex justify-content-center flex-wrap" id="crearligadiv">
                    <img src="<?php echo base_url('assets/img/balon.png') ?>" alt="Balon" class="img-fluid align-self-center" id="balon">
                    <p class="w-100 mt-1 font-weight-bold">Crear Liga</p>
                </div>
                <div class="opcion col-3 text-center p-2 d-flex justify-content-center flex-wrap" id="divgestionliga">
                    <img src="<?php echo base_url('assets/img/jugador.png') ?>" alt="Balon" class="img-fluid align-self-center" id="balon">
                    <p class="w-100 mt-1 font-weight-bold">Gestionar Liga</p>
                </div>
                <div class="opcion col-3 text-center p-2 d-flex justify-content-center">
                    <a href="login_c/cerrarsesion" class="">
                        <img src="<?php echo base_url('assets/img/cerrarsesion.png') ?>" alt="Balon" class="img-fluid align-self-center" id="balon">
                        <p class="w-100 mt-1 font-weight-bold">Cerrar Sesión</p>
                    </a>
                </div>
            </div>
            <div id="pie" class="row col-12 justify-content-center align-items-center">
                <img src="<?php echo base_url('assets/img/logo2.png') ?>" class="img-fluid mx-auto" alt="Logo TuBasket">
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        //PARA ABRIR EL FORMULARIO CON LIBRERIA VEX
        $("#crearligadiv").on("click", function(evento) {
            console.log($("#panel"));
            vex.dialog.open({
                message: 'Formulario CREAR LIGA:',
                input: [
                    'Nombre de la Liga:<input name="nombre" type="text" placeholder="Nombre de liga" id="nombreLiga" required />',
                    'Contraseña de la Liga:<input id="contrasenia" name="contrasenia" type="password" placeholder="Contraseña Liga" required />',
                    'Administrador de la liga:<input name="administrador" id="administrador" type="text" value="<?php echo $_SESSION['username'] ?>" disabled />'
                ].join(''),
                buttons: [
                    $.extend({}, vex.dialog.buttons.YES, {
                        text: 'Registrar'
                    }),
                    $.extend({}, vex.dialog.buttons.NO, {
                        text: 'Volver'
                    })
                ],
                callback: function(data) {
                    if (data) {
                        //Cogemos los valores del formulario
                        let liga = $("#nombreLiga").val();
                        let password = $("#contrasenia").val();
                        let administrador = $("#administrador").val();
                        //Creamos llamada a AJAX por GET
                        $.post("<?php echo base_url('Registro_c/crear_liga') ?>", {
                            //Pasamos por parametro los valores
                            "liga": liga,
                            "clave": password,
                            "administrador": administrador
                        }, function(dato_devuelto) {
                            console.log(dato_devuelto);
                            //Si la llamada devuelve Existe será que hay una liga ya con ese nombre
                            if (dato_devuelto == "Existe") {
                                //Simulamos un click a la sección cargar div para que intente de nuevo
                                $("#crearligadiv").click();
                                //Mostramos error
                                Swal.fire({
                                    backdrop: false,
                                    icon: 'error',
                                    title: 'Ooops....',
                                    text: 'Esa liga ya existe!',
                                    footer: 'Prueba'
                                })
                            } else if (dato_devuelto == "Creada") {
                                //Mostramos alerta correcta
                                Swal.fire({
                                    backdrop: false,
                                    icon: 'success',
                                    title: 'Ooops....',
                                    text: 'Esa liga ya existe!',
                                    footer: 'Prueba'
                                })
                            }
                        });
                    }
                }
            })
        });

        $("#divgestionliga").on("click", function(evento) {
            Swal.fire({
                backdrop: false,
                title: '<strong>Elige la liga</strong>',
                icon: '',
                html: '<?php foreach ($ligas as $liga) : ?>' +
                    '<div class="card"><div class="card-header">' +
                    '<?= $liga->nombre ?> ' +
                    '</div><div class="card-body">' +
                    '<?= $liga->password ?> ' +
                    '</div></div>' +
                    '<?php endforeach; ?>',
                showCloseButton: true,
                showConfirmButton: false,
                focusConfirm: false,
            })
        })
    });
</script>