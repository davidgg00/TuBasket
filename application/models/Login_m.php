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

        //Probamos a ver si la cuenta está en la tabla admin
        $sqlAdmin = "SELECT *  FROM admin WHERE username=? AND password = ?";
        $resultado = $this->db->query($sqlAdmin, array($username, $password));
        if ($resultado) {
            return $resultado->row();
        }
        //Probamos si la cuenta está en la tabla jugadores
        $sqlUsuarios = "SELECT *  FROM usuarios WHERE username=? AND password = ?";
        $resultado = $this->db->query($sqlUsuarios, array($username, $password));
        if ($resultado) {
            return $resultado->row();
        }
        return false; //Si llega aqui es que el usuario no existe
    }
}
