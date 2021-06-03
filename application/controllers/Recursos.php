<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Recursos extends CI_Controller {

    function __construct() {
        parent::__construct();
        //$this->load->library('aos_funciones');
    }


    //                         __
    //                       .'  '.
    //                   _.-'/  |  \
    //      ,        _.-"  ,|  /    `-.
    //      |\    .-"       `--""-.__.'======================,
    //      \ '-'`        .___.--._)=========================|
    //       \            .'      |                          |
    //        |     /,_.-'        |        CODIGO AJAX       |
    //      _/   _.'(             |            BY            |
    //     /  ,-' \  \            |        ALEKS ORTIZ       |
    //     \  \    `-'            |                          |
    //      `-'                   '--------------------------'
    
    /////////////////////////////  C O N T R O L  D E  R E C U R S O S  /////////////////////////////


    function asignar_recursos(){
        $usd = $this->aos_funciones->getUSD();
        $data['usd'] = $usd[0];
        $data['usd_actualizacion'] = $usd[1];

        $this->load->view('header');
        $this->load->view('recursos/asignar_recursos', $data);
    }

    function ver_forma_pago(){
        if(isset($_POST["id"])){
            $id = $this->input->post('id');
        }
        else {
            redirect(base_url('inicio'));
        }

        $data["id"] = $id;

        $this->load->view('header');
        $this->load->view('recursos/ver_forma_pago', $data);
    }

    function ajax_getPO_recursos(){
        
        $metodo = 0; $date_sort = 0;
        if(isset($_POST['metodo']))
        {
            $metodo = $this->input->post('metodo');
        }
        if(isset($_POST['date_sort']))
        {
            $date_sort = $this->input->post('date_sort');
        }
        
        $query = "SELECT PO.*, concat(U.nombre, ' ', U.paterno) as User from ordenes_compra PO inner join usuarios U on U.id = PO.usuario where 1 = 1";
        
        $query .= " and PO.recurso != 'PAGADO'";

        $query .= " and (PO.estatus = 'AUTORIZADA' or PO.estatus = 'ORDENADA' or PO.estatus = 'RECIBIDA' or PO.estatus = 'CERRADA')";


        if($metodo != 0){
            $query .= " and PO.metodo_pago = $metodo";
        }

        if($date_sort != 0){
            $query .= " order by PO.fecha_cobro desc";
        }


        $res = $this->Conexion->consultar($query);
        if($res){
            echo json_encode($res);
        }
        else {
            echo "";
        }
    }

    function ajax_getMetodosPago(){
        //$query = "SELECT MP.*, (ifnull(sum(MPM.monto), 0) - ifnull(sum(PO.total), 0)) as Saldo from empresa_metodos_pago MP left join empresa_metodos_pago_movimientos MPM on MPM.metodo = MP.id left join ordenes_compra PO on PO.metodo_pago = MP.id and PO.recurso != 'PENDIENTE' group by MP.id;";
        $query = "SELECT MP.*, (SELECT (ifnull(sum(MPM.monto), 0)) as Ingreso from empresa_metodos_pago_movimientos MPM where MPM.metodo = MP.id) - (ifnull(sum(PO.total * PO.tipo_cambio), 0)) as Saldo from empresa_metodos_pago MP left join ordenes_compra PO on PO.metodo_pago = MP.id and PO.recurso != 'PENDIENTE' and (PO.estatus != 'RECHAZADA' and PO.estatus != 'CANCELADA') where MP.activo = '1' group by MP.id";

        $res = $this->Conexion->consultar($query);
        if($res){
            echo json_encode($res);
        }
        else {
            echo "";
        }
    }



    function ajax_setPO(){
        $this->load->library('recursos_funciones');

        $po = json_decode($this->input->post('PO'));

        $res = $this->Conexion->modificar('ordenes_compra', $po, array('fecha_provision' => 'CURRENT_TIMESTAMP()'), array('id' => $po->id));
        if($res > 0)
        {
            $this->recursos_funciones->NotificacionMinimo($po->metodo_pago);
            echo "1";
        }
    }

    function ajax_setFondeo(){
        $registro = json_decode($this->input->post('registro'));
        $registro->usuario = $this->session->id;

        $res = $this->Conexion->insertar('empresa_metodos_pago_movimientos', $registro, array('fecha' => 'CURRENT_TIMESTAMP()'));
        if($res > 0)
        {
            $this->Conexion->modificar('empresa_metodos_pago', array('fondear' => 0), null, array('id' => $registro->metodo));
            echo "1";
        }
    }

    //
    function ajax_getMovimientos(){
        $id = $this->input->post('id');
        
        $query = "SELECT EMM.id, EMM.monto, '1' as tipo_cambio, EMM.fecha, 'ABONO' as TipoM, EM.nombre, EM.tipo from empresa_metodos_pago_movimientos EMM inner join empresa_metodos_pago EM on EMM.metodo = EM.id where EMM.metodo = $id";
        $query .= " UNION ";
        $query .= "SELECT PO.id, PO.total, PO.tipo_cambio, PO.fecha_provision, PO.recurso, M.nombre, M.tipo from ordenes_compra PO inner join empresa_metodos_pago M on PO.metodo_pago = M.id where PO.metodo_pago = $id and PO.recurso != 'PENDIENTE' and (PO.estatus != 'RECHAZADA' and PO.estatus != 'CANCELADA') order by fecha";

        $res = $this->Conexion->consultar($query);
        if($res){
            echo json_encode($res);
        }
        else {
            echo "";
        }
    }


}