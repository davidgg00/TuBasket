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
        //Al borrar una liga también vamos a borrar las imagenes del servidor de los jugadores y escudos.

        $imgEscudos = $this->Admin_m->getEscudos($_POST['liga']);
        foreach ($imgEscudos as $imgEscudo) {
            unlink($imgEscudo->escudo_ruta);
        }

        $imgJugadores = $this->Admin_m->getPerfilesJugadores($_POST['liga']);
        foreach ($imgJugadores as $imgJugador) {
            //Si la imagen no es la de por defecto se borra.
            if ($imgJugador->imagen != "assets/uploads/perfiles/pordefecto.png") {
                unlink($imgJugador->imagen);
            }
        }
        //Y finalmente borramos la liga.
        $this->Admin_m->borrarLiga($_POST['liga']);
    }

    public function obtenerNLigas()
    {
        //Obtenemos las ligas para después mostrarlas
        $data = $this->Admin_m->mostrar_ligas($_SESSION['username']);
        echo $data->num_rows();
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

    public function getPartidosCarrusel($liga)
    {
        //Obtenemos las ligas para después mostrarlas en la linea 21
        $resultado = $this->Admin_m->getProx5Partidos($liga);
        return $resultado;
    }

    //Función que actualiza los datos de perfil del admin.
    public function updateAdmin()
    {
        //Si se sube archivo
        if ($_FILES['fotoperfil']['name']) {
            $img = $_FILES['fotoperfil']['name'];
            $tmp = $_FILES['fotoperfil']['tmp_name'];
            $nombre_imagen = $img;
            $path = "assets/uploads/perfiles/" . rand(1, 1000) . $nombre_imagen;
            move_uploaded_file($tmp, $path);

            if ($_SESSION['imagen'] != "assets/uploads/perfiles/pordefecto.png") {
                unlink($_SESSION['imagen']);
            }
            //Modificamos la variable de sesión que tiene la foto de perfil
            $_SESSION['imagen'] = $path;
        }
        //Si existe $path 
        if (isset($path)) {
            $this->Admin_m->updateAdmin($_POST['apenom'], $_POST['email'], $_POST['fecha_nac'], $path);
        } else {
            $this->Admin_m->updateAdmin($_POST['apenom'], $_POST['email'], $_POST['fecha_nac'], $path = null);
        }
        echo $path;
    }
}
