<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notificaciones_c extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        //cargamos modelos
        $this->load->model("Notificaciones_m");

        //Si el usuario no es un Entrenador, redirigimos LOGIN
        if ($this->session->userdata['tipo_cuenta'] != 'Entrenador') {
            //El redirect lo ponemos vacío porque el controlador por defecto es Login_c.
            redirect('');
        }
    }

    /**
     * leerTodasNotificaciones
     * Función que manda al modelo que el entrenador ha leido todas sus notificaciones.
     */
    public function leerTodasNotificaciones()
    {
        $this->Notificaciones_m->leerNotificaciones($_POST['idfichaje'], $_SESSION['username']);
    }

    /**
     * getnumeroNotificaciones
     * Función que pide al modelo el numero de notificaciones que tiene el entrenador y te lo devuelve.
     */
    public function getnumeroNotificaciones()
    {
        $datos = $this->Notificaciones_m->numeroNotificaciones($_SESSION["username"]);
        echo json_encode($datos);
    }
}
