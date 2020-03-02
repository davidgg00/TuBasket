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
        $this->load->view("modulos/head", array("css" => array("plantilla")));
        $this->load->view("login_v");
    }

    public function iniciarsesion()
    {
        //cargamos el modelo
        $this->load->model("Login_m");
        //Si devuelve algo comprobar_usuario_clave es que el login es correcto
        $cuenta = $this->Login_m->comprobar_usuario_clave($this->input->post()['username'], $this->input->post()['password']);

        if ($cuenta) {
            if ($cuenta->tipo == "Jugador" && $cuenta->equipo != null && $cuenta->validado == 0) {
                //Si es un jugador, tiene equipo pero no está validado no dejamos iniciar sesión
                $this->session->set_flashdata('error', 'No estás confirmado en la plataforma, debes de esperar a que el administrador te acepte');
                redirect(base_url());
            } else if (!isset($cuenta->tipo)) {
                //Si no existe el campo "tipo" es que es una cuenta admin
                $array = array(
                    'username' => $cuenta->username,
                    'tipo_cuenta' => "Admin"
                );
                //Creamos la session con los datos
                $this->session->set_userdata($array);
                //Redirigimos al controlador
                redirect("Admin_c");
            } else {
                //Si es un jugador pero está validado o no está validado y no tiene equipo:
                $array = array(
                    'username' => $cuenta->username,
                    'apenom' => $cuenta->apenom,
                    'equipo' => $cuenta->equipo,
                    'tipo_cuenta' => $cuenta->tipo,
                    'liga' => $cuenta->liga,
                    'validado' => $cuenta->validado
                );
                //Creamos la session con los datos
                $this->session->set_userdata($array);
                //Redirigimos al controlador
                redirect("Jugador_c");
            }
        } else {
            $this->session->set_flashdata('error', 'El username o la contraseña no válidos.');
            redirect(base_url());
        }
    }
    public function cerrarsesion()
    {
        session_destroy();
        redirect(base_url());
    }
}
