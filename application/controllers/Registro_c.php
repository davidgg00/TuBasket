<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Registro_c extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('encryption');
    }

    public function index()
    {
        $datos["contenido"] = "registro_v";
        $this->load->view("plantilla/plantilla", $datos);
    }

    public function registrar_user()
    {
        $this->load->model("Login_m");
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'nombre de usuario', 'is_unique[usuarios.username]');
        $this->form_validation->set_rules('password', 'contraseña del usuario', 'is_unique[usuarios.password]');
        if ($this->form_validation->run() == FALSE) {
            echo "quedise";
        } else {
            echo "funca";
        }
        $this->load->model("Registro_m");
        if ($this->input->post()['tipocuenta'] == "administrador") {
            $datos_post = array(
                'username' => $this->input->post()['username'],
                'password' => $this->input->post()['password'],
                'email' => $this->input->post()['email'],
                'apenom' => $this->input->post()['apenom'],
                'fecha_nac' => $this->input->post()['fecha_nac'],
            );
            $this->Registro_m->insert_admin($datos_post);
            redirect(base_url());
        } else {
            $this->Registro_m->insert_jugador($this->input->post());
            redirect(base_url());
        }
    }

    public function mostrar()
    {
        //Acceder al modelo de las categorias para coger todos los datos
        $datos["contenido"] = "mostrar_v";
        $this->load->model("Registro_m");
        $datos['usuarios'] = $this->Registro_m->leer();
        $this->load->view("plantilla/plantilla", $datos);
    }
}
