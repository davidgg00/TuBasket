<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jugador_c extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        //cargamos el modelo
        $this->load->model("Jugador_m");
        //Si no hay una sesión activa redirigimos al Login
        if ($this->session->userdata['username'] == FALSE) {
            redirect('Login_c');
        }
    }

    public function index()
    {
        if ($_SESSION['validado'] == 1) {
            $this->load->view("modulos/head", array("css" => array("liga", "jugador")));
            $data["liga"] = $_SESSION['liga'];
            $this->load->view("modulos/header_jugador", $data);
            $this->load->view("jugador_v", $data);
            $this->load->view("modulos/footer");
        } else {
            $this->load->view("modulos/head");
            $this->load->view("sinequipo_v", self::obtenerEquiposLiga());
        }
    }

    public function estadisticas()
    {
        $this->load->view("modulos/head", array("css" => array("liga", "estadisticas")));
        $data["liga"] = $_SESSION['liga'];
        $data["estadisticas"] = self::getEstadisticasJugador($_SESSION["username"]);
        $this->load->view("modulos/header_jugador", $data);
        $this->load->view("estadisticas_v");
        $this->load->view("modulos/footer");
    }

    public function obtenerLigas()
    {
        //Obtenemos las ligas para después mostrarlas en la linea 21
        $data['ligas'] = $this->Jugador_m->mostrar_ligas($_SESSION['username']);
        return $data;
    }

    public function obtenerEquiposLiga()
    {
        //obtenemos todos los equipos de la liga que queremos
        $data['equipos'] = $this->Jugador_m->obtenerEquipos($_SESSION['liga']);
        return $data;
    }

    public function unirseEquipo($equipo, $username)
    {
        //Ejecutamos método de Jugador_m para unirse a un equipo
        $this->Jugador_m->unirseEquipo($equipo, $username);
        //Cerramos Sesión y redirigimos al Login
        self::cerrarsesion();
    }

    public function getEstadisticasJugador($username)
    {
        $resultado = $this->Jugador_m->getStats($username);
        return $resultado->row();
    }

    public function cerrarsesion()
    {
        //Destruimos sesión y redirigimos al login
        session_destroy();
        redirect(base_url());
    }
}
