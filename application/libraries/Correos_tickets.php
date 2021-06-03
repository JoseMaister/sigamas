<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Correos_tickets {

    function ticketsPendientes($datos) {
        $CI = & get_instance();
        $logo = base_url('template/images/logo.png');
               
        $CI->load->library('email');

        foreach ($datos as $elem) {
            $CI->email->from('tickets@masmetrologia.com', 'Soporte SIGA-MAS');
            $nombreUsuario = $elem['nombre'];

            $CI->email->subject('Tickets Pendientes');
            $mensaje = <<<EOD
    
            <img width='400' src='$logo'><br>
            <h1><font face="Times">SIGA-MAS</font></h1>
            <h2>Tickets Pendientes de Revisión</h2>
            <p><b>Usuario:</b> $nombreUsuario</p>
            <p><b>Tickets:</b></p>
EOD;

            $correo = array($elem['correo']);
            
            foreach ($elem['tickets'] as $key => $value) {
                $id = (int)substr($value, 2);
                $url = base_url('tickets_' . substr($value, 0, 2) . '/ver/') . $id;
                $mensaje .= "<a href='" . $url . "' class='btn btn-primary'>$value</a><br>";

                if(substr($value, 0, 2) == "IT" && !in_array("jc@masmetrologia.com", $correo)){
                    $correo = array_merge($correo, array("jc@masmetrologia.com"));
                }
            }

            $CI->email->to($correo);
            $CI->email->message($mensaje);
    
    
            $CI->email->send();
            echo $CI->email->print_debugger();
        }

    }


}
