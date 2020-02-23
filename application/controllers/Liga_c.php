<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Liga_c extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        //Si no hay una sesión activa redirigimos al Login
        if ($this->session->userdata['username'] == FALSE) {
            redirect('Login_c');
        }
    }

    public function index($liga)
    {
        $datos["liga"] = $liga;
        $this->load->view("modulos/head_liga");
        $this->load->view("liga_v", $datos);
    }
    public function cerrarsesion()
    {
        session_destroy();
        redirect(base_url());
    }
}
