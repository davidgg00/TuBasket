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
}
