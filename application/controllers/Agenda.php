<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Agenda extends CI_Controller {
//create the constructor to load the database for 'Angenda'
    function __construct() {
        parent::__construct();
        $this->load->model('agenda_model','Modelo');
    }
//Function to show the page to use
    public function index() {
        $this->load->view('header');
        $this->load->view('agenda/calendario');
        //$this->load->view('test/chat');
    }
//get the fucntions from class 'agenda_model' 
    function getEventos()
    {
        $data = $this->Modelo->getEventos();
        echo json_encode($data);
    }
//create event to insert data 
    function crearEvento()
    {
        $datos['usuario'] = $this->session->id;
        $datos['titulo'] = $_POST['titulo'];
        $datos['inicia'] = $_POST['inicia'];
        $datos['termina'] = $_POST['termina'];
        $datos['descripcion'] = $_POST['descripcion'];
        echo $this->Modelo->insertEvent($datos);
    }
//delete data 
    function borrarEvento()
    {
        $id = $_POST['id'];
        if($this->Modelo->deleteEvent($id) > 0)
        {
          echo "1";
        }
        else {
          echo "0";
        }
    }


}
