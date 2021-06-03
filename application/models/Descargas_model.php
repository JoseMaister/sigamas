<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Descargas_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function getFile($id, $tabla)
    {
        $this->db->where('id', $id);
        $res = $this->db->get($tabla);
        if($res->num_rows() > 0)
        {
            return $res->row();
        }
        else
        {
            return false;
        }
    }
}

?>
