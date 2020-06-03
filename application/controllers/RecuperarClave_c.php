<?php
defined('BASEPATH') or exit('No direct script access allowed');

class RecuperarClave_c extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        //cargamos modelos
        $this->load->model("RecuperarClave_m");
    }

    /**
     * index
     * Función que te lleva a la vista de recuperarclave
     */
    public function index()
    {
        $this->load->view("modulos/head", array("css" => array("plantilla")));
        $this->load->view("recuperarclave_v");
    }

    /**
     * recuperarclave
     * Función que manda al modelo el email para comprobar si existe y después envia un correo de reseteo de contraseña.
     * @return void
     */
    public function recuperarclave()
    {
        //Primero de todo vamos a comprobar si el email existe
        if ($this->RecuperarClave_m->existeEmailCuenta($_POST['email'])) {
            $email = $_POST['email'];
            //Generamos un token de longitud 100
            $token = bin2hex(random_bytes("100"));
            //Lo insertamos en la BBDD
            $this->RecuperarClave_m->insertarTokenBBDD($email, $token);
            //Enviamos el email
            self::EnviarMail($email, $token);
            $this->session->set_flashdata('acierto', 'Email de reseteo confirmado correctamente');
            redirect('RecuperarClave_c');
        } else {
            $this->session->set_flashdata('error', 'El correo introducido no existe.');
            redirect('RecuperarClave_c');
        }
    }

    /**
     * EnviarMail
     * Función que envia el correo de reseteo de clave.
     * @param  $email
     * @param  $token
     */
    public function EnviarMail($email, $token)
    {
        // Protocolo de envío
        $config['protocol'] = 'smtp';
        // Servidor SMTP de gmail.
        $config['smtp_host'] = "ssl://smtp.gmail.com";
        // Puerto SMTP
        $config['smtp_port'] = 465;
        // Email del remitente
        $config['smtp_user'] = $this->config->item('credenciales')['email'];
        // Contraseña  del remitente
        $config['smtp_pass'] = $this->config->item('credenciales')['clave'];
        $this->email->initialize($config);
        $this->email->set_newline("\r\n");

        $this->email->from("tubasket2020@gmail.com", "tubasket2020@gmail.com");

        // Añadimos el destinatario
        $this->email->to($email);
        // Asunto del email
        $this->email->subject("Petición de recuperación de contraseña");
        // Mensaje del email
        $this->email->message("Si desea restablecer la contraseña haga click en el siguiente link: <br> <a href=" . base_url('RecuperarClave_c/resetearClave?token=' . $token . '&email=' . $email . '') . ">Recuperar Contraseña</a><br>Tiene un plazo de 24 horas.");
        $this->email->set_mailtype('html');
        // Enviamos EMAIL
        $this->email->send();
    }

    /**
     * resetearClave
     * Función que te comprueba si el token es correcto, si es asi te redirige para poner la nueva contraseña.
     * @return
     */
    public function resetearClave()
    {
        $datetime = new DateTime('today');
        $datosToken = $this->RecuperarClave_m->getDatosToken($_GET['token']);

        //Si el token ha expirado, te redirige al login y te mostrará error.
        if ($datetime->format('Y-m-d') > $datosToken->exp) {
            $this->session->set_flashdata('error', 'La petición de reseteo de contraseña ha expirado');
            redirect('Login_c');
        } else {
            if ($datosToken->email == $_GET['email'] && $datosToken->token == $_GET['token']) {
                $datos['email'] = $_GET['email'];
                $this->load->view("modulos/head", array("css" => array("plantilla")));
                $this->load->view("resetearclave_v", $datos);
            }
        }
    }

    /**
     * cambiarClave
     * Función que te agrega un $_SESSION de confirmación y te redirige al login.
     */
    public function cambiarClave()
    {
        if ($this->RecuperarClave_m->cambiarClaveUsuario($_POST['email'], hash("sha512", $_POST['clave']))) {
            $this->session->set_flashdata('acierto', 'Contraseña cambiada correctamente');
            redirect('Login_c');
        }
    }
}
