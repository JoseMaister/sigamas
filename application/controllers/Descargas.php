<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Descargas extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('descargas_model', 'Modelo');
        $this->load->helper('download');
    }

    public function index() {

    }

    function tickets_AT($id)
    {
      $row = $this->Modelo->getFile($id, 'tickets_autos_archivos');
      $file = $row->archivo;
      $nombre = $row->nombre;

      force_download($nombre, $file);
    }

    function tickets_ED($id)
    {
      $row = $this->Modelo->getFile($id, 'tickets_edificio_archivos');
      $file = $row->archivo;
      $nombre = $row->nombre;

      force_download($nombre, $file);
    }

    function tickets_IT($id)
    {
      $row = $this->Modelo->getFile($id, 'tickets_sistemas_archivos');
      $file = $row->archivo;
      $nombre = $row->nombre;

      force_download($nombre, $file);
    }

}
