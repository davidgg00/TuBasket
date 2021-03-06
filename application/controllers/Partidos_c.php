<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Partidos_c extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        //cargamos modelos
        $this->load->model("Partidos_m");
    }

    /**
     * partidos
     * Función que devuelve el calendario de partidos y nos la muestra en una vista.  
     * @param  $liga
     */
    public function partidos($liga = null)
    {
        //Si no se pasa ningún parámetro es que el nombre de liga lo tenemos en la sesión (cuentas jugador y entrenador)
        if ($liga == null) {
            $liga = $_SESSION['liga'];
        }
        $datos["liga"] = $liga;
        if (isset($_SESSION['equipo'])) {
            $datos['numeroNotif'] = self::getnumeroNotificaciones();
        }
        $datos["partidos"] = $this->Partidos_m->getPartidos($liga)->result();
        $datos["nequipos"] = $this->Partidos_m->getNumEquipos($liga);
        $datos["equipos"] = $this->Partidos_m->getEquipos($liga);
        $this->load->view("modulos/head", array("css" => array("liga", "partidos")));
        $this->load->view("modulos/header", $datos);
        $this->load->view('partidos_v');
        $this->load->view("modulos/footer");
    }


    /**
     * insertarResultadoEquipos
     * Función que manda al modelo el resultado de LOS EQUIPOS (no jugadores).
     * @param  $liga
     */
    public function insertarResultadoEquipos($liga)
    {
        //Si el usuario es un administrador se comunica con el modelo
        if ($this->session->userdata['tipo_cuenta'] == 'Administrador') {
            $this->Partidos_m->insertarResultadoPartido($_POST['id'], $_POST['equipolocal'], $_POST['equipovisitante']);
            echo "Insertado";

            //Al guardar un partido vamos a comprobar si es el último que quedaba por jugarse.
            $nequipos = $this->Partidos_m->num_equipos_liga($liga);
            $npartidos = ($nequipos - 1) * $nequipos;
            $npartidosJugados = $this->Partidos_m->getNPartidosJugados($liga);
            if ($npartidosJugados->total == $npartidos) {
                $this->Partidos_m->definirGanador($liga);
            }

            //Enviamos EMAIL y PDF
            $datos_jugadores = $this->Partidos_m->getEmailJugadores($_POST['id']);
            $datos_partido = $this->Partidos_m->getPartido($_POST['id']);
            self::generarPDF($_POST['id']);
            self::EnviarMail($_POST['id'], $datos_jugadores, $datos_partido);
        }
    }

    /**
     * generarLiga
     * Función que manda al modelo los enfrentamientos que se van a generar.
     * @param  $liga
     */
    function generarLiga($liga)
    {
        if ($this->session->userdata['tipo_cuenta'] == 'Administrador') {
            //obtenemos todos los equipos de la liga que queremos
            $data = $this->Partidos_m->getEquipos($liga);
            //Creamos un array donde se guardarán las ids de los equipos
            $equipos = array();
            foreach ($data as $dato) {
                $equipos[] = $dato->id;
            }

            //Generamos el número de jornadas
            $jornadas = (($count = count($equipos)) % 2 === 0 ? $count - 1 : $count) * 2;

            //Utilizamos la libreria ScheduleBuilder para que nos genere un array con los enfrentamientos
            $scheduleBuilder = new ScheduleBuilder($equipos, $jornadas);
            $schedule = $scheduleBuilder->build();

            //Recorremos el array y vamos insertando los partidos que se han generado en la Base de Datos
            foreach ($schedule as $jornada => $partidos) {
                foreach ($partidos as $equipo) {
                    $this->Partidos_m->insertPartidos($equipo[0], $equipo[1], $jornada, $liga);
                }
            }
            redirect('Admin_c/partidos/' . $liga);
        }
    }

    /**
     * resultadoPartido
     * Función que te devuelve la vista de un partido en concreto.
     * @param  $liga
     * @param  $id
     */
    public function resultadoPartido($liga, $id)
    {
        $datos['liga'] = $liga;
        $datos['id'] = $id;
        $datos['equipos'] = $this->Partidos_m->getPartido($id);
        $datos['jugadores'] = $this->Partidos_m->getJugadoresPartidos($id);
        $this->load->view("modulos/head", array("css" => array("liga", "partido")));
        $this->load->view("modulos/header", $datos);
        $this->load->view("partido_v");
        $this->load->view("modulos/footer");
    }

    /**
     * enviarResultado
     * Función que inserta las estadísticas de los JUGADORES que han disputado el encuentro.
     * @param  $id
     * @param  $liga
     */
    public function enviarResultado($id, $liga)
    {
        if ($this->session->userdata['tipo_cuenta'] == 'Administrador') {
            //Bucle que recorre los tr y TD que se han enviado para después enviarlos al MODELO
            for ($i = 0; $i <= count($_POST['miform']); $i++) {
                if ($i % 6 == 0 && $i != 0) {
                    $valor = $i;
                    $this->Partidos_m->insertarEstadisticaPartido($id, $_POST['miform'][$valor - 6], $_POST['miform'][$valor - 5], $_POST['miform'][$valor - 4], $_POST['miform'][$valor - 3], $_POST['miform'][$valor - 2], $_POST['miform'][$valor - 1]);
                }
            }
        }
    }

    /**
     * cambiarFecha
     * Función que manda al modelo el cambio de fecha de un partido.
     */
    public function cambiarFecha()
    {
        $this->Partidos_m->cambiarFecha($_POST['idPartido'], $_POST['fecha']);
    }

    /**
     * cambiarHora
     * Función que manda al modelo el cambio de hora de un partido.
     */
    public function cambiarHora()
    {
        $this->Partidos_m->cambiarHora($_POST['idPartido'], $_POST['hora']);
    }

    /**
     * resetPartido
     * Función que manda al modelo el reseteo de un partido.
     */
    public function resetPartido()
    {
        $this->Partidos_m->resetPartido($_POST['idPartido']);
    }

    /**
     * generarPDF
     * Función que te genera el PDF del partido.
     * @param  $idpartido
     */
    public function generarPDF($idpartido)
    {
        if (file_exists('assets/pdfPartidos/' . $idpartido . '.pdf')) {
            unlink('assets/pdfPartidos/' . $idpartido . '.pdf');
        } else {
            echo "The file does not exist";
        }


        $mpdf = new \Mpdf\Mpdf(['margin_left' => 0, 'margin_right' => 0, 'margin_top' => 0, 'margin_bottom' => 0, 'margin_header' => 0, 'margin_footer' => 0, 'dpi' => 100]);
        $mpdf->AddPage('L'); // Adds a new page in Landscape orientation
        $partido = $this->Partidos_m->getPartido($idpartido);
        $jugadores = $this->Partidos_m->getJugadoresPartidos($idpartido);
        print_r($jugadores);
        $html = "
        <style>body{box-sizing: border-box;}#contenedor{width: 100%; background: url(" . base_url('assets/img/background-liga.jpg') . ");}#partido{background-color: rgb(35,40,45); margin: 0 auto; width: 100%; padding: 0; height: 100%;}#plataforma{margin: 0 auto; text-align: center; background-color: rgb(35,40,45); width: 100%;}#logo{width: 200px;}#contenedor-equipos{width: 90%; height:25%; margin: 0 auto; background-color: white;}#equipos{width: 100%; float: left;}.equipo{width: 33.14%; height: 35%; border: 1px solid black; float: left; text-align: center;}.escudo{width: 175px; height: 180px;}.vs{margin-top: 50px;}.equipo p{width: 100%; text-align: center;}.resultado{font-size: 20px;}#jugadores_stats{background-color: white; margin: 0 auto; text-align: center; width: 90%; height: 48.6%;}#titulos{width: 100%; margin: 0 auto;}.titulo{float: left; width: 14.28%; font-size: 14px;}#titulos div{width: 14.28%; border-bottom: 1px solid black; float: left; font-size: 14px; margin-bottom: 7px;}#titulos div:last-child{margin-bottom: 0px;}</style> <div id='partido'> <div id='plataforma'> <img id='logo' src='" . base_url('assets/img/logo2.png') . "'> </div><div id='contenedor'> <div id='contenedor-equipos'> <div id='equipos'> <div class='equipo'> <img class='escudo' src='" . base_url($partido->escudo_local) . "'> <p>$partido->equipo_local</p><p class='resultado'>$partido->resultado_local</p></div><div class='equipo'> <img class='escudo vs' src='" . base_url('assets/img/vs.png') . "'> </div><div class='equipo'> <img class='escudo' src='" . base_url($partido->escudo_visitante) . "'> <p>$partido->equipo_visitante</p><p class='resultado'>$partido->resultado_visitante</p></div></div></div><div id='jugadores_stats'> <div id='titulos'><div class='titulo'>Jugador</div><div class='titulo'>Equipo</div><div class='titulo'>Triples Metidos</div><div class='titulo'>Tiros de 2 Metidos</div><div class='titulo'>Tiros libres metidos</div><div class='titulo'>Tapones</div><div class='titulo'>Robos</div>";
        foreach ($jugadores as $jugador) {
            $html .= "<div>$jugador->apenom</div><div>$jugador->equipo</div><div>$jugador->triples_metidos</div><div>$jugador->tiros_2_metidos</div><div>$jugador->tiros_libres_metidos</div><div>$jugador->tapones</div><div>$jugador->robos</div>";
        }
        $html .= "</div></div></div></div>";
        $mpdf->WriteHTML($html);
        $mpdf->Output('C:/xampp/htdocs/TuBasket/assets/pdfPartidos/' . $idpartido . '.pdf', 'F');
    }

    /**
     * EnviarMail
     * Función que Envia el email a los jugadores
     * @param  $id
     * @param  $datos_jugadores
     * @param  $datos_partido
     */
    public function EnviarMail($id, $datos_jugadores, $datos_partido)
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
        //Añadimos el PDF
        $this->email->attach('assets/pdfPartidos/' . $id . '.pdf');

        $this->email->from("tubasket2020@gmail.com", "tubasket2020@gmail.com");

        // Guardamos en un array los correos de los jugadores que han disputado el encuentro
        $array_emails = array();
        foreach ($datos_jugadores as $jugador) {
            array_push($array_emails, $jugador->email);
        }
        //Añadimos también al array a los entrenadores
        $entrenadorlocal = $this->Partidos_m->getEmailEntrenador($datos_partido->id_local);
        $entrenadorvisitante = $this->Partidos_m->getEmailEntrenador($datos_partido->id_visitante);
        if (isset($entrenadorlocal)) {
            array_push($array_emails, $entrenadorlocal->email);
        }
        if (isset($entrenadorvisitante)) {
            array_push($array_emails, $entrenadorvisitante->email);
        }

        // Añadimos el array como destinatario
        $this->email->to($array_emails);
        // Asunto del email
        $this->email->subject("Resultado Partido $datos_partido->equipo_local vs $datos_partido->equipo_visitante Jornada $datos_partido->jornada");
        // Mensaje del email
        $this->email->message("Partido disputado el $datos_partido->fecha a las $datos_partido->hora de la liga $datos_partido->liga");
        // Enviamos EMAIL
        $this->email->send();
    }

    /**
     * getnumeroNotificaciones
     * Función que te devuelve el numero de notificaciones del entrenador.
     */
    public function getnumeroNotificaciones()
    {
        $this->load->model("Notificaciones_m");
        $datos = $this->Notificaciones_m->numeroNotificaciones($_SESSION["equipo"]);
        return $datos;
    }

    /**
     * getNJugadoresPartido
     * Función que te devuelve el numero de jugadores que tiene un partido (si no hay el mínimo no te deja entrar.)
     * @param  $id
     */
    public function getNJugadoresPartido($id)
    {

        $njugadores = $this->Partidos_m->getNJugadoresPartidos($id)->result();
        echo json_encode($njugadores);
    }

    public function obtenerPartidosLiga($liga)
    {
        $partidos = $this->Partidos_m->getPartidos($liga)->result();
        echo json_encode($partidos);
    }
}
