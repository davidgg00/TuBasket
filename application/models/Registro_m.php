<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Registro_m extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    /**
     * insert_admin
     * inserta los datos de un admin a su tabla
     * @param  $datos
     */
    public function insert_admin($datos)
    {
        $this->db->insert('usuarios', $datos);
    }

    /**
     * insert_jugador
     * inserta los datos de un usuario a su tabla
     * @param  $datos
     */
    public function insert_jugador($datos)
    {
        $this->db->insert('usuarios', $datos);
    }

    /**
     * comprueba_liga
     * Comprueba si el nombre de liga y contraseña es correcto para que el usuario tipo Entrenador O Jugador pueda solicitar unirse
     * @param  $liga
     * @param  $clave
     * @return $query->row() OR false
     */
    public function comprueba_liga($liga, $clave)
    {
        $this->db->where('nombre', $liga);
        $this->db->where('password', $clave);
        $query = $this->db->get('ligas');
        if ($query) {
            return $query->row();
        } else {
            return false;
        }
    }

    /**
     * select_username
     * Comprueba si existe el username
     * @param  $username
     * @return void
     */
    public function select_username($username)
    {
        $query = $this->db->get_where('usuarios', array('username' => $username))->row();
        if ($query) {
            return $query;
        }
    }


    /**
     * select_email
     * Comprueba si existe el email
     * @param  $email
     * @return void
     */
    public function select_email($email)
    {
        $query = $this->db->get_where('usuarios', array('email' => $email))->row();
        if ($query) {
            return $query;
        }
    }
}
