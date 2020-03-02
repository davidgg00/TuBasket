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
        return $query->result();
    }

    public function num_equipos_liga($liga)
    {
        //Creamos la sentencia sql
        $query = $this->db->get_where('equipo', array('liga' => $liga));
        //Retornamos el numero de filas
        return $query->num_rows();
    }

    public function getJugadoresSinConfirmar($liga)
    {
        //Creamos la sentencia sql
        $this->db->select('*');
        $this->db->from('view_usuarios_liga');
        $this->db->where("liga", $liga);
        $this->db->where("validado", 0);
        $query = $this->db->get();
        //Retornamo resultado
        return $query;
    }

    public function getJugadoresConfirmados($liga)
    {
        //Creamos la sentencia sql
        $this->db->select('*');
        $this->db->from('view_usuarios_liga');
        $this->db->where("liga", $liga);
        $this->db->where("validado", 1);
        $query = $this->db->get();
        //Retornamo resultado
        return $query;
    }

    public function aceptarJugador($username)
    {
        $this->db->set('validado', 1);
        $this->db->where('username', $username);
        $this->db->update('usuarios');
    }

    public function denegarJugador($username)
    {
        $this->db->where('username', $username);
        $this->db->delete('usuarios');
    }
}
