<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Inicio_c extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        //Si no hay una sesión activa redirigimos al Login
        if ($this->session->userdata['username'] == FALSE) {
            redirect('Login_c');
        }
    }

    public function index($liga = "")
    {
        if ($_SESSION['tipo_cuenta'] == "Admin") {
            $this->load->view("modulos/head");
            $this->load->view("admin_v", self::obtenerLigas());
        } else if ($_SESSION['tipo_cuenta'] == "Jugador") {
            $this->load->view("modulos/head");
            $this->load->view("jugador_v", $liga);
        }
    }

    public function obtenerLigas()
    {   //cargamos el modelo
        $this->load->model("Inicio_m");
        $data['ligas'] = $this->Inicio_m->mostrar_ligas($_SESSION['username']);
        return $data;
    }

    public function liga($liga)
    {
        $datos["liga"] = $liga;
        $this->load->view("modulos/head");
        $this->load->view("liga_v", $datos);
    }
}
