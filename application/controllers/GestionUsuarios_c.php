<?php
defined('BASEPATH') or exit('No direct script access allowed');

class GestionUsuarios_c extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("GestionUsuarios_m");

        //Si el usuario no es un Administrador, redirigimos LOGIN
        if ($this->session->userdata['tipo_cuenta'] != 'Administrador') {
            //El redirect lo ponemos vacío porque el controlador por defecto es Login_c.
            redirect('');
        }
    }
    /**
     * gestJugadores
     * Función que te redirige a la vista de la Gestión de Jugadores
     * @param  $liga
     */
    public function gestUsuarios($liga)
    {
        $datos["liga"] = $liga;
        $datos['jugadoresSinConfirmar'] = $this->GestionUsuarios_m->getJugadoresSinConfirmar($liga);
        $datos['jugadoresConfirmados'] = $this->GestionUsuarios_m->getJugadoresConfirmados($liga);
        $this->load->view("modulos/head", array("css" => array("liga", "gestion_jugadores")));
        $this->load->view("modulos/header", $datos);
        $this->load->view('gest_jugadores_v');
        $this->load->view("modulos/footer");
    }

    /**
     * aceptarJugador
     * Función que comunica al modelo que jugador se va a aceptar en la liga.
     * @param  $username
     */
    public function aceptarJugador($username)
    {
        $this->GestionJugadores_m->aceptarJugador($username);
    }

    /**
     * eliminarJugador
     * Función que comunica al modelo que jugador se va a denegar en la liga.
     * @param  $username
     */
    public function eliminarJugador($username)
    {
        $this->GestionJugadores_m->denegarJugador($username);
    }
}
