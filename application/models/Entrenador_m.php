<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Entrenador_m extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    /**
     * proxPartido
     * Retorna los 3 próximos partidos de una liga y equipo en específico (pasado por parámetro).
     * @param  $liga
     * @param  $equipo
     * @return $query->result();
     */
    public function proxPartido($liga, $equipo)
    {
        //Select que te muestra los escudos, la jornada y la fecha de los próximos partidos a disputar del equipo y liga. (Máximo 3 partidos muestra)
        $this->db->select('escudo_local,escudo_visitante,jornada,fecha,hora FROM `view_partidos_liga` where liga = "' . $liga . '" and ((id_local = "' . $equipo . '") or (id_visitante="' . $equipo . '")) AND date(fecha) > "' . date('Y-m-d') . '" AND resultado_local LIKE "" ORDER BY jornada ASC LIMIT 3');
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * obtenerEquipos
     * Retorna los equipos de una liga (pasada por parámetros).
     * @param  $liga
     * @return $query->result()
     */
    public function obtenerEquipos($liga)
    {
        $query = $this->db->get_where('equipo', array('liga' => $liga));
        return $query->result();
    }

    /**
     * getDatosEntrenador
     * Retorna los datos del Entrenador de un equipo.
     * @param  $user
     * @return $query->row()
     */
    public function getDatosEntrenador($user)
    {
        //Creamos la sentencia sql
        $query = $this->db->get_where('usuarios ', array('username' => $user));
        //Retornamos
        return $query->row();
    }

    /**
     * obtenerJugadoresEquipo
     * Retorna los jugadores de un equipo en específico (pasado por parámetros).
     * @param  $idequipo
     * @return $query->result()
     */
    public function obtenerJugadoresEquipo($idequipo)
    {
        //Creamos la sentencia sql
        $query = $this->db->get_where('view_usuarios_liga ', array('equipo' => $idequipo));
        //Retornamos
        return $query->result();
    }


    /**
     * verFichajes
     * Retorna TODOS los fichajes (ya sean PENDIENTES,ACEPTADOS O DENEGADOS) de un entrenador (dando igual si ha pedido un fichaje o se lo han pedido)-
     * @param  $username
     * @return $resultado->result()
     */
    public function verFichajes($username)
    {
        $this->db->select('f.entrenadorSolicita AS `entrenadorSolicita`, f.username_jugador1 AS `pide`,u.imagen as `img_jugador_pide`, f.username_jugador2 AS `ofrece`, u2.imagen as `img_jugador_ofrece`, f.EntrenadorRecibe AS `EntrenadorRecibe`,e.equipo AS `equipoSolicitante`, f.id as `idfichaje`, f.estado as `estado`');
        $this->db->from('fichajes f');
        $this->db->join('usuarios u', 'u.username = f.username_jugador1');
        $this->db->join('usuarios u2', 'u2.username = f.username_jugador2');
        $this->db->join('usuarios u3', 'u3.username = f.EntrenadorSolicita');
        $this->db->join('usuarios u4', 'u4.username = f.EntrenadorRecibe');
        $this->db->join('equipo e', 'e.id = u3.equipo');
        $this->db->where("(f.entrenadorSolicita='$username') OR (f.EntrenadorRecibe='$username')", NULL, FALSE);
        $this->db->order_by('f.id', 'DESC');
        $this->db->order_by('f.id', 'DESC');
        $resultado = $this->db->get();
        return $resultado->result();
    }

    /**
     * getGanador
     * Método que retorna el ganador de la liga (si no hay ganador, estará vacía.)
     * @param  $liga
     * @return $query->row();
     */
    public function getGanador($liga)
    {
        $this->db->select("e.equipo, e.escudo_ruta");
        $this->db->join('equipo e', 'e.id = l.ganador');
        $this->db->where('l.nombre', $liga);
        $this->db->where('l.ganador !=', "");
        $query = $this->db->get('liga l');
        return $query->row();
    }
}
