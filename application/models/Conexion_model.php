<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Conexion_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function get($tabla, $where = null){
        if (!is_null($where))
        {
            $this->db->where($where);
        }
        
        $res = $this->db->get($tabla);
        if($res->num_rows() > 0)
        {
            return $res->result();
        }
        else{ return false; }
    }

    function consultar($query, $row = FALSE, $array = TRUE){
        
        $res = $this->db->query($query);
        if($res->num_rows() > 0)
        {
            if($array)
            {
                if($row)
                {
                    return $res->row();
                } else {
                    return $res->result();
                }
            } 
            else
            {
                return $res;
            }

            
        }
        else{ return false; }
    }

    function comando($query){
        $res = $this->db->query($query);
        if($this->db->affected_rows() > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    function insertar($tabla, $datos, $funciones = null){
        if (!is_null($funciones))
        {
            foreach ($funciones as $key => $value) 
            {
                $this->db->set($key, $value, FALSE);
            }
        }

        $this->db->insert($tabla, $datos);
        return $this->db->insert_id();
    }

    function modificar($tabla, $datos, $funciones = null, $where){
        if (!is_null($datos))
        {
            foreach ($datos as $key => $value) 
            {
                $this->db->set($key, $value);
            }
        }

        if (!is_null($funciones))
        {
            foreach ($funciones as $key => $value) 
            {
                $this->db->set($key, $value, FALSE);
            }
        }
        
        if (!is_null($where))
        {
            foreach ($where as $key => $value) 
            {
                $this->db->where($key, $value);
            }
        }

        $this->db->update($tabla);
        return $this->db->affected_rows();
    }

    function eliminar($tabla, $where){
        if (!is_null($where))
        {
            foreach ($where as $key => $value) 
            {
                $this->db->where($key, $value);
            }
        }
        $this->db->delete($tabla);
        return true;

    }

  


}

?>
