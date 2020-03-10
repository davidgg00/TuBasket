<?php
defined('BASEPATH') or exit('No direct script access allowed');

class GestionJugadores_m extends CI_Model
{
    function __construct()
    {
        parent::__construct();
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


    public function getJugadoresConfirmados($liga)
    {
        //Creamos la sentencia sql
        $this->db->select('*');
        $this->db->from('view_usuarios_liga');
        $this->db->where("liga", $liga);
        $this->db->where("validado", 1);
        $this->db->order_by('equipo', 'ASC');
        $query = $this->db->get();
        //Retornamo resultado
        return $query;
    }
}
