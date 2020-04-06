<?php
defined('BASEPATH') or exit('No direct script access allowed');
//Controlador que contiene los métodos del Jugador, Entrenador y ambos.
class Usuario_c extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        //cargamos los modelos
        $this->load->model("Jugador_m");
        $this->load->model("Entrenador_m");
        //Si no hay una sesión activa redirigimos al Login
        /* if ($this->session->userdata['username'] == FALSE) {
            redirect('Login_c');
        } */
    }

    public function index()
    {
        //Si está validado y es un Jugador
        if ($_SESSION['validado'] == 1 && $_SESSION['tipo_cuenta'] == "Jugador") {
            $this->load->view("modulos/head", array("css" => array("liga", "jugador")));
            $data["liga"] = $_SESSION['liga'];
            $data["proxPartidos"] = self::proxPartido($_SESSION['liga'], $_SESSION['equipo']);
            $this->load->view("modulos/header", $data);
            $this->load->view("liga_v", $data);
            $this->load->view("modulos/footer");
            //Si está validado y es un Entrenador
        } else if ($_SESSION['validado'] == 1 && $_SESSION['tipo_cuenta'] == "Entrenador") {
            $datos["liga"] = $_SESSION['liga'];
            $datos["proxPartidos"] = self::proxPartido($_SESSION['liga'], $_SESSION['equipo']);
            //Cargamos los modulos junto con $datos que tiene el nombre de la liga
            $this->load->view("modulos/head", array("css" => array("liga")));
            $this->load->view("modulos/header", $datos);
            $this->load->view("liga_v");
            $this->load->view("modulos/footer");
        } else {
            $this->load->view("modulos/head", array("css" => array("liga", "sin_equipo")));
            $this->load->view("sinequipo_v", self::obtenerEquiposLiga());
        }
    }

    //Funcion que consulta las estadísticas totales y por partido del JUGADOR y nos lo muestra en una vista
    public function estadisticas()
    {
        $this->load->view("modulos/head", array("css" => array("liga", "estadisticas")));
        $data["liga"] = $_SESSION['liga'];
        $data["estadisticas"] = self::getEstadisticasJugador($_SESSION['username']);
        $data["stats_ind"] = self::getEstadisticasJugadorPartido($_SESSION['username']);
        $this->load->view("modulos/header", $data);
        $this->load->view("estadisticas_v");
        $this->load->view("modulos/footer");
    }

    //Función que consulta la clasificación y nos la muestra en una vista.
    public function clasificacion()
    {
        $this->load->view("modulos/head", array("css" => array("liga", "clasificacion")));
        $data["liga"] = $_SESSION['liga'];
        $data["clasificacion"] = self::getClasificacion($_SESSION["liga"]);
        $this->load->view("modulos/header", $data);
        $this->load->view("clasificacion_v");
        $this->load->view("modulos/footer");
    }

    //Función que devuelve el calendario de partidos y nos la muestra en una vista.
    public function partidos($liga)
    {
        $datos["liga"] = $liga;
        $datos["partidos"] = self::mostrarPartidos($_SESSION["liga"]);
        $datos["nequipos"] = self::numeroEquiposLiga($_SESSION["liga"]);
        $this->load->view("modulos/head", array("css" => array("liga", "partidos")));
        $this->load->view("modulos/header", $datos);
        $this->load->view('partidos_v');
        $this->load->view("modulos/footer");
    }

    //Función que devuelve la clasificación.
    public function getClasificacion($liga)
    {
        $resultado = $this->Jugador_m->mostrarClasificacion($liga);
        return $resultado;
    }

    //Funcion que devuelve los equipos que tiene una liga
    public function obtenerEquiposLiga()
    {
        //obtenemos todos los equipos de la liga que queremos
        $data['equipos'] = $this->Jugador_m->obtenerEquipos($_SESSION['liga']);
        return $data;
    }

    //Funcion que hace un update en un jugador para unirse a un equipo.
    public function unirseEquipo($equipo, $username)
    {
        //Ejecutamos método de Jugador_m para unirse a un equipo
        $this->Jugador_m->unirseEquipo($equipo, $username);
        //Cerramos Sesión y redirigimos al Login
        self::cerrarsesion();
    }

    //Funcion que devuelve las estadisticas totales de un jugador
    public function getEstadisticasJugador($username)
    {
        $resultado = $this->Jugador_m->getStats($username);
        return $resultado;
    }

    //Funcion que devuelve las estadisticas por partido de un jugador.
    public function getEstadisticasJugadorPartido($username)
    {
        $resultado = $this->Jugador_m->getEstadisticasJugadorPartido($username);
        return $resultado;
    }

    //Funcion que te destruye la sesión y te devuelve al login.
    public function cerrarsesion()
    {
        //Destruimos sesión y redirigimos al login
        session_destroy();
        redirect(base_url());
    }

    //Funcion que devuelve los proximos partido de un equipo
    public function proxPartido($liga, $equipo)
    {
        $resultado = $this->Jugador_m->proxPartido($liga, $equipo);
        return $resultado;
    }

    //Función que devuelve el calendario de partidos de una liga
    public function mostrarPartidos($liga)
    {
        $partidos = $this->Jugador_m->getPartidos($liga);
        return $partidos->result();
    }

    //Función que te dice el numero de equipos que hay en una liga.
    public function numeroEquiposLiga($liga)
    {
        $nequipos = $this->Jugador_m->getNumEquipos($liga);
        return $nequipos;
    }
}
