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
                    <a href="admin_c/cerrarsesion" class="">
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
    let base_url = '<?= base_url() ?>';
</script>
<script src="<?php echo base_url('assets/js/admin.js') ?>"></script>
<script>
    $(document).ready(function() {
        //PARA ABRIR EL FORMULARIO CON LIBRERIA VEX
        $("#crearligadiv").on("click", function(evento) {
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
                    console.log(data);
                    if (data) {
                        //Cogemos los valores del formulario
                        let liga = $("#nombreLiga").val();
                        let password = $("#contrasenia").val();
                        let administrador = $("#administrador").val();
                        //Creamos llamada a AJAX por POST
                        $.post("<?php echo base_url('Admin_c/crear_liga') ?>", {
                            //Pasamos por parametro los valores
                            "liga": liga,
                            "clave": password,
                            "administrador": administrador
                        }, function(dato_devuelto) {
                            console.log(dato_devuelto);
                            //Si la llamada devuelve Existe será que hay una liga ya con ese nombre
                            if (dato_devuelto == "Existe") {
                                //Mostramos error
                                Swal.fire({
                                    backdrop: false,
                                    icon: 'error',
                                    title: 'Ooops....',
                                    text: 'Esa liga ya existe, prueba a crear una con otro nombre',
                                    //Cuando se vaya a cerrar, se muestra de nuevo el formulario
                                    onClose: () => {
                                        $("#crearligadiv").click();
                                    }
                                })
                                //Simulamos un click a la sección cargar div para que intente de nuevo
                            } else if (dato_devuelto == "Creada") {
                                //Mostramos alerta correcta
                                Swal.fire({
                                    backdrop: false,
                                    icon: 'success',
                                    title: 'Liga creada con éxito....',
                                    text: 'Puede acceder a su liga en el apartado Gestionar Liga',
                                }).then(function() {
                                    window.location.href = "admin_c";
                                })
                            }
                        });
                    }
                }
            })
        });

        $("#divgestionliga").on("click", function(evento) {
            obtenerLigas();
        })
    });
</script>