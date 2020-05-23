<?php
defined('BASEPATH') or exit('No direct script access allowed');

class GestionJugadores_c extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("GestionJugadores_m");

        //Si el usuario no es un Administrador, redirigimos LOGIN
        if ($this->session->userdata['tipo_cuenta'] != 'Administrador') {
            //El redirect lo ponemos vacío porque el controlador por defecto es Login_c.
            redirect('');
        }
    }

    public function obtenerJugadoresSinConfirmar($liga)
    {
        $jugadores = $this->GestionJugadores_m->getJugadoresSinConfirmar($liga);
        return $jugadores;
    }

    public function gestJugadores($liga)
    {
        $datos["liga"] = $liga;
        $datos['jugadoresSinConfirmar'] = self::obtenerJugadoresSinConfirmar($liga);
        $datos['jugadoresConfirmados'] = self::obtenerJugadoresConfirmados($liga);
        $this->load->view("modulos/head", array("css" => array("liga", "gestion_jugadores")));
        $this->load->view("modulos/header", $datos);
        $this->load->view('gest_jugadores_v');
        $this->load->view("modulos/footer");
    }
    public function aceptarJugador($username)
    {
        $this->GestionJugadores_m->aceptarJugador($username);
    }

    public function eliminarJugador($username)
    {
        $this->GestionJugadores_m->denegarJugador($username);
    }

    public function obtenerJugadoresConfirmados($liga)
    {
        $jugadores = $this->GestionJugadores_m->getJugadoresConfirmados($liga);
        return $jugadores;
    }
}
