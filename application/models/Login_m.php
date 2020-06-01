<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login_m extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    /**
     * comprobar_usuario_clave
     * Comprueba si el inicio de sesión es correcto
     * @param  $username
     * @param  $password
     * @return $resultado->row()
     */
    public function comprobar_usuario_clave($username, $password)
    {
        //Para evitar la inyeccion SQL hago una consulta preparada
        $sqlAdmin = "SELECT `username`,`email`,`apenom`,`fecha_nac`, `imagen`,`equipo`,`validado`,`tipo`,`liga` FROM usuarios WHERE username=? AND password = ?";
        $resultado = $this->db->query($sqlAdmin, array($username, $password));
        return $resultado->row();
    }
}
