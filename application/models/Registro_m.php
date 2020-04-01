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
        //Comprobamos si existe el email tanto de cuenta administrador como de cuenta jugador
        $queryAdmin = $this->db->get_where('admin', array('username' => $username))->row();
        $queryUsuarios = $this->db->get_where('usuarios', array('username' => $username))->row();
        if ($queryAdmin) {
            return $queryAdmin;
        }
        if ($queryUsuarios) {
            return $queryUsuarios;
        }
    }


    public function select_email($email)
    {
        //Comprobamos si existe el email tanto de cuenta administrador como de cuenta jugador
        $queryAdmin = $this->db->get_where('admin', array('email' => $email))->row();
        $queryUsuarios = $this->db->get_where('usuarios', array('email' => $email))->row();
        if ($queryAdmin) {
            return $queryAdmin;
        }
        if ($queryUsuarios) {
            return $queryUsuarios;
        }
    }
}
