<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Correos_logistica {

    function acuse($data) {
        $CI = & get_instance();
        $CI->load->library('email');

        $logo = base_url('template/images/logo.png');
        $firma = base_url('data/logistica/firmas/') . $data->firma;


        $mensaje = "
            <img width='400' src='$logo'><br>
            <h1><font face='Times'>SIGA-MAS</font></h1>
            <h2>Acuse de recibo</h2>
            <p>Buen día $data->contacto</p>
            <p>Mas metrología agradece su preferencia y amable patrocinio. Agradecemos de antemano su apoyo para la autorización de nuestras facturas.</p>
            <p>Por este medio confirmamos que la documentación descrita a continuación fue dejada a su digno cargo para autorización:</p>
            
            <p><b>Facturas: </b> $data->facturas</p>
            <p>la(s) cual(es) estaremos recolectando de acuerdo a lo acordado el día " . $CI->aos_funciones->fecha($data->fecha_retorno) . "</p>
            <p>Nuestro compromiso es servirle, por favor déjenos saber si tiene alguna queja o sugerencia al correo <a href='sugerencias@masmetrologia.com'>sugerencias@masmetrologia.com</a></p>
            <br>
            <p>Gracias,</p>
            <p>MASMetrología</p>
            <p>¡Porque el resultado sí importa!</p>
            <br><br>";

            if($data->comentarios){
                $mensaje .= "<p><b>Comentarios:</b> $data->comentarios</p>";
            }
            
            $mensaje .= "<br>
            <p><b>Firma:</b></p>
            <img border='1' width='300' src='$firma'><br>";

        $CI->email->from('tickets@masmetrologia.com', 'SIGA-MAS');
        $CI->email->to($data->correo);

        $CI->email->subject('Acuse de recibo');
        $CI->email->message($mensaje);

        $CI->email->send();
    }




}
