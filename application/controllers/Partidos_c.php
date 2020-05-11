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

    //Función que devuelve el calendario de partidos y nos la muestra en una vista.
    public function partidos($liga = null)
    {
        //Si no se pasa ningún parámetro es que el nombre de liga lo tenemos en la sesión (cuentas jugador y entrenador)
        if ($liga == null) {
            $liga = $_SESSION['liga'];
        }
        $datos["liga"] = $liga;
        $datos["partidos"] = self::mostrarPartidos($liga);
        $datos["nequipos"] = self::numeroEquiposLiga($liga);
        $this->load->view("modulos/head", array("css" => array("liga", "partidos")));
        $this->load->view("modulos/header", $datos);
        $this->load->view('partidos_v');
        $this->load->view("modulos/footer");
    }

    //Función que devuelve el calendario de partidos de una liga
    public function mostrarPartidos($liga)
    {
        $partidos = $this->Partidos_m->getPartidos($liga);
        return $partidos->result();
    }

    public function numeroEquiposLiga($liga)
    {
        $nequipos = $this->Partidos_m->getNumEquipos($liga);
        return $nequipos;
    }

    //MÉTODOS PARTIDO INDIVIDUAL SELECCIONADO
    public function getJugadoresPartidos($id)
    {
        $partidos = $this->Partidos_m->getJugadoresPartidos($id);
        return $partidos;
    }

    public function getPartido($id)
    {
        $partido = $this->Partidos_m->getPartido($id);
        return $partido;
    }

    public function insertarResultadoEquipos()
    {
        $this->Partidos_m->insertarResultadoPartido($_POST['id'], $_POST['equipolocal'], $_POST['equipovisitante']);
        echo "Insertado";
    }

    function generarLiga($liga)
    {
        //obtenemos todos los equipos de la liga que queremos
        $data = $this->Partidos_m->obtenerEquiposLiga($liga);
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

    public function resultadoPartido($liga, $id)
    {
        $datos['liga'] = $liga;
        $datos['id'] = $id;
        $datos['equipos'] = self::getPartido($id);
        $datos['jugadores'] = self::getJugadoresPartidos($id);
        $this->load->view("modulos/head", array("css" => array("liga", "partido")));
        $this->load->view("modulos/header", $datos);
        $this->load->view("partido_v");
        $this->load->view("modulos/footer");
    }

    public function enviarResultado($id)
    {
        //Bucle que recorre los tr y TD que se han enviado para después enviarlos al MODELO
        for ($i = 0; $i <= count($_POST['miform']); $i++) {
            if ($i % 6 == 0 && $i != 0) {
                $valor = $i;
                $this->Partidos_m->insertarEstadisticaPartido($id, $_POST['miform'][$valor - 6], $_POST['miform'][$valor - 5], $_POST['miform'][$valor - 4], $_POST['miform'][$valor - 3], $_POST['miform'][$valor - 2], $_POST['miform'][$valor - 1]);
            }
        }
        $datos_jugadores = $this->Partidos_m->getEmailJugadores($id);
        $datos_partido = $this->Partidos_m->getPartido($id);
        self::generarPDF($_POST['html'], $id);
        self::EnviarMail($id, $datos_jugadores, $datos_partido);
    }

    public function cambiarFecha()
    {
        $this->Partidos_m->cambiarFecha($_POST['idPartido'], $_POST['fecha']);
    }

    public function cambiarHora()
    {
        $this->Partidos_m->cambiarHora($_POST['idPartido'], $_POST['hora']);
    }

    public function resetPartido()
    {
        $this->Partidos_m->resetPartido($_POST['idPartido']);
    }

    public function generarPDF($documento, $idpartido)
    {
        unlink('assets/pdfPartidos/' . $idpartido . '.pdf');

        $mpdf = new \Mpdf\Mpdf(['margin_left' => 0, 'margin_right' => 0, 'margin_top' => 0, 'margin_bottom' => 0, 'margin_header' => 0, 'margin_footer' => 0, 'dpi' => 100]);
        $mpdf->AddPage('L'); // Adds a new page in Landscape orientation
        $partido = $this->Partidos_m->getPartido($idpartido);
        $jugadores = $this->Partidos_m->getJugadoresPartidos($idpartido);
        $html = "
        <style>body{box-sizing: border-box;}#contenedor{width: 100%; background: url(" . base_url('assets/img/background-liga.jpg') . ");}#partido{background-color: rgb(35,40,45); margin: 0 auto; width: 100%; padding: 0; height: 100%;}#plataforma{margin: 0 auto; text-align: center; background-color: rgb(35,40,45); width: 100%;}#logo{width: 200px;}#contenedor-equipos{width: 90%; height:25%; margin: 0 auto; background-color: white;}#equipos{width: 100%; float: left;}.equipo{width: 33.14%; height: 35%; border: 1px solid black; float: left; text-align: center;}.escudo{width: 175px; height: 180px;}.vs{margin-top: 50px;}.equipo p{width: 100%; text-align: center;}.resultado{font-size: 20px;}#jugadores_stats{background-color: white; margin: 0 auto; text-align: center; width: 90%; height: 48.6%;}#titulos{width: 100%; margin: 0 auto;}.titulo{float: left; width: 14.28%; font-size: 14px;}#titulos div{width: 14.28%; border-bottom: 1px solid black; float: left; font-size: 14px; margin-bottom: 7px;}#titulos div:last-child{margin-bottom: 0px;}</style> <div id='partido'> <div id='plataforma'> <img id='logo' src='" . base_url('assets/img/logo2.png') . "'> </div><div id='contenedor'> <div id='contenedor-equipos'> <div id='equipos'> <div class='equipo'> <img class='escudo' src='" . base_url($partido->escudo_local) . "'> <p>$partido->equipo_local</p><p class='resultado'>$partido->resultado_local</p></div><div class='equipo'> <img class='escudo vs' src='" . base_url('assets/img/vs.png') . "'> </div><div class='equipo'> <img class='escudo' src='" . base_url($partido->escudo_visitante) . "'> <p>$partido->equipo_visitante</p><p class='resultado'>$partido->resultado_visitante</p></div></div></div><div id='jugadores_stats'> <div id='titulos'><div class='titulo'>Jugador</div><div class='titulo'>Equipo</div><div class='titulo'>Triples Metidos</div><div class='titulo'>Tiros de 2 Metidos</div><div class='titulo'>Tiros libres metidos</div><div class='titulo'>Tapones</div><div class='titulo'>Robos</div>";
        foreach ($jugadores as $jugador) {
            $html .= "<div>$jugador->apenom</div><div>$jugador->equipo</div><div>$jugador->triples_metidos</div><div>$jugador->tiros_2_metidos</div><div>$jugador->tiros_libres_metidos</div><div>$jugador->tapones</div><div>$jugador->robos</div>";
        }
        $html .= "</div></div></div></div>";
        $resultado = preg_replace('/<button id="boton" type="button" class="btn btn-outline-success btn-lg mx-auto">Guardar Partido<\/button>/i', '', $documento);
        $resultado = preg_replace('/<td class="d-none">(.*?)<\/td>/i', '', $resultado);
        $mpdf->WriteHTML($html);
        $mpdf->Output('C:/xampp/htdocs/TuBasket/assets/pdfPartidos/' . $idpartido . '.pdf', 'F');
    }

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
}
