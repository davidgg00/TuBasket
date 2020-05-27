<?php
defined('BASEPATH') or exit('No direct script access allowed');
//Modelo en que se comunicará con la base de datos solo con las operaciones relacionadas con el perfil/cuenta.
class Perfiles_m extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function actualizarClave($claveAntigua, $claveNueva, $username)
    {
        $this->db->set('password', $claveNueva);
        $this->db->where('username', $username);
        $this->db->where('password', $claveAntigua);
        $this->db->update('usuarios');

        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function updateJugador($apenom, $email, $fechanac, $path = null)
    {
        $this->db->set('apenom', $apenom);
        $this->db->set('email', $email);
        $this->db->set('fecha_nac', $fechanac);
        if ($path != null) {
            $this->db->set('imagen', $path);
        }
        $this->db->where('username', $_SESSION['username']);
        $this->db->update('usuarios');

        //Reemplazamos las variables de sesión
        $this->session->set_userdata('apenom', $apenom);
        $this->session->set_userdata('email', $email);
        $this->session->set_userdata('fecha_nac', $fechanac);
    }

    public function getEmail($email, $usuario)
    {
        $this->db->select('email');
        $this->db->where('email', $email);
        $this->db->where('username <>', $usuario);
        $query = $this->db->get('usuarios');
        return $query->num_rows();
    }
}
