$.ajax({
    type: "POST",
    url: baseurl + "Usuario_c/getJugadoresEquipo/",
    data: "data",
    dataType: "dataType",
    success: function (response) {
        let jugadores = JSON.parse(response);
        console.log(jugadores);
    }
});

function ofrecerFichaje() {
    console.log($("#nombreFichaje").html());
    $.ajax({
        type: "POST",
        url: "<?= base_url('Fichajes_c/OfrecerFichaje'); ?>",
        data: {
            //Enviamos el username del jugador que queremos fichar, el id de su equipo actual y el username del jugador que ofrece
            jugadorAFichar: $("#nombreFichaje").html(),
            entrenadorRecibe: $("#nombreFichaje").data("entrenador"),
            jugadorOfrecido: $("#jugadores").val()
        },
        success: function (response) {
            console.log(response);
            if (response == "Error") {
                Swal.fire({
                    backdrop: false,
                    icon: 'error',
                    title: 'Ooops....',
                    text: 'Ya has realizado este fichaje y está PENDIENTE. Cuando haya algún cambio se le notificará',
                })
                //Cerramos modal
                $('#modalFichaje').modal('toggle');
            } else {
                //Mostramos alerta correcta
                Swal.fire({
                    backdrop: false,
                    icon: 'success',
                    title: 'Petición de fichaje realizada con éxito',
                    text: 'Cuando el equipo contrario decida si aceptar o denegar la propuesta, se le notificará.',
                })
                //Cerramos modal
                $('#modalFichaje').modal('toggle');
            }
        }
    });

}

$(document).ready(function () {
    $("#ofrecerFichaje").on("click", function (evento) {
        if (entrenadorExiste != "") {
            $("#modalFichaje").modal("show");
        } else {
            Swal.fire({
                backdrop: false,
                icon: 'error',
                title: 'Ooops....',
                text: 'El entrenador del jugador que deseas fichar no está dado de alta en la plataforma.',
            })
        }
    });
});