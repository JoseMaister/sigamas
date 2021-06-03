<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Correos_pr {



    function creacionPR($datos) {

        $id = $datos['id'];
        $fecha = $datos['fecha'];
        $usuario = $datos['usuario'];
        $prioridad = $datos['prioridad'];
        $unidad = $datos['unidad'];
        $cantidad = $datos['cantidad'];
        $descripcion = $datos['descripcion'];
        $atributos = json_decode($datos['atributos'], TRUE);
        $correos = $datos['correos'];
        $comentarios = $datos['comentarios'];


        $logo = base_url('template/images/logo.png');
        $url = base_url('compras/ver_pr/') . $id;
        $idCompleto = "PR" . str_pad($id, 6, "0", STR_PAD_LEFT);

        $remitentes = array('tickets@masmetrologia.com');

        $remitentes = array_merge($remitentes, $correos);
        

        $CI = & get_instance();
        $CI->load->library('email');

        $att = "";
        foreach ($atributos as $key => $value) {
            $att .= "<p><b>" . ucfirst($key) . ":</b> $value</p>";
        }

        $mensaje = <<<EOD

               <img width='400' src='$logo'><br>
               <h1><font face="Arial">SIGA-MAS</font></h1>
               <h2>Se ha creado PR (Solicitud de Compra)</h2>
               <p><b>ID:</b> $idCompleto</p>
               <p><b>Usuario:</b> $usuario</p>
               <p><b>Prioridad:</b> $prioridad</p>
               <p><b>Unidad:</b> $unidad</p>
               <p><b>Cantidad:</b> $cantidad</p>
               <p><b>Descripción:</b> $descripcion</p>

               $att

               <br>

               <a href='$url' class='btn btn-primary'>Ver PR</a>
EOD;

        $CI->email->from('tickets@masmetrologia.com', 'Soporte SIGA-MAS');

        $CI->email->to($remitentes);

        $CI->email->subject('Solicitud de Compra (PR)');
        $CI->email->message($mensaje);

        $CI->email->send();
    }

    function comentarioPR($datos) {

        $id = $datos['id'];
        $comentario = $datos['comentario'];
        $correos = $datos['correos'];
        

        $logo = base_url('template/images/logo.png');
        $url = base_url('compras/ver_pr/') . $id;
        $idCompleto = "PR" . str_pad($id, 6, "0", STR_PAD_LEFT);

        $remitentes = array('tickets@masmetrologia.com');

        $remitentes = array_merge($remitentes, $correos);
        

        $CI = & get_instance();
        $CI->load->library('email');



        $mensaje = <<<EOD

               <img width='400' src='$logo'><br>
               <h1><font face="Arial">SIGA-MAS</font></h1>
               <h2>Nuevo comentario de PR</h2>
               <p><b>ID:</b> $idCompleto</p>

               <br>
               <p><b>Comentario: </b> $comentario</p>
               <a href='$url' class='btn btn-primary'>Ver PR</a>
EOD;

        $CI->email->from('tickets@masmetrologia.com', 'Soporte SIGA-MAS');

        $CI->email->to($remitentes);

        $CI->email->subject('Nuevo Comentario (PR)');
        $CI->email->message($mensaje);

        $CI->email->send();
    }

    function liberarPR($datos) {

        $id = $datos['id'];
        $fecha = $datos['fecha'];
        $usuario = $datos['usuario'];
        //$cliente = $datos['cliente'];
        $prioridad = $datos['prioridad'];
        $unidad = $datos['unidad'];
        $cantidad = $datos['cantidad'];
        $descripcion = $datos['descripcion'];
        $atributos = json_decode($datos['atributos'], TRUE);
        $correos = $datos['correos'];
        $estatus = $datos['estatus'];
        $comentarios = $datos['comentarios'];

        /*if($estatus == "LIBERADO")
        {
            $leyendaEstatus = "Se ha liberado QR";
        }*/
        if($estatus == "APROBADO")
        {
            $leyendaEstatus = "Se ha Aprobado PR";
        }


        $logo = base_url('template/images/logo.png');
        $url = base_url('compras/ver_pr/') . $id;
        $idCompleto = "PR" . str_pad($id, 6, "0", STR_PAD_LEFT);

        $remitentes = array('tickets@masmetrologia.com');

        $remitentes = array_merge($remitentes, $correos);
        

        $CI = & get_instance();
        $CI->load->library('email');

        $att = "";
        foreach ($atributos as $key => $value) {
            $att .= "<p><b>" . ucfirst($key) . ":</b> $value</p>";
        }

        $mensaje = <<<EOD

               <img width='400' src='$logo'><br>
               <h1><font face="Arial">SIGA-MAS</font></h1>
               <h2><font color='green'>$leyendaEstatus</font></h2>
               <p><b>ID:</b> $idCompleto</p>
               <p><b>Usuario:</b> $usuario</p>
               <p><b>Prioridad:</b> $prioridad</p>
               <p><b>Unidad:</b> $unidad</p>
               <p><b>Cantidad:</b> $cantidad</p>
               <p><b>Descripción:</b> $descripcion</p>

               $att

               <br>
               <p><b>Notas: </b> $comentarios</p>
               <a href='$url' class='btn btn-primary'>Ver PR</a>
EOD;

        $CI->email->from('tickets@masmetrologia.com', 'Soporte SIGA-MAS');

        $CI->email->to($remitentes);

        $CI->email->subject('Solicitud de Compra (PR)');
        $CI->email->message($mensaje);

        $CI->email->send();
    }

    function rechazoPR($datos) {

        $id = $datos['id'];
        $fecha = $datos['fecha'];
        $usuario = $datos['usuario'];
        $prioridad = $datos['prioridad'];
        $unidad = $datos['unidad'];
        $cantidad = $datos['cantidad'];
        $descripcion = $datos['descripcion'];
        $atributos = json_decode($datos['atributos'], TRUE);
        $correos = $datos['correos'];
        $comentarios = $datos['comentarios'];


        $logo = base_url('template/images/logo.png');
        $url = base_url('compras/ver_pr/') . $id;
        $idCompleto = "PR" . str_pad($id, 6, "0", STR_PAD_LEFT);

        $remitentes = array('tickets@masmetrologia.com');

        $remitentes = array_merge($remitentes, $correos);
        

        $CI = & get_instance();
        $CI->load->library('email');


        $att = "";
        foreach ($atributos as $key => $value) {
            $att .= "<p><b>" . ucfirst($key) . ":</b> $value</p>";
        }

        $mensaje = <<<EOD

               <img width='400' src='$logo'><br>
               <h1><font face="Arial">SIGA-MAS</font></h1>
               <h2><font color='red'>Se ha rechazado PR</font></h2>
               <p><b>ID:</b> $idCompleto</p>
               <p><b>Usuario:</b> $usuario</p>
               <p><b>Prioridad:</b> $prioridad</p>
               <p><b>Unidad:</b> $unidad</p>
               <p><b>Cantidad:</b> $cantidad</p>
               <p><b>Descripción:</b> $descripcion</p>
               
               $att

               <br>
               <p><b>Motivos de Rechazo: </b> $comentarios</p>
               <a href='$url' class='btn btn-primary'>Ver PR</a>
EOD;

        $CI->email->from('tickets@masmetrologia.com', 'Soporte SIGA-MAS');

        $CI->email->to($remitentes);

        $CI->email->subject('Solicitud de Compra (PR)');
        $CI->email->message($mensaje);

        $CI->email->send();
    }

















/*
    function edicionQR($datos) {

        $id = $datos['id'];
        $fecha = $datos['fecha'];
        $usuario = $datos['usuario'];
        //$cliente = $datos['cliente'];
        $prioridad = $datos['prioridad'];
        $unidad = $datos['unidad'];
        $cantidad = $datos['cantidad'];
        $descripcion = $datos['descripcion'];
        $atributos = json_decode($datos['atributos'], TRUE);
        $correos = $datos['correos'];
        $comentarios = $datos['comentarios'];


        $logo = base_url('template/images/logo.png');
        $url = base_url('compras/ver_qr/') . $id;
        $idCompleto = "QR" . str_pad($id, 6, "0", STR_PAD_LEFT);

        $remitentes = array('tickets@masmetrologia.com');

        $remitentes = array_merge($remitentes, $correos);
        

        $CI = & get_instance();
        $CI->load->library('email');

        $att = "";
        foreach ($atributos as $key => $value) {
            $att .= "<p><b>" . ucfirst($key) . ":</b> $value</p>";
        }

        $mensaje = <<<EOD

               <img width='400' src='$logo'><br>
               <h1><font face="Arial">SIGA-MAS</font></h1>
               <h2>Se ha editado QR</h2>
               <p><b>ID:</b> $idCompleto</p>
               <p><b>Usuario:</b> $usuario</p>
               <p><b>Prioridad:</b> $prioridad</p>
               <p><b>Unidad:</b> $unidad</p>
               <p><b>Cantidad:</b> $cantidad</p>
               <p><b>Descripción:</b> $descripcion</p>

               $att

               <br>
               <p><b>Notas: </b> $comentarios</p>
               <a href='$url' class='btn btn-primary'>Ver QR</a>
EOD;

        $CI->email->from('tickets@masmetrologia.com', 'Soporte SIGA-MAS');

        $CI->email->to($remitentes);

        $CI->email->subject('Requisición de Cotización (QR)');
        $CI->email->message($mensaje);

        $CI->email->send();
    }

    function comentarioQR($datos) {

        $id = $datos['id'];
        $comentario = $datos['comentario'];
        $correos = $datos['correos'];
        

        $logo = base_url('template/images/logo.png');
        $url = base_url('compras/ver_qr/') . $id;
        $idCompleto = "QR" . str_pad($id, 6, "0", STR_PAD_LEFT);

        $remitentes = array('tickets@masmetrologia.com');

        $remitentes = array_merge($remitentes, $correos);
        

        $CI = & get_instance();
        $CI->load->library('email');



        $mensaje = <<<EOD

               <img width='400' src='$logo'><br>
               <h1><font face="Arial">SIGA-MAS</font></h1>
               <h2>Nuevo comentario de QR</h2>
               <p><b>ID:</b> $idCompleto</p>

               <br>
               <p><b>Comentario: </b> $comentario</p>
               <a href='$url' class='btn btn-primary'>Ver QR</a>
EOD;

        $CI->email->from('tickets@masmetrologia.com', 'Soporte SIGA-MAS');

        $CI->email->to($remitentes);

        $CI->email->subject('Nuevo Comentario (QR)');
        $CI->email->message($mensaje);

        $CI->email->send();
    }




   */
}
