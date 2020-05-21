<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Partidos_m extends CI_Model
{
    function __construct()
    {
        parent::__construct();
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

    public function getEquipos($liga)
    {
        //Creamos la sentencia sql
        $query = $this->db->get_where('equipo ', array('liga' => $liga));
        //Retornamos
        return $query->result();
    }

    public function getJugadoresPartidos($id)
    {
        $this->db->select('apenom,username,equipo.equipo,triples_metidos,tiros_2_metidos,tiros_libres_metidos,tapones,robos');
        $this->db->from('jugador_stats');
        $this->db->join('usuarios', 'username = jugador');
        $this->db->join('equipo', 'usuarios.equipo = equipo.id');
        $this->db->where('id_partido', $id);
        $query = $this->db->get();
        /* Con la anterior consulta se comprueba si hay estadisticas de los jugadores en la tabla jugador_stats
        *  En ese caso, el encuentro se ha disputado pero el admin quiere editar alguna estadística, entonces
        *  Deberá de mostrar las estadísticas REALES del partido y no los campos a 0 */
        if (!empty($query->result())) {
            return $query;
        } else {
            //Si no retorna la anterior consulta nada, es que se va a escribir las estadísticas de un partido NO DISPUTADO.
            return $this->db->get_where('view_jugadores_partidos', array('idpartido' => $id));
        }
    }

    public function obtenerEquiposLiga($liga)
    {
        $query = $this->db->get_where('equipo', array('liga' => $liga));
        return $query->result();
    }

    public function getPartido($id)
    {
        $query = $this->db->get_where('view_partidos_liga', array('id' => $id));
        return $query->row();
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
        //Hacemos un replace si no existen los datos se insertan y si existen es que se va a actualizar alguna estadística
        //Entonces se borra la fila antigua y se inserta la nueva
        $this->db->replace('jugador_stats', $data);
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

    public function resetPartido($id)
    {
        $this->db->set('resultado_local', "");
        $this->db->set('resultado_visitante', "");
        $this->db->where('id', $id);
        $this->db->update('partido');
    }

    //Obtener el email de los jugadores de un encuentro
    public function getEmailJugadores($id)
    {
        $this->db->select('email');
        $this->db->from('jugador_stats');
        $this->db->join('usuarios', 'username = jugador');
        $this->db->join('equipo', 'usuarios.equipo = equipo.id');
        $this->db->where('id_partido', $id);
        $query = $this->db->get();
        return $query->result();
    }

    public function getEmailEntrenador($idequipo)
    {
        $this->db->select('email');
        $this->db->from('usuarios');
        $this->db->where('equipo', $idequipo);
        $this->db->where('tipo', "Entrenador");
        $query = $this->db->get();
        return $query->row();
    }

    public function getNJugadoresPartidos($id)
    {
        $this->db->select('count(*) as totalEquipo');
        $this->db->from('view_jugadores_partidos');
        $this->db->where('idpartido', $id);
        $this->db->group_by('idequipo');
        $query = $this->db->get();
        return $query;
    }
}
