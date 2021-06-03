<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MLConexion_model extends CI_Model {

    function __construct() {
        parent::__construct();
        
    }

    function get($tabla, $where = null){
        $db2 = $this->load->database('second', TRUE);
        
        if (!is_null($where))
        {
            $db2->where($where);
        }
        
        $res = $db2->get($tabla);
        if($res->num_rows() > 0)
        {
            return $res->result();
        }
        else{ return false; }
    }

    function consultar($query, $row = FALSE, $array = TRUE){
        $db2 = $this->load->database('second', TRUE);

        $res = $db2->query($query);
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
        $db2 = $this->load->database('second', TRUE);

        $res = $db2->query($query);
        if($db2->affected_rows() > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    function insertar($tabla, $datos, $funciones = null){
        $db2 = $this->load->database('second', TRUE);

        if (!is_null($funciones))
        {
            foreach ($funciones as $key => $value) 
            {
                $db2->set($key, $value, FALSE);
            }
        }

        $db2->insert($tabla, $datos);
        return $db2->insert_id();
    }

    function modificar($tabla, $datos, $funciones = null, $where){
        $db2 = $this->load->database('second', TRUE);

        if (!is_null($datos))
        {
            foreach ($datos as $key => $value) 
            {
                $db2->set($key, $value);
            }
        }

        if (!is_null($funciones))
        {
            foreach ($funciones as $key => $value) 
            {
                $db2->set($key, $value, FALSE);
            }
        }
        
        if (!is_null($where))
        {
            foreach ($where as $key => $value) 
            {
                $db2->where($key, $value);
            }
        }

        $db2->update($tabla);
        return $db2->affected_rows();
    }

    function eliminar($tabla, $where){
        $db2 = $this->load->database('second', TRUE);

        if (!is_null($where))
        {
            foreach ($where as $key => $value) 
            {
                $db2->where($key, $value);
            }
        }
        $db2->delete($tabla);
        return true;

    }

  


}

?>
