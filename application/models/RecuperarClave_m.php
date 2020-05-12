<?php
defined('BASEPATH') or exit('No direct script access allowed');

class RecuperarClave_m extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function insertarTokenBBDD($email, $token)
    {
        $datetime = new DateTime('tomorrow');
        $data = array(
            'email' => $email,
            'token' => $token,
            'exp' => $datetime->format('Y-m-d'),
        );

        //Comprobamos si tenemos que hacer un insert o un update
        $existeEmail = self::existeEmail($email);
        if ($existeEmail) {
            $this->db->where('email', $email);
            $this->db->update('reseteo_clave', $data);
        } else {
            $this->db->insert('reseteo_clave', $data);
        }
    }

    //Función que comprueba si el email ya existe en la tabla de los TOKENS para saber si hacer un insert o Update
    public function existeEmail($email)
    {
        $this->db->from("reseteo_clave");
        $this->db->where("email", $email);

        $nresultados = $this->db->count_all_results();

        if ($nresultados == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function existeEmailCuenta($email)
    {
        $this->db->select("*");
        $this->db->from("usuarios");
        $this->db->where("email", $email);

        $nresultados = $this->db->count_all_results();

        if ($nresultados == 1) {
            return TRUE;
        } else {
            return false;
        }
    }

    //Función que te devuelve el día de expiración de un token
    public function getDatosToken($token)
    {
        $query = $this->db->get_where('reseteo_clave', array('token' => $token));
        //Retornamos la fila
        return $query->row();
    }

    public function cambiarClaveUsuario($email, $clave)
    {
        $data = array(
            'password' => $clave,
        );
        $this->db->where('email', $email);
        $this->db->update('usuarios', $data);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        }
    }
}
