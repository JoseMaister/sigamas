<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Correos_po {

    function creacionPO($datos) {
        $CI = & get_instance();
        $CI->load->library('email');


        $id = $datos['id'];
        $fecha = $datos['fecha'];
        $usuario = $datos['usuario'];
        $prioridad = $datos['prioridad'];
        
        $proveedor = $datos['proveedor'];
        $contacto = $datos['contacto'];
        $moneda = $datos['moneda'];
        $total = $datos['total'];
        $total = '$' . number_format($total, 2) . ' ' . $moneda;

        $correos = $datos['correos'];


        $logo = base_url('template/images/logo.png');
        $url = base_url('ordenes_compra/ver_po/') . $id;
        $idCompleto = "PO-" . str_pad($id, 6, "0", STR_PAD_LEFT);

        $mensaje = "
            <img width='400' src='$logo'><br>
            <h1><font face='Times'>SIGA-MAS</font></h1>
            <h2>Se ha creado PO (Orden de Compra)</h2>
            <p><b>ID:</b> $idCompleto</p>
            <p><b>Comprador:</b> $usuario</p>
            <p><b>Prioridad:</b> $prioridad</p>
            <p><b>Proveedor:</b> $proveedor</p>
            <p><b>Contacto:</b> $contacto</p>
            <p><b>Total:</b> $total</p>
            <br>
            <a href='$url' class='btn btn-primary'>Ver PO</a>";

        $CI->email->from('tickets@masmetrologia.com', 'Soporte SIGA-MAS');
        $CI->email->to($correos);

        $CI->email->subject('Orden de Compra (PO)');
        $CI->email->message($mensaje);

        $CI->email->send();
    }

    function aprobarPO($PO) {
        $CI = & get_instance();
        $CI->load->library('email');


        $id = $PO->id;
        $fecha = date('d/m/Y h:i A');
        $comprador = $PO->User;
        $comprador_correo = $PO->UserMail;
        $prioridad = $PO->prioridad;
        
        $proveedor = $PO->Prov;
        $contacto = $PO->Contact;
        $aprobador = $PO->UserA;
        $moneda = $PO->moneda;
        $total = $PO->total;
        $total = '$' . number_format($total, 2) . ' ' . $moneda;

        $correos = array($comprador_correo);


        $logo = base_url('template/images/logo.png');
        $url = base_url('ordenes_compra/ver_po/') . $id;
        $idCompleto = "PO-" . str_pad($id, 6, "0", STR_PAD_LEFT);

        $mensaje = "
            <img width='400' src='$logo'><br>
            <h1><font face='Times'>SIGA-MAS</font></h1>
            <h2><font color='green'>Se ha aprobado PO (Orden de Compra)</font></h2>
            <p><b>ID:</b> $idCompleto</p>
            <p><b>Comprador:</b> $comprador</p>
            <p><b>Prioridad:</b> $prioridad</p>
            <p><b>Proveedor:</b> $proveedor</p>
            <p><b>Contacto:</b> $contacto</p>
            <p><b>Total:</b> $total</p>
            <br>
            <p><b>Aprobado por:</b> $aprobador</p>
            <a href='$url' class='btn btn-primary'>Ver PO</a>";

        $CI->email->from('tickets@masmetrologia.com', 'Soporte SIGA-MAS');
        $CI->email->to($correos);

        $CI->email->subject('Orden de Compra (PO)');
        $CI->email->message($mensaje);

        $CI->email->send();
    }

    function rechazarPO($PO) {
        $CI = & get_instance();
        $CI->load->library('email');


        $id = $PO->id;
        $fecha = date('d/m/Y h:i A');
        $comprador = $PO->User;
        $comprador_correo = $PO->UserMail;
        $prioridad = $PO->prioridad;
        $comentarios = $PO->comentario;
        
        $proveedor = $PO->Prov;
        $contacto = $PO->Contact;
        $aprobador = $PO->UserA;
        $moneda = $PO->moneda;
        $total = $PO->total;
        $total = '$' . number_format($total, 2) . ' ' . $moneda;

        $correos = array($comprador_correo);


        $logo = base_url('template/images/logo.png');
        $url = base_url('ordenes_compra/ver_po/') . $id;
        $idCompleto = "PO-" . str_pad($id, 6, "0", STR_PAD_LEFT);

        $mensaje = "
            <img width='400' src='$logo'><br>
            <h1><font face='Times'>SIGA-MAS</font></h1>
            <h2><font color='red'>Se ha rechazado PO (Orden de Compra)</font></h2>
            <p><b>ID:</b> $idCompleto</p>
            <p><b>Comprador:</b> $comprador</p>
            <p><b>Prioridad:</b> $prioridad</p>
            <p><b>Proveedor:</b> $proveedor</p>
            <p><b>Contacto:</b> $contacto</p>
            <p><b>Total:</b> $total</p>
            <br>
            <p><b>Rechazado por:</b> $aprobador</p>
            <p><b>Motivos de Rechazo: </b> $comentarios</p>
            <a href='$url' class='btn btn-primary'>Ver PO</a>";

        $CI->email->from('tickets@masmetrologia.com', 'Soporte SIGA-MAS');
        $CI->email->to($correos);

        $CI->email->subject('Orden de Compra (PO)');
        $CI->email->message($mensaje);

        $CI->email->send();
    }

    function enviarPO_proveedor($datos) {
        $id = $datos['id'];
        $file = base_url('ordenes_compra/po_pdf/' . $id);

        $correo_prov = $datos['correo_proveedor'];
        $body = $datos['body'];
        $remitentes = array($correo_prov);

        $CI = & get_instance();
        $config['smtp_user'] = $CI->session->correo;
        $config['smtp_pass'] = $CI->session->password_correo;
               
        $CI->load->library('email', $config);

        $CI->email->from($CI->session->correo, 'Compras SIGA-MAS');

        $CI->email->to($remitentes);

        $CI->email->subject('Orden de Compra');
        $CI->email->message($body);
        $filename = 'PO-' . str_pad($id, 6, "0", STR_PAD_LEFT) . ".pdf";
        $CI->email->attach($file, 'attachment', $filename);
        $CI->email->send();

        echo $CI->email->print_debugger();
    }


}
