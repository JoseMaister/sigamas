<?php defined('BASEPATH') OR exit('No direct script access allowed');
//create class extends CI_Controller
class Archivos extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('conexion_model', 'Conexion');
    }
    
    function pdf(){
        if(isset($_POST['tabla']) && isset($_POST['id']))
        {
            $tabla = $this->input->post("tabla");
            $id = $this->input->post("id");
            $res = $this->Conexion->consultar("SELECT nombre, archivo from $tabla where id = $id", TRUE);
            $nombre = $res->nombre;
            $file = $res->archivo;
            
            header('Content-type: application/pdf');
            header('Content-Disposition: inline; filename="' . $nombre . '"');
            header('Content-Transfer-Encoding: binary');
            header('Accept-Ranges: bytes');

            echo $file;
        }
        else
        {
            redirect(base_url('inicio'));
        }
    }

    function documento(){
        if(isset($_POST['tabla']) && isset($_POST['id']) && isset($_POST['campo']))
        {
            $id = $this->input->post("id");
            $tabla = $this->input->post("tabla");
            $campo = $this->input->post("campo");

            $res = $this->Conexion->consultar("SELECT $campo from $tabla where id = $id", TRUE);            
            $file = $res->$campo;
            
            header('Content-type: application/pdf');
            header('Content-Disposition: inline; filename="' . $campo . '"');
            header('Content-Transfer-Encoding: binary');
            header('Accept-Ranges: bytes');

            echo $file;
        }
        else
        {
            redirect(base_url('inicio'));
        }
    }

    function descarga(){
        if(isset($_POST['tabla']) && isset($_POST['id']) && isset($_POST['campo']))
        {
            $id = $this->input->post("id");
            $tabla = $this->input->post("tabla");
            $campo = $this->input->post("campo");

            $res = $this->Conexion->consultar("SELECT $campo from $tabla where id = $id", TRUE);            
            $file = $res->$campo;
            
            header('Content-type: text/xml');

            echo $file;
        }
        else
        {
            redirect(base_url('inicio'));
        }
    }
}