<?php
defined('BASEPATH') or exit('No direct script access allowed');

class GestionJugadores_m extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    /**
     * getJugadoresSinConfirmar
     * Retorna los jugadores que no están confirmados en la plataforma todavía.
     * @param  $liga
     * @return return $query->result()
     */
    public function getJugadoresSinConfirmar($liga)
    {
        //Creamos la sentencia sql
        $this->db->select('apenom, email, username, fecha_nac, equipo,nombre_equipo');
        $this->db->from('view_usuarios_liga');
        $this->db->where("liga", $liga);
        $this->db->where("validado", 0);
        $query = $this->db->get();
        //Retornamo resultado
        return $query->result();
    }

    /**
     * aceptarJugador
     * Actualiza el estado de jugador a validado por un admin
     * @param  $username
     * @return void
     */
    public function aceptarJugador($username)
    {
        $this->db->set('validado', 1);
        $this->db->where('username', $username);
        $this->db->update('usuarios');
    }

    /**
     * denegarJugador
     * Borra a un jugador que no estaba validado ya que el admin le ha denegado el acceso a la plataforma.
     * @param  $username
     * @return void
     */
    public function denegarJugador($username)
    {
        $this->db->where('username', $username);
        $this->db->delete('usuarios');
    }


    /**
     * getJugadoresConfirmados
     *
     * @param  $liga
     * @return void
     */
    public function getJugadoresConfirmados($liga)
    {
        //Creamos la sentencia sql
        $this->db->select('apenom, email, username, fecha_nac, equipo,nombre_equipo,tipo,foto_perfil');
        $this->db->from('view_usuarios_liga');
        $this->db->where("liga", $liga);
        $this->db->where("validado", 1);
        $this->db->order_by('equipo', 'ASC');
        $query = $this->db->get();
        //Retornamo resultado
        return $query->result();
    }
}
