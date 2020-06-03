<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Fichajes_c extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        //cargamos modelos
        $this->load->model("Fichajes_m");

        //Si el usuario no es un Administrador, redirigimos LOGIN
        if ($this->session->userdata['tipo_cuenta'] != 'Entrenador') {
            //El redirect lo ponemos vacío porque el controlador por defecto es Login_c.
            redirect('');
        }
    }


    /**
     * OfrecerFichaje
     * Función que manda al modelo la solicitud del fichaje
     */
    public function OfrecerFichaje()
    {
        $mensaje = $this->Fichajes_m->OfrecerFichaje($_SESSION['username'], $_POST['jugadorAFichar'], $_POST['entrenadorRecibe'], $_POST['jugadorOfrecido']);
        echo $mensaje;
    }

    /**
     * aceptarFichaje
     * Función que acepta la solicitud del fichaje
     */
    public function aceptarFichaje()
    {
        $this->Fichajes_m->aceptarFichaje($_POST['idfichaje']);
    }

    /**
     * rechazarFichaje
     * Función que deniega la solicitud del fichaje
     */
    public function rechazarFichaje()
    {
        $this->Fichajes_m->rechazarFichaje($_POST['idfichaje']);
    }
}
