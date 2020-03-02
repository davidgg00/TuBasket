<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ajax_c extends CI_Controller
{
    public function obtenerJugadoresSinConfirmar($liga)
    {
        $this->load->model("Admin_m");
        $jugadoresNull = $this->Admin_m->getJugadoresSinConfirmar($liga);
        echo json_encode($jugadoresNull->result());
    }

    public function obtenerJugadoresConfirmados($liga)
    {
        $this->load->model("Admin_m");
        $jugadores = $this->Admin_m->getJugadoresConfirmados($liga);
        echo json_encode($jugadores->result());
    }

    public function aceptarJugador($username)
    {
        $this->load->model("Admin_m");
        $this->Admin_m->aceptarJugador($username);
    }

    public function eliminarJugador($username)
    {
        $this->load->model("Admin_m");
        $this->Admin_m->denegarJugador($username);
    }
}
