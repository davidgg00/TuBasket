<?php
defined('BASEPATH') or exit('No direct script access allowed');

class GestionJugadores_c extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("GestionJugadores_m");
    }

    public function obtenerJugadoresSinConfirmar($liga)
    {
        $jugadoresNull = $this->GestionJugadores_m->getJugadoresSinConfirmar($liga);
        echo json_encode($jugadoresNull->result());
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
        echo json_encode($jugadores->result());
    }
}
