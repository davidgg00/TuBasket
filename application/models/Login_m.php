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
        $resultado = $this->db->query("SELECT * FROM admin WHERE username like '$username' and password like '$password'");
        return $resultado->result();
    }
}
