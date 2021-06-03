<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('usuarios_model');
        $this->load->library('correos_tickets');
    }

    function index() {
        date_default_timezone_set('America/Chihuahua');
        $data['url_actual'] = base_url('inicio');
        if(isset($this->session->url_actual))
        {
          $data['url_actual']=$this->session->url_actual;
        }
        $this->session->sess_destroy();
        $this->load->view('login', $data);
    }

    function autenticar() {
        //$this->output->enable_profiler(TRUE);
        $url_actual = $this->input->post('url_actual');
        $usuario = $this->input->post('user');
        $pass = $this->input->post('pass');
        $res = $this->usuarios_model->autenticar($usuario, $pass);
        if ($res) {
            $row = $res->row();
            $this->session->nombre = $row->User;
            $this->session->id = $row->id;
            $this->session->no_empleado = $row->no_empleado;
            $this->session->password = $row->password;
            $this->session->vencimiento_password = $row->vencimiento_password;
            $this->session->password_correo = $row->password_correo;
            $this->session->correo = $row->correo;
            $this->session->puesto = $row->puesto;
            $this->session->activo = $row->activo;
            $this->session->foto = $row->foto;
            $this->session->chats = '{ "chatbox0" : "CHAT"}';

            //SE LEEN LAS TABLAS DE PRIVILEGIOS SEGUN EL PUESTO
            $this->session->privilegios = $this->usuarios_model->getPrivilegios($this->session->id);

            $this->usuarios_model->ultimaSesion($row->id);
            
            /*
            $fecha = date("y-m-d", strtotime($row->ultima_sesion));
            $today = date("y-m-d", strtotime("today"));
            */

            $us = $this->Conexion->consultar("SELECT max(ultima_sesion) as us from usuarios", true);
            $fecha = date("y-m-d", strtotime($us->us));
            $today = date("y-m-d", strtotime("today"));
            //if ($today > $fecha)
            {
                $query = "SELECT 'IT' as tipo, T.id, T.usuario, concat(U.nombre,' ',U.paterno) as User, U.correo, T.estatus from tickets_sistemas T inner join usuarios U on U.id = T.usuario where T.estatus = 'SOLUCIONADO' and usuario = $row->id"
                . " union "
                . "SELECT 'AT', T.id, T.usuario, concat(U.nombre,' ',U.paterno) as User, U.correo, T.estatus from tickets_autos T inner join usuarios U on U.id = T.usuario where T.estatus = 'SOLUCIONADO' and usuario = $row->id"
                . " union "
                . "SELECT 'ED', T.id, T.usuario, concat(U.nombre,' ',U.paterno) as User, U.correo, T.estatus from tickets_edificio T inner join usuarios U on U.id = T.usuario where T.estatus = 'SOLUCIONADO' and usuario = $row->id";

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
            
            redirect($url_actual);


        } else {
            $ERRORES = array();
            $error = array('titulo' => 'ERROR', 'detalle' => 'Usuario y/o Contraseña incorrectas');
            array_push($ERRORES, $error);
            $this->session->errores = $ERRORES;

            $this->session->url_actual = $url_actual;
            redirect(base_url('login'));
        }
    }

    public function cerrar_sesion() {
        $this->session->sess_destroy();
        redirect(base_url('login'));
    }

}
