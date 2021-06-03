<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Agenda_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function insertEvent($data)
    {
        $this->db->set('fecha', 'current_timestamp()', FALSE);
        $this->db->insert('agenda', $data);
        //$this->LOG
        return $this->db->insert_id();
    }

    function deleteEvent($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('agenda');
        return $this->db->affected_rows();
    }

    function getEventos()
    {
        $this->db->select('A.id, A.fecha, A.inicia as start, A.termina as end, A.titulo as title, A.descripcion, A.usuario, concat(U.nombre," ",U.paterno) as User');
        $this->db->join('usuarios U', 'A.usuario = U.id', 'LEFT');
        $res = $this->db->get('agenda A');
        if($res->num_rows() > 0)
        {
          return $res->result_array();
        }
        else {
          return false;
        }
    }
}
