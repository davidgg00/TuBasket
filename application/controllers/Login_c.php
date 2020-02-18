<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login_c extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $datos["contenido"] = "login_v";
        $this->load->view("plantilla/plantilla", $datos);
    }

    public function iniciarsesion()
    {

        $this->load->model("Login_m");
        if ($this->Login_m->comprobar_usuario_clave($this->input->post()['username'], $this->input->post()['password'])) {
            echo "LOGIN CORRECTAMENTE";
        } else {
            echo "Error de inicio sesion";
        }
    }
}
