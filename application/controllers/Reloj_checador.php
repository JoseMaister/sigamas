<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Reloj_checador extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('reloj_model');
    }

    function index() {
        $data['usuario'] = 0;
        $data['idusuario'] = 0;
        $idusuario = $this->session->id;
        if(isset($idusuario))
        {
            $data['idusuario'] = $idusuario;
        }
        $this->load->view('reloj_checador/checador', $data);
    }

    function checar() {
        $data['usuario'] = $this->session->no_empleado;
        $data['idusuario'] = $this->session->id;
        $this->load->view('reloj_checador/checador', $data);
    }

    function reporte(){
        $datos['semanaActual'] = $this->aos_funciones->no_semana();
        $this->load->view('header');
        $this->load->view('reloj_checador/reporte', $datos);
    }

    function comprobar_usuario_ajax(){
        $no_empleado = strtoupper(trim($this->input->post('no_empleado')));
        $user = $this->reloj_model->getUsuario($no_empleado);
        if($user){
            echo json_encode($user);
        }
    }

    function checar_ajax(){
        $this->load->model('usuarios_model');
        $data['foto'] = $this->input->post('src');
        $data['usuario'] = $this->input->post('usuario');
        $data['tipo'] = $this->input->post('tipo');

        $res = $this->reloj_model->checarEntrada($data);
        if($res)
        {
            $checada = $this->reloj_model->getEntrada($res);
            $this->usuarios_model->ultimaSesion($data['usuario']);
            $data['hora'] = $checada->hora;
            echo json_encode($data);
        } else {
            echo "";
        }
    }

    function checadas_ajax(){
        $idusuario = $this->input->post('idusuario');
        $res = $this->reloj_model->getChecadas($idusuario);
        if($res)
        {
            echo json_encode($res);
        } else {
            echo "";
        }
    }

    function reporte_ajax()
    {
        $year = $this->input->post('year');
        $semana = $this->input->post('semana');
        
        $fecha = $this->aos_funciones->fecha_semana($year, $semana, $semana);
        $data['inicio'] = $fecha[0];
        $data['final'] = $fecha[1];

        $res = $this->reloj_model->getReporte($data);
        if($res)
        {
            echo json_encode($res);
        } else {
            echo "";
        }
    }




}
