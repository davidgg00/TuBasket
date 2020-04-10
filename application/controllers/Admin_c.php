<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_c extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        //cargamos modelos
        $this->load->model("Admin_m");
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
            $datos["proxPartidos"] = self::getPartidosCarrusel($liga);
            //Cargamos los modulos junto con $datos que tiene el nombre de la liga
            $this->load->view("modulos/head", array("css" => array("liga")));
            $this->load->view("modulos/header", $datos);
            $this->load->view("liga_v");
            $this->load->view("modulos/footer");
        }
    }


    public function crear_liga()
    {
        //Aunque es requerido los campos, si están vacíos y le damos a registrar y clickamos fuera de la alerta te lo registra.
        //Con esta condición comprobamos que no esté vacío los campos
        if ($_POST['liga'] == "" && $_POST['password'] = "") {
            return false;
        }
        $resultado = $this->Admin_m->comprobarNombreLiga($_POST['liga']);
        if ($resultado) {
            echo "Existe";
        } else {
            $registros = array(
                'nombre' => $_POST['liga'],
                'password' => hash("sha512", $_POST['password']),
                'administrador' => $_POST['administrador']
            );
            $this->Admin_m->crearLiga($registros);
            echo "Creada";
        }
    }

    public function obtenerLigas()
    {
        //Obtenemos las ligas para después mostrarlas
        $data = $this->Admin_m->mostrar_ligas($_SESSION['username']);
        echo json_encode($data->result());
    }

    public function borrarLiga()
    {
        $this->Admin_m->borrarLiga($_POST['liga']);
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
        $this->load->view("modulos/head", array("css" => array("liga", "gestion_equipos")));
        $this->load->view("modulos/header", $datos);
        $this->load->view('gest_equipos_v');
        $this->load->view("modulos/footer");
    }

    public function gestJugadores($liga)
    {
        $datos["liga"] = $liga;
        $this->load->view("modulos/head", array("css" => array("liga", "gestion_jugadores")));
        $this->load->view("modulos/header", $datos);
        $this->load->view('gest_jugadores_v');
        $this->load->view("modulos/footer");
    }

    public function partidos($liga)
    {
        $datos["liga"] = $liga;
        $datos["partidos"] = self::mostrarPartidos($liga);
        $datos["nequipos"] = self::numeroEquiposLiga($liga);
        $this->load->view("modulos/head", array("css" => array("liga", "partidos")));
        $this->load->view("modulos/header", $datos);
        $this->load->view('partidos_v');
        $this->load->view("modulos/footer");
    }

    public function getPartidosCarrusel($liga)
    {

        //Obtenemos las ligas para después mostrarlas en la linea 21
        $resultado = $this->Admin_m->getProx5Partidos($liga);
        return $resultado;
    }

    //Función que devuelve el calendario de partidos de una liga
    public function mostrarPartidos($liga)
    {
        $partidos = $this->Admin_m->getPartidos($liga);
        return $partidos->result();
        $this->output->enable_profiler(TRUE);
    }

    public function numeroEquiposLiga($liga)
    {
        $nequipos = $this->Admin_m->getNumEquipos($liga);
        return $nequipos;
    }
}
