<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Partidos_m extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function getJugadoresPartidos($id)
    {
        //Creamos la sentencia sql
        $query = $this->db->get_where('view_usuarios_partidos', array('idpartido' => $id));
        return $query;
    }

    public function obtenerEquiposLiga($liga)
    {
        $query = $this->db->get_where('equipo', array('liga' => $liga));
        return $query->result();
    }

    public function getPartido($id)
    {
        //Creamos la sentencia sql
        $this->db->select('e.equipo, e.escudo_ruta, e.id');
        $this->db->from('equipo e');
        $this->db->join('partido p', 'p.local = e.id or p.visitante = e.id');
        $this->db->where('p.id', $id);
        $query = $this->db->get();
        return $query;
    }

    public function insertarEstadisticaPartido($id, $jugador, $triples, $tiros2, $tiroslibres, $tapones, $robos)
    {
        $data = array(
            'id_partido' => $id,
            'jugador' => $jugador,
            'triples_metidos' => $triples,
            'tiros_2_metidos' => $tiros2,
            'tiros_libres_metidos' => $tiroslibres,
            'tapones' => $tapones,
            'robos' => $robos
        );

        $this->db->insert('jugador_stats', $data);
    }

    public function insertPartidos($local, $visitante, $jornada, $liga)
    {
        $data = array(
            'id' => null,
            'local' => $local,
            'visitante' => $visitante,
            'jornada' => $jornada,
            'liga' => $liga,
        );

        $this->db->insert('partido', $data);
    }

    public function insertarResultadoPartido($id, $local, $visitante)
    {
        $this->db->set('resultado_local', $local);
        $this->db->set('resultado_visitante', $visitante);
        $this->db->where('id', $id);
        $this->db->update('partido');
    }

    public function cambiarFecha($idPartido, $fecha)
    {
        $this->db->set('fecha', $fecha);
        $this->db->where('id', $idPartido);
        $this->db->update('partido');
    }

    public function cambiarHora($idPartido, $hora)
    {
        $this->db->set('hora', $hora);
        $this->db->where('id', $idPartido);
        $this->db->update('partido');
    }
}
