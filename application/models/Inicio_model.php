<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Inicio_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function confirmarDatos($id, $datos){
      $this->db->where('id', $id);
      $this->db->set('fecha_alta', 'current_timestamp()', FALSE);
      $this->db->set('ultima_sesion', 'current_timestamp()', FALSE);
      if ($this->db->update('usuarios', $datos)) {
          return true;
      } else {
          return false;
      }
    }

}

?>
