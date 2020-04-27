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

    //MÉTODOS PARTIDO INDIVIDUAL SELECCIONADO
    public function getJugadoresPartidos($id)
    {
        $partidos = $this->Partidos_m->getJugadoresPartidos($id);
        echo json_encode($partidos);
    }

    public function getPartido($id)
    {
        $partido = $this->Partidos_m->getPartido($id);
        echo json_encode($partido);
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
        $equipos = array();
        $equipos2 = $equipos;
        foreach ($data as $dato) {
            $equipos[] = $dato->id;
            $equipos2[] = $dato->equipo;
        }
        for ($i = 1; $i < count($equipos); $i++) {
            echo "-----------------JORNADA " . $i . "-------------------";
            echo "<br>";
            shuffle($equipos);
            for ($j = 0; $j < count($equipos);) {
                $local =  $equipos[$j];
                $j++;
                $visitante = $equipos[$j++];
                $jornada = $i;
                $this->Partidos_m->insertPartidos($local, $visitante, $jornada, $liga);
            }
        }
    }

    function resultadoPartido($liga, $id)
    {
        $datos['liga'] = $liga;
        $datos['id'] = $id;
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
        $html =
            "<style>

            #equipos {
                width: 290mm;
                margin: 0 auto;
                height: 60mm;
            }
        
            .equipo {
                width: 95mm;
                float: left;
                text-align:center;
                height: 60mm;
            }

            #img-vs {
                margin-top:10mm;
            }
        
            img {
                display: block;
                width: 150px;
                height: 150px;
                margin: 0 auto;
            }
        
            div.equipo p {
                width: 100%;
                text-align: center;
            }

            #jugadores_stats {
                width: 290mm;
                height: 140mm;
                border:2px solid green;
            }
        
            table {
                width: 290mm;
            }
            tr td {
                text-align: center;
            }

            tr td input {
                text-align: center;
                border: 0;
            }
            </style>";
        $resultado = preg_replace('/<button id="boton" type="button" class="btn btn-outline-success btn-lg mx-auto">Guardar Partido<\/button>/i', '', $documento);
        $resultado = preg_replace('/<td class="d-none">(.*?)<\/td>/i', '', $resultado);
        $html .= $resultado;
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
        array_push($array_emails, $entrenadorlocal->email);
        array_push($array_emails, $entrenadorvisitante->email);

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
