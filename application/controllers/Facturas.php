<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Facturas extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('correos_facturacion');
    }

    function index(){
        $this->load->view('header');
        $this->load->view('facturas/catalogo_facturas');
    }

    function solicitudes(){
        $this->load->view('header');
        $this->load->view('facturas/catalogo_solicitudes');
    }

    function solicitud_factura(){
        $data["id"] = 0;

        $this->load->view('header');
        $this->load->view('facturas/solicitud_facturas', $data);
    }

    function editar_solicitud(){
        if(isset($_POST["id"]))
        {
            $id = $this->input->post('id');
        }
        else if ($id == 0){
            redirect(base_url('inicio'));
        }

        $data["id"] = $id;
        $data["editar"] = true;

        $this->load->view('header');
        $this->load->view('facturas/solicitud_facturas', $data);
    }

    function ver_solicitud($id = 0){
        if(isset($_POST["id"]))
        {
            $id = $this->input->post('id');
        }
        else if ($id == 0){
            redirect(base_url('inicio'));
        }

        $data["id"] = $id;

        $this->load->view('header');
        $this->load->view('facturas/solicitud_facturas', $data);
    }

    function documentos_globales(){
        $this->load->view('header');
        $this->load->view('facturas/documentos_globales');
    }

    function logistica(){
        $this->load->view('header');
        $this->load->view('facturas/logistica');
    }

    function programacion_recorrido(){
        $this->load->view('header');
        $this->load->view('facturas/programacion_recorrido');
    }

    /////////////////////////////

    function ajax_setSolicitud(){
        $solicitud = json_decode($this->input->post('solicitud'));
        $other = json_decode($this->input->post('other'));
        $rs_items = json_decode($this->input->post('rs_items'));

        if(isset($_FILES['f_O']))
        {
            $solicitud->f_orden_compra = file_get_contents($_FILES['f_O']['tmp_name']);
        }
        if(isset($_FILES['f_R']))
        {
            $solicitud->f_remision = file_get_contents($_FILES['f_R']['tmp_name']);
        }
        $funciones = array('fecha' => 'CURRENT_TIMESTAMP()');
        
        $res = false;
        if($solicitud->id == 0)
        {
            $solicitud->usuario = $this->session->id;
            $res = $this->Conexion->insertar('solicitudes_facturas', $solicitud, $funciones);
            $solicitud->id = $res;
        }
        else
        {
            $res = $this->Conexion->modificar('solicitudes_facturas', $solicitud, null, array('id' => $solicitud->id)) >= 0;
        }


        $this->load->model('MLConexion_model', 'MLConexion');
        foreach ($rs_items as $item) 
        {
            $borrar = $item->BORRAR;
            unset($item->BORRAR);
            if($item->id == 0){
                $item->id_factura = $solicitud->id;
                $this->Conexion->insertar('rsitems_facturas', $item);

                $this->MLConexion->modificar('rsitems', array('Solicitud_ID' => $item->id_factura), null, array('item_id' => $item->item_id));
            }
            else
            {
                if($borrar)
                {
                    $this->Conexion->eliminar('rsitems_facturas', array('id' => $item->id));
                    $this->MLConexion->modificar('rsitems', array('Solicitud_ID' => 0), null, array('item_id' => $item->item_id));
                }
                else
                {
                    $this->Conexion->modificar('rsitems_facturas', $item, null, array('id' => $item->id));
                }
            }
        }




        //ENVIAR CORREO
        if(isset($_FILES['other'])){   
            $solicitud->User = $other->User;
            $solicitud->Client = $other->Client;
            $solicitud->Contact = $other->Contact;

            $correos = [];
            $correos_a = $this->Conexion->consultar("SELECT U.correo from privilegios P inner join usuarios U on P.usuario = U.id where P.responder_facturas = 1");
            foreach ($correos_a as $key => $value) {
                array_push($correos, $value->correo);
            }
            $solicitud->correos = array_merge(array($this->session->correo), $correos);

            $this->correos_facturacion->solicitud($solicitud);
        }


        if($res)
        {
            echo "1";
        }
    }

    function ajax_getSolicitudes(){
        $id = $this->input->post('id');
        $aceptadas = $this->input->post('aceptadas');
        $cliente = $this->input->post('cliente');
        $ejecutivo = $this->input->post('ejecutivo');
        $texto = $this->input->post('texto');
        $parametro = $this->input->post('parametro');

        

        $query = "SELECT F.id, F.fecha, F.usuario, F.ejecutivo, F.cliente, F.contacto, F.reporte_servicio, F.orden_compra, F.forma_pago, F.pagada, F.urgente, F.conceptos, F.notas, F.estatus, F.documentos_requeridos, F.serie, F.folio, F.codigo_impresion, F.bitacora_estatus, E.nombre as Cliente, concat(U.nombre, ' ', U.paterno) as User from solicitudes_facturas F inner join empresas E on E.id = F.cliente inner join usuarios U on U.id = F.ejecutivo where 1 = 1";

        if($id)
        {
            $query .= " and F.id = '$id'";
        }
        else
        {
            if($texto)
            {
                $query .= " and F.$parametro = '$texto'";
            }
            if($aceptadas == 0)
            {
                $query .= " and (F.estatus != 'ACEPTADO' && F.estatus != 'CANCELADO')";
            }
            if($cliente && $cliente != 0)
            {
                $query .= " and F.cliente = '$cliente'";
            }
            if($ejecutivo && $ejecutivo != 0)
            {
                $query .= " and F.ejecutivo = '$ejecutivo'";
            }
            
        }
        
        if(isset($_POST['estatus']))
        {
            $estatus = $this->input->post('estatus');
            $query .= " and F.estatus = '$estatus'";
        }

        if(isset($_POST['logistica']))
        {
            $logistica = $this->input->post('logistica');
            $query .= " and F.logistica = '$logistica'";
        }

        $query .= " order by F.fecha desc";

        $res = $this->Conexion->consultar($query, $id);
        if($res)
        {
            echo json_encode($res);
        }
    }

    function ajax_editSolicitud(){
        $solicitud = json_decode($this->input->post('solicitud'));
        $other = json_decode($this->input->post('other'));

        if(isset($_FILES['f_A']))
        {
            $solicitud->f_acuse = file_get_contents($_FILES['f_A']['tmp_name']);
        }
        if(isset($_FILES['f_F']))
        {
            $solicitud->f_factura = file_get_contents($_FILES['f_F']['tmp_name']);
        }
        if(isset($_FILES['f_X']))
        {
            $solicitud->f_xml = file_get_contents($_FILES['f_X']['tmp_name']);
        }

        $comentario = $this->input->post('comentario');

        $res = $this->Conexion->modificar('solicitudes_facturas', $solicitud, null, array('id' => $solicitud->id));
        if($solicitud->estatus_factura == "ACEPTADO")
        {
            $this->load->model('MLConexion_model', 'MLConexion');
            $this->MLConexion->comando("UPDATE rsitems set Factura = ifnull(Factura, $solicitud->folio) where Solicitud_ID = $solicitud->id;");
        }


        if($res > 0)
        {
            if(isset($_POST['comentario']) && !empty($comentario))
            {
                $this->Conexion->insertar('solicitudes_facturas_comentarios', array('solicitud' => $solicitud->id, 'usuario' => $this->session->id, 'comentario' => $comentario), array('fecha' => 'CURRENT_TIMESTAMP()'));
                $solicitud->comentario = $comentario;
            }

            $correos = [];
            $correos_a = $this->Conexion->consultar("SELECT U.correo from privilegios P inner join usuarios U on P.usuario = U.id where P.responder_facturas = 1");
            foreach ($correos_a as $key => $value) {
                array_push($correos, $value->correo);
            }
            $solicitud->correos = array_merge(array($this->session->correo), $correos);
            $solicitud->User = $other->User;
            $solicitud->Client = $other->Client;
            $solicitud->Contact = $other->Contact;

            $this->correos_facturacion->editar_solicitud($solicitud);
            echo "1";
        }
        else
        {
            echo "";
        }
    }

    function ajax_getReporteServicios(){

        $this->load->model('MLConexion_model', 'MLConexion');

        $texto = $this->input->post('texto');
        $rs = $this->input->post('rs');

        //$query = "SELECT item_id, folio_id, descripcion, Solicitud_ID, ifnull(Equipo_ID,'') as Equipo_ID, ifnull(Fabricante,'') as Fabricante, ifnull(Modelo,'') as Modelo, ifnull(Serie,'') as Serie, Monto from rsitems where isnull(fechaCancelado)";
        $query = "SELECT item_id, folio_id, descripcion, concat(descripcion, if(isnull(Fabricante), '', concat(' ', Fabricante)), if(isnull(Modelo), '', concat(' ', Modelo)), if(isnull(Serie), '', concat(' Serie: ', Serie)), if(isnull(Equipo_ID), '', concat(' ID: ', Equipo_ID))) as CadenaDescripcion, Solicitud_ID, Monto from rsitems where isnull(fechaCancelado)";
        $query .= " and folio_id = '$rs'";
        if($texto)
        {
            $query .= " having CadenaDescripcion like '%$texto%'";
        }

        $res = $this->MLConexion->Consultar($query);

        if($res){
            echo json_encode($res);
        }
    }

    function ajax_getRSItems(){
        $id_factura = $this->input->post('id_factura');
        $res = $this->Conexion->Consultar("SELECT * from rsitems_facturas where id_factura = $id_factura");
        if($res){
            echo json_encode($res);
        }
    }


    function ajax_setComentarios(){
        $comentario = json_decode($this->input->post('comentario'));
        $comentario->usuario = $this->session->id;
        $funciones = array('fecha' => 'CURRENT_TIMESTAMP()');
        

        $res = $this->Conexion->insertar('solicitudes_facturas_comentarios', $comentario, $funciones);
        if($res > 0)
        {
            echo "1";
        }
        else
        {
            echo "";
        }


    }

    function ajax_getComentarios(){
        $id = $this->input->post('id');

        $query = "SELECT C.*, concat(U.nombre, ' ', U.paterno) as User from solicitudes_facturas_comentarios C inner join usuarios U on U.id = C.usuario where 1 = 1";

        if($id)
        {
            $query .= " and C.solicitud = '$id'";
        }

        $res = $this->Conexion->consultar($query);
        if($res)
        {
            echo json_encode($res);
        }
        else
        {
            echo "";
        }


    }

    function ajax_getRequisitores(){
        $id = $this->input->post('id');

        $query = "SELECT U.id, concat(U.nombre, ' ', U.paterno) as Nombre, P.puesto as Puesto from usuarios U inner join puestos P on U.puesto = P.id inner join privilegios PR on PR.usuario = U.id where U.activo = 1 and PR.solicitar_facturas = 1";

        if($id)
        {
            $query .= " and U.id = '$id'";
        }

        $res = $this->Conexion->consultar($query, $id);
        if($res)
        {
            echo json_encode($res);
        }
        else
        {
            echo "";
        }
    }

    function ajax_getVFPData(){
        $modelo = $this->input->post('modelo');
        $res = shell_exec("C:/xampp/htdocs/MASMetrologia/vfp_reader/vfp_reader.exe \"$modelo\"");
        echo $res;
    }

    function archivo_impresion(){
        ini_set('display_errors', 0);
        $this->load->library('pdfmerge');
        
        $id = $this->input->post('id');
        $codigo = $this->input->post('codigo');
        
        $pdf = new PDFMerger();
        
        $res = $this->Conexion->consultar("SELECT SF.* from solicitudes_facturas SF where SF.id = $id", TRUE);

        for ($i=0; $i < strlen($codigo); $i++) { 
            switch (strtoupper($codigo[$i])) {
                
                case 'F':
                    $campo = 'f_factura';
                    break;
    
                case 'R':
                    $campo = 'f_remision';
                    break;
    
                case 'O':
                    $campo = 'f_orden_compra';
                    break;
    
                case 'A':
                    $campo = 'f_acuse';
                    break;

                case 'P':
                    $campo = 'OPINION';
                    break;

                case 'S':
                    $campo = 'EMISION';
                    break;

                default:
                    $campo = null;
                    break;
            }

            
            if($campo != null)
            {
                if(substr($campo, 0, 2 ) == "f_")
                {
                    $file = $res->$campo;
                    $fichero = sys_get_temp_dir(). '/' . $campo . '.pdf';
                    file_put_contents($fichero, $file);
                    $pdf->addPDF($fichero, 'all');
                }
                else
                {
                    $fichero = "data/empresas/documentos_globales/" . $campo . "_000001.pdf";
                    $pdf->addPDF($fichero, 'all');
                }
            }
        }

        $pdf->merge('browser');
        
    }

    function ajax_getClientes(){
        
        $query = "SELECT C.id, C.nombre, C.razon_social, C.foto, C.opinion_positiva, C.emision_sua from empresas C where C.cliente = 1";

        $res = $this->Conexion->consultar($query);
        if($res)
        {
            echo json_encode($res);
        }
        else
        {
            echo "";
        }
    }

    function ajax_getClientesSolicitudes(){
        $texto = $this->input->post('texto');
        
        $query = "SELECT E.id, E.nombre, count(S.id) as NumSol from solicitudes_facturas S inner join empresas E on E.id = S.cliente";

        if($texto)
        {
            $query .= " where E.nombre like '%$texto%'";
        }
        $query .= " group by E.id;";

        $res = $this->Conexion->consultar($query);

        if($res)
        {
            echo json_encode($res);
        }
    }

    function ajax_getEjecutivosSolicitudes(){
        $texto = $this->input->post('texto');
        
        $query = "SELECT U.id, concat(U.nombre, ' ', U.paterno) as Ejecutivo, count(S.id) as NumSol from solicitudes_facturas S inner join usuarios U on U.id = S.ejecutivo";

        if($texto)
        {
            $query .= " where concat(U.nombre, ' ', U.paterno) like '%$texto%'";
        }
        $query .= " group by U.id;";

        $res = $this->Conexion->consultar($query);

        if($res)
        {
            echo json_encode($res);
        }
    }

    function ajax_getDocumentosGlobales(){
        
        $query = "SELECT id, opinion_positiva, emision_sua from documentos_globales where id = 1";

        $res = $this->Conexion->consultar($query);
        if($res)
        {
            echo json_encode($res);
        }
        else
        {
            echo "";
        }
    }

    function ajax_filesExists($id){
        $this->load->helper('file');

        $id = str_pad($id, 6, "0", STR_PAD_LEFT);
        $acuse = read_file(base_url("data/empresas/documentos_facturacion/ACUSE_" . $id . ".pdf")) ? "1" : "0";
        $emision = read_file(base_url("data/empresas/documentos_facturacion/EMISION_" . $id . ".pdf")) ? "1" : "0";

        echo json_encode(array($acuse, $emision));
    }

    function ajax_readXML(){
        $dom = new DomDocument;
        $dom->preserveWhiteSpace = FALSE;
        $dom->loadXML(file_get_contents($_FILES['f_X']['tmp_name']));
      //$dom->loadXML(file_get_contents(base_url('data/1.xml')));
        $comp = $dom->getElementsByTagName('Comprobante');
        $ext = 1;
        $data = array();
        foreach ($comp[0]->attributes as $elem)
        {
            if($elem->name == "Serie" | $elem->name == "Folio" | $elem->name == "Total")
            {
                $e = array($elem->name => $elem->value);
                array_push($data, $e);
            }


            if($elem->name == "Folio")
            {
                $folio = $elem->value;

                $res = $this->Conexion->consultar("SELECT count(*) as existe FROM solicitudes_facturas where folio = '$folio'", TRUE);
                $ext = $res->existe;
            }

            
        }

        if($ext == 0)
        {
            echo json_encode($data);
        }
        else
        {
            echo "0";
        }
        
    }

    function ajax_setDocumentoFacturacion(){
        $file = $this->input->post('file');
        $documento = $this->input->post('documento');
        $id = $this->input->post('empresa');
        $id = str_pad($id, 6, "0", STR_PAD_LEFT);
        
        if($file != "undefined")
        {
            $config['upload_path'] = 'data/empresas/documentos_facturacion/';
            $config['allowed_types'] = 'pdf';
            $config['overwrite'] = TRUE;
            $config['file_name'] = $documento . '_' . $id;
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('file'))
            {
                $where['id'] = $id;
                switch($documento)
                {
                    case "EMISION":
                    $campo = "emision_sua";
                    break;
                    
                    case "OPINION":
                    $campo = "opinion_positiva";
                    break;
                }
                $data[$campo] = $this->upload->data('file_name');
                $this->Conexion->modificar('empresas', $data, null, $where);
                echo "1";
            } 
        }
    }

    function ajax_deleteDocumentoFacturacion(){
        $documento = $this->input->post('documento');
        $id = $this->input->post('empresa');
        $id = str_pad($id, 6, "0", STR_PAD_LEFT);
        unlink('data/empresas/documentos_facturacion/' . $documento . '_' . $id . '.pdf');

        $where['id'] = $id;
        switch($documento)
        {
            case "EMISION":
            $campo = "emision_sua";
            break;
            
            case "OPINION":
            $campo = "opinion_positiva";
            break;
        }
        $data[$campo] = "";
        $this->Conexion->modificar('empresas', $data, null, $where);
    }

    function ajax_setDocumentoGlobal(){
        $file = $this->input->post('file');
        $documento = $this->input->post('documento');
        $id = $this->input->post('empresa');
        $id = str_pad($id, 6, "0", STR_PAD_LEFT);
        
        if($file != "undefined")
        {
            $config['upload_path'] = 'data/empresas/documentos_globales/';
            $config['allowed_types'] = 'pdf';
            $config['overwrite'] = TRUE;
            $config['file_name'] = $documento . '_' . $id;
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('file'))
            {
                $where['id'] = $id;
                switch($documento)
                {
                    case "EMISION":
                    $campo = "emision_sua";
                    break;
                    
                    case "OPINION":
                    $campo = "opinion_positiva";
                    break;
                }
                $data[$campo] = $this->upload->data('file_name');
                $this->Conexion->modificar('documentos_globales', $data, null, $where);
                echo "1";
            } 
        }
    }

    function ajax_deleteDocumentoGlobal(){
        $documento = $this->input->post('documento');
        $id = $this->input->post('empresa');
        $id = str_pad($id, 6, "0", STR_PAD_LEFT);
        unlink('data/empresas/documentos_globales/' . $documento . '_' . $id . '.pdf');

        $where['id'] = $id;
        switch($documento)
        {
            case "EMISION":
            $campo = "emision_sua";
            break;
            
            case "OPINION":
            $campo = "opinion_positiva";
            break;
        }
        $data[$campo] = "";
        $this->Conexion->modificar('documentos_globales', $data, null, $where);
    }

    function ajax_enviarCorreo(){
        $id = $this->input->post('id');
        $body = $this->input->post('body');
        $subject = $this->input->post('subject');
        $para = $this->input->post('para');
        $cc = $this->input->post('cc');
        
        $campos = json_decode($this->input->post('campos'));

        $archivos = [];
        $res = $this->Conexion->consultar("SELECT SF.* from solicitudes_facturas SF where SF.id = $id", TRUE);
        foreach ($campos as $value) {
            if(substr($value, 0, 2 ) == "f_")
            {
                $file = $res->$value;
                $fichero = sys_get_temp_dir(). '/' . $value . ($value == "f_xml" ? '.xml' : '.pdf');
                file_put_contents($fichero, $file);
            }
            else
            {
                switch ($value) {
                    case 'opinion_positiva':
                        $value = 'OPINION';
                        break;
                    
                    case 'emision_sua':
                        $value = 'EMISION';
                        break;
                }
                $fichero = "data/empresas/documentos_globales/" . $value . "_000001.pdf";
            }

            array_push($archivos, $fichero);
        }

        $datos['id'] = $id;
        $datos['para'] = $para;
        $datos['cc'] = $cc;
        $datos['subject'] = $subject;
        $datos['body'] = $body;
        $datos['campos'] = $campos;
        $datos['archivos'] = $archivos;
        $this->correos_facturacion->enviarCorreo($datos);

    }

    ////////////////////////////////// F A C T U R A S //////////////////////////////////

    function ajax_getFacturas(){
        $id = $this->input->post('id');

        $query = "SELECT F.id, F.fecha, F.usuario, F.cliente, F.contacto, F.reporte_servicio, F.orden_compra, F.forma_pago, F.pagada, F.conceptos, F.notas, F.estatus_factura, F.documentos_requeridos, F.serie, F.folio, F.codigo_impresion, (SELECT count(id) from recorrido_conceptos where id_concepto = F.id and tipo = 'FACTURA') as Recorridos, (SELECT count(id) from envios_factura where factura = F.id) as Envios, E.nombre as Cliente, concat(U.nombre, ' ', U.paterno) as User, U.correo, ifnull(EC.correo, 'N/A') as CorreoContacto from solicitudes_facturas F inner join empresas E on E.id = F.cliente inner join usuarios U on U.id = F.usuario left join empresas_contactos EC on EC.id = F.contacto";
        $query .= " where F.folio > 0 and F.estatus = 'ACEPTADO'";

        if($id)
        {
            $query .= " and F.id = '$id'";
        }
        
        if(isset($_POST['estatus']))
        {
            $estatus = $this->input->post('estatus');
            $query .= " and F.estatus = '$estatus'";
        }

        $res = $this->Conexion->consultar($query, $id);
        if($res)
        {
            echo json_encode($res);
        }
    }


    ////////////////////////////////// L O G I S T I C A //////////////////////////////////
    function ajax_getMensajeros(){
        $query = "SELECT U.id, U.nombre, U.paterno, U.materno, U.no_empleado, U.puesto, U.correo, U.ultima_sesion, U.departamento, U.activo, U.jefe_directo, U.autorizador_compras, U.autorizador_compras_venta, concat(U.nombre, ' ', U.paterno) as User, concat(U.nombre, ' ', U.paterno, ' ', U.materno) as CompleteName from usuarios U inner join privilegios P on P.usuario = U.id where U.activo = '1'";// having Name like '%$texto%'";
        $query .= " and P.mensajero = '1'";
        $query .= " order by User";
        
        $res = $this->Conexion->consultar($query);
        if($res)
        {
            echo json_encode($res);
        }

    }

    function ajax_setRecorrido(){
        $mensajero = $this->input->post('mensajero');
        $fecha = $this->input->post('fecha');
        $recorrido = json_decode($this->input->post('recorrido'));

        $data['mensajero'] = $mensajero;
        $data['fecha_recorrido'] = $fecha;
        $recorrido_id = $this->Conexion->insertar('recorridos', $data);

        foreach ($recorrido as $value) {
            $data2['recorrido'] = $recorrido_id;
            $data2['factura'] = $value[1];
            $data2['accion'] = $value[0];
            $data2['estatus'] = "EN RECORRIDO";

            $this->Conexion->insertar('recorrido_conceptos', $data2);
            $this->Conexion->modificar('solicitudes_facturas', array('estatus' => $data2['estatus']), null, array('id' => $data2['factura']));
        }
        
    }

    function ajax_getRecorridos(){
        $pendientes = $this->input->post('pendientes');
        $factura = $this->input->post('factura');

        $query = "SELECT RF.*, R.mensajero, R.fecha_recorrido, (SELECT count(RC.id) from recorrido_comentarios RC where RC.recorrido_factura = RF.id) as Comentarios, (SELECT count(RF2.id) from recorrido_facturas RF2 where RF2.recorrido = RF.recorrido and RF2.estatus = 'EN RECORRIDO') as Pendientes, (SELECT E.nombre from solicitudes_facturas F inner join empresas E on E.id = F.cliente where F.id = RF.factura) as Cliente, ifnull(concat(M.nombre, ' ', M.paterno), 'N/A') as Mensajero from recorrido_facturas RF inner join recorridos R on R.id = RF.recorrido left join usuarios M on M.id = R.mensajero where 1 = 1";

        if(isset($_POST['factura']))
        {
            $query .= " and RF.factura = $factura";
        }

        if($pendientes == "1")
        {
            $query .= " having Pendientes > 0";
        }

        $query .= " order by R.fecha_recorrido, R.id, RF.id asc";

        $res = $this->Conexion->consultar($query);

        echo json_encode($res);
    }

    function ajax_updateRecorrido(){
        $recorrido = json_decode($this->input->post('recorrido'));
        $recolecta = $this->input->post('recolecta');
        $comentario = $this->input->post('comentario');
        
        $this->Conexion->modificar('recorrido_facturas', $recorrido, null, array('id' => $recorrido->id));

        if(substr($recorrido->estatus, 0, 2) == "NO")
        {
            $estat = "PENDIENTE " . $recorrido->accion;
            $this->Conexion->modificar('solicitudes_facturas', array('estatus' => $estat), null, array('id' => $recorrido->factura));
        }
        else
        {
            $estat = $recolecta == "1" ? "PENDIENTE RECOLECTA" : "CERRADO";
            $this->Conexion->modificar('solicitudes_facturas', array('estatus' => $estat), null, array('id' => $recorrido->factura));
        }

        if($comentario)
        {
            $color = substr($recorrido->estatus, 0, 2) == "NO" ? "red" : "green";
            $comentario = '<font color=' . $color . '><b>' . $recorrido->estatus . ':</b></font> ' . $comentario;

            $data_com['recorrido_factura'] = $recorrido->id;
            $data_com['usuario'] = $this->session->id;
            $data_com['comentario'] = $comentario;
            $func_com['fecha'] = "CURRENT_TIMESTAMP()";
            $this->Conexion->insertar('recorrido_comentarios', $data_com, $func_com);
        }
        
        
    }

    function ajax_getComentariosRecorrido(){
        $id = $this->input->post('id');

        $query = "SELECT C.*, concat(U.nombre, ' ', U.paterno) as User from recorrido_comentarios C inner join usuarios U on U.id = C.usuario where 1 = 1";

        if($id)
        {
            $query .= " and C.recorrido_factura = '$id'";
        }
        $query .= " order by C.fecha";

        $res = $this->Conexion->consultar($query);
        if($res)
        {
            echo json_encode($res);
        }


    }

}
