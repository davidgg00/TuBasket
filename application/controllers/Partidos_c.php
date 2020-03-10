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

    public function mostrarPartidos()
    {
        $partidos = $this->Partidos_m->getPartidos($_POST['liga']);
        if ($partidos) {
            echo json_encode($partidos->result());
        } else {
            echo "Nada";
        }
    }


    //MÉTODOS PARTIDO INDIVIDUAL SELECCIONADO
    public function getJugadoresPartidos($id)
    {
        $partidos = $this->Partidos_m->getJugadoresPartidos($id);
        if ($partidos) {
            echo json_encode($partidos->result());
        } else {
            echo "Nada";
        }
    }

    public function getPartido($id)
    {
        $partido = $this->Partidos_m->getPartido($id);
        echo json_encode($partido->result());
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
        $this->load->view("modulos/header_admin", $datos);
        $this->load->view("partido_v");
        $this->load->view("modulos/footer");
    }

    public function enviarResultado($id)
    {
        $this->load->model("Ajax_m");
        //$this->Ajax_m->insertarEstadisticaPartido($id);
        for ($i = 0; $i < count($_POST['miform']); $i++) {

            if ($i % 6 == 0 && $i != 0) {
                $valor = $i;
                $this->Ajax_m->insertarEstadisticaPartido($id, $_POST['miform'][$valor - 6], $_POST['miform'][$valor - 5], $_POST['miform'][$valor - 4], $_POST['miform'][$valor - 3], $_POST['miform'][$valor - 2], $_POST['miform'][$valor - 1]);
            }
            echo $_POST['miform'][$i];
        }
    }
}
