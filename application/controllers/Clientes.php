<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Clientes extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('conexion_model', 'Conexion');
    }

    function ajax_getClientes(){
        $id = $this->input->post('id');
        $nombre = $this->input->post('nombre');

        $query = "SELECT id, nombre, razon_social, rfc, calle, numero, numero_interior, colonia, credito_cliente, credito_cliente_plazo, horario_facturas, ultimo_dia_facturas, documentos_facturacion, codigo_impresion from empresas where cliente = 1";

        if($id)
        {
            $query .= " and id = '$id'";
        }
        else
        {
            if($nombre)
            {
                $query .= " and nombre like '%$nombre%'";
            }
        }


        $res = $this->Conexion->consultar($query, $id);
        if($res)
        {
            echo json_encode($res);
        }
        else
        {
            echo "";
        }
    }

    function ajax_getContactos(){
        $id = $this->input->post('id');
        $empresa = $this->input->post('id_cliente');

        $query = "SELECT * from empresas_contactos where activo = 1";

        if($id)
        {
            $query .= " and id = '$id'";
        }
        else
        {
            if($empresa)
            {
                $query .= " and empresa = '$empresa'";
            }
        }

        $res = $this->Conexion->consultar($query, $id);
        if($res)
        {
            echo json_encode($res);
        }
    }

    

}
