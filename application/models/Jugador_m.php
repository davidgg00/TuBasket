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
}
