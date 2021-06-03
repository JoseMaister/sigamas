<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Correos_servicios {

    function requerimiento($data) {
        $CI = & get_instance();
        $CI->load->library('email');

        $logo = base_url('template/images/logo.png');
        $url = base_url('requerimientos/ver/') . $data->id;
        $idCompleto = "REQ" . str_pad($data->id, 6, "0", STR_PAD_LEFT);

        $mensaje = "
            <img width='400' src='$logo'><br>
            <h1><font face='Times'>SIGA-MAS</font></h1>
            <h2>Evaluación Requerimiento</h2>
            <p><b>ID:</b> $idCompleto</p>
            <p><b>Tipo:</b> $data->tipo</p>
            <p><b>Fabricante:</b> $data->fabricante</p>
            <p><b>Modelo:</b> $data->modelo</p>
            <p><b>Estatus:</b> $data->estatus</p>
            <p><b>Descripción:</b> $data->descripcion</p>
            <br>
            <a href='$url' class='btn btn-primary'>Ver Requerimiento</a>";

        $CI->email->from('tickets@masmetrologia.com', 'Soporte SIGA-MAS');
        $CI->email->to($data->correo);

        $CI->email->subject('Evaluación de Requerimiento');
        $CI->email->message($mensaje);

        $CI->email->send();
    }


}
