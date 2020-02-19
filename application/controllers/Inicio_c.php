<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Inicio_c extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($_SESSION['tipo_cuenta'] == "Admin") {
            $this->load->view("modulos/head");
            $this->load->view("admin_v");
        } else if ($_SESSION['tipo_cuenta'] == "Jugador") {
            $this->load->view("modulos/head");
            $this->load->view("jugador_v");
        }
    }
}
