<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Entrenador_m extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function proxPartido($liga, $equipo)
    {
        //Select que te muestra los escudos, la jornada y la fecha de los próximos partidos a disputar del equipo y liga. (Máximo 3 partidos muestra)
        $this->db->select('escudo_local,escudo_visitante,jornada,fecha,hora FROM `view_partidos_liga` where liga = "' . $liga . '" and ((id_local = "' . $equipo . '") or (id_visitante="' . $equipo . '")) AND date(fecha) > "' . date('Y-m-d') . '" AND resultado_local LIKE "" ORDER BY jornada ASC LIMIT 3');
        $query = $this->db->get();
        return $query->result();
    }

    public function obtenerEquipos($liga)
    {
        $query = $this->db->get_where('equipo', array('liga' => $liga));
        return $query->result();
    }

    public function getDatosEntrenador($user)
    {
        //Creamos la sentencia sql
        $query = $this->db->get_where('usuarios ', array('username' => $user));
        //Retornamos
        return $query->row();
    }

    public function obtenerJugadoresEquipo($idequipo)
    {
        //Creamos la sentencia sql
        $query = $this->db->get_where('view_usuarios_liga ', array('equipo' => $idequipo));
        //Retornamos
        return $query->result();
    }


    public function verFichajes($idequipo)
    {
        $this->db->select('e.id as `idEquipoSolicitante` , e.equipo AS `equipoSolicitante`, f.username_jugador1 AS `pide`,u.imagen as `img_jugador_pide`, f.username_jugador2 AS `ofrece`, u2.imagen as `img_jugador_ofrece`, e2.id AS `idEquipoRecibe`,e2.equipo AS `equipoRecibe`, f.id as `idfichaje`, f.estado as `estado`, f.leidoEntrenadorSolicita, f.leidoEntrenadorRecibe');
        $this->db->from('fichajes f');
        $this->db->join('equipo e', 'e.id = f.IdEquipoSolicita');
        $this->db->join('equipo e2', 'e2.id = f.IdEquipoRecibe');
        $this->db->join('usuarios u', 'u.username = f.username_jugador1');
        $this->db->join('usuarios u2', 'u2.username = f.username_jugador2');
        $this->db->where("(f.idEquipoSolicita='$idequipo') OR (f.IdEquipoRecibe='$idequipo')", NULL, FALSE);
        $this->db->order_by('f.id', 'DESC');
        $this->db->order_by('f.id', 'DESC');
        $resultado = $this->db->get();
        return $resultado->result();
    }
}
