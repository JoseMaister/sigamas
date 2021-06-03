<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Compras extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('compras_model','Modelo');
        $this->load->model('descargas_model');
        $this->load->model('conexion_model', 'Conexion');

        $this->load->helper('download');
        $this->load->library('correos');
        $this->load->library('correos_pr');
        $this->load->library('AOS_funciones');
    }

    function generar_qr(){
        $this->load->view('header');
        $this->load->view('compras/generar_qr');
    }

    function ver_qr($id){
        $data['comentarios'] = $this->Modelo->verQr_comentarios($id);
        $data['comentarios_fotos'] = $this->Modelo->verQr_comentarios_fotos($id);

        $data['qr'] = $this->Modelo->getDetalleQR($id);

        switch ($data['qr']->estatus) 
        {
            case 'ABIERTO':
            $data['btn_estatus'] = "btn-primary";
            break;

            case 'LIBERADO':
            case 'COMPRA APROBADA':
            $data['btn_estatus'] = "btn-success";
            break;

            case 'COTIZANDO':
            $data['btn_estatus'] = "btn-warning";
            break;

            case 'CANCELADO':
            $data['btn_estatus'] = "btn-default";
            break;

            case 'RECHAZADO':
            case 'COMPRA RECHAZADA':
            $data['btn_estatus'] = "btn-danger";
            break;
            
            default:
                # code...
                break;
        }

        $this->load->view('header');
        $this->load->view('compras/ver_qr', $data);
    }

    function editar_qr($id){
        $data['qr'] = $this->Modelo->getDetalleQR($id);
        $this->load->view('header');
        $this->load->view('compras/editar_qr', $data);
    }

    function clonar_qr($id){
        $data['qr'] = $this->Modelo->getDetalleQR($id);
        $this->load->view('header');
        $this->load->view('compras/clonar_qr', $data);
    }

    function requisiciones($estatus = 'TODO'){
        $data['estatus'] = strtoupper($estatus);

        $data['otros_aprobadores'] = $data['estatus'] == 'TODO' ? '' : 'unchecked';

        $this->load->view('header');
        $this->load->view('compras/catalogo_qr', $data);
    }
    
    function mis_qrs(){
        $this->load->view('header');
        $this->load->view('compras/mis_qrs');
    }

    /////////////////////////////////////////////////////////////////////
    function ajax_generarQR(){
        $_info = json_decode($this->input->post('info'));
        $_atributos = $this->input->post('atributos');

        $info['usuario'] = $this->session->id;
        //$info['cliente'] = $_info->cliente;
        $info['archivo'] = "0";
        $info['nombre_archivo'] = "";
        $info['tipo'] = $_info->tipo;
        $info['subtipo'] = $_info->subtipo;
        $info['cantidad'] = $_info->cantidad;
        $info['cantidad_aprobada'] = 0;
        $info['unidad'] = $_info->unidad;
        $info['clave_unidad'] = $_info->clave_unidad;
        $info['descripcion'] = $_info->descripcion;
        $info['prioridad'] = $_info->prioridad;
        $info['lugar_entrega'] = $_info->lugar_entrega;
        $info['comentarios'] = $_info->comentarios;
        $info['critico'] = $_info->critico;
        $info['destino'] = $_info->destino;
        $info['atributos'] = $_atributos;
        $info['notificaciones'] = $_info->notificaciones;
        $info['estatus'] = 'ABIERTO';


        $res = $this->Modelo->generarQR($info);
        if($res)
        {
            $datos['id'] = $res;
            $datos['fecha'] = date('d/m/Y h:i A');
            $datos['usuario'] = $this->session->nombre;
            //$datos['cliente'] = $_info->nombrecliente;
            $datos['cantidad'] = $_info->cantidad;
            $datos['unidad'] = $_info->unidad;
            $datos['descripcion'] = $_info->descripcion;
            $datos['atributos'] = $_atributos;
            $datos['prioridad'] = $_info->prioridad;
            $datos['comentarios'] = $_info->comentarios;
            $datos['correos'] = array_merge(array($this->session->correo), $this->Modelo->getCorreosQR());
            
            if($_info->prioridad != 'NORMAL')
            {
                $this->correos->creacionQR($datos);
            }
            echo $res;
        }
    }

    function test(){
        print_r($this->Modelo->getCorreosQR());
    }

    function ajax_editarQR(){
        $_info = json_decode($this->input->post('info'));
        $_atributos = $this->input->post('atributos');

        $info['id'] = $_info->id;
        $info['usuario'] = $this->session->id;
        $info['tipo'] = $_info->tipo;
        $info['subtipo'] = $_info->subtipo;
        $info['cantidad'] = $_info->cantidad;
        //$info['cantidad_aprobada'] = 0;
        $info['unidad'] = $_info->unidad;
        $info['clave_unidad'] = $_info->clave_unidad;
        $info['descripcion'] = $_info->descripcion;
        $info['prioridad'] = $_info->prioridad;
        $info['lugar_entrega'] = $_info->lugar_entrega;
        $info['comentarios'] = $_info->comentarios;
        $info['critico'] = $_info->critico;
        $info['destino'] = $_info->destino;
        $info['atributos'] = $_atributos;
        $info['notificaciones'] = $_info->notificaciones;
        $info['estatus'] = 'ABIERTO';


        $res = $this->Modelo->editarQR($info);
        if($res)
        {
            $datos['id'] = $_info->id;
            $datos['fecha'] = date('d/m/Y h:i A');
            $datos['usuario'] = $this->session->nombre;
            $datos['cantidad'] = $_info->cantidad;
            $datos['unidad'] = $_info->unidad;
            $datos['descripcion'] = $_info->descripcion;
            $datos['atributos'] = $_atributos;
            $datos['prioridad'] = $_info->prioridad;
            $datos['comentarios'] = $_info->comentarios;
            $datos['correos'] = array_merge(array($this->session->correo), $this->Modelo->getCorreosQR());
            
            if($_info->prioridad != 'NORMAL')
            {
                $this->correos->edicionQR($datos);
            }
            echo "1";
        }
    }


    function ajax_getQRs(){
        $prioridad = json_decode($this->input->post('prioridad'));
        $tipo = json_decode($this->input->post('tipo'));
        $estatus = $this->input->post('estatus');
        $texto = $this->input->post('texto');
        $parametro = $this->input->post('parametro');
        $usuario = $this->input->post('usuario');

        $query = "SELECT R.id, R.fecha, R.usuario, R.prioridad, R.tipo, R.subtipo, R.cantidad, R.cantidad_aprobada, R.unidad, R.clave_unidad, R.descripcion, R.atributos, R.critico, R.destino, R.lugar_entrega, R.comentarios, R.estatus, concat(U.nombre, ' ', U.paterno) as User";
        $query .= " from requisiciones_cotizacion R left join usuarios U on R.usuario = U.id where 1 = 1";

        if($estatus != 'TODO')
        {
            $query .= " and R.estatus = '$estatus'";
        }
        if($usuario == '1')
        {
            $idUser = $this->session->id;
            $query .= " and R.usuario = '$idUser'";
        }

        if(count($prioridad) > 0)
        {
            $query .= " and ( 1 = 0 ";
            foreach ($prioridad as $key => $value) {
                $query .= " or R.prioridad = '$value'";
            }
            $query .= " )";
            
        }

        if(isset($tipo) && count($tipo) > 0)
        {
            $query .= " and ( 1 = 0 ";
            foreach ($tipo as $key => $value) {
                $query .= " or R.tipo = '$value'";
            }
            $query .= " )";
        }

        if( $this->session->privilegios['crear_qr_interno'] != $this->session->privilegios['crear_qr_venta'] )
        {
            if($this->session->privilegios['editar_qr'] == "0" && $this->session->privilegios['liberar_qr'] == "0")
            {
                if($this->session->privilegios['crear_qr_interno'] == "1")
                {
                    $query .= " and R.destino = 'CONSUMO INTERNO'";
                }
                else
                {
                    $query .= " and R.destino = 'VENTA'";
                }
            }
        }

        if(!empty($texto))
        {
            if($parametro == "folio")
            {
                $query .= " and R.id = '$texto'";
            }
            if($parametro == "usuario")
            {
                //$query .= " having User like '%$texto%'";
                $query .= " and concat(U.nombre, ' ', U.paterno) like '%$texto%'";
            }
            if($parametro == "contenido")
            {
                $query .= " and (R.descripcion like '%$texto%' or UPPER(R.atributos->'$.marca') like UPPER('%$texto%') or UPPER(R.atributos->'$.modelo') like UPPER('%$texto%') )";
            }
        }

        $query .= " and R.maximo_vencimiento > (CURRENT_DATE() - INTERVAL 1 YEAR) order by R.fecha desc";


        $res = $this->Modelo->consulta($query);
        if($res)
        {
            echo json_encode($res);
            //echo $query;
        }
        else{
            echo "";
        }
    }

    function ajax_getMisQRs(){
        $user = $this->input->post('usuario');
        
        $res = $this->Modelo->getMisQrs($user);
        if($res)
        {
            echo json_encode($res);
        }
        else{
            echo "";
        }
    }

    function ajax_getQRComentarios(){
        $qr = $this->input->post('qr');
        $res = $this->Conexion->consultar("SELECT C.*, concat(U.nombre, ' ', U.paterno, ' ', U.materno) as User from qr_comentarios C inner join usuarios U on U.id = C.usuario where C.qr = $qr");
        if($res)
        {
            echo json_encode($res);    
        }
    }

    function ajax_getDetalleQR(){
        $id = $this->input->post('idQR');
        $res = $this->Modelo->getDetalleQR($id);
        if($res)
        {
            echo json_encode($res);
        }
        else
        {
            echo "";
        }
    }

    function ajax_getUsuariosQRNotificaciones(){
        $privilegio = $this->input->post('privilegio');
        $id = $this->input->post('id');

        $query = "SELECT U.id, concat(U.nombre, ' ', U.paterno) as Nombre, P.puesto as Puesto, U.correo from usuarios U inner join puestos P on U.puesto = P.id inner join privilegios PR on PR.usuario = U.id where U.activo = 1";

        if($id)
        {
            $query .= " and U.id = '$id'";
        }
        else
        {
            $query .= " and PR.$privilegio = 1";
        }

        $res = $this->Conexion->consultar($query, $id);
        if($res)
        {
            echo json_encode($res);
        }
    }

    function ajax_getProveedoresAsignados() {
        $idQR = $this->input->post('idQR');
        $query = "SELECT E.id, QP.id as idQP, P.entrega, E.nombre, QP.monto, QP.total, QP.moneda, QP.tiempo_entrega, QP.dias_habiles, QP.comentarios, QP.nominado, QP.seleccionado, QP.nombre_archivo, QP.vencimiento from qr_proveedores QP inner join empresas E on E.id = QP.empresa inner join proveedores P on P.empresa = E.id where QP.qr = '".$idQR."'";
        $res = $this->Modelo->consulta($query);
        if($res)
        {
            echo json_encode($res);
        }
        else {
            echo "";
        }
    }

    function ajax_getPropuestas() {
        $idQR = $this->input->post('idQR');
        $query = "SELECT E.id, QP.id as idQP, P.entrega, P.rma_requerido, E.nombre, QP.monto, QP.total, QP.moneda, QP.tiempo_entrega, QP.dias_habiles, QP.comentarios, QP.nominado, QP.seleccionado, QP.nombre_archivo, QP.vencimiento, QR.cantidad, QR.descripcion, QR.tipo, QR.subtipo, ifnull(json_unquote(atributos->'$.serie'),'') as Serie from qr_proveedores QP inner join requisiciones_cotizacion QR on QR.id = QP.qr inner join empresas E on E.id = QP.empresa inner join proveedores P on P.empresa = E.id where QP.qr = '".$idQR."'";
        $res = $this->Modelo->consulta($query);
        if($res)
        {
            echo json_encode($res);
        }
        else {
            echo "";
        }
    }

    function ajax_setProveedor(){
        $data['qr'] = $this->input->post('idQR');
        $data['empresa'] = $this->input->post('idProv');
        $data['total'] = "0";
        $data['dias_habiles'] = "1";
        $data['nominado'] = "0";
        $data['seleccionado'] = "0";
        $data['comentarios'] = "";
        $data['factor'] = "0";
        

        $res = $this->Modelo->setProveedor($data);
        if($res)
        {
            echo "1";
        }
    }

    function ajax_setProveedorSugerido(){
        $qr = $this->input->post('qr');
        $qr_prov = $this->input->post('qr_prov');

        $query = "UPDATE qr_proveedores set seleccionado = '0' where qr='$qr'";
        $query2 = "UPDATE qr_proveedores set seleccionado = '1' where id='$qr_prov'";

        $this->Modelo->update($query);
        $this->Modelo->update($query2);

        echo "1";

    }

    function ajax_eliminarProveedor(){
        $data['qr'] = $this->input->post('qr');
        $data['empresa'] = $this->input->post('empresa');
        $res = $this->Modelo->deleteProveedor($data);
        if($res)
        {
            echo "1";
        }
    }

    function guardarProveedores(){
        //$this->output->enable_profiler(TRUE);
        $datos = json_decode($this->input->post('datos'), TRUE);

        foreach ($datos as $key => $value) {
            $this->Modelo->updateProveedor($value);
        }


        $id = $datos[0]["id"];
        
        
        $this->Conexion->comando("UPDATE requisiciones_cotizacion set maximo_vencimiento = (SELECT max(vencimiento) from qr_proveedores where qr = (SELECT qr from qr_proveedores where id = $id))");

        echo "1";
    }

    function proveedoresSugeridos(){
        $tags = $this->input->post('tags');
        $arreglo = explode(" ", trim($tags));
        $arreglo = array_diff($arreglo, array(""));

        $query = "SELECT E.id, E.nombre from empresas E inner join proveedores P on P.empresa = E.id where E.proveedor = 1 and (1 != 1 ";
        foreach ($arreglo as $key => $value) {
            $query .= " or tags like '%," . $value . ",%'";
        }
        $query .= ")";
        
        
        $res = $this->Modelo->consulta($query);
        if($res)
        {
            echo json_encode($res);
        }
        else {
            echo "";
        }
        
      }

      /*function proveedoresSugeridosMarca(){
        $tags = $this->input->post('tags');
        
        $arreglo = explode(" ", trim($tags));
        $arreglo = array_diff($arreglo, array(""));
 
        $query = "SELECT E.id, E.nombre, ifnull((SELECT count(QP.id) from qr_proveedores QP inner join requisiciones_cotizacion QR on QR.id = QP.qr where QP.monto > 0 and QP.empresa = E.id and upper(QR.atributos->'$.marca') = upper('\"$tags\"')), 0) as QtyQr from empresas E inner join proveedores P on P.empresa = E.id where E.proveedor = 1 and (1 != 1 ";
        foreach ($arreglo as $key => $value) {
            $query .= " or tags like '%," . $value . ",%'";
        }
        $query .= ")";

        $query .= " UNION ";

        $query .= "SELECT E.id, E.nombre, ifnull((SELECT count(QP.id) from qr_proveedores QP inner join requisiciones_cotizacion QR on QR.id = QP.qr where QP.monto > 0 and QP.empresa = E.id and upper(QR.atributos->'$.marca') = upper('\"$tags\"')), 0) as QtyQr from qr_proveedores QP inner join requisiciones_cotizacion QR on QP.qr = QR.id inner join empresas E on E.id = QP.empresa where E.proveedor = 1 and QP.monto > 0 and upper(QR.atributos->'$.marca') = upper('\"" . $tags . "\"');";
        
        $res = $this->Modelo->consulta($query);
        if($res)
        {
            echo json_encode($res);
        }
        else {
            echo "";
        }
      }*/

      function proveedoresSugeridosMarca(){
        $tags = $this->input->post('tags');
 
        $query = "SELECT E.id, E.nombre, ifnull((SELECT count(QP.id) from qr_proveedores QP inner join requisiciones_cotizacion QR on QR.id = QP.qr where QP.monto > 0 and QP.empresa = E.id and upper(QR.atributos->'$.marca') = upper('\"$tags\"')), 0) as QtyQr from empresas E inner join proveedores P on P.empresa = E.id where E.proveedor = 1 and (1 != 1 or tags like '%," . $tags . ",%') and !isnull(P.entrega) and json_length(P.tipo) > 0 and json_length(P.formas_pago) > 0";

        $query .= " UNION ";

        $query .= "SELECT E.id, E.nombre, ifnull((SELECT count(QP.id) from qr_proveedores QP inner join requisiciones_cotizacion QR on QR.id = QP.qr where QP.monto > 0 and QP.empresa = E.id and upper(QR.atributos->'$.marca') = upper('\"$tags\"')), 0) as QtyQr from qr_proveedores QP inner join requisiciones_cotizacion QR on QP.qr = QR.id inner join empresas E on E.id = QP.empresa where E.proveedor = 1 and QP.monto > 0 and upper(QR.atributos->'$.marca') = upper('\"" . $tags . "\"');";
        
        $res = $this->Modelo->consulta($query);
        if($res)
        {
            echo json_encode($res);
        }
        else 
        {
            echo "";
        }
      }

      function proveedoresSugeridosModelo(){
        $tags = $this->input->post('tags');

        $query = "SELECT E.id, E.nombre, ifnull((SELECT count(QP.id) from qr_proveedores QP inner join requisiciones_cotizacion QR on QR.id = QP.qr where QP.monto > 0 and QP.empresa = E.id and upper(QR.atributos->'$.modelo') = upper('\"$tags\"')), 0) as QtyQr from qr_proveedores QP inner join requisiciones_cotizacion QR on QP.qr = QR.id inner join empresas E on E.id = QP.empresa where E.proveedor = 1 and QP.monto > 0 and upper(QR.atributos->'$.modelo') = upper('\"" . $tags . "\"');";
        

        $res = $this->Modelo->consulta($query);
        if($res)
        {
            echo json_encode($res);
        }
        else {
            echo "";
        }
      }

    
      function ajax_getProveedor(){
        $id = $this->input->post('id');

        $query = "SELECT QP.id, QP.qr, QP.empresa, QP.costos, QP.monto, QP.moneda, QP.total, QP.tiempo_entrega, QP.dias_habiles, QP.comentarios, QP.nominado, QP.seleccionado, QP.vencimiento, QP.nombre_archivo, E.nombre, P.entrega from qr_proveedores QP inner join empresas E on E.id = QP.empresa inner join proveedores P on P.empresa = E.id where QP.id='" . $id . "'";

        $res = $this->Modelo->consulta($query, TRUE);
        if($res)
        {
            echo json_encode($res);
        }
        else
        {
            echo "";
        }

    }

    function ajax_getProveedores(){
        $texto = $this->input->post('texto');
        $query = "SELECT E.* from empresas E inner join proveedores P on E.id = P.empresa where 1=1";
        $query .= " and E.proveedor = 1 and (P.tags like '%,".$texto.",%' or E.nombre like '%".$texto."%')";
        $query .= " and !isnull(P.entrega) and json_length(P.tipo) > 0 and json_length(P.formas_pago) > 0";

        $res = $this->Modelo->consulta($query);
        if($res)
        {
            echo json_encode($res);
        }
        else {
            echo "";
        }

    }

    function ajax_setEstatusQR(){
        $estatus = $this->input->post('estatus');
        $idqr = $this->input->post('idqr');
        $liberador = $this->session->id;

        $query = "update requisiciones_cotizacion set estatus='" . $estatus . "' where id='" . $idqr . "'";

        if($estatus == "LIBERADO")
        {
            $query = "update requisiciones_cotizacion set estatus='" . $estatus . "', fecha_liberacion = CURRENT_TIMESTAMP(), liberador = $liberador where id='" . $idqr . "'";
        }

        $res = $this->Modelo->update($query);
        if($res){

            if($estatus == "LIBERADO" | $estatus == "COMPRA APROBADA")
            {
                $qr = $this->Modelo->getDetalleQR($idqr);

                $datos['id'] = $idqr;
                $datos['fecha'] = date('d/m/Y h:i A');
                $datos['usuario'] = $qr->User;
                $datos['cliente'] = $qr->Client;
                $datos['prioridad'] = $qr->prioridad;
                $datos['unidad'] = $qr->unidad;
                $datos['cantidad'] = $qr->cantidad;
                $datos['descripcion'] = $qr->descripcion;
                $datos['atributos'] = $qr->atributos;
                $datos['comentarios'] = $qr->comentarios;
                $datos['correos'] = array($qr->correo);

                $Notificar = json_decode($qr->notificaciones);

                $query = "SELECT U.correo from usuarios U where 1 != 1 ";
                foreach ($Notificar as $value) {
                    $query .= " or U.id = $value";
                }
                $res = $this->Conexion->consultar($query);
                foreach ($res as $key => $value) {
                    array_push($datos['correos'], $value->correo);
                }

                
                $datos['estatus'] = $estatus;

                $this->correos->liberarQR($datos);
            }
            echo "1";
        }
        else{
            echo "";
        }
    }

    function ajax_setEstatusMsjQR(){
        $idqr = $this->input->post('idqr');
        $estatus = $this->input->post('estatus');
        $comentario_original = $this->input->post('comentario');
        $comentario = "<b><font color='red'>$estatus:</font></b> " . $comentario_original;
        $tags = $this->input->post('txtTags');
        $correos = explode(",", $tags);



        $query = "UPDATE requisiciones_cotizacion set estatus='" . $estatus . "' where id='" . $idqr . "'";


        $res = $this->Modelo->update($query);
        if($res){

            $data = array(
                'qr' => $idqr,
                'usuario' => $this->session->id,
                'comentario' => $comentario,
            );
            $this->Modelo->agregar_comentario($data);
            
            $qr = $this->Modelo->getDetalleQR($idqr);
            
            $datos['id'] = $idqr;
            $datos['fecha'] = date('d/m/Y h:i A');
            $datos['usuario'] = $qr->User;
            $datos['cliente'] = $qr->Client;
            $datos['prioridad'] = $qr->prioridad;
            $datos['unidad'] = $qr->unidad;
            $datos['cantidad'] = $qr->cantidad;
            $datos['descripcion'] = $qr->descripcion;
            $datos['atributos'] = $qr->atributos;
            $datos['comentarios'] = $comentario_original;
            $datos['correos'] = array($qr->correo);


            if($estatus == "RECHAZADO" | $estatus == "COMPRA RECHAZADA")
            {
                $this->correos->rechazoQR($datos);
            }
            else if($estatus == "LIBERADO")
            {
                $this->correos->liberarQR($datos);
            }

            if(count($correos) > 0)
            {
                $datos2['id'] = $idqr;
                $datos2['comentario'] = $comentario;
                $datos2['correos'] = $correos;
                $this->correos->comentarioQR($datos2);
            }

            


            echo $comentario;
        }
        else{
            echo "";
        }
    }

    function ajax_setProveedoresNominados(){
        $res = TRUE;

        $qr_proveedor = json_decode($this->input->post('qr_proveedores'));
        $qr = $this->input->post('qr');

        $this->Modelo->update("UPDATE qr_proveedores set nominado=0 where qr= $qr");

        foreach ($qr_proveedor as $key => $value)
        {
            if(!$this->Modelo->update("UPDATE qr_proveedores set nominado=1 where id= $value"))
            {
                $res = FALSE;
            }
        }

        if($res){
            echo "1";
        }
        else{
            echo "";
        }
    }

    function ajax_subirArchivoQR() {
        $datos['id'] = $this->input->post('qr');
        $datos['archivo'] = file_get_contents($_FILES['file']['tmp_name']);
        $datos['nombre_archivo'] = str_pad($datos['id'], 6, "0", STR_PAD_LEFT) . ".pdf";
        //$datos['nombre_archivo'] = $_FILES['file']['name'];
        
        if(!$this->Modelo->setQRFile($datos))
        {
            trigger_error("Error al subir archivo", E_USER_ERROR);
        }
        else {
            //echo $datos['nombre_archivo'];
            echo "1";
        }
    }

    function ajax_borrarArchivoQR(){
        $datos['id'] = $this->input->post('qr');
        $datos['archivo'] = "";
        $datos['nombre_archivo'] = "";
        
        if(!$this->Modelo->setQRFile($datos))
        {
            trigger_error("Error al subir archivo", E_USER_ERROR);
        }
        else {
            //echo $datos['nombre_archivo'];
            echo "1";
        }
    }

    function ajax_subirEvidencia() {
        $datos['id'] = $this->input->post('qr_prov');
        $datos['archivo'] = file_get_contents($_FILES['file']['tmp_name']);
        $datos['nombre_archivo'] = $_FILES['file']['name'];
        
        if(!$this->Modelo->updateProveedor($datos))
        {
            trigger_error("Error al subir archivo", E_USER_ERROR);
        }
        else {
            echo $datos['nombre_archivo'];
        }
    }

    function ajax_eliminarEvidencia(){
        $datos['id'] = $this->input->post('qr_prov');
        $datos['archivo'] = null;
        $datos['nombre_archivo'] = null;

        if(!$this->Modelo->updateProveedor($datos))
        {
            trigger_error("Error al eliminar archivo", E_USER_ERROR);
        }
        else {
            echo "1";
        }
    }

    function getEvidencia($qr_prov){
        $row = $this->descargas_model->getFile($qr_prov, 'qr_proveedores');
        $file = $row->archivo;
        $nombre = $row->nombre_archivo;

        //$file = 'dummy.pdf';
        header('Content-type: application/pdf');
        header('Content-Disposition: inline; filename="' . $nombre . '"');
        header('Content-Transfer-Encoding: binary');
        //header('Content-Length: ' . filesize($file));
        header('Accept-Ranges: bytes');

        echo $file;

        //force_download($nombre, $file);
    }

    function getQrFile($qr){
        $row = $this->descargas_model->getFile($qr, 'requisiciones_cotizacion');
        $file = $row->archivo;
        $nombre = $row->nombre_archivo;

        //$file = 'dummy.pdf';
        header('Content-type: application/pdf');
        header('Content-Disposition: inline; filename="' . $nombre . '"');
        header('Content-Transfer-Encoding: binary');
        //header('Content-Length: ' . filesize($file));
        header('Accept-Ranges: bytes');

        echo $file;

        //force_download($nombre, $file);
    }

    function agregarComentario() {
        $idQr = $this->input->post('idQr');
        $comentario = $this->input->post('comentario');
        $tags = $this->input->post('txtTags');
        $correos = explode(",", $tags);

        $data = array(
            'qr' => $idQr,
            'usuario' => $this->session->id,
            'comentario' => $comentario,
        );

        $this->Modelo->agregar_comentario($data);

        if(count($correos) > 0)
        {
            $datos['id'] = $idQr;
            $datos['comentario'] = $comentario;
            $datos['correos'] = $correos;
            $this->correos->comentarioQR($datos);
        }

        redirect(base_url('compras/ver_qr/' . $idQr));
    }

    function ajax_getResumenMarca() {
        $prov = $this->input->post('prov');
        $marca = $this->input->post('marca');

        $query = "SELECT QP.id as idQP, QP.qr, QR.descripcion, QP.total, QP.moneda, QP.tiempo_entrega, QP.dias_habiles, QP.nombre_archivo, QP.vencimiento from qr_proveedores QP inner join requisiciones_cotizacion QR on QR.id = QP.qr where QP.monto > 0 and QP.empresa = '$prov' and upper(QR.atributos->'$.marca') = upper('\"$marca\"')";
        $res = $this->Modelo->consulta($query);
        if($res)
        {
            echo json_encode($res);
        }
        else {
            echo "";
        }
    }

    function ajax_getResumenModelo() {
        $prov = $this->input->post('prov');
        $modelo = $this->input->post('modelo');

        $query = "SELECT QP.id as idQP, QP.qr, QR.descripcion, QP.total, QP.moneda, QP.tiempo_entrega, QP.dias_habiles, QP.nombre_archivo, QP.vencimiento from qr_proveedores QP inner join requisiciones_cotizacion QR on QR.id = QP.qr where QP.monto > 0 and QP.empresa = '$prov' and upper(QR.atributos->'$.modelo') = upper('\"$modelo\"')";

        $res = $this->Modelo->consulta($query);
        if($res)
        {
            echo json_encode($res);
        }
        else {
            echo "";
        }
    }

    function ajax_getPRS_QR(){ //VER PR's RECIENTES CREADAS APARTIR DE LA ACTUAL QR... ANTES DE CREAR PR
        $idQR = $this->input->post('id_qr');
        $query = "SELECT PR.id, PR.fecha, PR.estatus, concat(U.nombre,' ',U.paterno) as User FROM prs PR inner join usuarios U on PR.usuario = U.id where (PR.estatus != 'CANCELADO' and PR.estatus != 'CERRADO') and PR.qr = $idQR;";

        $res = $this->Conexion->consultar($query);
        if($res){
            echo json_encode($res);
        }
        else{
            echo "";
        }
    }

    function dashboard(){
        $this->load->view('header');
        $this->load->view('compras/dashboard');
    }

    function ajax_getReporteQR(){
        $query = 'SELECT count(*) as Total, (SELECT count(*) FROM requisiciones_cotizacion where estatus = "ABIERTO") as Abiertos, (SELECT min(fecha) FROM requisiciones_cotizacion where estatus = "ABIERTO") as ultAbiertos,';
        $query .= ' (SELECT count(*) FROM requisiciones_cotizacion where estatus = "RECHAZADO") as Rechazados, (SELECT min(fecha) FROM requisiciones_cotizacion where estatus = "RECHAZADO") as ultRechazados,';
        $query .= ' (SELECT count(*) FROM requisiciones_cotizacion where estatus = "COTIZANDO") as Cotizando, (SELECT min(fecha) FROM requisiciones_cotizacion where estatus = "COTIZANDO") as ultCotizando';
        $query .= ' FROM requisiciones_cotizacion;';
        $res = $this->Conexion->consultar($query, TRUE);
        echo json_encode($res);
    }

    function ajax_getReportePR(){
        $query = 'SELECT count(*) as Total, (SELECT count(*) FROM prs where estatus = "PENDIENTE") as Pendientes, (SELECT min(fecha) FROM prs where estatus = "PENDIENTE") as ultPendientes,';
        $query .= ' (SELECT count(*) FROM prs where estatus = "APROBADO") as Aprobados, (SELECT min(fecha) FROM prs where estatus = "APROBADO") as ultAprobados,';
        $query .= ' (SELECT count(*) FROM prs where estatus = "RECHAZADO") as Rechazados, (SELECT min(fecha) FROM prs where estatus = "RECHAZADO") as ultRechazados,';
        $query .= ' (SELECT count(*) FROM prs where estatus = "EN SELECCION") as Seleccion, (SELECT min(fecha) FROM prs where estatus = "EN SELECCION") as ultSeleccion,';
        $query .= ' (SELECT count(*) FROM prs where estatus = "PO AUTORIZADA") as PO_Autorizada, (SELECT min(fecha) FROM prs where estatus = "PO AUTORIZADA") as ultPO_Autorizada,';
        $query .= ' (SELECT count(*) FROM prs where estatus = "EN PO") as En_PO, (SELECT min(fecha) FROM prs where estatus = "EN PO") as ultEn_PO,';
        $query .= ' (SELECT count(*) FROM prs where estatus = "POR RECIBIR") as Por_Recibir, (SELECT min(fecha) FROM prs where estatus = "POR RECIBIR") as ultPor_Recibir';
        $query .= ' FROM prs;';
        $res = $this->Conexion->consultar($query, TRUE);
        echo json_encode($res);
    }

    function ajax_getReportePO(){
        $query = 'SELECT count(*) as Total, (SELECT count(*) FROM ordenes_compra where estatus = "EN PROCESO") as EnProceso, (SELECT min(fecha) FROM ordenes_compra where estatus = "EN PROCESO") as ultEnProceso,'; 
        $query .= ' (SELECT count(*) FROM ordenes_compra where estatus = "PENDIENTE AUTORIZACION") as PendienteAutorizacion, (SELECT min(fecha) FROM ordenes_compra where estatus = "PENDIENTE AUTORIZACION") as ultPendienteAutorizacion,';
        $query .= ' (SELECT count(*) FROM ordenes_compra where estatus = "AUTORIZADA") as Autorizada, (SELECT min(fecha) FROM ordenes_compra where estatus = "AUTORIZADA") as ultAutorizada,';
        $query .= ' (SELECT count(*) FROM ordenes_compra where estatus = "RECHAZADA") as Rechazada, (SELECT min(fecha) FROM ordenes_compra where estatus = "RECHAZADA") as ultRechazada,';
        $query .= ' (SELECT count(*) FROM ordenes_compra where estatus = "ORDENADA") as Ordenada, (SELECT min(fecha) FROM ordenes_compra where estatus = "ORDENADA") as ultOrdenada,';
        $query .= ' (SELECT count(*) FROM ordenes_compra where estatus = "RECIBIDA") as Recibida, (SELECT min(fecha) FROM ordenes_compra where estatus = "RECIBIDA") as ultRecibida';
        $query .= ' FROM ordenes_compra;';
        $res = $this->Conexion->consultar($query, TRUE);
        echo json_encode($res);
    }

    ////////////////////////////////////////////////////////////// PURCHASE REQUEST //////////////////////////////////////////////////////////////
    function solicitudes_compra($estatus = 'TODO'){
        $estatus = strtoupper($estatus);
        $data['estatus'] = str_replace('_', ' ', $estatus);

        $data['otros_aprobadores'] = $data['estatus'] == 'TODO' ? '' : 'checked';
        
        $this->load->view('header');
        $this->load->view('compras/catalogo_pr', $data);
    }

    function ver_pr($id){
        
        $data['comentarios'] = $this->Modelo->verPr_comentarios($id);
        $data['comentarios_fotos'] = $this->Modelo->verPr_comentarios_fotos($id);

        $data['pr'] = $this->Modelo->getPR($id);

        switch ($data['pr']->estatus) 
        {
            case 'APROBADO':
            case 'PO AUTORIZADA':
            $data['btn_estatus'] = "btn-success";
            break;

            case 'PENDIENTE':
            case 'EN SELECCION':
            case 'POR RECIBIR':
            $data['btn_estatus'] = "btn-warning";
            break;

            case 'EN PO':
            case 'CERRADO':
            $data['btn_estatus'] = "btn-primary";
            break;

            case 'RECHAZADO':
            $data['btn_estatus'] = "btn-danger";
            break;

            case 'PROCESADO':
            case 'CANCELADO':
            $data['btn_estatus'] = "btn-default";
            break;
        }

        $this->load->view('header');
        $this->load->view('compras/ver_pr', $data);
    }

    function mis_prs(){
        $this->load->view('header');
        $this->load->view('compras/mis_prs');
    }

    function ajax_generarPR(){
        $qr = $this->input->post('qr');
        $qty = $this->input->post('qty');
        $precio = $this->input->post('precio');
        $descripcion = $this->input->post('descripcion');
        $serie = $this->input->post('serie');
        $qr_prov = $this->input->post('qr_prov');

        $item = $this->input->post('item');
        $id = $this->input->post('id');
        

        $qr = $this->Modelo->getDetalleQR($qr);
        $qr_prov = $this->Modelo->getQRProv($qr_prov);

        //ATRIBUTOS
        $att = json_decode($qr->atributos, TRUE);
        if(array_key_exists('serie', $att)){
            if(!$serie)
            {
                $serie = 'N/A';
            }
            $att['serie'] = $serie;

            if($id)
            {
                $att['id'] = $id;
            }
            if($item)
            {
                $att['item'] = $item;
            }
        }


        $datos['qr'] = $qr->id;
        $datos['qr_proveedor'] = $qr_prov->id;
        $datos['usuario'] = $this->session->id;
        $datos['prioridad'] = $qr->prioridad;
        $datos['tipo'] = $qr->tipo;
        $datos['subtipo'] = $qr->subtipo;
        $datos['cantidad'] = $qty;
        $datos['precio_unitario'] = $qr_prov->monto;
        $datos['importe'] = $qr_prov->monto * $qty;
        $datos['moneda'] = $qr_prov->moneda;
        $datos['unidad'] = $qr->unidad;
        $datos['clave_unidad'] = $qr->clave_unidad;
        $datos['descripcion'] = $descripcion;
        $datos['atributos'] = json_encode($att);
        $datos['critico'] = $qr->critico;
        $datos['destino'] = $qr->destino;
        $datos['lugar_entrega'] = $qr->lugar_entrega;
        $datos['comentarios'] = "";
        $datos['estatus'] = "PENDIENTE";

        $funciones['fecha'] = 'CURRENT_TIMESTAMP()';

        $res = $this->Conexion->insertar('prs', $datos, $funciones);

        if($res > 0)
        {
            $datos['id'] = $res;
            $datos['fecha'] = date('d/m/Y h:i A');
            $datos['usuario'] = $this->session->nombre;
            $datos['cantidad'] = $qty;
            $datos['unidad'] = $qr->unidad;
            $datos['descripcion'] = $qr->descripcion;
            $datos['atributos'] = $qr->atributos;
            $datos['prioridad'] = $qr->prioridad;
            $datos['comentarios'] = "";
            //$datos['correos'] = array_merge(array($this->session->correo), $this->Modelo->getCorreosAprobadoresPR($this->session->id));
            $datos['correos'] = array_merge(array($this->session->correo), $this->Modelo->getAprobadorPR($this->session->id, $qr->destino));
            
            $this->correos_pr->creacionPR($datos);
            
            echo $res;
        }
    }

    function ajax_editarPR(){
        $id = $this->input->post('id');
        $qty = $this->input->post('qty');

        $query = "UPDATE prs set cantidad = $qty, importe=precio_unitario*cantidad, estatus='PENDIENTE' where id=$id";
        $this->Conexion->comando($query);
        echo "1";

    }

    function ajax_getPRs(){
        $curUser = $this->session->id;
        $misprs = $this->input->post('misprs');

        $prioridad = json_decode($this->input->post('prioridad'));
        $estatus = $this->input->post('estatus');
        $texto = $this->input->post('texto');
        $parametro = $this->input->post('parametro');

        $query = "SELECT PR.id, PR.fecha, PR.usuario, PR.prioridad, PR.tipo, PR.subtipo, PR.cantidad, PR.unidad, PR.clave_unidad, PR.descripcion, PR.atributos, PR.critico, PR.destino, PR.lugar_entrega, PR.comentarios, PR.estatus, concat(U.nombre, ' ', U.paterno) as User, U.autorizador_compras, U.autorizador_compras_venta,";
        $query .= " ifnull((SELECT OCC.po from ordenes_compra_conceptos OCC inner join ordenes_compra OC on OCC.po = OC.id where OCC.pr = PR.id and OC.estatus != 'CANCELADA'), 0) as POActual";
        $query .= " from prs PR left join usuarios U on PR.usuario = U.id where 1 = 1";

        if($estatus != 'TODO')
        {
            $query .= " and PR.estatus = '$estatus'";
        }
        

        if(count($prioridad) > 0)
        {
            $query .= " and ( 1 = 0 ";
            foreach ($prioridad as $key => $value) {
                $query .= " or PR.prioridad = '$value'";
            }
            $query .= " )";
            
        }

        if($misprs == "1")
        {
            //$query .= " and U.autorizador_compras = $curUser";
            $query .= " and if(PR.destino = 'VENTA', U.autorizador_compras_venta = $curUser, U.autorizador_compras = $curUser)";
        }

        /*
        if($this->session->privilegios['crear_qr_interno'] != $this->session->privilegios['crear_qr_venta'])
        {
            if($this->session->privilegios['crear_qr_interno'] == "1")
            {
                $query .= " and R.destino = 'CONSUMO INTERNO'";
            }
            else
            {
                $query .= " and R.destino = 'VENTA'";
            }
        }
        */

        if(!empty($texto))
        {
            if($parametro == "folio")
            {
                $query .= " and PR.id = '$texto'";
            }
            if($parametro == "usuario")
            {
                $query .= " having User like '%$texto%'";
            }
            if($parametro == "contenido")
            {
                $query .= " and (PR.descripcion like '%$texto%' or UPPER(PR.atributos->'$.marca') like UPPER('%$texto%') or UPPER(PR.atributos->'$.modelo') like UPPER('%$texto%') )";
            }
        }

        if(true)
        {
            $query .= " order by PR.fecha desc";
        }


        $res = $this->Modelo->consulta($query);
        //echo $query;

        if($res)
        {
            echo json_encode($res);
        }
    }

    function ajax_getMisPRs(){
        $user = $this->session->id;

        $prioridad = json_decode($this->input->post('prioridad'));
        $estatus = $this->input->post('estatus');
        $texto = $this->input->post('texto');
        $parametro = $this->input->post('parametro');

        $misprs = $this->input->post('misprs');

        $query = "SELECT PR.id, PR.fecha, PR.usuario, concat(U.nombre, ' ', U.paterno, ' ', U.materno) as User, PR.prioridad, PR.tipo, PR.subtipo, PR.cantidad, PR.unidad, PR.clave_unidad, PR.descripcion, PR.atributos, PR.critico, PR.destino, PR.lugar_entrega, PR.comentarios, PR.estatus,";
        $query .= " ifnull((SELECT OCC.po from ordenes_compra_conceptos OCC inner join ordenes_compra OC on OCC.po = OC.id where OCC.pr = PR.id and OC.estatus != 'CANCELADA'), 0) as POActual";
        $query .= " from prs PR inner join usuarios U on U.id = PR.usuario where 1 = 1";

        if($misprs == "1")
        {
            $query .= " and PR.usuario = $user";
        }

        if($estatus != 'TODO')
        {
            $query .= " and PR.estatus = '$estatus'";
        }
        

        if(count($prioridad) > 0)
        {
            $query .= " and ( 1 = 0 ";
            foreach ($prioridad as $key => $value) {
                $query .= " or PR.prioridad = '$value'";
            }
            $query .= " )";
            
        }

        if(!empty($texto))
        {
            if($parametro == "folio")
            {
                $query .= " and PR.id = '$texto'";
            }
            if($parametro == "contenido")
            {
                $query .= " and (PR.descripcion like '%$texto%' or UPPER(PR.atributos->'$.marca') like UPPER('%$texto%') or UPPER(PR.atributos->'$.modelo') like UPPER('%$texto%') )";
            }
        }

        if(true)
        {
            $query .= " order by PR.fecha desc";
        }



        $res = $this->Modelo->consulta($query);
        if($res)
        {
            echo json_encode($res);
        }
        else{
            echo "";
        }









        /*$usuario = $this->session->id;

        $query = "SELECT PR.id, PR.fecha, PR.usuario, PR.prioridad, PR.tipo, PR.subtipo, PR.cantidad, PR.unidad, PR.clave_unidad, PR.descripcion, PR.atributos, PR.critico, PR.destino, PR.lugar_entrega, PR.comentarios, PR.estatus, concat(U.nombre, ' ', U.paterno) as User";
        $query .= " from prs PR left join usuarios U on PR.usuario = U.id where 1 = 1 and PR.usuario = $usuario order by PR.fecha desc";

        $res = $this->Modelo->consulta($query);
        if($res)
        {
            echo json_encode($res);
        }
        else{
            echo "";
        }
        */
    }

    function ajax_getPR(){

        $id = $this->input->post('id');

        $query = "SELECT PR.*, concat(U.nombre,' ',U.paterno) as User, U.correo from prs PR inner join usuarios U on U.id = PR.usuario where PR.id = $id";

        $res = $this->Conexion->consultar($query, TRUE);

        if($res)
        {
            echo json_encode($res);
        }
        else
        {
            echo "";
        }
    }

    function ajax_getProveedorPR() {
        $id = $this->input->post('id');
        $query = "SELECT E.id, QP.id as idQP, P.entrega, E.nombre, QP.monto, QP.total, QP.moneda, QP.tiempo_entrega, QP.dias_habiles, QP.comentarios, QP.nominado, QP.seleccionado, QP.nombre_archivo, QP.vencimiento from qr_proveedores QP inner join empresas E on E.id = QP.empresa inner join proveedores P on P.empresa = E.id where QP.id = '".$id."'";
        $res = $this->Modelo->consulta($query);
        if($res)
        {
            echo json_encode($res);
        }
        else {
            echo "";
        }
    }

    function ajax_setEstatusPR(){
        $estatus = $this->input->post('estatus');
        $id = $this->input->post('id');
        $aprobador = $this->session->id;

        $query = "update prs set estatus='" . $estatus . "' where id='" . $id . "'";

        if($estatus == "APROBADO")
        {
            $query = "update prs set estatus='" . $estatus . "', fecha_aprobacion = CURRENT_TIMESTAMP(), aprobador = $aprobador where id='" . $id . "'";
        }
        if($estatus == "CERRADO")
        {
            $query = "update prs set estatus='" . $estatus . "', entregado = CURRENT_TIMESTAMP() where id='" . $id . "'";
            if($this->Modelo->update($query))
            {
                echo "1";
            }
            exit();
        }


        $res = $this->Modelo->update($query);
        if($res){

            //$qr = $this->Modelo->getDetalleQR($idqr);
            $pr = $this->Modelo->getPR($id);

            $datos['id'] = $id;
            $datos['fecha'] = date('d/m/Y h:i A');
            $datos['usuario'] = $pr->User;
            $datos['prioridad'] = $pr->prioridad;
            $datos['unidad'] = $pr->unidad;
            $datos['cantidad'] = $pr->cantidad;
            $datos['descripcion'] = $pr->descripcion;
            $datos['atributos'] = $pr->atributos;
            $datos['comentarios'] = $pr->comentarios;

            $datos['estatus'] = $estatus;

            if($estatus == "APROBADO")
            {
                $datos['correos'] = array_merge(array($qr->correo), $this->Modelo->getCorreosQR());
                $this->correos_pr->liberarPR($datos);
            }
            echo "1";
        }
        else{
            echo "";
        }
    }

    function agregarComentarioPR() {
        $id = $this->input->post('id');
        $comentario = $this->input->post('comentario');
        $tags = $this->input->post('txtTags');
        $correos = explode(",", $tags);

        $data = array(
            'pr' => $id,
            'usuario' => $this->session->id,
            'comentario' => $comentario,
        );

        $this->Modelo->agregar_comentarioPR($data);

        if(count($correos) > 0)
        {
            $datos['id'] = $id;
            $datos['comentario'] = $comentario;
            $datos['correos'] = $correos;
            $this->correos_pr->comentarioPR($datos);
        }

        redirect(base_url('compras/ver_pr/' . $id));
    }

    function ajax_setEstatusMsjPR(){
        $id = $this->input->post('id');
        $estatus = $this->input->post('estatus');
        $comentario_original = $this->input->post('comentario');
        $comentario = "<b><font color='red'>$estatus:</font></b> " . $comentario_original;
        $tags = $this->input->post('txtTags');
        $correos = explode(",", $tags);



        $query = "UPDATE prs set estatus='" . $estatus . "' where id='" . $id . "'";


        $res = $this->Modelo->update($query);
        if($res){

            $data = array(
                'pr' => $id,
                'usuario' => $this->session->id,
                'comentario' => $comentario,
            );
            $this->Modelo->agregar_comentarioPR($data);
            
            $pr = $this->Modelo->getPR($id);

            $datos['id'] = $id;
            $datos['fecha'] = date('d/m/Y h:i A');
            $datos['usuario'] = $pr->User;
            $datos['prioridad'] = $pr->prioridad;
            $datos['unidad'] = $pr->unidad;
            $datos['cantidad'] = $pr->cantidad;
            $datos['descripcion'] = $pr->descripcion;
            $datos['atributos'] = $pr->atributos;
            $datos['comentarios'] = $pr->comentarios;

            $datos['estatus'] = $estatus;

            if($estatus == "RECHAZADO")
            {
                $datos['correos'] = array($pr->correo);
                $this->correos_pr->rechazoPR($datos);
            }

            if(count($correos) > 0)
            {
                $datos2['id'] = $id;
                $datos2['comentario'] = $comentario;
                $datos2['correos'] = $correos;
                $this->correos_pr->comentarioPR($datos2);
            }


            echo $comentario;
        }
        else{
            echo "";
        }
    }

    function ajax_getLiberadoresCompra(){
        $query = "SELECT U.id, concat(U.nombre,' ',U.paterno,' ',U.materno) as Name from usuarios U inner join privilegios P on P.usuario = U.id where U.activo = 1 and P.aprobar_pr = 1";
        
        $res = $this->Conexion->consultar($query);
        if($res)
        {
            echo json_encode($res);
        }

    }

    function ajax_getLiberadoresCotizacion(){
        $query = "SELECT U.id, concat(U.nombre,' ',U.paterno,' ',U.materno) as Name from usuarios U inner join privilegios P on P.usuario = U.id where U.activo = 1 and P.aprobar_cotizacion = 1";
        
        $res = $this->Conexion->consultar($query);
        if($res)
        {
            echo json_encode($res);
        }

    }

}
