<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jugador_m extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    /**
     * mostrarClasificacion
     * Retorna los datos de la clasificación de una liga (pasada por parámetro).
     * @param  $liga
     * @return $query->result()
     */
    public function mostrarClasificacion($liga)
    {
        $this->db->select("v.*, e.escudo_ruta");
        $this->db->join('equipo e', 'e.equipo = v.equipo');
        $this->db->where('v.liga', $liga);
        $this->db->order_by('puntos_clasificacion', 'DESC');
        $query = $this->db->get('view_clasificacion v');
        return $query->result();
    }

    /**
     * obtenerEquipos
     * Obtiene los equipos de una liga (Pasada por parámetros).
     * @param  $liga
     * @return  $query->result()
     */
    public function obtenerEquipos($liga)
    {
        $query = $this->db->get_where('equipo', array('liga' => $liga));
        return $query->result();
    }

    /**
     * unirseEquipo
     * Actualiza el equipo de un jugador pasando de NULL a el id del equipo.
     * @param  $equipo
     * @param  $username
     */
    public function unirseEquipo($equipo, $username)
    {
        $this->db->set('equipo', $equipo);
        $this->db->where('username', $username);
        $this->db->update('usuarios');
    }

    /**
     * getStats
     * Obtiene las estadísticas TOTALES de un jugador (pasado por parámetro)
     * @param  $username
     * @return $query->row()
     */
    public function getStats($username)
    {
        $this->db->select('SUM(triples_metidos) AS triples, SUM(tiros_2_metidos) AS tiros_2, SUM(tiros_libres_metidos) AS tiros_libres, SUM(tapones) AS tapones, SUM(robos) AS robos, COUNT(jugador) partidos_jugados FROM `jugador_stats` WHERE jugador="' . $username . '"');
        $query = $this->db->get();
        return $query->row();
    }

    /**
     * proxPartido
     *  Retorna los escudos, la jornada, fecha de los próximos partidos a disputar del equipo y liga.
     * @param  $liga
     * @param  $equipo
     */
    public function proxPartido($liga, $equipo)
    {
        //Select que te muestra los escudos, la jornada y la fecha de los próximos partidos a disputar del equipo y liga. (Máximo 3 partidos muestra)
        $this->db->select('escudo_local,escudo_visitante,jornada,fecha,hora FROM `view_partidos_liga` where liga = "' . $liga . '" and ((id_local = "' . $equipo . '") or (id_visitante="' . $equipo . '")) AND date(fecha) > "' . date('Y-m-d') . '" AND resultado_local LIKE "" ORDER BY jornada ASC LIMIT 3');
        $query = $this->db->get();
        //Si la consulta no devuelve nada, vamos a probar si es porque las fechas no están puestas todavía
        if ($query->num_rows() == 0) {
            $query = $this->db->select('escudo_local,escudo_visitante,jornada,fecha,hora FROM `view_partidos_liga` where liga = "' . $liga . '" and ((id_local = "' . $equipo . '") or (id_visitante="' . $equipo . '")) AND resultado_local LIKE "" ORDER BY jornada ASC LIMIT 3');
            $query = $this->db->get();
        }
        return $query->result();
    }

    /**
     * getEstadisticasJugadorPartido
     * Retorna las estadísticas de CADA partido de un jugador (pasado por parámetro).
     * @param  $username
     * @return $query->result()
     */
    public function getEstadisticasJugadorPartido($username)
    {
        $this->db->select('id_local,equipo_local, id_visitante,equipo_visitante, triples_metidos, tiros_2_metidos, tiros_libres_metidos, tapones, robos');
        $this->db->from('jugador_stats');
        $this->db->join('view_partidos_liga', 'id_partido = id');
        $this->db->where('jugador', $username);
        $query = $this->db->get();
        return $query->result();
    }


    /**
     * getDatosUser
     * Retorna los datos de un usuario (pasado por parámetro).
     * @param $user
     * @return $query->row()
     */
    public function getDatosUser($user)
    {
        //Creamos la sentencia sql
        $query = $this->db->get_where('usuarios ', array('username' => $user));
        //Retornamos
        return $query->row();
    }

    /**
     * getEntrenadorJugador
     * Retorna el entrenador que tiene un jugador.
     * @param  $jugador
     * @return $query->row()
     */
    public function getEntrenadorJugador($jugador)
    {
        $this->db->select('u2.username as `Entrenador`');
        $this->db->from('usuarios u');
        $this->db->join('usuarios u2', 'u2.equipo = u.equipo');
        $this->db->where('u.username', $jugador);
        $this->db->where('u2.tipo', "Entrenador");
        $query = $this->db->get();
        return $query->row();
    }

    /**
     * getNJugadoresEquipos
     * Retorna el número de jugadores que tiene un equipo.
     * @param  $liga
     * @return $query->result()
     */
    public function getNJugadoresEquipos($liga)
    {
        $this->db->select('equipo,count(*) as total');
        $this->db->from('usuarios');
        $this->db->where('tipo', "Jugador");
        $this->db->where('liga', $liga);
        $this->db->group_by('equipo');
        $query = $this->db->get();
        return $query->result();
    }
}
