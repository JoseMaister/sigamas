<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tickets extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('tickets_model');
        $this->load->model('conexion_model', 'Conexion');
        $this->load->library('correos_tickets');
    }

    public function index() {
        $datos['modulo'] = 'generar';
        $this->load->view('header');
        $this->load->view('tickets', $datos);
    }

    public function administrar() {
        $datos['modulo'] = 'administrar/activos';
        $this->load->view('header');
        $this->load->view('tickets', $datos);
    }

    public function mis_tickets() {
        $datos['tickets'] = $this->tickets_model->getMis_tickets($this->session->id);
        $this->load->view('header');
        $this->load->view('tickets/mis_tickets', $datos);
    }

    public function reportes() {
        $datos['modulo'] = 'reporte';
        $this->load->view('header');
        $this->load->view('tickets', $datos);
    }




    /////// F U N C I O N E S  A J A X ///////

    function ajax_getTicketsSolucionados(){
        $user = $this->input->post('usuario');
        $res = $this->Conexion->consultar("SELECT count(*) as Conteo FROM tickets_sistemas where usuario = '$user' and estatus = 'SOLUCIONADO'", TRUE);
        if($res)
        {
            echo json_encode($res);   
        }
    }

    function ajax_sendTicketNotification(){
        $query = "SELECT 'IT' as tipo, T.id, T.usuario, concat(U.nombre,' ',U.paterno) as User, U.correo, T.estatus from tickets_sistemas T inner join usuarios U on U.id = T.usuario where T.estatus = 'SOLUCIONADO'"
        . " union "
        . "SELECT 'AT', T.id, T.usuario, concat(U.nombre,' ',U.paterno) as User, U.correo, T.estatus from tickets_autos T inner join usuarios U on U.id = T.usuario where T.estatus = 'SOLUCIONADO'"
        . " union "
        . "SELECT 'ED', T.id, T.usuario, concat(U.nombre,' ',U.paterno) as User, U.correo, T.estatus from tickets_edificio T inner join usuarios U on U.id = T.usuario where T.estatus = 'SOLUCIONADO' order by usuario";

        $arr = array();
        $res = $this->Conexion->consultar($query);
        if($res)
        {
            foreach ($res as $key => $value) {
                if(!isset($arr[$value->usuario]))
                {
                    $arr[$value->usuario]['nombre'] = $value->User;
                    $arr[$value->usuario]['correo'] = $value->correo;
                    $arr[$value->usuario]['tickets'] = array();
                }
                array_push($arr[$value->usuario]['tickets'], $value->tipo . str_pad($value->id, 6, "0", STR_PAD_LEFT));
            }
        }

        $this->correos_tickets->ticketsPendientes($arr);

        

    }

}
