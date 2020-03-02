<script>
    $.ajax({
        type: "get",
        url: "<?php echo base_url("Ajax_c/obtenerEquipos/$liga") ?>",
        liga: '<?= $liga ?>',
        success: function(dato_devuelto) {
            let datos = JSON.parse(dato_devuelto);
            for (let dato of datos) {
                $("tbody").after("<tr class='text-center'><td class='d-none'>" + dato.id + "</td><td class='equipo'><p contenteditable='true'>" + dato.equipo + "</p></td><td class='pabellon'><p contenteditable='true'>" + dato.pabellon + "</p></td><td class='ciudad'><p contenteditable='true'>" + dato.ciudad + "</p></td><td><img src='<?= base_url('assets/uploads/escudos/') ?>" + dato.escudo_ruta + "' class='img-fluid'></img></td><td><button>Eliminar</button></td></tr>")
            }

            //Si presionamos enter en el contenteditable te genera <br> así que
            //vamos a hacer que si presionamos enter no haga nada
            $('p[contenteditable]').keydown(function(e) {
                if (e.keyCode === 13) {
                    return false;
                }
            });

            $("p").on("blur", function(evento) {
                let contenido = $(this).html();
                let campo = $(this).parent().attr('class');
                let equipo = $(this).parent().parent().children().eq(0).html();
                console.log(contenido);
                console.log(campo);
                console.log(equipo);
                $.ajax({
                    type: "post",
                    url: "<?php echo base_url("Ajax_c/modificarEquipo") ?>",
                    data: {
                        contenido: $(this).html(),
                        campo: $(this).parent().attr('class'),
                        equipo: $(this).parent().parent().children().eq(0).html()
                    },
                    success: function(response) {
                        console.log(response);
                    }
                });
            })
        }
    });
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
            <tr>
                <td>hola</td>
                <td>hola</td>
                <td>hola</td>
                <td>hola</td>
                <td>hola</td>
            </tr>
        </tbody>
    </table>
</div>