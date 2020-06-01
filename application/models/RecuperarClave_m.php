<?php
defined('BASEPATH') or exit('No direct script access allowed');

class RecuperarClave_m extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    /**
     * insertarTokenBBDD
     * Inserta el nuevo token a la Base de datos
     * @param  $email
     * @param  $token
     */
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

    /**
     * existeEmail
     * Comprueba si el email existe en la tabla de los tokens para hacer un insert o Update
     * @param  $email
     * @return true or false
     */
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

    /**
     * existeEmailCuenta
     *  Comprueba si existe el email de una cuenta.
     * @param  $email
     * @return true or false
     */
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

    /**
     * getDatosToken
     * Te devuelve el dia de expiración de un token
     * @param  $token
     * @return $query->row()
     */
    public function getDatosToken($token)
    {
        $query = $this->db->get_where('reseteo_clave', array('token' => $token));
        //Retornamos la fila
        return $query->row();
    }

    /**
     * cambiarClaveUsuario
     * Cambia la clave de un usuario
     * @param  $email
     * @param  $clave
     * @return true
     */
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
