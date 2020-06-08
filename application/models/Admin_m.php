<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_m extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    /**
     * comprobarNombreLiga
     * Retorna los datos de la liga si encuentra una liga con ese nombre, de lo contrario retorna false
     *
     * @param $liga
     * @return query or false
     */
    public function comprobarNombreLiga($liga)
    {
        $this->db->where('nombre', $liga);
        $query = $this->db->get('ligas');
        if ($query) {
            return $query->row();
        } else {
            return false;
        }
    }

    /**
     * crearLiga
     * Inserta la liga con sus datos en la Base de Dtos
     * @param $datos
     */
    public function crearLiga($datos)
    {
        $this->db->insert('ligas', $datos);
    }

    /**
     * borrarLiga
     * Borra la liga, que se le pasa por parámetro, de la base de datos
     * @param  $liga
     */
    public function borrarLiga($liga)
    {
        $this->db->delete('ligas', array('nombre' => $liga));
    }

    /**
     * mostrar_ligas
     * Retorna las ligas que ha creado un administrador. (Recordemos que un administrador puede crear hasta 3 ligas).
     * @param  $username
     * @return $query
     */
    public function mostrar_ligas($username)
    {
        $this->db->select("l.nombre, l.administrador, e.equipo as ganador");
        $this->db->join('equipos e', 'e.id = l.ganador', 'left');
        $this->db->where('l.administrador', $username);
        $query = $this->db->get('ligas l');
        return $query;
    }

    /**
     * getProx5Partidos
     * Retorna los 5 próximos partidos (Para el Slider) a disputar ordenado por jornada y después por fecha.
     * @param $liga
     * @return $query->result()
     */
    public function getProx5Partidos($liga)
    {
        $this->db->select('*');
        $this->db->where('liga', $liga);
        $this->db->where("resultado_local =", "");
        $this->db->order_by('jornada', 'ASC');
        $this->db->order_by('fecha', 'ASC');
        $this->db->limit(4);
        $query = $this->db->get('view_partidos_liga');
        return $query->result();
    }

    /**
     * num_equipos_liga
     * Retorna el numero de equipos que tiene una liga (pasada por parámetro).
     * @param  $liga
     * @return $query->num_rows();
     */
    public function num_equipos_liga($liga)
    {
        //Creamos la sentencia sql
        $query = $this->db->get_where('equipos', array('liga' => $liga));
        //Retornamos el numero de filas
        return $query->num_rows();
    }

    /**
     * updateAdmin
     * Actualiza los datos del perfil del tipo de cuenta Administrador
     * @param  $apenom
     * @param  $email
     * @param  $fechanac
     * @param  $path
     */
    public function updateAdmin($apenom, $email, $fechanac, $path = null)
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

    /**
     * getPerfilesJugadores
     * Retorna la imagen de los usuarios de una liga (pasada por parámetro).
     * Esta función se utiliza para borrar las imagenes de los jugadores de una liga que se va a borrar.
     * @param  $liga
     * @return $query->result();
     */
    public function getPerfilesJugadores($liga)
    {
        $this->db->select('imagen');
        $this->db->where('liga', $liga);
        $this->db->from('usuarios u');
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * getEscudos
     * Retorna los escudos de los equipos de una liga (pasada por parámetros).
     * Esta función se utiliza para borrar las imagenes de los equipos de una liga que se va a borrar.
     * @param  $liga
     * @return $query->result();
     */
    public function getEscudos($liga)
    {
        $this->db->select('escudo_ruta');
        $this->db->where('liga', $liga);
        $this->db->from('equipos e');
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * getGanador
     * Método que retorna el ganador de la liga (si no hay ganador, estará vacía.)
     * @param  $liga
     * @return $query->row();
     */
    public function getGanador($liga)
    {
        $this->db->select("e.equipo, e.escudo_ruta");
        $this->db->join('equipos e', 'e.id = l.ganador');
        $this->db->where('l.nombre', $liga);
        $this->db->where('l.ganador !=', "");
        $query = $this->db->get('ligas l');
        return $query->row();
    }
}
