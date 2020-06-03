<?php
defined('BASEPATH') or exit('No direct script access allowed');
//Controlador en el que controlaremos las ediciones de los perfiles de los usuarios
class Perfiles_c extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        //cargamos modelos
        $this->load->model("Perfiles_m");

        //Si el usuario NO está LOGUEADO
        if (!isset($this->session->userdata['tipo_cuenta'])) {
            //El redirect lo ponemos vacío porque el controlador por defecto es Login_c.
            redirect('');
        }
    }

    public function cambiarClave()
    {
        $datos = $this->Perfiles_m->actualizarClave(hash("sha512", $_POST["claveAntigua"]), hash("sha512", $_POST["claveNueva"]), $_POST["username"]);
        if (!$datos) {
            echo "Error";
        }
    }

    //Función que actualiza los datos de perfil del usuario.
    public function updateUsuario()
    {
        //Si se sube archivo
        if ($_FILES['fotoperfil']['name']) {
            //Ejecutamos este método que borrará la imagen antigua de la carpeta
            //Borramos la imagen si no es la de por defecto
            if ($_SESSION['imagen'] != "assets/uploads/perfiles/pordefecto.png") {
                unlink($_SESSION['imagen']);
            }
            $img = $_FILES['fotoperfil']['name'];
            $tmp = $_FILES['fotoperfil']['tmp_name'];
            $extension = pathinfo($img, PATHINFO_EXTENSION);
            $nombre_imagen = $img;
            $path = "assets/uploads/perfiles/" . $_SESSION['username'] . "." . $extension;
            move_uploaded_file($tmp, $path);
            //Modificamos la variable de sesión que tiene la foto de perfil
            $_SESSION['imagen'] = $path;
        }
        //Si existe $path 
        if (isset($path)) {
            $this->Perfiles_m->updateJugador($_POST['apenom'], $_POST['email'], $_POST['fecha_nac'], $path);
        } else {
            $this->Perfiles_m->updateJugador($_POST['apenom'], $_POST['email'], $_POST['fecha_nac'], $path = null);
        }
        echo $path;
    }

    public function verEmail()
    {
        echo $this->Perfiles_m->getEmail($_GET['email'], $_SESSION['username']);
    }
}
