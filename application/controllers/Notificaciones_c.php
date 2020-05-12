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
        //Dependiendo de si el entrenador que lo lee es el solicitante o el recibidor, se marcará como leído un campo u otro.
        if ($_POST['equipo'] == $_POST['equipo_solicitante']) {
            $this->Notificaciones_m->leerNotificacionSolicitante($_POST['idfichaje']);
            echo "xd";
        } else {
            $this->Notificaciones_m->leerNotificacionRecibidor($_POST['idfichaje']);
            echo "no";
        }
    }
}
