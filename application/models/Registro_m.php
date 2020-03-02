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
        $this->db->insert('admin', $datos);
    }

    public function insert_jugador($datos)
    {
        $this->db->insert('usuarios', $datos);
    }

    public function insert_liga($datos)
    {
        $this->db->insert('liga', $datos);
    }

    public function comprueba_liga($liga, $clave)
    {
        //En caso de que no exista en usuarios comprobamos en tabla admin
        $this->db->where('nombre', $liga);
        $this->db->where('password', $clave);
        $query = $this->db->get('liga');
        if ($query) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function select_liga($liga)
    {
        //En caso de que no exista en usuarios comprobamos en tabla admin
        $this->db->where('nombre', $liga);
        $query = $this->db->get('liga');
        if ($query) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function select_username($username)
    {
        //En caso de que no exista en usuarios comprobamos en tabla admin
        $query = $this->db->get_where('admin', array('username' => $username));
        if ($query) {
            return $query->row();
        } else {
            return false;
        }
    }


    public function select_email($email)
    {
        //En caso de que no exista en usuarios comprobamos en tabla admin
        $query = $this->db->get_where('admin', array('email' => $email));
        if ($query) {
            return $query->row();
        } else {
            return false;
        }
    }
}
