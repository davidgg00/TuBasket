<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login_c extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        //Si hay una sesión activa redirigimos a inicio_c
        if (isset($this->session->userdata['username'])) {
            redirect('Inicio_c');
        }
    }

    public function index()
    {
        $this->load->view("modulos/head");
        $this->load->view("login_v");
    }

    public function iniciarsesion()
    {
        //cargamos el modelo
        $this->load->model("Login_m");
        //Si devuelve algo comprobar_usuario_clave es que el login es correcto
        $login = $this->Login_m->comprobar_usuario_clave($this->input->post()['username'], $this->input->post()['password']);
        if ($login) {
            //Necesitamos saber que tipo de cuenta es para redirigir a una vista u otra
            //Entonces si tenemos el campo equipo es jugador. De lo contrario admin
            if (isset($login->equipo)) {
                $array = array(
                    'username' => $login->username,
                    'apenom' => $login->apenom,
                    'equipo' => $login->equipo,
                    'tipo_cuenta' => "Jugador"
                );
            } else {
                $array = array(
                    'username' => $login->username,
                    'tipo_cuenta' => "Admin"
                );
            }
            //Creamos la session con los datos
            $this->session->set_userdata($array);
            //Redirigimos al controlador
            redirect("inicio_c");
        } else {
            echo "Error de inicio sesion";
        }
    }
    public function cerrarsesion()
    {
        session_destroy();
        redirect(base_url());
    }
}
