<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Correos {

    function creacionTicket($datos) {

        $id = $datos['id'];
        $prefijo = $datos['prefijo'];
        $titulo = $datos['titulo'];
        $fecha = $datos['fecha'];
        $usuario = $datos['usuario'];
        $correo = $datos['correo'];

        $logo = base_url('template/images/logo.png');
        $url = base_url('tickets_' . $prefijo . '/ver/') . $id;
        $idCompleto = $prefijo . str_pad($id, 6, "0", STR_PAD_LEFT);

        if($prefijo == "IT")
        {
            $remitentes = array('tickets@masmetrologia.com', 'crodriguez@masmetrologia.com', 'jc@masmetrologia.com', $correo);
        }
        else if ($prefijo == "AT")
        {
            $remitentes = array('gsolano@masmetrologia.com', $correo);
        }
        else if ($prefijo == "ED")
        {
            $remitentes = array('gsolano@masmetrologia.com', $correo);
        }
        else
        {
            exit();
        }

        $CI = & get_instance();
        $CI->load->library('email');


        $mensaje = <<<EOD

               <img width='400' src='$logo'><br>
               <h1><font face="Arial">SIGA-MAS</font></h1>
               <h2>Se ha creado Ticket de Servicio $prefijo</h2>
               <p><b>ID:</b> $idCompleto</p>
               <p><b>Usuario:</b> $usuario</p>
               <p><b>Titulo:</b> $titulo</p>
               <a href='$url' class='btn btn-primary'>Ver Ticket</a>
EOD;

        $CI->email->from('tickets@masmetrologia.com', 'Soporte SIGA-MAS');

        $CI->email->to($remitentes);

        $CI->email->subject('Ticket De Servicio');
        $CI->email->message($mensaje);

        $CI->email->send();
    }

    function ticketSolucionado($datos) {
        $id = $datos['id'];
        $prefijo = $datos['prefijo'];
        $fecha = $datos['fecha'];
        $usuario = $datos['usuario'];
        $correo = $datos['correo'];
        $tecnico = $datos['tecnico'];

        $logo = base_url('template/images/logo.png');
        $url = base_url('tickets_' . $prefijo . '/ver/') . $id;
        $idCompleto = $prefijo . str_pad($id, 6, "0", STR_PAD_LEFT);

        $CI = & get_instance();
        $CI->load->library('email');

        if($prefijo == "IT")
        {
            $remitentes = array('tickets@masmetrologia.com', 'crodriguez@masmetrologia.com', 'jc@masmetrologia.com', $correo);
        }
        else if ($prefijo == "AT")
        {
            $remitentes = array('gsolano@masmetrologia.com', $correo);
        }
        else if ($prefijo == "ED")
        {
            $remitentes = array('gsolano@masmetrologia.com', $correo);
        }
        else
        {
            exit();
        }


        $mensaje = <<<EOD

               <img width='400' src='$logo'><br>
               <h1><font face="Arial">SIGA-MAS</font></h1>
               <h2>Se ha creado Ticket de Servicio $prefijo</h2>
               <p><b>ID:</b> $idCompleto</p>
               <p><b>Usuario:</b> $usuario</p>
               <p><b>Se ha Solucionado Ticket de Servicio</b></p>
               <p><b>Solucionado por:</b> $tecnico</p>
               <a href='$url' class='btn btn-primary'>Ver Ticket</a>
EOD;

        $CI->email->from('tickets@masmetrologia.com', 'Soporte SIGA-MAS');


        $CI->email->to($remitentes);

        $CI->email->subject('Ticket de Servicio');
        $CI->email->message($mensaje);

        $CI->email->send();
    }

    function creacionQR($datos) {

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
               <h2>Se ha creado QR</h2>
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

    function liberarQR($datos) {

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

        if($estatus == "LIBERADO")
        {
            $leyendaEstatus = "Se ha liberado QR";
        }
        else if($estatus == "COMPRA APROBADA")
        {
            $leyendaEstatus = "Se ha Aprobado Compra";
        }


        $logo = base_url('template/images/logo.png');
        $url = base_url('compras/ver_qr/') . $id;
        $idCompleto = "QR" . str_pad($id, 6, "0", STR_PAD_LEFT);

        $remitentes = $correos;
        

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
               <a href='$url' class='btn btn-primary'>Ver QR</a>
EOD;

        $CI->email->from('tickets@masmetrologia.com', 'Soporte SIGA-MAS');

        $CI->email->to($remitentes);

        $CI->email->subject('Requisición de Cotización (QR)');
        $CI->email->message($mensaje);

        $CI->email->send();
    }

    function rechazoQR($datos) {

        $id = $datos['id'];
        $fecha = $datos['fecha'];
        $usuario = $datos['usuario'];
        $cliente = $datos['cliente'];
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

        $remitentes = $correos;
        

        $CI = & get_instance();
        $CI->load->library('email');


        $att = "";
        foreach ($atributos as $key => $value) {
            $att .= "<p><b>" . ucfirst($key) . ":</b> $value</p>";
        }

        $mensaje = <<<EOD

               <img width='400' src='$logo'><br>
               <h1><font face="Arial">SIGA-MAS</font></h1>
               <h2><font color='red'>Se ha rechazado QR</font></h2>
               <p><b>ID:</b> $idCompleto</p>
               <p><b>Usuario:</b> $usuario</p>
               <p><b>Cliente:</b> $cliente</p>
               <p><b>Prioridad:</b> $prioridad</p>
               <p><b>Unidad:</b> $unidad</p>
               <p><b>Cantidad:</b> $cantidad</p>
               <p><b>Descripción:</b> $descripcion</p>
               
               $att

               <br>
               <p><b>Motivos de Rechazo: </b> $comentarios</p>
               <a href='$url' class='btn btn-primary'>Ver QR</a>
EOD;

        $CI->email->from('tickets@masmetrologia.com', 'Soporte SIGA-MAS');

        $CI->email->to($remitentes);

        $CI->email->subject('Requisición de Cotización (QR)');
        $CI->email->message($mensaje);

        $CI->email->send();
    }

    function proxMtto200($datos){
      $logo = base_url('template/images/logo.png');

      $auto = $datos['auto'];
      $placas = $datos['placas'];
      $serie = $datos['serie'];
      $kmActual = $datos['kmActual'];
      $proxMtto = $datos['proxMtto'];
      $correo = $datos['correoResponsable'];
      $url = base_url('autos/proximos_mttos');


      $CI = & get_instance();
      $CI->load->library('email');

      $remitentes = array('tickets@masmetrologia.com', $correo);


      $mensaje = <<<EOD

             <img width='400' src='$logo'><br>
             <h1><font face="Arial">SIGA-MAS</font></h1>
             <h2>Notificación de Proximo Mantenimiento</h2>
             <p><b>Auto:</b> $auto</p>
             <p><b>Placas:</b> $placas</p>
             <p><b>Serie:</b> $serie</p>
             <p><b>Kilometraje Actual:</b> $kmActual KM</p>
             <p><b>Proximo Mantenimiento:</b> $proxMtto KM</p>
             <a href='$url' class='btn btn-primary'>Ver Proximos Mantenimientos</a>
EOD;

      $CI->email->from('tickets@masmetrologia.com', 'Soporte SIGA-MAS');


      $CI->email->to($remitentes);

      $CI->email->subject('Proximo Mantenimiento');
      $CI->email->message($mensaje);

      $CI->email->send();
    }
}
