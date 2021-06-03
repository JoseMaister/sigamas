<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Correos_cotizaciones {

    function enviarCotizacionCliente($datos) {
        $CI = & get_instance();

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

        //$config['smtp_user'] = $datos['res_correo'];
        //$config['smtp_pass'] = $datos['res_correo_pass'];

        $para = explode(";", $datos['para']);
        $cc = explode(";", $datos['cc']);

        $CI->load->library('email', $configMJET);

        $CI->email->from($datos['res_correo'], 'Cotización MASMetrología');

        $CI->email->to($para);
        $CI->email->cc($cc);

        $CI->email->subject($datos['asunto']);
        $CI->email->message($datos['body']);
        $CI->email->attach($datos['archivo'], 'attachment', 'COT' . str_pad($datos['id'], 6, '0', STR_PAD_LEFT) . '.pdf');   

        $CI->email->send();
        return $CI->email->print_debugger();
    }

    function solicitarAprobacion($datos) {
        
        $CI = & get_instance();
        $CI->load->library('email');

        $logo = base_url('template/images/logo.png');
        $url = base_url('cotizaciones/ver_cotizacion/') . $datos['id'];
        $idCompleto = "COT" . str_pad($datos['id'], 6, "0", STR_PAD_LEFT);

        $mensaje = "
            <img width='400' src='$logo'><br>
            <h1><font face='Times'>SIGA-MAS</font></h1>
            <h2>Cotización pendiente de aprobación</h2>
            <p><b>ID:</b> $idCompleto</p>
            <p><b>Cliente:</b> " . $datos['nombreCliente'] . "</p>
            <p><b>Contacto:</b> " . $datos['nombreContacto'] . "</p>
            <p><b>Responsable:</b> " . $datos['nombreResponsable'] . "</p>
            
            <br>";

            if(isset($datos['comentarios']) && $datos['comentarios'])
            {
                $mensaje .= "<p><b>Comentarios: </b><br>". $datos['comentarios'] . "</p>";
            }

            $mensaje .= "<a href='$url' class='btn btn-primary'>Ver Cotización</a>";

        $CI->email->from('tickets@masmetrologia.com', 'SIGA-MAS');
        $CI->email->to($datos['correos']);

        $CI->email->subject('Cotización pendiente de aprobación');
        $CI->email->message($mensaje);

        $CI->email->send();
    }

    function rechazoCotizacion($datos) {
        $CI = & get_instance();
        $CI->load->library('email');

        $logo = base_url('template/images/logo.png');
        $url = base_url('cotizaciones/ver_cotizacion/') . $datos['id'];
        $idCompleto = "COT" . str_pad($datos['id'], 6, "0", STR_PAD_LEFT);

        $mensaje = "
            <img width='400' src='$logo'><br>
            <h1><font face='Times'>SIGA-MAS</font></h1>
            <h2>Se ha rechazado cotización</h2>
            <p><b>ID:</b> $idCompleto</p>
            <p><b>Cliente:</b> " . $datos['nombreCliente'] . "</p>
            <p><b>Contacto:</b> " . $datos['nombreContacto'] . "</p>
            <p><b>Responsable:</b> " . $datos['nombreResponsable'] . "</p>
            <br>";
            if(isset($datos['comentarios']) && $datos['comentarios'])
            {
                $mensaje .= "<p><b>Comentarios: </b><br>". $datos['comentarios'] . "</p>";
            }

            $mensaje .= "<a href='$url' class='btn btn-primary'>Ver Cotización</a>";

        $CI->email->from('tickets@masmetrologia.com', 'SIGA-MAS');
        $CI->email->to($datos['correos']);

        $CI->email->subject('Rechazo de cotización');
        $CI->email->message($mensaje);

        $CI->email->send();
    }

    function aprobacionCotizacion($datos) {
        $CI = & get_instance();
        $CI->load->library('email');

        $logo = base_url('template/images/logo.png');
        $url = base_url('cotizaciones/ver_cotizacion/') . $datos['id'];
        $idCompleto = "COT" . str_pad($datos['id'], 6, "0", STR_PAD_LEFT);

        $mensaje = "
            <img width='400' src='$logo'><br>
            <h1><font face='Times'>SIGA-MAS</font></h1>
            <h2>Cotización aprobada</h2>
            <p><b>ID:</b> $idCompleto</p>
            <p><b>Cliente:</b> " . $datos['nombreCliente'] . "</p>
            <p><b>Contacto:</b> " . $datos['nombreContacto'] . "</p>
            <p><b>Responsable:</b> " . $datos['nombreResponsable'] . "</p>
            <br>";
            if(isset($datos['comentarios']) && $datos['comentarios'])
            {
                $mensaje .= "<p><b>Comentarios: </b><br>". $datos['comentarios'] . "</p>";
            }

            $mensaje .= "<a href='$url' class='btn btn-primary'>Ver Cotización</a>";

        $CI->email->from('tickets@masmetrologia.com', 'SIGA-MAS');
        $CI->email->to($datos['correos']);

        $CI->email->subject('Se ha aprobado cotización');
        $CI->email->message($mensaje);

        $CI->email->send();
    }


}
