<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Correos_facturacion {

    function solicitud($data) {
        $CI = & get_instance();
        $CI->load->library('email');

        $logo = base_url('template/images/logo.png');
        $url = base_url('facturas/ver_solicitud/') . $data->id;
        $idCompleto = str_pad($data->id, 6, "0", STR_PAD_LEFT);

        $mensaje = "
            <img width='400' src='$logo'><br>
            <h1><font face='Times'>SIGA-MAS</font></h1>
            <h2>Solicitud de Factura</h2>
            <p><b>ID:</b> $idCompleto</p>
            <p><b>Requisitor:</b> $data->User</p>
            <p><b>Cliente:</b> $data->Client</p>
            <p><b>Contacto:</b> $data->Contact</p>
            <p><b>Notas:</b> $data->notas</p>
            <br>
            <a href='$url' class='btn btn-primary'>Ver Solicitud</a>";

        $CI->email->from('tickets@masmetrologia.com', 'Facturación SIGA-MAS');
        $CI->email->to($data->correos);

        $CI->email->subject('Solicitud de Factura');
        $CI->email->message($mensaje);

        $CI->email->send();
    }

    function editar_solicitud($data) {
        $CI = & get_instance();
        $CI->load->library('email');

        $logo = base_url('template/images/logo.png');
        $url = base_url('facturas/ver_solicitud/') . $data->id;
        $idCompleto = str_pad($data->id, 6, "0", STR_PAD_LEFT);
        $comentario = empty($data->comentario) ? "<p><b>Nuevo Estatus:</b> $data->estatus</p>" : "<p>$data->comentario</p>";

        $mensaje = "
            <img width='400' src='$logo'><br>
            <h1><font face='Times'>SIGA-MAS</font></h1>
            <h2>Solicitud de Factura</h2>
            <p><b>ID:</b> $idCompleto</p>
            <p><b>Requisitor:</b> $data->User</p>
            <p><b>Cliente:</b> $data->Client</p>
            <p><b>Contacto:</b> $data->Contact</p>
            <p><b>Notas:</b> $data->notas</p>
            <br>
            $comentario
            <br>
            <a href='$url' class='btn btn-primary'>Ver Solicitud</a>";

        $CI->email->from('tickets@masmetrologia.com', 'Facturación SIGA-MAS');
        $CI->email->to($data->correos);

        $CI->email->subject('Solicitud de Factura');
        $CI->email->message($mensaje);

        $CI->email->send();
    }

    function enviarCorreo($datos) {
        $CI = & get_instance();

        $configMJET = Array(
            'charset' => 'utf-8',
            'smtp_host' => 'in-v3.mailjet.com',
            'smtp_port' => '587',
            'smtp_user' => '1f55d1e5c5da7c2c10ee96e0a5d166af',
            'smtp_pass' => '0c68495c162a80a883412b1106045cb3',
            'mailtype' => 'html',
            'newline' => '\r\n',
            'crlf' => '\r\n',
            'protocol' => 'smtp',
        );

        //$config['smtp_user'] = $CI->session->correo;
        //$config['smtp_pass'] = $CI->session->password_correo;
        
        $para = explode (",", $datos['para']);
        $cc = explode (",", $datos['cc']);
               
        $CI->load->library('email', $configMJET);

        $CI->email->from($CI->session->correo, 'Facturación SIGA-MAS');

        $CI->email->to($para);
        $CI->email->cc($cc);

        $CI->email->subject($datos['subject']);
        $CI->email->message($datos['body']);

        foreach ($datos['archivos'] as $i => $value) {
            $CI->email->attach($value, 'attachment', $datos['campos'][$i]);
        }

        $CI->email->send();
        echo $CI->email->print_debugger();
    }


}
