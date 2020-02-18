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
        //cargamos el modelo
        $this->load->model("Login_m");
        //Si devuelve algo comprobar_usuario_clave
        $login = $this->Login_m->comprobar_usuario_clave($this->input->post()['username'], $this->input->post()['password']);
        if ($login) {
            //Login correcto, creamos la variable de sesión
            $array = array(
                'username' => $this->input->post()['username']
            );
            $this->session->set_userdata($array);
            //print_R($_SESSION);
            echo $login->username;
            echo "<a href=" . base_url() . "Login_c/cerrarsesion>Hola</a>";
        } else {
            echo "Error de inicio sesion";
        }
    }
    public function cerrarsesion()
    {
        session_destroy();
        print_R($_SESSION);
        //redirect(base_url());
    }
}
