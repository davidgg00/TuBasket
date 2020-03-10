<?php
defined('BASEPATH') or exit('No direct script access allowed');

class GestionEquipos_m extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function updateEquipo($equipo, $campo, $contenido)
    {
        $this->db->set($campo, $contenido);
        $this->db->where('id', $equipo);
        $this->db->update('equipo');
    }

    public function eliminarEquipo($id)
    {
        $this->db->delete('equipo', array('id' => $id));
    }

    public function getEquipos($liga)
    {
        //Creamos la sentencia sql
        $query = $this->db->get_where('equipo', array('liga' => $liga));
        return $query;
    }

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

    public function updateImgEquipo($ruta, $id)
    {
        $this->db->set('escudo_ruta', $ruta);
        $this->db->where('escudo_ruta', $id);
        $this->db->update('equipo');
    }
}
