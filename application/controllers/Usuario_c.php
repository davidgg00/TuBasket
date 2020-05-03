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
        //Si está validado y es un Jugador o Entrenador
        if ($_SESSION['validado'] == 1 && ($_SESSION['tipo_cuenta'] == "Jugador" || $_SESSION['tipo_cuenta'] == "Entrenador")) {
            $this->load->view("modulos/head", array("css" => array("liga", "jugador")));
            $data["liga"] = $_SESSION['liga'];
            $data["proxPartidos"] = self::proxPartido($_SESSION['liga'], $_SESSION['equipo']);
            $this->load->view("modulos/header", $data);
            $this->load->view("liga_v", $data);
            $this->load->view("modulos/footer");
        } else {
            $this->load->view("modulos/head", array("css" => array("liga", "sin_equipo")));
            $this->load->view("sinequipo_v", self::obtenerEquiposLiga());
        }
    }

    //Funcion que consulta las estadísticas totales y por partido del JUGADOR o jugadores y nos lo muestra en una vista
    public function estadisticas($username = null)
    {
        $this->load->view("modulos/head", array("css" => array("liga", "estadisticas")));
        $data["liga"] = $_SESSION['liga'];
        if (isset($_POST['jugador'])) {
            $statsJugadores = [];
            $statsIndJugadores = [];
            foreach ($_POST['jugador'] as $jugador) {
                $statsJugadores[] = self::getEstadisticasJugador($jugador);
                $statsIndJugadores[] = self::getEstadisticasJugadorPartido($jugador);
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
                $data["datos_jugador"] = self::getDatos($username);
                $data["tusJugadores"] = self::getJugadoresEquipo();
                $data["estadisticas"] = self::getEstadisticasJugador($username);
                $data["stats_ind"] = self::getEstadisticasJugadorPartido($username);
                $data['datos_user'] = $this->Jugador_m->getDatosUser($username);
            } else {
                $data["estadisticas"] = self::getEstadisticasJugador($_SESSION['username']);
                $data["stats_ind"] = self::getEstadisticasJugadorPartido($_SESSION['username']);
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
        $data["clasificacion"] = self::getClasificacion($_SESSION["liga"]);
        $this->load->view("modulos/header", $data);
        $this->load->view("clasificacion_v");
        $this->load->view("modulos/footer");
    }

    //Función que devuelve el calendario de partidos y nos la muestra en una vista.
    public function partidos()
    {
        $datos["liga"] = $_SESSION["liga"];
        $datos["partidos"] = self::mostrarPartidos($_SESSION["liga"]);
        $datos["nequipos"] = self::numeroEquiposLiga($_SESSION["liga"]);
        $this->load->view("modulos/head", array("css" => array("liga", "partidos")));
        $this->load->view("modulos/header", $datos);
        $this->load->view('partidos_v');
        $this->load->view("modulos/footer");
    }

    public function listaJugadores()
    {
        $this->load->model("GestionJugadores_m");
        $datos["liga"] = $_SESSION["liga"];
        $datos["partidos"] = self::mostrarPartidos($_SESSION["liga"]);
        $datos["nequipos"] = self::numeroEquiposLiga($_SESSION["liga"]);
        $datos['jugadores'] = $this->GestionJugadores_m->getJugadoresConfirmados($_SESSION["liga"])->result();
        $this->load->view("modulos/head", array("css" => array("liga", "listaJugadores")));
        $this->load->view("modulos/header", $datos);
        $this->load->view('listajugadores_v');
        $this->load->view("modulos/footer");
    }

    public function notificaciones()
    {
        $datos["fichajes_pendientes"] = self::fichajesPendiente();
        $datos["liga"] = $_SESSION["liga"];
        $this->load->view("modulos/head", array("css" => array("liga", "notificaciones")));
        $this->load->view("modulos/header", $datos);
        $this->load->view('notificaciones_v');
        $this->load->view("modulos/footer");
    }

    //Función que devuelve la clasificación.
    public function getClasificacion()
    {
        $resultado = $this->Jugador_m->mostrarClasificacion($_SESSION["liga"]);
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
    public function mostrarPartidos()
    {
        $partidos = $this->Jugador_m->getPartidos($_SESSION["liga"]);
        return $partidos->result();
    }

    //Función que te dice el numero de equipos que hay en una liga.
    public function numeroEquiposLiga()
    {
        $nequipos = $this->Jugador_m->getNumEquipos($_SESSION["liga"]);
        return $nequipos;
    }

    //Función que te devuelve los datos de un usuario. (Se ejecuta en el index, para editar la información del usuario si lo desea)
    public function getDatos($username = null)
    {
        if ($username == null) {
            $datos = $this->Jugador_m->getDatosUser($_SESSION["username"]);
        } else {
            $datos = $this->Jugador_m->getDatosUser($username);
        }

        return $datos;
    }

    //Función que actualiza los datos de perfil del usuario.
    public function updateUsuario()
    {
        //Si se sube archivo
        if ($_FILES['fotoperfil']['name']) {
            //Ejecutamos este método que borrará la imagen antigua de la carpeta
            self::borrarImagenAntigua();
            $img = $_FILES['fotoperfil']['name'];
            $tmp = $_FILES['fotoperfil']['tmp_name'];
            $nombre_imagen = $img;
            $path = "assets/uploads/perfiles/" . rand(1, 1000) . $nombre_imagen;
            move_uploaded_file($tmp, $path);
            //Modificamos la variable de sesión que tiene la foto de perfil
            $_SESSION['imagen'] = $path;
        }
        //Si existe $path 
        if (isset($path)) {
            $this->Jugador_m->updateJugador($_POST['apenom'], $_POST['email'], $_POST['fecha_nac'], $path);
        } else {
            $this->Jugador_m->updateJugador($_POST['apenom'], $_POST['email'], $_POST['fecha_nac'], $path = null);
        }
        echo $path;
    }

    //Función que busca una imagen de perfil en la carpeta donde se guardan las imagenes y la borra.
    public function borrarImagenAntigua()
    {
        //Buscamos la info del usuario
        if ($_SESSION['tipo_cuenta'] == "Jugador") {
            $datos = $this->Jugador_m->getDatosUser($_SESSION["username"]);
        } else {
            $datos = $this->Entrenador_m->getDatosEntrenador($_SESSION["username"]);
        }
        //Borramos la imagen si no es la de por defecto
        if ($datos->imagen != "assets/uploads/perfiles/pordefecto.png") {
            unlink($datos->imagen);
        }
    }

    public function getJugadoresEquipo()
    {
        $datos = $this->Entrenador_m->obtenerJugadoresEquipo($_SESSION["equipo"]);
        return $datos;
    }

    public function OfrecerFichaje()
    {
        $mensaje = $this->Entrenador_m->OfrecerFichaje($_SESSION['equipo'], $_POST['jugadorAFichar'], $_POST['idEquipoRecibe'], $_POST['jugadorOfrecido']);
        echo $mensaje;
    }

    public function fichajesPendiente()
    {
        $datos = $this->Entrenador_m->verFichajesPendientes($_SESSION["equipo"]);
        return $datos;
    }

    public function aceptarFichaje()
    {
        $this->Entrenador_m->aceptarFichaje($_POST['idfichaje']);
    }

    public function rechazarFichaje()
    {
        $this->Entrenador_m->rechazarFichaje($_POST['idfichaje']);
    }

    public function updateClave()
    {

        $datos = $this->Jugador_m->actualizarClave(hash("sha512", $_POST["claveAntigua"]), hash("sha512", $_POST["claveNueva"]), $_POST["cuenta"], $_POST["username"]);
        if (!$datos) {
            echo "Error";
        }
    }
}
