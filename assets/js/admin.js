function obtenerLigas() {
    console.log(base_url);
    //Este ajax nos trae de vuelta un listado con las ligas y si ha terminado la liga el ganador.
    $.ajax({
        type: "get",
        url: base_url + "Admin_c/obtenerLigas",
        success: function (dato_devuelto) {
            let datos = JSON.parse(dato_devuelto);
            let mihtml = "";
            for (dato of datos) {
                mihtml += "<div class='card'><div class='card-header'>";
                mihtml += "<a href='" + base_url + "Admin_c/index/" + dato.nombre + "'>" + dato.nombre + "</a>";
                mihtml += "</div><div class='card-body'>Ganador:";
                mihtml += dato.ganador;
                mihtml += "</div></div>";
            }
            Swal.fire({
                backdrop: false,
                title: '<strong>Elige la liga</strong>',
                icon: '',
                html: mihtml,
                showCloseButton: true,
                showConfirmButton: false,
                focusConfirm: false,
            })
        }
    });
}