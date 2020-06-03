<?php
defined('BASEPATH') or exit('No direct script access allowed');

class GestionEquipos_c extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("GestionEquipos_m");

        //Si el usuario no es un Administrador, redirigimos LOGIN
        if ($this->session->userdata['tipo_cuenta'] != 'Administrador') {
            //El redirect lo ponemos vacío porque el controlador por defecto es Login_c.
            redirect('');
        }
    }

    /**
     * index
     * Funcion que nos devuelve la vista de la gestión de equipos
     * @param  $liga
     */
    public function index($liga)
    {
        $datos["equipos"] = $this->GestionEquipos_m->getEquipos($liga)->result();
        $datos["liga"] = $liga;
        $datos["nPartidosLiga"] = $this->GestionEquipos_m->getNPartidosLiga($liga);
        $this->load->view("modulos/head", array("css" => array("liga", "gestion_equipos")));
        $this->load->view("modulos/header", $datos);
        $this->load->view('gest_equipos_v');
        $this->load->view("modulos/footer");
    }

    /**
     * modificarEquipo
     * Función que actualiza los datos de un equipo que haya mandado la vista.
     */
    public function modificarEquipo()
    {
        $this->GestionEquipos_m->updateEquipo($_POST['equipo'], $_POST['campo'], $_POST['contenido']);
    }

    /**
     * eliminarEquipo
     * Función que borra los datos de un equipo que haya mandado la vista.
     */
    public function eliminarEquipo()
    {
        $this->GestionEquipos_m->eliminarEquipo($_POST['id']);
        //Eliminamos la imagen del equipo
        unlink($_POST['rutaImagen']);
    }

    /**
     * obtenerNumEquipos
     * Función que obtiene el NÚMERO de equipos que hay en una liga
     * @param  $liga
     */
    public function obtenerNumEquipos($liga)
    {
        $equipos = $this->GestionEquipos_m->getEquipos($liga);
        echo $equipos->num_rows();
    }

    /**
     * obtenerEquipos
     * Función que obtiene los equipos de una liga
     * @param  $liga
     */
    public function obtenerEquipos($liga)
    {
        $equipos = $this->GestionEquipos_m->getEquipos($liga);
        echo json_encode($equipos->result());
    }

    /**
     * enviarEquipo
     * Función envia al módelo un equipo que se va a añadir en la base de datos
     */
    public function enviarEquipo()
    {
        if (!empty($_FILES['escudo']['name'])) {
            $img = $_FILES['escudo']['name'];
            $tmp = $_FILES['escudo']['tmp_name'];
            $path = "assets/uploads/escudos/" . $_POST['equipo'] . $img;
            move_uploaded_file($tmp, $path);
            $this->GestionEquipos_m->insertarEquipo($_POST['equipo'], $_POST['pabellon'], $_POST['ciudad'], $path, $_POST['liga']);
        }
        echo json_encode($this->GestionEquipos_m->getUltimoEquipoInsertado());
    }

    /**
     * cambiarImgEquipo
     * Función que cambia la imagen de un equipo.
     */
    public function cambiarImgEquipo()
    {
        if ($_FILES['escudo_nuevo']['name']) {
            //Borramos la imagen anterior de la carpeta de subidas
            unlink($_POST['idImagen']);
            $img = $_FILES['escudo_nuevo']['name'];
            $tmp = $_FILES['escudo_nuevo']['tmp_name'];
            $extension = pathinfo($img, PATHINFO_EXTENSION);
            $path = "assets/uploads/escudos/" . "escudoequipo" . $_POST['idEquipo'] . "." . $extension;
            move_uploaded_file($tmp, $path);
            $this->GestionEquipos_m->updateImgEquipo($path, $_POST['idImagen']);

            //Devolvemos por AJAX el escudo antiguo y nuevo para cambiarlo en el DOM
            $escudos = ["escudoAntiguo" => $_POST['idImagen'], "escudoNuevo" => $path];
            echo json_encode($escudos, JSON_UNESCAPED_SLASHES);
        }
    }
}
