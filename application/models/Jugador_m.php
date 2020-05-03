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

    public function mostrarClasificacion($liga)
    {
        $this->db->where('liga', $liga);
        $this->db->order_by('puntos_clasificacion', 'DESC');
        $query = $this->db->get('view_clasificacion');
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
        $this->db->select('SUM(triples_metidos) AS triples, SUM(tiros_2_metidos) AS tiros_2, SUM(tiros_libres_metidos) AS tiros_libres, SUM(tapones) AS tapones, SUM(robos) AS robos, COUNT(jugador) partidos_jugados FROM `jugador_stats` WHERE jugador="' . $username . '"');
        $query = $this->db->get();
        return $query->row();
    }

    public function getStatsJugadores($username)
    {
        $this->db->select('SUM(triples_metidos) AS triples, SUM(tiros_2_metidos) AS tiros_2, SUM(tiros_libres_metidos) AS tiros_libres, SUM(tapones) AS tapones, SUM(robos) AS robos, COUNT(jugador) partidos_jugados FROM `jugador_stats` WHERE jugador="' . $username . '"');
        $query = $this->db->get();
        return $query->row();
    }

    public function proxPartido($liga, $equipo)
    {
        //Select que te muestra los escudos, la jornada y la fecha de los próximos partidos a disputar del equipo y liga. (Máximo 3 partidos muestra)
        $this->db->select('escudo_local,escudo_visitante,jornada,fecha,hora FROM `view_partidos_liga` where liga = "' . $liga . '" and ((id_local = "' . $equipo . '") or (id_visitante="' . $equipo . '")) AND date(fecha) > "' . date('Y-m-d') . '" AND resultado_local LIKE "" ORDER BY jornada ASC LIMIT 3');
        $query = $this->db->get();
        return $query->result();
    }

    public function getEstadisticasJugadorPartido($username)
    {
        $this->db->select('id_local,equipo_local, id_visitante,equipo_visitante, triples_metidos, tiros_2_metidos, tiros_libres_metidos, tapones, robos');
        $this->db->from('jugador_stats');
        $this->db->join('view_partidos_liga', 'id_partido = id');
        $this->db->where('jugador', $username);
        $query = $this->db->get();
        return $query->result();
    }

    public function getPartidos($liga)
    {
        //Creamos la sentencia sql
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get_where('view_partidos_liga ', array('liga' => $liga));
        //Retornamos
        return $query;
    }

    public function getNumEquipos($liga)
    {
        //Creamos la sentencia sql
        $query = $this->db->get_where('equipo ', array('liga' => $liga));
        //Retornamos
        return $query->num_rows();
    }

    public function getDatosUser($user)
    {
        //Creamos la sentencia sql
        $query = $this->db->get_where('usuarios ', array('username' => $user));
        //Retornamos
        return $query->row();
    }

    public function updateJugador($apenom, $email, $fechanac, $path = null)
    {
        $this->db->set('apenom', $apenom);
        $this->db->set('email', $email);
        $this->db->set('fecha_nac', $fechanac);
        if ($path != null) {
            $this->db->set('imagen', $path);
        }
        $this->db->where('username', $_SESSION['username']);
        $this->db->update('usuarios');

        //Reemplazamos las variables de sesión
        $this->session->set_userdata('apenom', $apenom);
        $this->session->set_userdata('email', $email);
        $this->session->set_userdata('fecha_nac', $fechanac);
    }

    public function actualizarClave($claveAntigua, $claveNueva, $cuenta, $username)
    {
        if ($cuenta != "Admin") {
            $this->db->set('password', $claveNueva);
            $this->db->where('username', $username);
            $this->db->where('password', $claveAntigua);
            $this->db->update('usuarios');
        } else {
            $this->db->set('password', $claveNueva);
            $this->db->where('username', $username);
            $this->db->where('password', $claveAntigua);
            $this->db->update('admin');
        }

        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}
