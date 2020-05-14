<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notificaciones_c extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        //cargamos modelos
        $this->load->model("Notificaciones_m");
    }

    public function leerTodasNotificaciones()
    {
        $this->Notificaciones_m->leerNotificaciones($_POST['idfichaje'], $_SESSION['username']);
    }

    public function getnumeroNotificaciones()
    {
        $datos = $this->Notificaciones_m->numeroNotificaciones($_SESSION["username"]);
        echo json_encode($datos);
    }
}
