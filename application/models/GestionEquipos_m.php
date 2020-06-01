<?php
defined('BASEPATH') or exit('No direct script access allowed');

class GestionEquipos_m extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    /**
     * updateEquipo
     * Actualiza los datos de un equipo en la Base de datos
     * @param  $equipo
     * @param  $campo
     * @param  $contenido
     */
    public function updateEquipo($equipo, $campo, $contenido)
    {
        $this->db->set($campo, $contenido);
        $this->db->where('id', $equipo);
        $this->db->update('equipo');
    }

    /**
     * eliminarEquipo
     * Elimina todos los datos de un equipo (pasado por parámetro).
     * @param  $id
     * @return void
     */
    public function eliminarEquipo($id)
    {
        $this->db->delete('equipo', array('id' => $id));
    }

    /**
     * getEquipos
     * Obtiene los equipos de una liga (pasado por parámetro).
     * @param  $liga
     * @return $query
     */
    public function getEquipos($liga)
    {
        //Creamos la sentencia sql
        $query = $this->db->get_where('equipo', array('liga' => $liga));
        return $query;
    }

    /**
     * getEquipo
     * Obtiene los datos de UN equipo (pasado por parámetro).
     * @param  $idequipo
     * @return void
     */
    public function getEquipo($idequipo)
    {
        $query = $this->db->get_where('equipo', array('id' => $idequipo));
        return $query;
    }

    /**
     * getUltimoEquipoInsertado
     * Obtiene los datos del último Equipo Insertado y los retorna
     * @return void
     */
    public function getUltimoEquipoInsertado()
    {
        $this->db->select('*');
        $this->db->from('equipo');
        $this->db->order_by('id', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row();
    }

    /**
     * insertarEquipo
     * Inserta todos los datos de un equipo. (todos los datos a insertar son pasados por parámetros).
     * @param  $equipo
     * @param  $pabellon
     * @param  $ciudad
     * @param  $escudo
     * @param  $liga
     */
    public function insertarEquipo($equipo, $pabellon, $ciudad, $escudo, $liga)
    {
        $data = array(
            'id' => '',
            'equipo' => $equipo,
            'pabellon' => $pabellon,
            'ciudad' => $ciudad,
            'escudo_ruta' => $escudo,
            'liga' => $liga
        );

        $this->db->insert('equipo', $data);
    }

    /**
     * updateImgEquipo
     * Actualiza el escudo de un equipo en la base de datos (la ruta del nuevo escudo y el id del equipo se pasa por parámetro.)
     * @param  $ruta
     * @param  $id
     * @return void
     */
    public function updateImgEquipo($ruta, $id)
    {
        $this->db->set('escudo_ruta', $ruta);
        $this->db->where('escudo_ruta', $id);
        $this->db->update('equipo');
    }

    /**
     * getNPartidosLiga
     * Obtiene el número de partidos que tiene una liga (para comprobar si se han generado los enfrentamientos).
     * @param  $liga
     * @return void
     */
    public function getNPartidosLiga($liga)
    {
        //Vamos a ver si la liga ya tiene unos enfrentamientos generados.
        $query = $this->db->get_where('partido', array('liga' => $liga));
        return $query->num_rows();
    }
}
