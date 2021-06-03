<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Bitacora extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->load->view('header');
        $this->load->view('bitacora/software');
    }

    function ajax_getLog(){
        $res = $this->Conexion->consultar("SELECT * from bitacora_software");
        echo json_encode($res);
    }



}
