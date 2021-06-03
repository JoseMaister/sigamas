<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Recursos_funciones {

    function NotificacionMinimo($id_metodo){
        $CI = & get_instance();

        $CI->load->library('email');

        $res = $CI->Conexion->consultar("SELECT MP.nombre, (SELECT (ifnull(sum(MPM.monto), 0)) as Ingreso from empresa_metodos_pago_movimientos MPM where MPM.metodo = MP.id) - (ifnull(sum(PO.total * PO.tipo_cambio), 0)) as Saldo, MP.minimo, concat(U.nombre, ' ', U.paterno) as User, U.correo, MP.fondear FROM empresa_metodos_pago MP left join ordenes_compra PO on PO.metodo_pago = MP.id and PO.recurso != 'PENDIENTE' and (PO.estatus != 'RECHAZADA' and PO.estatus != 'CANCELADA') INNER JOIN usuarios U on JSON_CONTAINS(MP.notificaciones, CAST(U.id as JSON), '$') WHERE MP.id = $id_metodo group by U.id");

        $correos = array();
        foreach ($res as $elem) {
            array_push($correos, $elem->correo);
            $metodo = $elem->nombre;
            $minimo = $elem->minimo;
            $saldo = $elem->Saldo;
            $fondeo = $elem->fondear;
        }

        if(count($correos) > 0 && $saldo < $minimo && $minimo > 0 && $fondeo == 0)
        {
            $logo = base_url('template/images/logo.png');
            $mensaje = "
                <img width='400' src='$logo'><br>
                <h1><font face='Times'>SIGA-MAS</font></h1>
                <p>El instrumento: '$metodo' esta por debajo de su capital mínimo</p>
                <p><b>Saldo Actual</b>: $". number_format($saldo, 2) . "</p>
                <p><b>Mínimo</b>: $". number_format($minimo, 2) . "</p>";

            $CI->email->from('tickets@masmetrologia.com', 'SIGA-MAS');
            $CI->email->to($correos);

            $CI->email->subject('Notificación de Recursos');
            $CI->email->message($mensaje);

            if($CI->email->send())
            {
                $CI->Conexion->modificar('empresa_metodos_pago', array('fondear' => 1), null, array('id' => $id_metodo));
            }
        }
    }

}
