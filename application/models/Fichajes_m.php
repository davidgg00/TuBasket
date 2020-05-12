<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Fichajes_m extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function OfrecerFichaje($equipo, $jugadorAFichar, $idEquipoRecibe, $jugadorOfrecido)
    {
        $datos = array(
            'IdEquipoSolicita' => $equipo,
            'username_jugador1' => $jugadorAFichar,
            'IdEquipoRecibe' => $idEquipoRecibe,
            'username_jugador2' => $jugadorOfrecido,
            'Estado' => 'PENDIENTE'
        );
        $this->db->select('*');
        $this->db->from('fichajes');
        $this->db->where($datos);
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            echo "Error";
        } else {
            $this->db->insert('fichajes', $datos);
        }
    }

    public function aceptarFichaje($idfichaje)
    {
        $this->db->set('estado', 'ACEPTADO');
        $this->db->where('id', $idfichaje);
        $this->db->update('fichajes');
    }

    public function rechazarFichaje($idfichaje)
    {
        $this->db->set('estado', 'DENEGADO');
        $this->db->where('id', $idfichaje);
        $this->db->update('fichajes');
    }
}
