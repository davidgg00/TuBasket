<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jugador_m extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function mostrar_ligas($username)
    {
        $this->db->where('administrador', $username);
        $query = $this->db->get('liga');
        return $query->result();
    }

    public function obtenerEquipos($liga)
    {
        $query = $this->db->get_where('equipo', array('liga' => $liga));
        return $query->result();
    }

    public function unirseEquipo($equipo, $username)
    {
        $this->db->set('equipo', $equipo);
        $this->db->where('username', $username);
        $this->db->update('usuarios');
    }

    public function getStats($username)
    {
        $query = $this->db->get_where('jugador_stats', array('jugador' => $username));
        return $query;
    }

    public function proxPartido($liga, $equipo)
    {
        //Select que te muestra los escudos, la jornada y la fecha de los próximos partidos a disputar del equipo y liga. (Máximo 3 partidos muestra)
        $this->db->select('escudo_local,escudo_visitante,jornada,fecha,hora FROM `view_partidos_liga` where liga = "' . $liga . '" and ((id_local = "' . $equipo . '") or (id_visitante="' . $equipo . '")) AND date(fecha) > date(curdate()) AND resultado_local LIKE "" ORDER BY jornada ASC LIMIT 3');
        $query = $this->db->get();
        return $query->result();
    }
}
