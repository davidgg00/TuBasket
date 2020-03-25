<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_m extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function mostrar_ligas($username)
    {
        $this->db->where('administrador', $username);
        $query = $this->db->get('liga');
        return $query;
    }

    public function getProx5Partidos($liga)
    {
        $this->db->select('*');
        $this->db->where('liga', $liga);
        $this->db->order_by('jornada', 'ASC');
        $this->db->order_by('fecha', 'ASC');
        $this->db->limit(4);
        $query = $this->db->get('view_partidos_liga');
        return $query->result();
    }

    public function num_equipos_liga($liga)
    {
        //Creamos la sentencia sql
        $query = $this->db->get_where('equipo', array('liga' => $liga));
        //Retornamos el numero de filas
        return $query->num_rows();
    }
}
