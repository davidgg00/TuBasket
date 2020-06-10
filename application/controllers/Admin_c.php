<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_c extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        //cargamos modelos
        $this->load->model("Admin_m");

        //Si el usuario no es un Administrador, redirigimos LOGIN
        if ($this->session->userdata['tipo_cuenta'] != 'Administrador') {
            //El redirect lo ponemos vacío porque el controlador por defecto es Login_c.
            redirect('');
        }
    }

    /**
     * index
     * Método que nos devuelve, dependiendo si hay parámetro o no, el panel del administrador o la liga.
     * @param  $liga
     */
    public function index($liga = "")
    {
        //Si no estamos en una liga en concreto que te mande al panel
        if ($liga == "") {
            //Cargamos el head con el css necesario
            $this->load->view("modulos/head", array("css" => array("panel_admin")));
            $this->load->view("admin_v");
        } else {
            //Si se intenta acceder a una liga que no existe o si la liga a la que intentas acceder no es tuya. Redirigimos al panel
            if (!$this->Admin_m->comprobarNombreLiga($liga) || !$this->Admin_m->comprobarPropiedadLiga($liga, $_SESSION['username'])) {
                redirect("Admin_c");
            } else {
                $datos["liga"] = $liga;
                $datos["proxPartidos"] = $this->Admin_m->getProx5Partidos($liga);

                //Añadimos variable que almacena el ganador de la liga (Si no hay, estará vacía)
                $datos["ganador"] = $this->Admin_m->getGanador($liga);

                //Cargamos los modulos junto con $datos que tiene el nombre de la liga
                $this->load->view("modulos/head", array("css" => array("liga")));
                $this->load->view("modulos/header", $datos);
                $this->load->view("liga_v");
                $this->load->view("modulos/footer");
            }
        }
    }

    /**
     * gestEquipo
     * Método que te lleva a la vista de la Gestión de Equipos
     * @param  $liga
     */
    public function gestEquipo($liga)
    {
        $datos["liga"] = $liga;
        $this->load->view("modulos/head", array("css" => array("liga", "gestion_equipos")));
        $this->load->view("modulos/header", $datos);
        $this->load->view('gest_equipos_v');
        $this->load->view("modulos/footer");
    }

    /**
     * gestUsuarios
     * Método que te lleva a la vista de la Gestión de usuarios
     * @param  $liga
     */
    public function gestUsuarios($liga)
    {
        $datos["liga"] = $liga;
        $this->load->view("modulos/head", array("css" => array("liga", "gestion_jugadores")));
        $this->load->view("modulos/header", $datos);
        $this->load->view('gest_jugadores_v');
        $this->load->view("modulos/footer");
    }

    /**
     * crear_liga
     * Función que recoge el nombre y contraseña de la liga a crear y si no existe, se comunica con el modelo, de lo contrario te devuelve un "Existe"
     * Para controlar el error en la vista.
     * @return void
     */
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

    /**
     * obtenerLigas
     * Función que recoge del modelo las ligas creadas por un administrador y las devuelve a la vista.
     */
    public function obtenerLigas()
    {
        //Obtenemos las ligas para después mostrarlas
        $data = $this->Admin_m->mostrar_ligas($_SESSION['username']);
        echo json_encode($data->result());
    }

    /**
     * borrarLiga
     * Función que te borra la liga de la base de datos y sus imagenes.
     * @return void
     */
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

    /**
     * obtenerNLigas
     * Función que te devuelve el número de ligas que tiene el administrador (para controlar que no cree mas de 3).
     */
    public function obtenerNLigas()
    {
        //Obtenemos las ligas para después mostrarlas
        $data = $this->Admin_m->mostrar_ligas($_SESSION['username']);
        echo $data->num_rows();
    }
}
