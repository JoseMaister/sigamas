<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Privilegios_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function agregarPuesto($datos){
        $this->db->db_debug = FALSE;
        return $this->db->insert('puestos', $datos);
    }

    function agregarPrivilegio($datos){
        return $this->db->insert('privilegios', $datos);
    }

    function listadoPuestos(){
        $this->db->select('P.id, P.puesto, (SELECT count(*) from usuarios where puesto=P.id ) as Usuarios');
        $this->db->from('puestos P');
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            return $result->result();
        } else {
            return false;
        }
    }

    public function getPrivilegios($id_usuario) {
        $this->db->where('usuario', $id_usuario);
        $result = $this->db->get('privilegios');
        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return false;
        }
    }

    public function setPrivilegios($datos) {
        $this->db->where('usuario', $datos['usuario']);
        return $this->db->update('privilegios', $datos);
    }

}

?>
