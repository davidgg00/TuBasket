<?php
defined('BASEPATH') or exit('No direct script access allowed');

class GestionEquipos_c extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("GestionEquipos_m");
    }

    public function modificarEquipo()
    {
        $this->GestionEquipos_m->updateEquipo($_POST['equipo'], $_POST['campo'], $_POST['contenido']);
    }

    public function eliminarEquipo()
    {
        $this->GestionEquipos_m->eliminarEquipo($_POST['id']);
    }

    public function obtenerNumEquipos($liga)
    {
        $equipos = $this->GestionEquipos_m->getEquipos($liga);
        echo $equipos->num_rows();
    }

    public function obtenerEquipos($liga)
    {
        $equipos = $this->GestionEquipos_m->getEquipos($liga);
        echo json_encode($equipos->result());
    }

    public function enviarEquipo()
    {
        if ($_FILES['escudo']['name']) {
            $img = $_FILES['escudo']['name'];
            $tmp = $_FILES['escudo']['tmp_name'];
            $nombre_imagen =  $_POST['equipo'] . $img;
            $path = "assets/uploads/escudos/" . rand(1, 1000) . $nombre_imagen;
            move_uploaded_file($tmp, $path);
            $this->GestionEquipos_m->insertarEquipo($_POST['equipo'], $_POST['pabellon'], $_POST['ciudad'], $path, $_POST['liga']);
        }
    }

    public function cambiarImgEquipo()
    {
        if ($_FILES['escudo_nuevo']['name']) {
            $img = $_FILES['escudo_nuevo']['name'];
            $tmp = $_FILES['escudo_nuevo']['tmp_name'];
            $nombre_imagen = $img;
            $path = "assets/uploads/escudos/" . rand(1, 1000) . $nombre_imagen;
            move_uploaded_file($tmp, $path);
            $this->GestionEquipos_m->updateImgEquipo($path, $_POST['idImagen']);
            echo "hola";
        }
    }
}
