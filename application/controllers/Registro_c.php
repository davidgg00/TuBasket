<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Registro_c extends CI_Controller
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
        $this->load->view("registro_v");
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

    public function crear_liga()
    {
        if ($_POST['liga'] == "") {
            return false;
        }
        $resultado = $this->db->query("SELECT Count(*) as Contador FROM liga WHERE nombre=?", $_POST['liga']);
        $existe = $resultado->row();
        //Si resultado->row devuelve un 1 significará que ya existe una liga con ese nombres
        if ($existe->Contador == 1) {
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
