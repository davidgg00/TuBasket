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
        //cargamos modelos
        $this->load->model("Registro_m");
        //Si el tipo de cuenta es administrador
        if ($this->input->post()['tipocuenta'] == "administrador") {
            //Guardamos los datos en un array
            $datos_post = array(
                'username' => $this->input->post()['username'],
                'password' => $this->input->post()['password'],
                'email' => $this->input->post()['email'],
                'apenom' => $this->input->post()['apenom'],
                'fecha_nac' => $this->input->post()['fecha_nac'],
            );
            //Los insertamos y redirigimos al login
            $this->Registro_m->insert_admin($datos_post);
            redirect(base_url());
        } else {
            //TO-DO NO IMPLEMENTADO TODAVÍAR
            $this->Registro_m->insert_jugador($this->input->post());
            redirect(base_url());
        }
    }
}
