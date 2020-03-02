<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ajax_c extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Ajax_m");
    }

    public function obtenerJugadoresSinConfirmar($liga)
    {
        $jugadoresNull = $this->Ajax_m->getJugadoresSinConfirmar($liga);
        echo json_encode($jugadoresNull->result());
    }

    public function obtenerJugadoresConfirmados($liga)
    {
        $jugadores = $this->Ajax_m->getJugadoresConfirmados($liga);
        echo json_encode($jugadores->result());
    }

    public function aceptarJugador($username)
    {
        $this->Ajax_m->aceptarJugador($username);
    }

    public function eliminarJugador($username)
    {
        $this->Ajax_m->denegarJugador($username);
    }

    public function obtenerEquipos($liga)
    {
        $equipos = $this->Ajax_m->getEquipos($liga);
        echo json_encode($equipos->result());
    }

    public function modificarEquipo()
    {
        $this->Ajax_m->updateEquipo($_POST['equipo'], $_POST['campo'], $_POST['contenido']);
    }
}
