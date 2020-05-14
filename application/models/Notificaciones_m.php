<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notificaciones_m extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function leerNotificaciones($idfichaje, $username)
    {
        $this->db->set('leido', '1');
        $this->db->where('idfichaje', $idfichaje);
        $this->db->where('username', $username);
        $this->db->update('notificaciones');
    }

    public function numeroNotificaciones($username)
    {
        $this->db->select('*');
        $this->db->from('notificaciones n');
        $this->db->where("username", $username);
        $this->db->where("leido", "0");
        $resultado = $this->db->get();
        return $resultado->num_rows();
    }
}
