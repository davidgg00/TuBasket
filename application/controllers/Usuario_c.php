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
        $this->load->model("Notificaciones_m");
        //Si el usuario es Administrador, redirigimos al login
        if ($this->session->userdata['tipo_cuenta'] == 'Administrador') {
            //El redirect lo ponemos vacío porque el controlador por defecto es Login_c.
            redirect('');
        }
    }

    public function index()
    {
        //Si está validado y es un Jugador o Entrenador
        if ($_SESSION['validado'] == 1 && ($_SESSION['tipo_cuenta'] == "Jugador" || $_SESSION['tipo_cuenta'] == "Entrenador")) {
            $this->load->view("modulos/head", array("css" => array("liga", "jugador")));
            $data["liga"] = $_SESSION['liga'];
            $data["proxPartidos"] = $this->Jugador_m->proxPartido($_SESSION['liga'], $_SESSION['equipo']);

            //Añadimos variable que almacena el ganador de la liga (Si no hay, estará vacía)
            $datos["ganador"] = $this->Entrenador_m->getGanador($_SESSION['liga']);

            $this->load->view("modulos/header", $data);
            $this->load->view("liga_v", $data);
            $this->load->view("modulos/footer");
        } else {
            $data['equipos'] = $this->Jugador_m->obtenerEquipos($_SESSION['liga']);
            $this->load->view("modulos/head", array("css" => array("liga", "sin_equipo")));
            $this->load->view("sinequipo_v", $data);
        }
    }

    //Funcion que consulta las estadísticas totales y por partido del JUGADOR o JUGADORES y nos lo muestra en una vista
    public function estadisticas($username = null)
    {
        $this->load->view("modulos/head", array("css" => array("liga", "estadisticas")));
        $data["liga"] = $_SESSION['liga'];
        if (isset($_POST['jugador'])) {
            $statsJugadores = [];
            $statsIndJugadores = [];
            foreach ($_POST['jugador'] as $jugador) {
                $statsJugadores[] = self::getEstadisticasJugador($jugador);
                $statsIndJugadores[] = $this->Jugador_m->getEstadisticasJugadorPartido($_SESSION['username']);
                $datosUsuarios[] = $this->Jugador_m->getDatosUser($jugador);
            }
            $data["estadisticas"] = $statsJugadores;
            $data["stats_ind"] = $statsIndJugadores;
            $data['datos_user'] = $datosUsuarios;
            $this->load->view("modulos/header", $data);
            $this->load->view("compararjugadores_v");
            $this->load->view("modulos/footer");
        } else {
            $data["jugador"] = $username;
            //Si el username es nulo que nos muestre las estadísticas de la cuenta que ha iniciado sesion, de lo contrario las estadísticas del usuario pasado por param
            if ($username != null) {
                $data["entrenador"] = $this->Jugador_m->getEntrenadorJugador($username);
                $data["tusJugadores"] = $this->Entrenador_m->obtenerJugadoresEquipo($_SESSION["equipo"]);
                $data["estadisticas"] = $this->Jugador_m->getStats($username);
                $data["stats_ind"] = $this->Jugador_m->getEstadisticasJugadorPartido($_SESSION['username']);
                $data['datos_user'] = $this->Jugador_m->getDatosUser($username);
            } else {

                $data["estadisticas"] = $this->Jugador_m->getStats($_SESSION['username']);
                $data["stats_ind"] = $this->Jugador_m->getEstadisticasJugadorPartido($_SESSION['username']);
                $data['datos_user'] = $this->Jugador_m->getDatosUser($_SESSION['username']);
            }
            $this->load->view("modulos/head", array("css" => array("jugador")));
            $this->load->view("modulos/header", $data);
            $this->load->view("jugador_v");

            $this->load->view("modulos/footer");
        }
    }

    //Función que consulta la clasificación y nos la muestra en una vista.
    public function clasificacion()
    {
        $this->load->view("modulos/head", array("css" => array("liga", "clasificacion")));
        $data["liga"] = $_SESSION['liga'];
        $data["clasificacion"] = $this->Jugador_m->mostrarClasificacion($_SESSION["liga"]);
        $this->load->view("modulos/header", $data);
        $this->load->view("clasificacion_v");
        $this->load->view("modulos/footer");
    }

    public function listaJugadores()
    {
        $this->load->model("GestionJugadores_m");
        $datos["liga"] = $_SESSION["liga"];
        $datos['jugadores'] = $this->GestionJugadores_m->getJugadoresConfirmados($_SESSION["liga"]);
        $this->load->view("modulos/head", array("css" => array("liga", "listaJugadores")));
        $this->load->view("modulos/header", $datos);
        $this->load->view('listajugadores_v');
        $this->load->view("modulos/footer");
    }

    public function notificaciones()
    {
        $datos["fichajes"] = $this->Entrenador_m->verFichajes($_SESSION["username"]);
        $datos["liga"] = $_SESSION["liga"];
        $this->load->view("modulos/head", array("css" => array("liga", "notificaciones")));
        $this->load->view("modulos/header", $datos);
        $this->load->view('notificaciones_v');
        $this->load->view("modulos/footer");
    }

    //Funcion que hace un update en un jugador para unirse a un equipo.
    public function unirseEquipo($equipo, $username)
    {
        //Ejecutamos método de Jugador_m para unirse a un equipo
        $this->Jugador_m->unirseEquipo($equipo, $username);
        //Destruimos sesión y redirigimos al login
        session_destroy();
        redirect(base_url());
    }

    //Funcion que devuelve las estadisticas totales de un jugador o jugadores
    public function getEstadisticasJugador($username)
    {
        if (is_array($username)) {
            foreach ($username as $user) {
                $array[] = $this->Jugador_m->getStats($user);
            }
            return $array;
        } else {
            $resultado = $this->Jugador_m->getStats($username);
            return $resultado;
        }
    }

    //Funcion que te destruye la sesión y te devuelve al login.
    public function cerrarsesion()
    {
        //Destruimos sesión y redirigimos al login
        session_destroy();
        redirect(base_url());
    }

    public function obtenerJugadoresEquiposLiga($liga)
    {
        $datos = $this->Jugador_m->getNJugadoresEquipos($liga);
        echo json_encode($datos);
    }
}
