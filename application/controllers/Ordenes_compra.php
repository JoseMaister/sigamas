<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ordenes_compra extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('correos_po');
        $this->load->model('compras_model');
        //$this->load->library('AOS_funciones');
    }

    function catalogo_po($estatus = 'TODO'){
        $estatus = strtoupper($estatus);
        $data['estatus'] = str_replace('_', ' ', $estatus);
        
        $this->load->view('header');
        $this->load->view('ordenes_compra/catalogo_po', $data);
    }

    function generar_po(){
        $this->load->view('header');
        $this->load->view('ordenes_compra/generar_po');
    }

    function construccion_po($idtemp){
        
        $query = "SELECT OCT.*, JSON_UNQUOTE(OCT.prs) as PRS, JSON_UNQUOTE(OCT.prs_rechazados) as PRS_R, E.nombre FROM ordenes_compra_temp OCT inner join empresas E on OCT.proveedor = E.id where OCT.idtemp='$idtemp'";

        $res = $this->Conexion->consultar($query, TRUE);
        if($res)
        {
            $data['id_prov'] = $res->proveedor;
            $data['moneda'] = $res->moneda;
            $data['tipo'] = $res->tipo;

            $data['prs'] = $res->PRS;
            $data['prs_rechazadas'] = $res->PRS_R;

            $data['idtemp'] = $idtemp;

            $this->load->view('header');
            $this->load->view('ordenes_compra/construccion_po', $data);    
        }
    }

    function editar_po($id){
        
        $data['id'] = $id;
        $this->load->view('header');
        $this->load->view('ordenes_compra/editar_po', $data);
    }

    function ver_po($id){
        $data['id'] = $id;
        $data['comentarios'] = $this->compras_model->verPo_comentarios($id);
        $data['comentarios_fotos'] = $this->compras_model->verPo_comentarios_fotos($id);

        $this->load->view('header');
        $this->load->view('ordenes_compra/ver_po', $data);    
    }

    function po_pdf($id){
        $res = $this->Conexion->consultar("SELECT PO.id, PO.fecha, PO.shipping_address, PO.billing_address, PO.conceptos, PO.subtotal, PO.descuento, PO.impuesto, PO.impuesto_nombre, PO.total, PO.moneda, PO.rma, PO.fecha_aprobacion, concat(U.nombre, ' ', U.paterno) as User, U.correo as UserMail, concat(UA.nombre, ' ', UA.paterno) as UserA, E.razon_social, E.calle, E.numero, E.numero_interior, E.colonia, E.ciudad, E.estado, E.pais, E.rfc, EC.nombre, EC.telefono, EC.correo FROM ordenes_compra PO inner join empresas E on PO.proveedor = E.id inner join usuarios U on U.id = PO.usuario inner join usuarios UA on UA.id = PO.aprobador inner join empresas_contactos EC on PO.contacto = EC.id where PO.id='$id'", TRUE);

        $conceptos = json_decode($res->conceptos);
        $PO = 'PO-' . str_pad($res->id, 6, "0", STR_PAD_LEFT);
        $FECHA = date_format(date_create($res->fecha), 'd/m/Y h:i A');
        $PROVEEDOR = $res->razon_social;
        $RMA = $res->rma;
        $DOMICILIO = $res->calle . ' ' . $res->numero . ' ' . $res->numero_interior;
        $COLONIA = $res->colonia;
        $RFC = $res->rfc;

        $REQUISITOR = $res->User;
        $REQUISITOR_CORREO = $res->UserMail;

        $APROBADOR = $res->UserA;
        $FECHA_APROBACION = date_format(date_create($res->fecha_aprobacion), 'd/m/Y h:i A'); // d/m/Y h:i A

        $CONTACTO = $res->nombre;
        $TELEFONO = $res->telefono;
        $CORREO = $res->correo;
        $UBICACION = $res->ciudad . ', ' . $res->estado . ', ' . $res->pais;

        $BILLING_A = $res->billing_address;
        $SHIPPING_A = $res->shipping_address;

        $SUBTOTAL = $res->subtotal;
        $DESCUENTO = $res->descuento;
        $IMPUESTO = $res->impuesto;
        $IMPUESTO_NOMBRE = $res->impuesto_nombre;
        $TOTAL = $res->total;
        $MONEDA = $res->moneda;
        
        
        ini_set('display_errors', 0);
        $this->load->library('pdfview');

        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('AleksOrtiz');
        $pdf->SetTitle('Masmetrologia');
        $pdf->SetSubject('Formato PO');
        // set default header data
        
        $pdf->SetHeaderData(PDF_HEADER_LOGO_ORIGINAL, '40', '                                                       Orden de Compra / ' . $PO, "                                                             Fecha: " . $FECHA . " \n                                                             Comprador: ". $REQUISITOR ." \n                                                             Correo: " . $REQUISITOR_CORREO);
        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', 10));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }
        // set font
        $pdf->SetFont('times', 'B', 15);
        // add a page
        $pdf->AddPage();
        //Write( $h, $txt, $link = '', $fill = false, $align = '', $ln = false, $stretch = 0, $firstline = false, $firstblock = false, $maxh = 0, $wadj = 0, $margin = '' )
        

        // set color for background
        $pdf->SetFillColor(255, 255, 255);
        //$pdf->SetTextColor(127, 31, 0);
        //MultiCell( $w, $h, $txt, $border = 0, $align = 'J', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false )

        $pdf->SetFont('times', 'B', 12);
        $pdf->MultiCell(90, 0, "Proveedor/Supplier:", 0, 'L', 1, 0, '', '', true, 0, false, true, 0);
        $pdf->MultiCell(90, 0, $RMA ? "RMA:" : "", 0, 'L', 1, 1, '', '', true, 0, false, true, 0);
        $pdf->SetFont('times', '', 10);
        $pdf->MultiCell(90, 6, $PROVEEDOR, 0, 'L', 1, 0, '', '', true, 0, false, true, 0);
        $pdf->MultiCell(90, 0, $RMA ? $RMA : "", 0, 'L', 1, 1, '', '', true, 0, false, true, 0);
        

        $pdf->SetFont('times', 'B', 12);
        $pdf->MultiCell(90, 0, "Dirección / Address:", 0, 'L', 1, 0, '', '', true, 0, false, true, 0);
        $pdf->MultiCell(90, 0, "Contacto / Contact:", 0, 'L', 1, 1, '', '', true, 0, false, true, 0);
        $pdf->SetFont('times', '', 10);

        $pdf->MultiCell(90, 0, $DOMICILIO, 0, 'L', 1, 0, '', '', true, 0, false, true, 0);
        $pdf->MultiCell(90, 0, $CONTACTO, 0, 'L', 1, 1, '', '', true, 0, false, true, 0);
        $pdf->MultiCell(90, 0, $COLONIA, 0, 'L', 1, 0, '', '', true, 0, false, true, 0);
        $pdf->MultiCell(90, 0, $TELEFONO, 0, 'L', 1, 1, '', '', true, 0, false, true, 0);
        $pdf->MultiCell(90, 0, $UBICACION, 0, 'L', 1, 0, '', '', true, 0, false, true, 0);
        $pdf->MultiCell(90, 0, $CORREO, 0, 'L', 1, 1, '', '', true, 0, false, true, 0);
        
        $pdf->MultiCell(90, 6, $RFC, 0, 'L', 1, 1, '', '', true, 0, false, true, 0);
        
        $pdf->SetFont('times', 'B', 12);
        $pdf->MultiCell(90, 0, "Facturar a / Billing Address:", 0, 'L', 1, 0, '', '', true, 0, false, true, 0);
        $pdf->MultiCell(90, 6, "Enviar a / Shipping Address:", 0, 'L', 1, 1, '', '', true, 0, false, true, 0);
        $pdf->SetFont('times', '', 10);

        $pdf->MultiCell(90, 20, $BILLING_A, 0, 'L', 1, 0, '', '', true, 0, false, true, 0);
        $pdf->MultiCell(90, 20, $SHIPPING_A, 0, 'L', 1, 1, '', '', true, 0, false, true, 0);

        $pdf->MultiCell(180, 0, "", 0, 'L', 1, 1, '', '', true, 0, false, true, 0);

        $pdf->SetFont('times', 'B', 12);
        $pdf->SetFillColor(1, 59, 117);
        $pdf->SetTextColor(255);

        $pdf->SetTextColor(0);
        $pdf->Cell(15, 6, "Cant.", 1, 0, 'C', 0);
        $pdf->Cell(115, 6, "Descripción", 1, 0, 'C', 0);
        $pdf->Cell(25, 6, "Precio Unit.", 1, 0, 'C', 0);
        $pdf->Cell(25, 6, "Importe", 1, 0, 'C', 0);
        $pdf->Ln();

        $w = array(15, 115 , 25, 25);
        $pdf->SetFont('', '', 10);
        $pdf->MultiCell($w[0], 3,'','LR','C',0,0);
        $pdf->MultiCell($w[1], 3,'','LR','L',0,0);
        $pdf->MultiCell($w[2], 3,'','LR','R',0,0);
        $pdf->MultiCell($w[3], 3,'','LR','R',0,0);
        $pdf->Ln();
        $i = 0;
        
        foreach($conceptos as $indice => $concepto) {
            $cellcount = array();
            $startX = $pdf->GetX();
            $startY = $pdf->GetY();


            $pu = $concepto[2] / $concepto[0];
            $cellcount[] = $pdf->MultiCell($w[0], 6, $concepto[0], 0, 'C', 0, 0);
            $cellcount[] = $pdf->MultiCell($w[1], 6, $concepto[1], 0, 'L', 0, 0);
            $cellcount[] = $pdf->MultiCell($w[2], 6, "$" . number_format($pu, 2), 0, 'R', 0, 0);
            $cellcount[] = $pdf->MultiCell($w[3], 6, "$" . number_format($concepto[2], 2), 0, 'R', 0, 0); // VER AQUI

            $pdf->SetXY($startX, $startY);

            $maxnocells = max($cellcount);

            $pdf->MultiCell($w[0], $maxnocells * 6, '', 'LR', 'C', 0, 0);
            $pdf->MultiCell($w[1], $maxnocells * 6, '', 'LR', 'L', 0, 0);
            $pdf->MultiCell($w[2], $maxnocells * 6, '', 'LR', 'R', 0, 0);
            $pdf->MultiCell($w[3], $maxnocells * 6, '', 'LR', 'R', 0, 0);
            $pdf->Ln();
            

            if(isset($concepto[3]) && !empty($concepto[3]))
            {
                $cellcount = array();
                $startX = $pdf->GetX();
                $startY = $pdf->GetY();

                $cellcount[] = $pdf->MultiCell($w[0], 6, "", 0, 'C', 0, 0);
                $cellcount[] = $pdf->MultiCell($w[1], 6, "** " . $concepto[3], 0, 'L', 0, 0);
                $cellcount[] = $pdf->MultiCell($w[2], 6, "", 0, 'R', 0, 0);
                $cellcount[] = $pdf->MultiCell($w[3], 6, "", 0, 'R', 0, 0);

                $pdf->SetXY($startX, $startY);

                $maxnocells = max($cellcount);

                $pdf->MultiCell($w[0], $maxnocells * 6,'','LR','C',0,0);
                $pdf->MultiCell($w[1], $maxnocells * 6,'','LR','L',0,0);
                $pdf->MultiCell($w[2], $maxnocells * 6,'','LR','R',0,0);
                $pdf->MultiCell($w[3], $maxnocells * 6,'','LR','R',0,0);
                $pdf->Ln();
            }
            $i++;

            if($startY > 212)
            {
                $pdf->MultiCell(180, 6,'','T','C',0,0);
                $pdf->AddPage();
            }
        }
        

        for ($startY; $startY < 200; $startY = $startY + 6) { 
            $pdf->MultiCell($w[0], 6, '---', 'LR', 'C', 0, 0);
            $pdf->MultiCell($w[1], 6, '   -------------------------------------------------------------------------------------------', 'LR', 'L', 0, 0);
            $pdf->MultiCell($w[2], 6, '   ---------------   ', 'LR', 'R', 0, 0);
            $pdf->MultiCell($w[3], 6, '   ---------------   ', 'LR', 'R', 0, 0);
            $pdf->Ln();
        }
        //MultiCell( $w, $h, $txt, $border = 0, $align = 'J', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false )

        $pdf->MultiCell(130, 6, '* Moneda / Currency: ' . $MONEDA, 'T', 'M', 0 , 0);
        $pdf->MultiCell($w[2], 6, 'Sub-Total', 'T', 'C', 0 , 0, '', '', TRUE, 0, FALSE, TRUE, 0, 'M');
        $pdf->MultiCell($w[3], 6, "$" . number_format($SUBTOTAL, 2), 1, 'R', 0, 0, '', '', TRUE, 0, FALSE, TRUE, 0, 'M');
        $pdf->Ln();

        $pdf->MultiCell(130, 6, '* If you have any questions regarding this Purchase Order please contact the buyer.', 0, 'M', 0 , 0);
        $pdf->MultiCell($w[2], 6, 'Descuento', 0, 'C', 0 , 0, '', '', TRUE, 0, FALSE, TRUE, 0, 'M');
        $pdf->MultiCell($w[3], 6, "$" . number_format($DESCUENTO, 2), 1, 'R', 0 , 0, '', '', TRUE, 0, FALSE, TRUE, 0, 'M');
        $pdf->Ln();

        $pdf->MultiCell(130, 6, '* Any changes or exceptions must be authorized by the Purchasing Department.', 0, 'M', 0 , 0);
        $pdf->MultiCell($w[2], 6, "IVA / TAX", 0, 'C', 0 , 0, '', '', TRUE, 0, FALSE, TRUE, 0, 'M');
        $pdf->MultiCell($w[3], 6, "$" . number_format($IMPUESTO, 2), 1, 'R', 0 , 0, '', '', TRUE, 0, FALSE, TRUE, 0, 'M');
        $pdf->Ln();

        $pdf->MultiCell(130, 6, '* Elaborate one invoice for each Purchase Order.', 0, 'M', 0 , 0);
        $pdf->MultiCell($w[2], 6, 'Total', 0, 'C', 0 , 0, '', '', TRUE, 0, FALSE, TRUE, 0, 'M');
        $pdf->MultiCell($w[3], 6, "$" . number_format($TOTAL, 2), 1, 'R', 0 , 0, '', '', TRUE, 0, FALSE, TRUE, 0, 'M');
        $pdf->Ln();

        $pdf->MultiCell(180, 6, '* Favor de contactar al Comprador si usted tiene alguna duda acerca de esta Orden de Compra.', 0, 'M', 0 , 0);
        $pdf->Ln();
        
        $pdf->MultiCell(180, 6, '* Cualquier cambio o excepcion debera ser autorizado por el Departamento de Compras.', 0, 'M', 0 , 0);
        $pdf->Ln();

        $pdf->MultiCell(180, 6, '* Elaborar una factura por cada orden de compra.', 0, 'M', 0 , 0);
        $pdf->Ln();
        $pdf->Ln();

        $pdf->MultiCell(180, 6, 'Aprobado por: ' . $APROBADOR . ' (' . $FECHA_APROBACION . ')', 0, 'M', 0 , 0);
        $pdf->Ln();

        $pdf->Output($PO . '.pdf', 'I');
    }

    function menu_retroceder(){
        $this->load->view('header');
        $this->load->view('ordenes_compra/retroceder_opciones');
    }

    function retroceder_qr(){
        if($this->session->privilegios['retroceder_qr'])
        {
            $this->load->view('header');
            $this->load->view('ordenes_compra/retroceder_qr');
        }
        else
        {
            redirect(base_url('inicio'));
        }
    }

    function recibir_pr(){
        if($this->session->privilegios['retroceder_qr'] || $this->session->privilegios['retroceder_po'])
        {
            $this->load->view('header');
            $this->load->view('ordenes_compra/recibir_pr');
        }
        else
        {
            redirect(base_url('inicio'));
        }
    }

    function retroceder_po(){
        if($this->session->privilegios['retroceder_po'])
        {
            $this->load->view('header');
            $this->load->view('ordenes_compra/retroceder_po');
        }
        else
        {
            redirect(base_url('inicio'));
        }
    }

    function historial(){
        $this->load->view('header');
        $this->load->view('ordenes_compra/empresas_historial');
    }

    function historial_po(){
        $data['id_proveedor'] = $this->input->post("id");

        $this->load->view('header');
        $this->load->view('ordenes_compra/historial_po', $data);
    }

    function calendario_seguimiento(){
        $this->load->view('header');
        $this->load->view('ordenes_compra/calendario_seguimiento');
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



    function ajax_getPRs(){
        $texto = $this->input->post('texto');
        $parametro = $this->input->post('parametro');
        
        $id_proveedor = $this->input->post('id_proveedor');
        $tipo = $this->input->post('tipo');
        $moneda = $this->input->post('moneda');

        $query = "SELECT PR.id, E.id as IdProv, E.nombre as Prov, PR.cantidad, PR.tipo, ifnull(JSON_UNQUOTE(PR.atributos->'$.modelo'),'N/A') as Modelo, PR.descripcion, PR.importe, PR.moneda, PR.estatus from prs PR inner join qr_proveedores QR_p on PR.qr_proveedor = QR_p.id inner join empresas E on QR_p.empresa = E.id where 1=1";

        if($id_proveedor > 0)
        {
            $query .= " and E.id = '$id_proveedor' and PR.moneda = '$moneda' and PR.tipo = '$tipo'";
        }

        $query .= " and PR.estatus = 'APROBADO'";

        if(!empty($texto))
        {
            if($parametro == "folio")
            {
                $query .= " and PR.id = '$texto'";
            }
            if($parametro == "proveedor")
            {
                $query .= " having Prov like '%$texto%'";
            }
            if($parametro == "contenido")
            {
                $query .= " and (PR.descripcion like '%$texto%' or UPPER(PR.atributos->'$.marca') like UPPER('%$texto%') or UPPER(PR.atributos->'$.modelo') like UPPER('%$texto%') )";
            }
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

    function ajax_setTempPO(){
        $pr_aprob = [];
        $pr_rech = [];

        $prs = json_decode($this->input->post('prs'));
        $proveedor = $this->input->post('id_prov');
        $moneda = $this->input->post('moneda');
        $tipo = $this->input->post('tipo');

        $query = "SELECT * from prs where 1 != 1";
        foreach ($prs as $elem) {
            $query .= " or id ='$elem'";
        }


        $res = $this->Conexion->consultar($query);
        foreach ($res as $elem) {
            if($elem->estatus == "APROBADO")
            {
                $data['estatus'] = "EN SELECCION";
                $where['id'] = $elem->id;
                $this->Conexion->modificar('prs', $data, null, $where);
                
                array_push($pr_aprob, $elem->id);
            }
            else
            {
                array_push($pr_rech, $elem->id);
            }
            
        }
        
        $tempid = uniqid();
        $data2['idtemp'] = $tempid;
        $data2['usuario'] = $this->session->id;
        $data2['proveedor'] = $proveedor;
        $data2['moneda'] = $moneda;
        $data2['tipo'] = $tipo;
        $data2['prs'] = json_encode($pr_aprob);
        $data2['prs_rechazados'] = json_encode($pr_rech);
        $funciones['fecha'] = 'CURRENT_TIMESTAMP()';

        $this->Conexion->insertar('ordenes_compra_temp', $data2, $funciones);

        echo $tempid;
    }

    function ajax_getTempPO(){
        $prs = json_decode($this->input->post('prs'));  

        $query = "SELECT PR.*, ifnull(JSON_UNQUOTE(PR.atributos->'$.modelo'),'') as Modelo, ifnull(JSON_UNQUOTE(PR.atributos->'$.marca'),'') as Marca, ifnull(JSON_UNQUOTE(PR.atributos->'$.serie'),'') as Serie, QRP.costos, QRP.factor, P.entrega from prs PR inner join qr_proveedores QRP on PR.qr_proveedor = QRP.id inner join proveedores P on P.empresa = QRP.empresa where 1 != 1";
        foreach ($prs as $elem) {
            $query .= " or PR.id ='$elem'";
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

    function ajax_saveTempPO(){
        $idtemp = $this->input->post('idtemp');
        $prs_costos = $this->input->post('prs_costos');

        $data['prs_costos'] = $prs_costos;
        $where['idtemp'] = $idtemp;
        $this->Conexion->modificar('ordenes_compra_temp', $data, null, $where);
        echo "1";
    }

    function ajax_getPosContruccion(){
        $user = $this->session->id;
        $query = "SELECT CT.*, E.nombre as Proveedor FROM ordenes_compra_temp CT inner join empresas E on E.id = CT.proveedor where CT.usuario = '$user'";
        $res = $this->Conexion->consultar($query);

        if($res)
        {
            echo json_encode($res);
        }
    }

    function ajax_generarPO(){
        ini_set('display_errors', 0);
        $moneda = $this->input->post('moneda');
        $tipo = $this->input->post('tipo');
        $usd = 1;

        if($moneda == "USD")
        {
            $usd = $this->aos_funciones->getUSD()[0];
        }


        $datos = json_decode($this->input->post('datos'), TRUE);
        $idtemp = $this->input->post('idtemp');
        $prs = $this->input->post('prs');
        $id_prov = $this->input->post('id_prov');  
        $prioridad = 'NORMAL';
        //$prioridad = $this->input->post('prioridad');
        $entrega = $this->input->post('entrega');

        $data['usuario'] = $this->session->id;
        $data['prioridad'] = $prioridad;
        $data['proveedor'] = $id_prov;
        $data['tipo'] = $tipo;
        $data['contacto'] = 0;
        $data['prs'] = $prs;
        $data['moneda'] = $moneda;
        $data['estatus'] = 'EN PROCESO';
        $data['billing_address'] = '';
        $data['shipping_address'] = '';
        $data['entrega'] = $entrega;
        $data['metodo_pago'] = 0;
        $data['conceptos'] = '[]';
        $data['subtotal'] = 0;
        $data['descuento'] = '0';
        $data['impuesto'] = '0';
        $data['impuesto_nombre'] = 'Exento (0.00%)';
        $data['impuesto_factor'] = '0.00';
        $data['total'] = 0;
        $data['recurso'] = 'PENDIENTE';
        $data['rma'] = '';
        $data['numero_confirmacion'] = '';
        $data['tipo_cambio'] = $usd;

        $functions['fecha'] = 'CURRENT_TIMESTAMP()';

        $po_id = $this->Conexion->insertar('ordenes_compra', $data, $functions);
        $this->Conexion->insertar('ordenes_compra_evidencias', array('po' => $po_id));
        $this->Conexion->eliminar('ordenes_compra_temp', array('idtemp' => $idtemp));
       
        foreach ($datos as $key => $value) {
            
            $data2['usuario'] = $this->session->id;
            $data2['po'] = $po_id;
            $data2['pr'] = $value[0];
            $data2['cantidad'] = $value[1];
            $data2['precio_unitario'] = $value[2];
            $data2['importe'] = $value[3];
            $data2['costos'] = json_encode($value[4]);
            
            $this->Conexion->insertar('ordenes_compra_conceptos', $data2, null);
            $this->Conexion->modificar('prs', array('estatus' => 'EN PO'), null, array('id' => $value[0]));
        }
        echo $po_id;

        
    }

    function ajax_agregarAPO(){
        $datos = json_decode($this->input->post('datos'), TRUE);
        $id_po = $this->input->post('id_po');
        $idtemp = $this->input->post('idtemp');

        $res = $this->Conexion->consultar("SELECT estatus from ordenes_compra where id='$id_po'", TRUE);

        if($res->estatus == 'EN PROCESO')
        {   
            foreach ($datos as $key => $value) {
                
                $data2['usuario'] = $this->session->id;
                $data2['po'] = $id_po;
                $data2['pr'] = $value[0];
                $data2['cantidad'] = $value[1];
                $data2['precio_unitario'] = $value[2];
                $data2['importe'] = $value[3];
                $data2['costos'] = json_encode($value[4]);

                $this->Conexion->insertar('ordenes_compra_conceptos', $data2, null);
                $this->Conexion->modificar('prs', array('estatus' => 'EN PO'), null, array('id' => $value[0]));
            }

            $this->Conexion->eliminar('ordenes_compra_temp', array('idtemp' => $idtemp));

            echo "1";
        }
        else
        {
            echo "";
        }
    }

    function ajax_getShippingAddress(){
        $res = $this->Conexion->get('shipping_address');
        if($res)
        {
            echo json_encode($res);
        }
        else{
            echo "";
        }
    }

    function ajax_getBillingAddress(){
        $res = $this->Conexion->get('billing_address');
        if($res)
        {
            echo json_encode($res);
        }
        else{
            echo "";
        }
    }

    /*
        /////////////////////////////  FUNCIONES DE PO  /////////////////////////////
    */

    function ajax_getPOs(){

        $query = "SELECT PO.*, concat(U.nombre, ' ', U.paterno) as User, E.nombre as Prov, ifnull(EC.nombre,'NO DEFINIDO') as Contact from ordenes_compra PO inner join usuarios U on U.id = PO.usuario inner join empresas E on E.id = PO.proveedor left join empresas_contactos EC on EC.id = PO.contacto where 1 = 1";

        if(isset($_POST['proveedor'])){
            $proveedor = $this->input->post('proveedor');
            $query .= " and PO.proveedor = '$proveedor'";
        }

        if(isset($_POST['moneda'])){
            $moneda = $this->input->post('moneda');
            $query .= " and PO.moneda = '$moneda'";
        }

        if(isset($_POST['tipo'])){
            $tipo = $this->input->post('tipo');
            $query .= " and PO.tipo = '$tipo'";
        }

        if(isset($_POST['estatus'])){
            $estatus = $this->input->post('estatus');
            if($estatus == "TODO")
            {
                $query .= " and (PO.estatus != 'CERRADA' and PO.estatus != 'CANCELADA')";
            }
            else
            {
                $query .= " and PO.estatus = '$estatus'";
            }
        }

        if(isset($_POST['proveedor'])){
            $proveedor = $this->input->post('proveedor');
            $query .= " and PO.proveedor = '$proveedor'";
        }
        
        if(isset($_POST['prioridad'])){
            $prioridad = json_decode($this->input->post('prioridad'));
            if(count($prioridad) > 0)
            {
                $query .= " and ( 1 = 0 ";
                foreach ($prioridad as $key => $value) {
                    $query .= " or PO.prioridad = '$value'";
                }
                $query .= " )";
                
            }
        }

        $query .= " and (PO.fecha > (CURRENT_DATE() - INTERVAL 1 YEAR))";

        if(isset($_POST['texto'])){
            $texto = $this->input->post('texto');
            $parametro = $this->input->post('parametro');
            if(!empty($texto))
            {
                if($parametro == "folio")
                {
                    $query .= " and PO.id = '$texto'";
                }
                if($parametro == "usuario")
                {
                    $query .= " having User like '%$texto%'";
                }
                if($parametro == "proveedor")
                {
                    $query .= " having Prov like '%$texto%'";
                }
                if($parametro == "contenido")
                {
                    $query .= " and UPPER(conceptos) like '%".strtoupper($texto)."%'";
                }
            }
        }

        $query .= " order by PO.id desc";




        $res = $this->Conexion->consultar($query);
        if($res){
            echo json_encode($res);
        }
    }

    function ajax_getPO(){
        $id = $this->input->post('id');
        $query = "SELECT PO.*, concat(U.nombre, ' ', U.paterno) as User, U.correo UserMail, concat(UA.nombre, ' ', UA.paterno) as UserA, E.nombre as Prov, P.rma_requerido, ifnull(EC.nombre,'NO DEFINIDO') as Contact, EC.puesto, EC.correo, ifnull(MP.nombre,'NO DEFINIDO') as MetodoPago, ifnull(MP.tipo,'NO DEFINIDO') as TipoMetodoPago from ordenes_compra PO left join usuarios UA on UA.id = PO.aprobador inner join usuarios U on U.id = PO.usuario inner join empresas E on E.id = PO.proveedor inner join proveedores P on P.empresa = E.id left join empresas_contactos EC on EC.id = PO.contacto left join empresa_metodos_pago MP on MP.id = PO.metodo_pago where 1 = 1";
        $query .= " and PO.id = '$id'";

        $res = $this->Conexion->consultar($query, TRUE);
        if($res){
            echo json_encode($res);
        }
        else {
            echo "";
        }
    }

    function ajax_getPRsPO(){
        $po = $this->input->post('id');
        $query = "SELECT OCC.pr, concat(U.nombre, ' ', U.paterno) as User, PR.tipo, PR.subtipo, PR.cantidad, PR.descripcion, PR.estatus from ordenes_compra_conceptos OCC inner join prs PR on PR.id = OCC.pr inner join usuarios U on U.id = PR.usuario where OCC.po = '$po'";
        $res = $this->Conexion->consultar($query);
        if($res){
            echo json_encode($res);
        }
        else {
            echo "";
        }
    }

    function ajax_getConceptosPO(){
        $po = $this->input->post('id');
        $query = "SELECT OCC.* from ordenes_compra_conceptos OCC where OCC.po = '$po'";
        $res = $this->Conexion->consultar($query);
        if($res){
            echo json_encode($res);
        }
        else {
            echo "";
        }
    }

    function ajax_getConceptosPO_fromPRS(){
        $po = $this->input->post('id');
        $prs = $this->input->post('prs');
        $prs_act = $this->input->post('prs_actuales');

        $this->Conexion->modificar('ordenes_compra', array('prs' => $prs_act), null, array('id' => $po));

        $prs = json_decode($prs);

        $query = "SELECT OCC.* from ordenes_compra_conceptos OCC where OCC.po = '$po' and ( 1 != 1";
        foreach ($prs as $value) {
            $query .= " or OCC.pr = '$value'";
        }
        $query .= ")";
        
        $res = $this->Conexion->consultar($query);
        if($res){
            echo json_encode($res);
        }
        else {
            echo "";
        }
    }

    function ajax_solicitarAprobacionPO(){
        $this->load->library('recursos_funciones');

        $id = $this->input->post('id');
        $shipping_a = $this->input->post('shipping_a');
        $billing_a = $this->input->post('billing_a');
        $contacto = $this->input->post('contacto');
        $prioridad = 'NORMAL'; //$this->input->post('prioridad');
        $metodo_pago = $this->input->post('metodo_pago');
        $rma = $this->input->post('rma');
        $conceptos = $this->input->post('conceptos');
        $estatus = $this->input->post('estatus');

        $subtotal = $this->input->post('subtotal');
        $descuento = $this->input->post('descuento');
        $impuesto = $this->input->post('impuesto');
        $impuesto_nombre = $this->input->post('impuesto_nombre');
        $impuesto_factor = $this->input->post('impuesto_factor');
        $total = $this->input->post('total');
        ///////////
        $nombreProveedor = $this->input->post('nombre_proveedor');
        $nombreContacto = $this->input->post('nombre_contacto');

        $recurso = $this->input->post('recurso');
        $fecha_cobro = $this->input->post('fecha_cobro');

        $data['shipping_address'] = $shipping_a;
        $data['billing_address'] = $billing_a;
        $data['contacto'] = $contacto;
        $data['conceptos'] = $conceptos;
        $data['metodo_pago'] = $metodo_pago;
        $data['rma'] = $rma;
        $data['estatus'] = $estatus;

        $data['subtotal'] = $subtotal;
        $data['descuento'] = $descuento;
        $data['impuesto'] = $impuesto;
        $data['impuesto_nombre'] = $impuesto_nombre;
        $data['impuesto_factor'] = $impuesto_factor;
        $data['total'] = $total;

        $func = null;
        if($recurso != "PENDIENTE"){
            $func = array('fecha_provision' => 'CURRENT_TIMESTAMP()');
        }
        $data['recurso'] = $recurso;
        $data['fecha_cobro'] = date("Y-m-d", strtotime($fecha_cobro));

        $where['id'] = $id;

        $this->Conexion->modificar('ordenes_compra', $data, $func, $where);
        $this->recursos_funciones->NotificacionMinimo($metodo_pago);
        
        $datos['id'] = $id;
        $datos['fecha'] = date('d/m/Y h:i A');
        $datos['usuario'] = $this->session->nombre;
        $datos['prioridad'] = $prioridad;
        $datos['proveedor'] = $nombreProveedor;
        $datos['contacto'] = $nombreContacto;
        $datos['total'] = $total;

        $correos = [];
        $correos_a = $this->Conexion->consultar("SELECT U.correo from privilegios P inner join usuarios U on P.usuario = U.id where P.aprobar_compra = 1");
        foreach ($correos_a as $key => $value) {
            array_push($correos, $value->correo);
        }
        $datos['correos'] = array_merge(array($this->session->correo), $correos);
        
        $this->correos_po->creacionPO($datos);
        
        echo $id;
    }

    function ajax_cancelarPO(){
        $id = $this->input->post('id');

        $this->Conexion->comando("UPDATE ordenes_compra set estatus='CANCELADA' where id=$id");
        $res = $this->Conexion->consultar("SELECT distinct pr from ordenes_compra_conceptos where po = $id");

        $query2 = "UPDATE prs set estatus='APROBADO' where 1 != 1";
        foreach ($res as $elem) {
            $query2 .= " or id = $elem->pr";
        }
        $this->Conexion->comando($query2);

        echo "1";
    }
    
    function ajax_cancelarTempPO(){
        $idtemp = $this->input->post('idtemp');

        $res = $this->Conexion->consultar("SELECT prs from ordenes_compra_temp where idtemp = '$idtemp'", TRUE);
        $PRS = json_decode($res->prs);

        $query2 = "UPDATE prs set estatus='APROBADO' where 1 != 1";
        foreach ($PRS as $elem) {
            $query2 .= " or id = $elem";
        }
        $this->Conexion->comando($query2);
        $this->Conexion->eliminar('ordenes_compra_temp', array('idtemp' => $idtemp));

        echo "1";
    }

    function ajax_getMetodos(){
        $res = $this->Conexion->get('empresa_metodos_pago', null);
        if($res){
            echo json_encode($res);
        }
    }

    function agregarComentarioPO() {
        $id = $this->input->post('id');
        $comentario = $this->input->post('comentario');
        $tags = $this->input->post('txtTags');
        $correos = explode(",", $tags);

        $data = array(
            'po' => $id,
            'usuario' => $this->session->id,
            'comentario' => $comentario,
        );

        $funciones['fecha'] = 'current_timestamp()';
        
        $this->Conexion->insertar('po_comentarios', $data, $funciones);

        if(count($correos) > 0)
        {
            $datos['id'] = $id;
            $datos['comentario'] = $comentario;
            $datos['correos'] = $correos;
            //$this->correos_pr->comentarioPR($datos); VER AQUI
        }

        redirect(base_url('ordenes_compra/ver_po/' . $id));
    }

    function ajax_setEstatusMsjPO(){
        $PO = json_decode($this->input->post('PO'));
        $id = $this->input->post('id');

        $estatus = $this->input->post('estatus');
        $comentario_original = $this->input->post('comentario');
        $comentario = "<b><font color='red'>$estatus:</font></b> " . $comentario_original;
        $tags = $this->input->post('txtTags');
        $correos = explode(",", $tags);


        $query = "UPDATE ordenes_compra set estatus='" . $estatus . "' where id='" . $id . "'";


        $res = $this->Conexion->comando($query);
        if($res){

            $data = array(
                'po' => $id,
                'usuario' => $this->session->id,
                'comentario' => $comentario,
            );
            $funciones['fecha'] = 'current_timestamp()';
        
            $this->Conexion->insertar('po_comentarios', $data, $funciones);
            
            $PO->comentario = $comentario;
            $PO->UserA = $this->session->nombre;
            $this->correos_po->rechazarPO($PO);


            echo $comentario;
        }
        else{
            echo "";
        }
    }

    function ajax_poSetEstatus(){
        $PO = json_decode($this->input->post('PO'));

        $id = $this->input->post('id');
        $estatus = $this->input->post('estatus');
        $prs = json_decode($this->input->post('prs'));
        
        $prioridad = $PO->prioridad;
        $nombreProveedor = $PO->Prov;
        $nombreContacto = $PO->Contact;
        $total = $PO->total;
        

        if($estatus == 'AUTORIZADA')
        {
            $data['aprobador'] = $this->session->id;
            $funt['fecha_aprobacion'] = 'CURRENT_TIMESTAMP()';


            $stat_pr = 'PO AUTORIZADA';
            $query = "UPDATE prs set estatus='$stat_pr' where 1 != 1";
            foreach ($prs as $value) {
                $query .= " or id ='$value'";
            }
            $this->Conexion->comando($query);
            
            $PO->UserA = $this->session->nombre;
            $this->correos_po->aprobarPO($PO);
        }

        if($estatus == 'CANCELADA')
        {
            $stat_pr = 'CANCELADO';
            $query = "UPDATE prs set estatus='$stat_pr' where 1 != 1";
            foreach ($prs as $value) {
                $query .= " or id ='$value'";
            }
            $this->Conexion->comando($query);
        }

        $where['id'] = $id;
        $data['estatus'] = $estatus;
        $this->Conexion->modificar('ordenes_compra', $data, $funt, $where);



        echo "1";
    }

    function ajax_subirEvidencia(){
        $campo = $this->input->post('campo');

        $where['po'] = $this->input->post('po');
        $funciones['fecha' . $campo] = 'CURRENT_TIMESTAMP()';
        $datos['usuario' . $campo] = $this->session->id;
        $datos['archivo' . $campo] = file_get_contents($_FILES['file']['tmp_name']);
        $datos['nombre'. $campo] = $this->input->post('nombre') . ".pdf";

        if ($this->Conexion->modificar('ordenes_compra_evidencias', $datos, $funciones, $where) > 0)
        {
            echo "1";
        }
        else{
            trigger_error("Error al subir archivo", E_USER_ERROR);
        }
    }

    function ajax_eliminarEvidencia(){
        $po = $this->input->post('po');
        $campo = $this->input->post('campo');

        $where['po'] = $po;
        $datos['fecha' . $campo] = NULL;
        $datos['usuario' . $campo] = NULL;
        $datos['archivo' . $campo] = NULL;
        $datos['nombre' . $campo] = NULL;
        

        $this->Conexion->modificar('ordenes_compra_evidencias', $datos, NULL, $where);
        echo "1";
    }

    function ajax_getEvidenciaInfo(){
        $po = $this->input->post('po');

        $res = $this->Conexion->consultar("SELECT E.fecha1, E.fecha2, E.nombre1, E.nombre2, E.usuario1, E.usuario2, concat(U1.nombre, ' ', U1.paterno) as User1, concat(U2.nombre, ' ', U2.paterno) as User2 from ordenes_compra_evidencias E left join usuarios U1 on E.usuario1 = U1.id left join usuarios U2 on U2.id = E.usuario2 where E.po = '$po'", TRUE);
        echo json_encode($res);
    }

    function ajax_getPRsAgregadas(){
        $id = $this->input->post('id');
        $query = "SELECT OCC.pr from ordenes_compra_conceptos OCC where OCC.po = '$id'";
        $res = $this->Conexion->consultar($query);

        $prs = array();
        foreach ($res as $row) {
            array_push($prs, $row->pr);
        }
        
        echo json_encode($prs);
    }

    function ajax_enviarPO(){
        $body = $this->input->post('body');
        $para = $this->input->post('para');
        $po = $this->input->post('po');

        $datos['id'] = $po;
        $datos['correo_proveedor'] = $para;
        $datos['body'] = $body;

        $this->correos_po->enviarPO_proveedor($datos);
    }

    function ajax_recibirPO(){
        $id = $this->input->post('id');
        $prs = json_decode($this->input->post('prs'));
        $todos = $this->input->post('todos');
        
        if(boolval($todos))
        {
            $this->Conexion->comando("UPDATE ordenes_compra set estatus = 'RECIBIDA' where id = '$id'");
        }


        $query = "UPDATE prs set estatus = 'POR RECIBIR', recibido = CURRENT_TIMESTAMP() where 1 != 1";
        foreach ($prs as $value) {
            $query .= " or id = '$value'";
        }

        //echo $query;
        
        if($this->Conexion->comando($query))
        {
            echo "1";
        }


    }

    function evidencia(){
        $po = $this->input->post('po');
        $f = $this->input->post('file');


        $res = $this->Conexion->consultar("SELECT nombre$f as Nombre, archivo$f as Archivo from ordenes_compra_evidencias where po = '$po'", TRUE);
        $nombre = $res->Nombre;
        $file = $res->Archivo;        

        //$file = 'dummy.pdf';
        header('Content-type: application/pdf');
        header('Content-Disposition: inline; filename="' . $nombre . '"');
        header('Content-Transfer-Encoding: binary');
        //header('Content-Length: ' . filesize($file));
        header('Accept-Ranges: bytes');

        echo $file;
    }

    function ajax_retrocederQR(){
        $id = $this->input->post('id');
        $comentarios = $this->input->post('comentarios');

        $data['estatus'] = "ABIERTO";
        $data['fecha_liberacion'] = null;
        $data['liberador'] = null;

        $this->Conexion->modificar('requisiciones_cotizacion', $data, null, array('id' => $id));

        $data2['qr'] = $id;
        $data2['usuario'] = $this->session->id;
        $data2['comentario'] = "<b><font color=blue>RETROCEDIDO:</font></b> " . $comentarios;
        $this->Conexion->insertar('qr_comentarios', $data2, array('fecha' => 'CURRENT_TIMESTAMP()'));
    }

    function ajax_retrocederPO(){
        $id = $this->input->post('id');
        $comentarios = $this->input->post('comentarios');
        $prs = json_decode($this->input->post('prs'));

        $data['estatus'] = "EN PROCESO";
        $data['fecha_provision'] = null;
        $data['fecha_aprobacion'] = null;
        $data['aprobador'] = null;

        $this->Conexion->modificar('ordenes_compra', $data, null, array('id' => $id));

        $data2['po'] = $id;
        $data2['usuario'] = $this->session->id;
        $data2['comentario'] = "<b><font color=blue>RETROCEDIDO:</font></b> " . $comentarios;
        $this->Conexion->insertar('po_comentarios', $data2, array('fecha' => 'CURRENT_TIMESTAMP()'));

        foreach ($prs as $value) {
            $data3['estatus'] = "EN PO";
            $this->Conexion->modificar('prs', $data3, null, array('id' => $value));
        }
    }

    function ajax_getRecibirPRs(){
        $query = "SELECT PR.id, PR.fecha, PR.usuario, PR.prioridad, PR.tipo, PR.subtipo, PR.cantidad, PR.unidad, PR.clave_unidad, PR.descripcion, PR.atributos, PR.critico, PR.destino, PR.lugar_entrega, PR.comentarios, PR.estatus, concat(U.nombre, ' ', U.paterno) as User";
        $query .= " from prs PR left join usuarios U on PR.usuario = U.id where 1 = 1 and PR.estatus = 'POR RECIBIR' order by PR.fecha desc";

        $res = $this->Conexion->consultar($query);
        if($res)
        {
            echo json_encode($res);
        }
        else{
            echo "";
        }
    }


    ////////////////////////////////

    function requisitores(){
        $this->load->view('header');
        $this->load->view('ordenes_compra/catalogo_requisitores');
    }

    function ajax_getRequisitores(){
        $res = $this->Conexion->Consultar("SELECT U.id, concat(U.nombre, ' ', U.paterno, ' ', U.materno) as Requisitor, P.crear_qr_interno as QRI, P.crear_qr_venta as QRV from usuarios U inner join privilegios P on P.usuario = U.id where (P.crear_qr_interno = 1 or P.crear_qr_venta = 1) and U.activo = 1");
        if($res)
        {
            echo json_encode($res);
        }
    }

    function ajax_getAprobadores(){
        $res = $this->Conexion->Consultar("SELECT U.id, concat(U.nombre, ' ', U.paterno, ' ', U.materno) as Aprobador, (SELECT count(R.id) from usuarios R inner join privilegios PP on PP.usuario = R.id where (R.autorizador_compras = U.id and PP.crear_qr_interno = 1) or (R.autorizador_compras_venta = U.id and PP.crear_qr_venta = 1) and R.activo = 1) as RequisitoresACargo from usuarios U inner join privilegios P on P.usuario = U.id where P.aprobar_pr = 1 and U.activo = 1");
        if($res)
        {
            echo json_encode($res);
        }
    }

    function ajax_getRequisitoresACargo(){
        $aprobador = $this->input->post("aprobador");

        $res = $this->Conexion->Consultar("SELECT U.id, concat(U.nombre, ' ', U.paterno, ' ', U.materno) as Requisitor from usuarios U inner join privilegios P on P.usuario = U.id where (U.autorizador_compras = '$aprobador' and P.crear_qr_interno = 1) or (U.autorizador_compras_venta = '$aprobador' and P.crear_qr_venta = 1) and U.activo = 1");
        if($res)
        {
            echo json_encode($res);
        }
        
    }

    ////////////// H I S T O R I A L //////////////

    function ajax_getEmpresasHistorial(){
        $texto = $this->input->post('texto');
        $parametro = $this->input->post('parametro');

        $query = "SELECT E.id, E.foto, E.nombre, E.razon_social, E.cliente, E.proveedor, E.calle, E.numero, E.colonia, (SELECT count(*) from ordenes_compra where proveedor = E.id) as CountPO from empresas E where 1 = 1";

        if($texto)
        {
            if($parametro == "nombre")
            {
                $query .= " and E.nombre like '%$texto%'";
            }
        }
        $query .= " having CountPO > 0 order by E.nombre";

        $res = $this->Conexion->consultar($query);
        if($res){
            echo json_encode($res);
        }
    }

    ////////////// A C C I O N E S //////////////
    function ajax_getAcciones(){
        $po = $this->input->post('po');

        $res = $this->Conexion->consultar("SELECT A.*, concat(U.nombre, ' ', U.paterno) as User from po_acciones A inner join usuarios U on U.id = A.usuario where A.po = $po");
        if($res){
            echo json_encode($res);
        }
    }

    function ajax_getAcciones_calendar(){
        //$usuario = $this->input->post('usuario');

        $query = "SELECT A.*, concat('PO: ', A.po) as title, A.fecha_limite as start, A.fecha_limite + interval 1 hour as end, concat(U.nombre, ' ', U.paterno) as User,";
        $query .= " if(estatus = 'CANCELADA', 'gray', if(estatus = 'PENDIENTE' and current_timestamp() > A.fecha_limite, 'red', if(estatus = 'PENDIENTE' and current_timestamp() <= A.fecha_limite, '#f0ad4e', if(estatus = 'REALIZADA' and A.fecha_realizada > A.fecha_limite, '#76A874', if(estatus = 'REALIZADA' and A.fecha_realizada <= A.fecha_limite, 'green', ''))))) as color";
        $query .= " from po_acciones A inner join usuarios U on U.id = A.usuario where 1 = 1 ";

        $res = $this->Conexion->consultar($query);
        
        if($res)
        {
            echo json_encode($res);
        }
    }

    function ajax_setAccion(){
        $accion = json_decode($this->input->post('data'));
        $accion->usuario = $this->session->id;
        $accion->estatus = "PENDIENTE";

        $func['fecha_creacion'] = 'CURRENT_TIMESTAMP()';

        $id = $this->Conexion->insertar('po_acciones', $accion, $func);
        if($id > 0)
        {
            echo $id;
        }
    }

    function ajax_updateAccion(){
        $accion = json_decode($this->input->post('data'));

        $id = $this->Conexion->modificar('po_acciones', $accion, null, array('id' => $accion->id));
    }

    function ajax_setAccionRealizada(){
        $accion = json_decode($this->input->post('data'));
        $func['fecha_realizada'] = 'CURRENT_TIMESTAMP()';

        $id = $this->Conexion->modificar('po_acciones', $accion, $func, array('id' => $accion->id));
    }

    function ajax_setAccionComentario(){
        $comment = json_decode($this->input->post('data'));
        $comment->usuario = $this->session->id;

        $func['fecha'] = 'CURRENT_TIMESTAMP()';

        $id = $this->Conexion->insertar('po_acciones_comentarios', $comment, $func);
        if($id > 0)
        {
            echo $id;
        }
    }

    function ajax_getAccionComentarios(){
        $accion = $this->input->post('accion');
        $res = $this->Conexion->consultar("SELECT C.*, concat(U.nombre, ' ', U.paterno, ' ', U.materno) as User from po_acciones_comentarios C inner join usuarios U on U.id = C.usuario where C.accion = $accion");
        if($res)
        {
            echo json_encode($res);    
        }
    }

    function ajax_setNoConfirmacion(){
        $data['id'] = $this->input->post('po');
        $data['numero_confirmacion'] = $this->input->post('numero');
        
        $this->Conexion->modificar('ordenes_compra', $data, null, array('id' => $data['id']));
    }

}