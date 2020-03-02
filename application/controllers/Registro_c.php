<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Registro_c extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        //cargamos modelos
        $this->load->model("Registro_m");
    }

    public function index()
    {
        $this->load->view("modulos/head");
        $this->load->view("registro_v");
    }

    public function comprobar_username()
    {
        $resultado = $this->Registro_m->select_username($_GET['username']);
        if ($resultado) {
            echo "Existe";
        } else {
            echo $_GET['username'];
        }
    }

    public function comprobar_email()
    {
        $resultado = $this->Registro_m->select_email($_GET['email']);
        if ($resultado) {
            echo "Existe";
        } else {
            echo "No existe";
        }
    }

    public function comprobar_liga()
    {
        $resultado = $this->Registro_m->comprueba_liga($_GET['liga'], $_GET['clave']);
        if ($resultado) {
            echo "Correcto";
        } else {
            echo "Incorrecto";
        }
    }

    public function registrar_user()
    {
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
            //Guardamos los datos enviados en un array
            $datos_post = array(
                'username' => $this->input->post()['username'],
                'password' => $this->input->post()['password'],
                'email' => $this->input->post()['email'],
                'apenom' => $this->input->post()['apenom'],
                'fecha_nac' => $this->input->post()['fecha_nac'],
                'equipo' => null,
                'liga' => $this->input->post()['nombre_liga'],
                'validado' => '0'
            );
            $this->Registro_m->insert_jugador($datos_post);
            redirect(base_url());
        }
    }

    public function crear_liga()
    {
        //Aunque es requerido los campos, si están vacíos y le damos a registrar y clickamos fuera de la alerta te lo registra.
        //Con esta condición comprobamos que no esté vacío los campos
        if ($_POST['liga'] == "" && $_POST['contrasenia'] = "") {
            return false;
        }
        $resultado = $this->Registro_m->select_liga($_POST['liga']);
        if ($resultado) {
            echo "Existe";
        } else {
            $this->load->model("Registro_m");
            $registros = array(
                'nombre' => $_POST['liga'],
                'password' => $_POST['clave'],
                'administrador' => $_POST['administrador']
            );
            $this->Registro_m->insert_liga($registros);
            echo "Creada";
        }
    }
}
