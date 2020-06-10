<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Partidos_m extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    /**
     * getPartidos
     * Obtiene los partidos de una liga (pasada por parámetros).
     * @param  $liga
     * @return $query
     */
    public function getPartidos($liga)
    {
        //Creamos la sentencia sql
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get_where('view_partidos_liga ', array('liga' => $liga));
        //Retornamos
        return $query;
    }

    /**
     * getNumEquipos
     * Obtiene el número de equipos que tiene una liga (pasada por parámetros).
     * @param  $liga
     * @return $query->num_rows()
     */
    public function getNumEquipos($liga)
    {
        //Creamos la sentencia sql
        $query = $this->db->get_where('equipos ', array('liga' => $liga));
        //Retornamos
        return $query->num_rows();
    }

    /**
     * getEquipos
     * Retorna los equipos de una liga (pasada por parámetro).
     * @param  $liga
     * @return  $query->result()
     */
    public function getEquipos($liga)
    {
        //Creamos la sentencia sql
        $query = $this->db->get_where('equipos ', array('liga' => $liga));
        //Retornamos
        return $query->result();
    }

    /**
     * getJugadoresPartidos
     * Retorna los jugadores que disputan un partido (se pasa por parámetro la ID del PARTIDO).
     * @param  $id
     * @return $query->result()
     */
    public function getJugadoresPartidos($id)
    {
        $this->db->select('apenom,username,equipos.equipo,triples_metidos,tiros_2_metidos,tiros_libres_metidos,tapones,robos');
        $this->db->from('jugador_stats');
        $this->db->join('usuarios', 'username = jugador');
        $this->db->join('equipos', 'usuarios.equipo = equipos.id');
        $this->db->where('id_partido', $id);
        $query = $this->db->get();
        /* Con la anterior consulta se comprueba si hay estadisticas de los jugadores en la tabla jugador_stats
        *  En ese caso, el encuentro se ha disputado pero el admin quiere editar alguna estadística, entonces
        *  Deberá de mostrar las estadísticas REALES del partido y no los campos a 0 */
        if (!empty($query->result())) {
            return $query->result();
        } else {
            //Si no retorna la anterior consulta nada, es que se va a escribir las estadísticas de un partido NO DISPUTADO.
            return $this->db->get_where('view_jugadores_partidos', array('idpartido' => $id))->result();
        }
    }

    /**
     * getPartido
     * Retorna los datos de un partido (se pasa por parámetros el id del partido)
     * @param  $id
     * @return  $query->row()
     */
    public function getPartido($id)
    {
        $query = $this->db->get_where('view_partidos_liga', array('id' => $id));
        return $query->row();
    }

    /**
     * insertarEstadisticaPartido
     * Inserta las estadísticas de UN JUGADOR en la base de datos
     * @param  $id
     * @param  $jugador
     * @param  $triples
     * @param  $tiros2
     * @param  $tiroslibres
     * @param  $tapones
     * @param  $robos
     */
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

    /**
     * insertPartidos
     * Inserta un partido (al generarse la liga)
     * @param  $local
     * @param  $visitante
     * @param  $jornada
     * @param  $liga
     */
    public function insertPartidos($local, $visitante, $jornada, $liga)
    {
        $data = array(
            'id' => null,
            'local' => $local,
            'visitante' => $visitante,
            'jornada' => $jornada,
            'liga' => $liga,
        );

        $this->db->insert('partidos', $data);
    }

    /**
     * insertarResultadoPartido
     * Actualiza el resultado de un enfrentamiento.
     * @param  $id
     * @param  $local
     * @param  $visitante
     */
    public function insertarResultadoPartido($id, $local, $visitante)
    {
        $this->db->set('resultado_local', $local);
        $this->db->set('resultado_visitante', $visitante);
        $this->db->where('id', $id);
        $this->db->update('partidos');
    }

    /**
     * cambiarFecha
     * Actualiza la fecha de un encuentro.
     * @param  $idPartido
     * @param  $fecha
     */
    public function cambiarFecha($idPartido, $fecha)
    {
        $this->db->set('fecha', $fecha);
        $this->db->where('id', $idPartido);
        $this->db->update('partidos');
    }

    /**
     * cambiarHora
     * Actualiza la hora de un encuentro
     * @param  $idPartido
     * @param  $hora
     */
    public function cambiarHora($idPartido, $hora)
    {
        $this->db->set('hora', $hora);
        $this->db->where('id', $idPartido);
        $this->db->update('partidos');
    }

    /**
     * resetPartido
     * Resetea un partido y pone los resultados a null.
     * @param  $id
     */
    public function resetPartido($id)
    {
        $this->db->set('resultado_local', "");
        $this->db->set('resultado_visitante', "");
        $this->db->where('id', $id);
        $this->db->update('partidos');
    }

    /**
     * getEmailJugadores
     * Retorna los emails de los jugadores de un encuentro.
     * @param  $id
     * @return $query->result();
     */
    public function getEmailJugadores($id)
    {
        $this->db->select('email');
        $this->db->from('jugador_stats');
        $this->db->join('usuarios', 'username = jugador');
        $this->db->join('equipos', 'usuarios.equipo = equipos.id');
        $this->db->where('id_partido', $id);
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * getEmailEntrenador
     * Retorna el email del entrenador de un equipo
     * @param  $idequipo
     * @return $query->row();
     */
    public function getEmailEntrenador($idequipo)
    {
        $this->db->select('email');
        $this->db->from('usuarios');
        $this->db->where('equipo', $idequipo);
        $this->db->where('tipo', "Entrenador");
        $query = $this->db->get();
        return $query->row();
    }

    /**
     * getNJugadoresPartidos
     * Retorna el numero de jugadores qaue disputa un partido.
     * @param  $id
     * @return $query
     */
    public function getNJugadoresPartidos($id)
    {
        $this->db->select('count(*) as totalEquipo');
        $this->db->from('view_jugadores_partidos');
        $this->db->where('idpartido', $id);
        $this->db->group_by('idequipo');
        $query = $this->db->get();
        return $query;
    }

    /**
     * getNPartidosJugados
     * Retorna el numero de partidos que se ha jugado en la liga
     * @param  $liga
     * @return $query->row()
     */
    public function getNPartidosJugados($liga)
    {
        $this->db->select('count(*) as total');
        $this->db->where('liga', $liga);
        $this->db->where('resultado_local !=', '');
        $this->db->from('partidos');
        $query = $this->db->get();
        return $query->row();
    }

    /**
     * num_equipos_liga
     * Retorna el numero de equipos que tiene una liga (pasada por parámetro).
     * @param  $liga
     * @return $query->num_rows();
     */
    public function num_equipos_liga($liga)
    {
        //Creamos la sentencia sql
        $query = $this->db->get_where('equipos', array('liga' => $liga));
        //Retornamos el numero de filas
        return $query->num_rows();
    }

    public function definirGanador($liga)
    {

        //obtenemos al primer clasificado
        $this->db->select("v.*, e.escudo_ruta, e.id as idequipo");
        $this->db->join('equipos e', 'e.id = v.idequipo');
        $this->db->where('v.liga', $liga);
        $this->db->order_by('puntos_clasificacion', 'DESC');
        $this->db->order_by('puntos_favor ', 'DESC');
        $this->db->limit(1);
        $ganador = $this->db->get('view_clasificacion v')->row();
        $this->db->set('ganador', $ganador->idequipo);
        $this->db->where('nombre', $liga);
        $this->db->update('liga');
    }
}
