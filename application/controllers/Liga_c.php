<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Liga_c extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('grocery_CRUD');
        //Si no hay una sesión activa redirigimos al Login
        if ($this->session->userdata['username'] == FALSE) {
            redirect('Login_c');
        }
    }

    public function index($liga)
    {
        $datos["liga"] = $liga;
        $this->load->view("modulos/head_liga");
        $this->load->view("modulos/header_admin", $datos);
        $this->load->view("liga_v");
        $this->load->view("modulos/footer");
    }

    public function cerrarsesion()
    {
        session_destroy();
        redirect(base_url());
    }

    public function gestEquipo($liga)
    {
        $datos["liga"] = $liga;
        $crud = new grocery_CRUD();
        //para que te liste los equipos de la liga en la que están
        $crud->where('liga', $liga);
        //Ponemos un tema
        $crud->set_theme('flatgrid');
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
        //Renderizar mantenimiento
        $output = $crud->render();
        $this->load->view("modulos/head_liga", $output);
        $this->load->view("modulos/header_admin", $datos);
        $this->load->view('gest_equipos_v');
        $this->load->view("modulos/footer");
    }
}
