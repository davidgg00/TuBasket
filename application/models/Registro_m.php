<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Registro_m extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function insert_admin($datos)
    {
        $this->db->insert('usuarios', $datos);
    }

    public function insert_jugador($datos)
    {
        $this->db->insert('usuarios', $datos);
    }

    public function comprueba_liga($liga, $clave)
    {
        $this->db->where('nombre', $liga);
        $this->db->where('password', $clave);
        $query = $this->db->get('liga');
        if ($query) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function select_username($username)
    {
        //Comprobamos si existe el username
        $query = $this->db->get_where('usuarios', array('username' => $username))->row();
        if ($query) {
            return $query;
        }
    }


    public function select_email($email)
    {
        //Comprobamos si existe el email
        $query = $this->db->get_where('usuarios', array('email' => $email))->row();
        if ($query) {
            return $query;
        }
    }
}
