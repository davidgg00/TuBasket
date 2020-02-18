<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login_m extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function comprobar_usuario_clave($username, $password)
    {
        //Para evitar la inyeccion SQL hago una consulta preparada
        $sql = "SELECT *  FROM admin WHERE username=? AND password = ?";
        $resultado = $this->db->query($sql, array($username, $password));
        return $resultado->row();
    }
}
