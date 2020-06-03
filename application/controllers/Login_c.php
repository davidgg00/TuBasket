<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login_c extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        //cargamos el modelo
        $this->load->model("Login_m");
    }

    /**
     * index
     * Función que te redirige a la vista del login.
     */
    public function index()
    {
        $this->load->view("modulos/head", array("css" => array("plantilla")));
        $this->load->view("login_v");
    }

    /**
     * iniciarsesion
     * Función que se comunica con el modelo para comprobar si el usuario y contraseña es correcto.
     * @return void
     */
    public function iniciarsesion()
    {
        //Si devuelve algo comprobar_usuario_clave es que el login es correcto
        $cuenta = $this->Login_m->comprobar_usuario_clave($this->input->post()['username'], hash("sha512", $this->input->post()['password']));

        if ($cuenta) {
            //Si es un jugador o entrenador, tiene equipo pero no está validado. No dejamos iniciar sesión
            if (($cuenta->tipo == "Jugador" || $cuenta->tipo == "Entrenador") && $cuenta->equipo != null && $cuenta->validado == 0) {
                $this->session->set_flashdata('error', 'No estás confirmado en la plataforma, debes de esperar a que el administrador te acepte');
                redirect(base_url());
            } else if ($cuenta->tipo == "Administrador") {
                //si es un administrador creamos las variables de sesion y redirigimos
                $array = array(
                    'username' => $cuenta->username,
                    'email' => $cuenta->email,
                    'apenom' => $cuenta->apenom,
                    'fecha_nac' => $cuenta->fecha_nac,
                    'tipo_cuenta' => "$cuenta->tipo",
                    'imagen' => $cuenta->imagen
                );
                //Creamos la session con los datos
                $this->session->set_userdata($array);
                //Redirigimos al controlador
                redirect("Admin_c");
            } else if ($cuenta->tipo == "Entrenador" && $cuenta->equipo != null && $cuenta->validado == 1) {
                //Si es un entrenador pero está validado y tiene equipo
                $array = array(
                    'username' => $cuenta->username,
                    'tipo_cuenta' => $cuenta->tipo,
                    'email' => $cuenta->email,
                    'apenom' => $cuenta->apenom,
                    'fecha_nac' => $cuenta->fecha_nac,
                    'liga' => $cuenta->liga,
                    'equipo' => $cuenta->equipo,
                    'validado' => $cuenta->validado,
                    'imagen' => $cuenta->imagen
                );
                //Creamos la session con los datos
                $this->session->set_userdata($array);
                //Redirigimos al controlador
                redirect("Usuario_c");
            } else {
                //Si es un jugador pero está validado o no está validado y no tiene equipo:
                $array = array(
                    'username' => $cuenta->username,
                    'tipo_cuenta' => $cuenta->tipo,
                    'email' => $cuenta->email,
                    'apenom' => $cuenta->apenom,
                    'fecha_nac' => $cuenta->fecha_nac,
                    'liga' => $cuenta->liga,
                    'equipo' => $cuenta->equipo,
                    'validado' => $cuenta->validado,
                    'imagen' => $cuenta->imagen
                );
                //Creamos la session con los datos
                $this->session->set_userdata($array);
                //Redirigimos al controlador
                redirect("Usuario_c");
            }
        } else {
            $this->session->set_flashdata('error', 'El username o la contraseña no válidos.');
            redirect(base_url());
        }
    }
}
