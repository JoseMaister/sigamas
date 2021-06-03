<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Correo extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->load->library('correos');
        $datos['titulo'] = 'Titulo de Prueba';
        $datos['id'] = 'AT000023';
        $datos['prefijo'] = 'AT';
        $datos['titulo'] = 'Mantenimiento de Rutina';
        $datos['fecha'] = '17-Ene-2019';
        $datos['usuario'] = 'ALEJANDRO ORTIZ';
        $this->correos->creacionTicket($datos);
    }

    function prueba()
    {
        
        $configGOOGLE = Array(
            'smtp_host' => 'smtp.gmail.com',
            'smtp_port' => '465',
            'smtp_user' => 'aleksrocknlove@gmail.com',
            'smtp_pass' => 'Alekssdr14',
            'mailtype' => 'html',
            'newline' => '\r\n',
            'crlf' => '\r\n',
            'protocol' => 'smtp',
        );

        $configMAS = Array(
            'smtp_host' => 'smtpout.secureserver.net',
            'smtp_port' => '80',
            'smtp_user' => 'tickets@masmetrologia.com',
            'smtp_pass' => 'Soporte2018@',
            'mailtype' => 'html',
            'newline' => '\r\n',
            'crlf' => '\r\n',
            'protocol' => 'smtp',
        );

        $configMJET = Array(
            'smtp_host' => 'in-v3.mailjet.com',
            'smtp_port' => '587',
            'smtp_user' => '1f55d1e5c5da7c2c10ee96e0a5d166af',
            'smtp_pass' => '0c68495c162a80a883412b1106045cb3',
            'mailtype' => 'html',
            'newline' => '\r\n',
            'crlf' => '\r\n',
            'protocol' => 'smtp',
        );
        
        $this->load->library('email', $configMJET);

        $this->email->from('aortiz@masmetrologia.com', 'PRUEBA MAIL-JET');
        $this->email->to('alejandro_ortiz426@hotmail.com');
        $logo = base_url('template/images/logo.png');
        $mensaje = <<<EOD

        <a href='#'><img width='400' src='$logo'><br></a>
        <h1><font face="Arial">SIGA-MAS</font></h1>
EOD;

        $this->email->subject('SIGA MAILJET');
        //$this->email->message($mensaje);
        $this->email->message("PRUEBA MAIL-JET");
        $this->email->send();
        echo $this->email->print_debugger();
    }

    public function ticket($datos) {
        $logo = base_url('template/images/logo.png');
        $titulo = $datos['titulo'];

        $mensaje = <<<EOD
               <img width='500' src='$logo'>
               <h1>Ticket de Servicio</h1>
               <h3>Titulo: $titulo</h3>
EOD;

        $this->load->library('email');

        $this->email->from('alejandro_ortiz426@hotmail.com', 'Aleks Ortiz');
        $this->email->to('aortiz@masmetrologia.com');

        $this->email->subject('EXIaaaaaTO');
        $this->email->message($mensaje);

        $this->email->send();

        echo $this->email->print_debugger();
    }

}
