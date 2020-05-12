<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notificaciones_m extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function leerNotificacionSolicitante($idfichaje)
    {
        $this->db->set('LeidoEntrenadorSolicita', '1');
        $this->db->where('id', $idfichaje);
        $this->db->update('fichajes');
    }

    public function leerNotificacionRecibidor($idfichaje)
    {
        $this->db->set('LeidoEntrenadorRecibe', '1');
        $this->db->where('id', $idfichaje);
        $this->db->update('fichajes');
    }

    public function numeroNotificaciones($idequipo)
    {
        $this->db->select('e.id as `idEquipoSolicitante` , e.equipo AS `equipoSolicitante`, f.username_jugador1 AS `pide`,u.imagen as `img_jugador_pide`, f.username_jugador2 AS `ofrece`, u2.imagen as `img_jugador_ofrece`, e2.id AS `idEquipoRecibe`,e2.equipo AS `equipoRecibe`, f.id as `idfichaje`, f.estado as `estado`, f.leidoEntrenadorSolicita, f.leidoEntrenadorRecibe');
        $this->db->from('fichajes f');
        $this->db->join('equipo e', 'e.id = f.IdEquipoSolicita');
        $this->db->join('equipo e2', 'e2.id = f.IdEquipoRecibe');
        $this->db->join('usuarios u', 'u.username = f.username_jugador1');
        $this->db->join('usuarios u2', 'u2.username = f.username_jugador2');
        $this->db->where("(f.idEquipoSolicita='$idequipo' AND f.LeidoEntrenadorSolicita = 0) OR (f.IdEquipoRecibe='$idequipo' and f.LeidoEntrenadorRecibe = 0)", NULL, FALSE);
        $this->db->order_by('f.id', 'DESC');
        $resultado = $this->db->get();
        return $resultado->num_rows();
    }
}
