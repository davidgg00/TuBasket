<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_c extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        //Cargamos la librería
        $this->load->library('grocery_CRUD');
        //cargamos modelos
        $this->load->model("Admin_m");
        //Si no hay una sesión activa redirigimos al Login
        if ($this->session->userdata['username'] == FALSE) {
            redirect('Login_c');
        }
    }

    public function index($liga = "")
    {
        //Si no estamos en una liga en concreto que te mande al panel
        if ($liga == "") {
            //Cargamos el head con el css necesario
            $this->load->view("modulos/head", array("css" => array("panel_admin")));
            $this->load->view("admin_v");
        } else {
            $datos["liga"] = $liga;
            //Cargamos los modulos junto con $datos que tiene el nombre de la liga
            $this->load->view("modulos/head", array("css" => array("liga")));
            $this->load->view("modulos/header_admin", $datos);
            $this->load->view("liga_v");
            $this->load->view("modulos/footer");
        }
    }

    public function obtenerLigas()
    {   //cargamos el modelo
        $this->load->model("Admin_m");
        //Obtenemos las ligas para después mostrarlas en la linea 21
        $data = $this->Admin_m->mostrar_ligas($_SESSION['username']);
        echo json_encode($data->result());
    }

    public function cerrarsesion()
    {
        //Borra $_SESSION y redirige al login
        session_destroy();
        redirect(base_url());
    }

    public function gestEquipo($liga)
    {
        $datos["liga"] = $liga;
        /* $crud = new grocery_CRUD();
        //para que te liste los equipos de la liga en la que están
        $crud->where('liga', $liga);
        //Ponemos un tema
        $crud->set_theme('flexigrid');
        //Elegimos la tabla
        $crud->set_table('equipo');
        //La ponemos en español
        $crud->set_language("spanish");
        //Nombres a visualizar
        $crud->display_as('nombre', 'Equipo');
        $crud->field_type('liga', 'hidden', $liga);

        $crud->set_field_upload('escudo_ruta', 'assets/uploads/escudos');
        //Campos requeridos
        $crud->required_fields(['nombre', 'pabellon', 'ciudad', 'escudo_ruta', 'liga']);
        //Si hay mas de diez equipos no te deja insertar mas
        if ($this->Admin_m->num_equipos_liga($liga) >= 10) {
            $crud->unset_add();
        }
        //Renderizar mantenimiento
        $output = $crud->render(); */
        $this->load->view("modulos/head", array("css" => array("liga", "gestion_equipos")));
        //$this->load->view("modulos/head", $output);
        $this->load->view("modulos/header_admin", $datos);
        $this->load->view('gest_equipos_v');
        $this->load->view("modulos/footer");
    }

    public function gestJugadores($liga)
    {
        $datos["liga"] = $liga;
        $this->load->view("modulos/head", array("css" => array("liga", "gestion_jugadores")));
        $this->load->view("modulos/header_admin", $datos);
        $this->load->view('gest_jugadores_v');
        $this->load->view("modulos/footer");
    }
}
