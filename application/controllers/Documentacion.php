<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Documentacion extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('conexion_model', 'Conexion');
    }

    function manuales(){
        $this->load->view('header');
        $this->load->view('documentacion/catalogo');
    }

    function mapa_sitio(){
        $this->load->view('header');
        $this->load->view('documentacion/mapa_sitio');
    }
    
    /////////////////////////////  A        /////////////////////////////
    /////////////////////////////    J      /////////////////////////////   (\(\
    /////////////////////////////      A    /////////////////////////////   (=';')
    /////////////////////////////        X  /////////////////////////////   (,,)(")(")


}
