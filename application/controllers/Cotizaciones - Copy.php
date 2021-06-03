<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cotizaciones extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('correos_cotizaciones');
    }

    function index(){
        $this->load->view('header');
        $this->load->view('cotizaciones/catalogo');
    }

    function crear_cotizacion(){
        $usd = $this->aos_funciones->getUSD();
        $data["id"] = 0;
        $data['USD'] = $usd[0];
        $data['USD_ACT'] = $usd[1];
        $data['COPY'] = 0;
        
        if(isset($_POST["id"]))
        {
            $id = $this->input->post('id');
            $rev = $this->input->post('rev');
            $data['COPY'] = $id . '-' . $rev;
        }

        $this->load->view('header');
        $this->load->view('cotizaciones/generar', $data);
    }

    function ver_cotizacion($id = 0){
        $usd = $this->aos_funciones->getUSD();
        $data['USD'] = $usd[0];
        $data['USD_ACT'] = $usd[1];

        if(isset($_POST["id"]))
        {
            $id = $this->input->post('id');
        }
        else if ($id == 0){
            redirect(base_url('inicio'));
        }

        $data["id"] = $id;

        $this->load->view('header');
        $this->load->view('cotizaciones/generar', $data);
    }

    function dashboard(){
        $this->load->view('header');
        $this->load->view('cotizaciones/dashboard');
    }

    function cotizacion_pdf($param){
        $param = explode('-', $param);
        $id = $param[0];
        $rev = $param[1];

        $query = "SELECT (SELECT ifnull(max(CC2.revision), 0) from cotizaciones_conceptos CC2 where CC2.cotizacion = $id) as UltRev, C.fecha, C.moneda, C.tipo, C.impuesto_factor,";
        $query .= " C.impuesto_nombre, C.aprobador, C.estatus, E.razon_social, E.calle, E.numero, E.numero_interior, E.colonia, E.ciudad, E.estado, E.pais, E.rfc, EC.nombre,";
        $query .= " EC.telefono, EC.correo, (if(E.credito_cliente = 1, concat(E.credito_cliente_plazo, ' Días'), 'Contado')) as Credito, concat(R.nombre, ' ', R.paterno) as Resp,";
        $query .= " R.correo as RespCorreo, CC.*, C.planta, ifnull(EP.nombre, 'N/A') as PlantaNombre, ifnull(EP.calle, 'N/A') as PlantaCalle, ifnull(EP.colonia, 'N/A') as PlantaColonia, ifnull(EP.ciudad, 'N/A') as PlantaCiudad, ifnull(EP.estado, 'N/A') as PlantaEstado";
        $query .= " FROM cotizaciones_conceptos CC inner join cotizaciones C on C.id = CC.cotizacion";
        $query .= " left join empresa_plantas EP on EP.id = C.planta";
        $query .= " inner join empresas E on E.id = C.empresa inner join empresas_contactos EC on EC.id = C.contactos->'$[0]'";
        $query .= " inner join usuarios R on R.id = C.responsable where CC.cotizacion = $id and CC.revision = $rev";

        $res = $this->Conexion->consultar($query);


        $conceptos = [];
        $APROB = -1;
        $ESTATUS = "";
        $SERVICIOS = new stdClass;
        $SUBTOTAL = 0;
        $IMPUESTO = 0;
        $TOTAL = 0;



        foreach ($res as $i => $elem) {
            $OBS = $elem->UltRev != $rev ? " OBSOLETA" : "";
            $APROB = $elem->aprobador;
            $ESTATUS = $elem->estatus;
            $COT = 'COT-' . str_pad($elem->cotizacion, 6, "0", STR_PAD_LEFT) . " Rev: " . $rev . $OBS;
            $FECHA = date_format(date_create($elem->fecha), 'd/m/Y h:i A');
            $CLIENTE = $elem->razon_social;
            $DOMICILIO = $elem->calle . ' ' . $elem->numero . ' ' . $elem->numero_interior;
            $COLONIA = $elem->colonia;
            $RFC = $elem->rfc;

            
            $CONTACTO = $elem->nombre;
            $TELEFONO = $elem->telefono;
            $CORREO = $elem->correo;
            $UBICACION = $elem->ciudad . ', ' . $elem->estado . ', ' . $elem->pais;

            $RESPONSABLE = $elem->Resp;
            $RESPONSABLE_CORREO = $elem->RespCorreo;

            $ID_PLANTA = $elem->planta;
            $NOMBRE_PLANTA = $elem->PlantaNombre;
            $CALLE_PLANTA = $elem->PlantaCalle;
            $COLONIA_PLANTA = $elem->PlantaColonia;
            $CIUDAD_PLANTA = $elem->PlantaCiudad;
            $ESTADO_PLANTA = $elem->PlantaEstado;



            ////////////////////////////////////////////////////////////////////////////////////
            $concepto = new stdClass;
            $concepto->cantidad = $elem->cantidad;

            $concepto->atributos = json_decode($elem->atributos);

            $concepto->descripcion = $elem->descripcion;
            $concepto->servicios = json_decode($elem->servicios);

            foreach ($concepto->servicios as $key => $value) {
                $cod = $value[1];
                if($cod != "N/A")
                {
                    $SERVICIOS->$cod = $value[2];
                }
            }

            $concepto->comentarios = $elem->comentarios;
            $concepto->tiempo_entrega = $elem->tiempo_entrega;
            $concepto->sitio = $elem->sitio;
            $concepto->precio_unitario = $elem->precio_unitario;
            $concepto->importe = floatval($elem->precio_unitario) * floatval($elem->cantidad);
            array_push($conceptos, $concepto);

            ////////////////////////////////////////////////////////////////////////////////////
            
            $IMPUESTO_NOMBRE = "IVA / TAX [" . ($elem->impuesto_factor)*100 . "%]";
            $MONEDA = $elem->moneda;
            $CREDITO = $elem->Credito;

            $SUBTOTAL += $concepto->importe;
            $IMPUESTO += $concepto->importe * ($elem->impuesto_factor);
            $TOTAL += $concepto->importe * ($elem->impuesto_factor + 1);

            $NOTAS = "TERMINOS Y CONDICIONES:";

            switch ($elem->tipo) {
                case 'CALIBRACION':
                    $Margin = 195;
                    $NOTAS .= ''
                    . "\n1.- El servicio se programa con la orden de compra correspondiente. Si su orden de compra incluye mas de un equipo se requiere que los mismos se calibren dentro de un periodo de 30 días máximo."
                    . "\n2.- La Cotización es válida por 120 días a partir de la fecha de elaboración."
                    . "\n3.- El servicio de calibración descrito se ofrece usando los métodos y procedimientos internos del laboratorio, si existen requisitos específicos del cliente, se iniciará nuevamente el proceso de cotización."
                    . "\n4.- El costo del servicio es aplicable aun cuando su equipo no pase la calibración o no responda al proceso de ajuste, en cuyo caso, un reporte con información detallada de la falla presentada por su equipo le será entregado."
                    . "\n5.- No hay garantía de que el equipo mantendrá las tolerancias especificadas a lo largo del intervalo de la calibración, esto debido a deriva, medio ambiente, manejo y otras situaciones fuera de nuestro control."
                    . "\n6.- Identificación y frecuencia de calibración son asignadas por el cliente, asegurarse de proporcionarlas con su aprobación para agilizar la emisión de los documentos del servicio."
                    . "\n7.- El tiempo de entrega está sujeto a programación y transcurre a partir de la aprobación y de la recepción física del instrumento."
                    . "\nESTE SERVICIO CONSTA DE:"
                    . "\n1.- Revisión del Equipo y sus funciones generales / Limpieza externa del instrumento."
                    . "\n2.- Calibración del Equipo.";
                    break;
                
                case 'ESTUDIO DIMENSIONAL':
                    $Margin = 215;
                    $NOTAS .= ''
                    . "\n1.- Para programar e iniciar el servicio se requiere de la orden de compra correspondiente,\nUNA VEZ RECIBIDA SE LE CONFIRMA FECHA DE ENTREGA DE RESULTADOS."
                    . "\n2.- Favor de generar la orden de compra de acuerdo a la presente cotización y sus requisitos internos."
                    . "\n3.- La Cotización es válida por 120 días a partir de la fecha de elaboración."
                    . "\n4.- Se requieren planos legibles."
                    . "\n5.- La realización del servicio puede requerir seccionar piezas, provea la cantidad de piezas necesarias.";
                    break;

                case 'RENTA':
                    $Margin = 215;
                    $NOTAS .= ''
                    . "\n1.- Para programar e iniciar el servicio se requiere de la orden de compra correspondiente."
                    . "\n2.- Favor de generar la orden de compra de acuerdo a la presente cotización y sus requisitos internos."
                    . "\n3.- La Cotización es válida por 30 días a partir de la fecha de elaboración."
                    . "\nESTE SERVICIO CONSTA DE:"
                    . "\n1.- El equipo se entrega en su planta el día que usted lo requiera."
                    . "\n2.- Se instruirá a su personal sobre la operación y uso correcto del equipo."
                    . "\n3.- Se instalará el equipo donde usted lo disponga (solo básculas y contadores de componentes).";
                    break;

                case 'REPARACION':
                    $Margin = 215;
                    $NOTAS .= ''
                    . "\n1.- Para programar e iniciar el servicio se requiere de la orden de compra correspondiente."
                    . "\n2.- Favor de generar la orden de compra de acuerdo a la presente cotización y sus requisitos internos."
                    . "\n3.- La Cotización es válida por 15 días a partir de la fecha de elaboración.";
                    break;

                case 'VENTA':
                    $Margin = 215;
                    $NOTAS .= ''
                    . "\n1.- Favor de generar la orden de compra de acuerdo a la presente cotización y sus requisitos internos."
                    . "\n2.- La Cotización es válida por 30 días a partir de la fecha de elaboración."
                    . "\n3.- Pedido No Cancelable."
                    . "\n4.- Equipo disponible salvo previa venta si no se tiene confirmado por la orden de compra."
                    . "\n5.- Se requiere una orden de compra por escrito para realizar la entrega del equipo."
                    . "\n6.- Al recibir su Orden de Compra se le confirmara la fecha de entrega actualizada.";
                    break;

                case 'SOPORTE':
                    $Margin = 215;
                    $NOTAS .= ''
                    . "\n1.- Para programar e iniciar el servicio se requiere de la orden de compra correspondiente."
                    . "\n2.- Favor de generar la orden de compra de acuerdo a la presente cotización y sus requisitos internos."
                    . "\n3.- La Cotización es válida por 30 días a partir de la fecha de elaboración.";
                    break;

                case 'CALIBRACION EXTERNA':
                    $Margin = 205;
                    $NOTAS .= ''
                    . "\n1.- El servicio se programa con la orden de compra correspondiente y el equipo a disposición de Metrología Aplicada y Servicios. Si su orden de compra incluye más de un equipo se requiere que los mismos se calibren dentro de un periodo de 30 días máximo."
                    . "\n2.- La Cotización es válida por 30 días a partir de la fecha de elaboración."
                    . "\n3.- El servicio de calibración descrito se ofrece con el proveedor especificado en la cotización, si el cliente desea que su equipo sea enviado a otro proveedor distinto al especificado, se iniciara nuevamente el proceso de cotización."
                    . "\n4.- El costo del servicio es aplicable aun cuando su equipo no pase la calibración o no responda al proceso de ajuste, en cuyo caso, un reporte con información detallada de la falla presentada por su equipo le será entregado."
                    . "\n5.- No hay garantía de que el equipo mantendrá las tolerancias especificadas a lo largo del intervalo de la calibración, esto debido a deriva, medio ambiente, manejo y otras situaciones fuera de nuestro control."
                    . "\n6.- Tiempos de entrega sujetos a cambio, cualquier cambio en la programación se notificará con anticipación."
                    . "\n7.- El tiempo de entrega está sujeto a programación y transcurre a partir de la aprobación y de la recepción física del instrumento."
                    . "\nESTE SERVICIO CONSTA DE:"
                    . "\n1.- Revisión del Equipo y sus funciones generales / Limpieza externa del instrumento."
                    . "\n2.- Calibración del Equipo";
                    break;

                case 'MAPEO':
                    $Margin = 215;
                    $NOTAS .= ''
                    . "\n1.- El servicio se programa con la orden de compra correspondiente."
                    . "\n2.- Se requiere que el equipo sea puesto a disposición de Metrología Aplicada y Servicios a nuestra llegada a su planta para la realizacion del servicio."
                    . "\n3.- La cotizacion es por el servicio a ser realizado en el tiempo establecido en la cotizacion, en caso de requerir mas tiempo por causas ajenas a nosotros, se le cotizara aparte."
                    . "\n4.- En caso de cambio en el requerimiento o puntos adicionales, se le presentara la propuesta complementaria para su autorizacion."
                    . "\n5.- La Cotización es válida por 60 días a partir de la fecha de elaboración.";
                    break;

                case 'LISTA PRECIOS':
                    $Margin = 210;
                    $NOTAS .= ''
                    . "\n1.- El servicio se programa con la orden de compra correspondiente."
                    . "\n2.- El servicio de calibración descrito se ofrece usando los métodos y procedimientos internos del laboratorio, si existen requisitos específicos del cliente, se iniciara nuevamente el proceso de cotización."
                    . "\n3.- El costo del servicio es aplicable aun cuando su equipo no pase la calibración o no responda al proceso de ajuste, en cuyo caso, un reporte con información detallada de la falla presentada por su equipo le será entregado."
                    . "\n4.- No hay garantía de que el equipo mantendrá las tolerancias especificadas a lo largo del intervalo de la calibración, esto debido a deriva, medio ambiente, manejo y otras situaciones fuera de nuestro control."
                    . "\n5.- La vigencia de la presente cotización se establecerá en el contrato o acuerdo correspondiente."
                    . "\nESTE SERVICIO CONSTA DE:"
                    . "\n1.- Revisión del Equipo y sus funciones generales / Limpieza externa del instrumento."
                    . "\n2.- Calibración del Equipo";
                    break;
            }
        }


        ini_set('display_errors', 0);
        $this->load->library('pdfview');

        if($ESTATUS == "CANCELADA")
        {
            $pdf = new pdfview_CANCEL(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        }
        else
        {
            if($APROB > 0)
            {
                $pdf = new pdfview(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            }
            else{
                $pdf = new pdfview_NA(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            }
        }
        

        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('AleksOrtiz');
        $pdf->SetTitle('Masmetrologia');
        $pdf->SetSubject('Formato Cotización');
        
        //$pdf->SetHeaderData(PDF_HEADER_LOGO_ORIGINAL, '40', '                                                       Cotización / ' . $COT, "                                                             Fecha: " . $FECHA . " \n                                                             Ejecutivo: ". $RESPONSABLE ." \n                                                             Correo: " . $RESPONSABLE_CORREO);
        //$pdf->SetHeaderData(PDF_HEADER_LOGO_ORIGINAL, '40', 'Cotización / ' . $COT, "Fecha: " . $FECHA . " \n Ejecutivo: ". $RESPONSABLE ." \n Correo: " . $RESPONSABLE_CORREO);

        $spc = "                                      ";
        $head = "MASMetrología $spc Cotización / $COT";
        $txt = "Blvd Manuel Gómez Morin #8009                    Fecha: " . $FECHA;
        $txt .= "\nCol. Partido Senecú                                            Ejecutivo: " . $RESPONSABLE;
        $txt .= "\nRFC: MAS080825EE7                                       Correo: " . $RESPONSABLE_CORREO;

        $pdf->SetHeaderData(PDF_HEADER_LOGO_ORIGINAL, '40', $head, $txt);
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', 9));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        //$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetMargins(8, PDF_MARGIN_TOP, 8);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        $pdf->SetFont('times', '', 8);
        $pdf->AddPage();

        $tbl = <<<EOD
            <table border="0">
                <tr>
                    <td>
                        <b>Cliente/Client:</b><br>
                        $CLIENTE<br><br>
                        <b>Dirección / Address:</b><br>
                        $DOMICILIO<br>
                        $COLONIA<br>
                        $UBICACION<br>
                        RFC: $RFC<br>
                    </td>
                    <td>
EOD;

if($ID_PLANTA > 0)
{
        $tbl .= <<<EOD
        <b>Planta/Plant:</b><br>
        $NOMBRE_PLANTA<br>
        $CALLE_PLANTA<br>
        $COLONIA_PLANTA<br>
        $CIUDAD_PLANTA $ESTADO_PLANTA<br><br>
EOD;
}

        $tbl .= <<<EOD
                <b>Contacto / Contact:</b><br>
                $TELEFONO<br>
                $CORREO<br>
            </td>
        </tr>
    </table>
EOD;

        $pdf->writeHTML($tbl, false, false, false, false, '');
        $w = array(8, 125, 12, 24, 24);


        $pdf->SetFont('helvetica', 'B', 9);
        $pdf->SetTextColor(255);
        $w = array(8, 125, 12, 24, 24);

        $pdf->SetTextColor(0);

        $pdf->Cell($w[0], 6, "#", 1, 0, 'C');
        $pdf->Cell($w[1], 6, "Descripción", 1, 0, 'C');
        $pdf->Cell($w[2], 6, "Cant.", 1, 0, 'C');
        $pdf->Cell($w[3], 6, "Precio Unit.", 1, 0, 'C');
        $pdf->Cell($w[4], 6, "Importe", 1, 1, 'C');

        $pdf->SetFont('', '', 7);
        $i = 0;

        //ESPACIO ANTES DEL PRIMER CONCEPTO

        $pdf->writeHTMLCell($w[0], $h, '', '', '', "LRT", 0, 0, true, 'J', false);
        $pdf->writeHTMLCell($w[1], $h, '', '', '', "LRT", 0, 0, true, 'J', false);
        $pdf->writeHTMLCell($w[2], $h, '', '', '', "LRT", 0, 0, true, 'J', false);
        $pdf->writeHTMLCell($w[3], $h, '', '', '', "LRT", 0, 0, true, 'J', false);
        $pdf->writeHTMLCell($w[4], $h, '', '', '', "LRT", 1, 0, true, 'J', false);

        $RenSpace = 2.5;

        foreach($conceptos as $indice => $concepto)
        {
            $i++;
            $startX = $pdf->GetX();
            $startY = $pdf->GetY();
            $renSize = 0;
            $pdf->SetFont('', '', 7);

            ////// TIEMPO DE ENTREGA //////
            $dicSitios = array('OS' => 'En Planta', 'LAB' => 'LAB', 'EXT' => 'Prov. Externo');
            $sitio = $concepto->sitio != "N/A" ? (", Donde: " . $dicSitios[$concepto->sitio]) : "";
            $tEntrega = $concepto->tiempo_entrega > 0 ? ("T. Entrega: " . $concepto->tiempo_entrega . " Día" . ($concepto->tiempo_entrega > 1 ? "s" : "") . $sitio) : ("T. Entrega: N/A" . $sitio);

            ////// SERVICIOS //////
            if(count($concepto->servicios) > 0){
                $codigos = " ";
                foreach ($concepto->servicios as $value) {
                    $value[1] = $value[1] == "N/A" ? $value[2] : $value[1];
                    $codigos .= $value[1] . ", ";
                }

                $cellcount = array();
                $cellcount[] = $pdf->MultiCell($w[0], '', $indice + 1, 0, 'C', 0, 0);
                $cellcount[] = $pdf->MultiCell($w[1], '', "Servicios: " . $codigos . "   " . $tEntrega, 0, 'L', 0, 0);
                $cellcount[] = $pdf->MultiCell($w[2], '', number_format($concepto->cantidad, 0), 0, 'C', 0, 0);
                $cellcount[] = $pdf->MultiCell($w[3], '', ("$" . number_format($concepto->precio_unitario, 2)), 0, 'R', 0, 0);
                $cellcount[] = $pdf->MultiCell($w[4], '', ("$" . number_format($concepto->importe, 2)), 0, 'R', 0, 1);

                $renSize += max($cellcount);
            }

            ////// EQUIPO //////
            $att = "";
            if(array_key_exists("ID", $concepto->atributos)){
                $att .= "ID: " . $concepto->atributos->ID . ", ";
            }
            if(array_key_exists("Marca", $concepto->atributos)){
                $att .= "Marca: " . $concepto->atributos->Marca . ", ";
            }
            if(array_key_exists("Modelo", $concepto->atributos)){
                $att .= "Mod: " . $concepto->atributos->Modelo . ", ";
            }
            if(array_key_exists("Serie", $concepto->atributos)){
                $att .= "S/N: " . $concepto->atributos->Serie . ", ";
            }

            foreach ($concepto->atributos as $key => $value) {
                if($key != "ID" && $key != "Marca" && $key != "Modelo" && $key != "Serie")
                {
                    $att .= $key . ": " . $value . ", ";
                }
            }
            $att = rtrim($att, ', ');

            $cellcount = array();
            $cellcount[] = $pdf->MultiCell($w[0], '', count($concepto->servicios) > 0 ? "" : $indice + 1, 0, 'C', 0, 0);
            $cellcount[] = $pdf->MultiCell($w[1], '', $concepto->descripcion . (count($concepto->servicios) > 0 ? (" " . $att) : ("   " . $tEntrega)), 0, 'L', 0, 0);
            $cellcount[] = $pdf->MultiCell($w[2], '', count($concepto->servicios) > 0 ? "" : $concepto->cantidad, 0, 'C', 0, 0);
            $cellcount[] = $pdf->MultiCell($w[3], '', count($concepto->servicios) > 0 ? "" :  ("$" . number_format($concepto->precio_unitario, 2)), 0, 'R', 0, 0);
            $cellcount[] = $pdf->MultiCell($w[4], '', count($concepto->servicios) > 0 ? "" :  ("$" . number_format($concepto->importe, 2)), 0, 'R', 0, 1);
            $renSize += max($cellcount);

            ////// COMENTARIOS //////
            if(!empty($concepto->comentarios)){
                
                $cellcount = array();
                $cellcount[] = $pdf->MultiCell($w[0], '', "", 0, 'C', 0, 0);
                $cellcount[] = $pdf->MultiCell($w[1], '', "** " . $concepto->comentarios, 0, 'L', 0, 0);
                $cellcount[] = $pdf->MultiCell($w[2], '', "", 0, 'R', 0, 0);
                $cellcount[] = $pdf->MultiCell($w[3], '', "", 0, 'R', 0, 0);
                $cellcount[] = $pdf->MultiCell($w[4], '', "", 0, 'R', 0, 0);
                $renSize += max($cellcount);
            }
        
            $h = ($renSize + 1) * 3;

            $pdf->SetXY($startX, $startY);
            $pdf->writeHTMLCell($w[0], $h, '', '', '', "LR", 0, 0, true, 'J', false);
            $pdf->writeHTMLCell($w[1], $h, '', '', '', "LR", 0, 0, true, 'J', false);
            $pdf->writeHTMLCell($w[2], $h, '', '', '', "LR", 0, 0, true, 'J', false);
            $pdf->writeHTMLCell($w[3], $h, '', '', '', "LR", 0, 0, true, 'J', false);
            $pdf->writeHTMLCell($w[4], $h, '', '', '', "LR", 1, 0, true, 'J', false);


            if($pdf->GetY() > (260))
            {
                $pdf->MultiCell(193, '','','T','C',0,0);
                $pdf->AddPage();

                $pdf->SetFont('times', '', 8);
                $pdf->writeHTML($tbl, false, false, false, false, '');

                if($i < count($conceptos))
                {
                    $pdf->SetFont('helvetica', 'B', 9);
                    $pdf->SetTextColor(0);
                    $pdf->Cell($w[0], 6, "#", 1, 0, 'C');
                    $pdf->Cell($w[1], 6, "Descripción", 1, 0, 'C');
                    $pdf->Cell($w[2], 6, "Cant.", 1, 0, 'C');
                    $pdf->Cell($w[3], 6, "Precio Unit.", 1, 0, 'C');
                    $pdf->Cell($w[4], 6, "Importe", 1, 1, 'C');

                    $pdf->writeHTMLCell($w[0], '', '', '', '', "LRT", 0, 0, true, 'J', false);
                    $pdf->writeHTMLCell($w[1], '', '', '', '', "LRT", 0, 0, true, 'J', false);
                    $pdf->writeHTMLCell($w[2], '', '', '', '', "LRT", 0, 0, true, 'J', false);
                    $pdf->writeHTMLCell($w[3], '', '', '', '', "LRT", 0, 0, true, 'J', false);
                    $pdf->writeHTMLCell($w[4], '', '', '', '', "LRT", 1, 0, true, 'J', false);
                }
            }
        }







        //DESCRIPCION DE CODIGOS DE SERVICIO
        if(count((array)$SERVICIOS) > 0)
        {
            
            $pdf->MultiCell($w[0], '', '===', 'LR', 'C', 0, 0);
            $pdf->MultiCell($w[1], '', '====================================================================================', 'LR', 'C', 0, 0);
            $pdf->MultiCell($w[2], '', '=====', 'LR', 'C', 0, 0);
            $pdf->MultiCell($w[3], '', '============', 'LR', 'C', 0, 0);
            $pdf->MultiCell($w[4], '', '============', 'LR', 'C', 0, 1);

            
            $pdf->SetFont('', 'B', 7);
            $pdf->MultiCell($w[0], '', '', 'LR', 'C', 0, 0);
            $pdf->MultiCell($w[1], '', 'Descripción de Servicios:', 0, 'L', 0, 0);
            $pdf->MultiCell($w[2], '', '', 'LR', 'R', 0, 0);
            $pdf->MultiCell($w[3], '', '', 'LR', 'R', 0, 0);
            $pdf->MultiCell($w[4], '', '', 'LR', 'R', 0, 1);
            

            $pdf->SetFont('', '', 7);
            foreach($SERVICIOS as $codigo => $servicio) 
            {
                $startX = $pdf->GetX();
                $startY = $pdf->GetY();

                $cellcount = array();
                $cellcount[] = $pdf->MultiCell($w[0], '', '', 0, 'C', 0, 0);
                $cellcount[] = $pdf->MultiCell($w[1], '', $codigo . ": " . $servicio, 0, 'L', 0, 0);
                $cellcount[] = $pdf->MultiCell($w[2], '', '', 0, 'R', 0, 0);
                $cellcount[] = $pdf->MultiCell($w[3], '', '', 0, 'R', 0, 0);
                $cellcount[] = $pdf->MultiCell($w[4], '', '', 0, 'R', 0, 0);
                
                $pdf->SetXY($startX, $startY);
                $h = (max($cellcount) + 1) * 3;
                $pdf->MultiCell($w[0], $h,'','LR','C',0,0);
                $pdf->MultiCell($w[1], $h,'','LR','L',0,0);
                $pdf->MultiCell($w[2], $h,'','LR','R',0,0);
                $pdf->MultiCell($w[3], $h,'','LR','R',0,0);
                $pdf->MultiCell($w[4], $h,'','LR','R',0,1);
            }
        }
        


        $startY = $pdf->GetY();
        for ($startY; $startY < $Margin; $startY = $startY + 6) {
            $pdf->MultiCell($w[0], 6, '----', 'LR', 'C', 0, 0);
            $pdf->MultiCell($w[1], 6, '-----------------------------------------------------------------------------------------------------------------------------------------------', 'LR', 'C', 0, 0);
            $pdf->MultiCell($w[2], 6, '-------', 'LR', 'C', 0, 0);
            $pdf->MultiCell($w[3], 6, '-------------------', 'LR', 'C', 0, 0);
            $pdf->MultiCell($w[4], 6, '-------------------', 'LR', 'C', 0, 0);
            $pdf->Ln();
        }

        $pdf->MultiCell($w[0] + $w[1] + $w[2], 6, $NOTAS, 'T', 'M', 0 , 0);
        $pdf->SetFont('', '', 8);
        $pdf->MultiCell($w[3], 4, 'Sub-Total', 'T', 'C', 0 , 0, '', '', TRUE, 0, FALSE, TRUE, 0, 'M');
        $pdf->MultiCell($w[4], 4, "$" . number_format($SUBTOTAL, 2), 1, 'R', 0, 0, '', '', TRUE, 0, FALSE, TRUE, 0, 'M');
        $pdf->Ln();

        
        $pdf->MultiCell($w[0] + $w[1] + $w[2], 6, '', 0, 'L', 0 , 0);
        $pdf->MultiCell($w[3], 4, $IMPUESTO_NOMBRE, 0, 'C', 0 , 0, '', '', TRUE, 0, FALSE, TRUE, 0, 'M');
        $pdf->MultiCell($w[4], 4, "$" . number_format($IMPUESTO, 2), 1, 'R', 0 , 0, '', '', TRUE, 0, FALSE, TRUE, 0, 'M');
        $pdf->Ln();

        $pdf->MultiCell($w[0] + $w[1] + $w[2], 6, '', 0, 'M', 0 , 0);
        $pdf->MultiCell($w[3], 4, 'Total', 0, 'C', 0 , 0, '', '', TRUE, 0, FALSE, TRUE, 0, 'M');
        $pdf->MultiCell($w[4], 4, '$' . number_format($TOTAL, 2), 1, 'R', 0 , 0, '', '', TRUE, 0, FALSE, TRUE, 0, 'M');
        $pdf->Ln();

        $pdf->MultiCell($w[0] + $w[1] + $w[2], 6, '', 0, 'M', 0 , 0);
        $pdf->MultiCell($w[3] + $w[4], 6, '* Moneda / Currency: ' . $MONEDA, 0, 'C', 0 , 0, '', '', TRUE, 0, FALSE, TRUE, 0, 'M');
        //$pdf->MultiCell($w[3], 6, $MONEDA, 0, 'C', 0 , 0, '', '', TRUE, 0, FALSE, TRUE, 0, 'M');
        $pdf->Ln();

        $pdf->MultiCell($w[0] + $w[1] + $w[2], 6, '', 0, 'M', 0 , 0);
        $pdf->MultiCell($w[3] + $w[4], 6, '', 0, 'C', 0 , 0, '', '', TRUE, 0, FALSE, TRUE, 0, 'M');
        $pdf->Ln();
        
        $pdf->MultiCell(180, 6, '', 0, 'M', 0 , 0);
        $pdf->Ln();

        $pdf->MultiCell(180, 6, '', 0, 'M', 0 , 0);
        $pdf->Ln();
        $pdf->Ln();

        $pdf->Output($COT . '.pdf', 'I');
    }

    //                         __
    //                       .'  '.
    //                   _.-'/  |  \
    //      ,        _.-"   |  /    `-.
    //      |\    .-"       `--""-.__.'======================,
    //      \ '-'`        .___.--._)=========================|
    //       \            .'      |                          |
    //        |     /,_.-'        |        CODIGO AJAX       |
    //      _/   _.'(             |            BY            |
    //     /  ,-' \  \            |        ALEKS ORTIZ       |
    //     \  \    `-'            |                          |
    //      `-'                   '--------------------------'

    function ajax_setCotizacion(){
        $cotizacion = json_decode($this->input->post("cotizacion"));
        $conceptos = json_decode($this->input->post("conceptos"));

        if($cotizacion->id == 0)
        {
            $cotizacion->usuario = $this->session->id;
            $cotizacion->id = $this->Conexion->insertar('cotizaciones', $cotizacion, array('fecha' => 'CURRENT_TIMESTAMP()'));
        }
        else
        {
            // M O D I F I C A C I O N    D E    D A T O S
            $func = null;
            if($cotizacion->estatus == 'APROBADA')
            {
                $cotizacion->aprobador = $this->session->id;
                $func['fecha_aprobacion'] = 'CURRENT_TIMESTAMP()';
            }
            if($cotizacion->estatus == 'CONFIRMADA')
            {
                $func['fecha_confirmacion'] = 'CURRENT_TIMESTAMP()';
            }
            $this->Conexion->modificar('cotizaciones', $cotizacion, $func, array('id' => $cotizacion->id));


            
            // E N V I O    D E    C O R R E O S
            if(isset($_POST['comentarios']) && $_POST['comentarios'])
            {
                $datos['comentarios'] = $this->input->post('comentarios');
            }

            if($cotizacion->estatus == 'PENDIENTE AUTORIZACION')
            {
                $res = $this->Conexion->consultar("SELECT E.nombre as NombreCliente, EC.nombre as NombreContacto, concat(R.nombre, ' ', R.paterno) as Responsable, A.correo from cotizaciones C inner join usuarios R on R.id = C.responsable inner join usuarios A on R.autorizador_cotizacion = A.id inner join empresas E on E.id = C.empresa inner join empresas_contactos EC on EC.id = C.contactos->'$[0]' where C.id = $cotizacion->id", TRUE);
                $datos['id'] = $cotizacion->id;
                $datos['correos'] = $res->correo;
                $datos['nombreCliente'] = $res->NombreCliente;
                $datos['nombreContacto'] = $res->NombreContacto;
                $datos['nombreResponsable'] = $res->Responsable;

                
                $this->correos_cotizaciones->solicitarAprobacion($datos);
            }
            if($cotizacion->estatus == 'RECHAZADA')
            {
                $res = $this->Conexion->consultar("SELECT E.nombre as NombreCliente, EC.nombre as NombreContacto, concat(R.nombre, ' ', R.paterno) as Responsable, R.correo from cotizaciones C inner join usuarios R on R.id = C.responsable inner join empresas E on E.id = C.empresa inner join empresas_contactos EC on EC.id = C.contactos->'$[0]' where C.id = $cotizacion->id", TRUE);
                $datos['id'] = $cotizacion->id;
                $datos['correos'] = $res->correo;
                $datos['nombreCliente'] = $res->NombreCliente;
                $datos['nombreContacto'] = $res->NombreContacto;
                $datos['nombreResponsable'] = $res->Responsable;

                $this->correos_cotizaciones->rechazoCotizacion($datos);
            }
            if($cotizacion->estatus == 'APROBADA')
            {
                $res = $this->Conexion->consultar("SELECT E.nombre as NombreCliente, EC.nombre as NombreContacto, concat(R.nombre, ' ', R.paterno) as Responsable, R.correo from cotizaciones C inner join usuarios R on R.id = C.responsable inner join empresas E on E.id = C.empresa inner join empresas_contactos EC on EC.id = C.contactos->'$[0]' where C.id = $cotizacion->id", TRUE);
                $datos['id'] = $cotizacion->id;
                $datos['correos'] = $res->correo;
                $datos['nombreCliente'] = $res->NombreCliente;
                $datos['nombreContacto'] = $res->NombreContacto;
                $datos['nombreResponsable'] = $res->Responsable;

                $this->correos_cotizaciones->aprobacionCotizacion($datos);
            }
        }

        foreach ($conceptos as $key => $elem) {
            $elem->cotizacion = $cotizacion->id;
            if($elem->id == 0)
            {
                $this->Conexion->insertar('cotizaciones_conceptos', $elem);
            }
            if($elem->id < 0)
            {
                $this->Conexion->eliminar('cotizaciones_conceptos', array('id' => (intval($elem->id) * -1)));
            }
            else
            {
                $this->Conexion->modificar('cotizaciones_conceptos', $elem, null, array('id' => $elem->id));
            }
        }

        if(isset($_POST['comentarios']) && $_POST['comentarios'])
        {
            $comentario = new stdClass;
            $comentario->cotizacion = $cotizacion->id;
            $comentario->usuario = $this->session->id;
            $comentario->comentario = $this->input->post('comentarios');
            
            $this->Conexion->insertar('cotizaciones_comentarios', $comentario, array('fecha' => 'CURRENT_TIMESTAMP()'));
        }
        
        echo $cotizacion->id;
    }

    function ajax_getCotizaciones(){
        $id = $this->input->post('id');
        $texto = $this->input->post('texto');
        $parametro = $this->input->post('parametro');
        $cliente = $this->input->post('cliente');
        $estatus = $this->input->post('estatus');
        $tipo = $this->input->post('tipo');

        $group = TRUE;
        
        $query = "SELECT C.*, (SELECT ifnull(max(CC.revision), 0) as Rev from cotizaciones_conceptos CC where CC.cotizacion = C.id) as UltRev, E.nombre as Cliente, EC.nombre as Contacto, concat(R.nombre, ' ', R.paterno) as Responsable from cotizaciones C left join empresas E on E.id = C.empresa left join empresas_contactos EC on EC.id = C.contactos->'$[0]' left join usuarios R on R.id = C.responsable inner join cotizaciones_conceptos CC on C.id = CC.cotizacion where 1 = 1";

        if($id)
        {
            $query .= " and C.id = '$id'";
        }
        else
        {
            if(!empty($cliente) && $cliente != 0)
            {
                $query .= " and C.empresa = '$cliente'";
            }
            if(!empty($tipo) && $tipo != "TODOS")
            {
                $query .= " and C.tipo = '$tipo'";
            }
            if(!empty($estatus) && $estatus != 'TODOS')
            {
                $query .= " and C.estatus = '$estatus'";
            }
            if(!empty($texto))
            {
                if($parametro == "folio")
                {
                    $query .= " and C.id = '$texto'";
                }
                if($parametro == "id")
                {
                    $query .= " and UPPER(CC.atributos->'$.ID') like '%" . strtoupper($texto) . "%'";
                }
                if($parametro == "marca")
                {
                    $query .= " and UPPER(CC.atributos->'$.Marca') like '%" . strtoupper($texto) . "%'";
                }
                if($parametro == "serie")
                {
                    $query .= " and UPPER(CC.atributos->'$.Serie') like '%" . strtoupper($texto) . "%'";
                }
                if($parametro == "modelo")
                {
                    $query .= " and UPPER(CC.atributos->'$.Modelo') like '%" . strtoupper($texto) . "%'";
                }
                if($parametro == "responsable")
                {
                    $group = FALSE;
                    $query .= " group by C.id";
                    $query .= " having Responsable like '%$texto%'";
                }
                if($parametro == "contenido")
                {
                    $query .= " and CC.descripcion like '%$texto%'";
                }
            }
        }

        if($group)
        {
            $query .= " group by C.id";
        }

        $res = $this->Conexion->consultar($query, $id);

        if($res)
        {
            echo json_encode($res);
        }
    }

    function ajax_getClientesCotizaciones(){
        $texto = $this->input->post('texto');
        
        $query = "SELECT E.id, E.nombre, count(C.id) as NumCot from cotizaciones C inner join empresas E on E.id = C.empresa";

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

    function ajax_getCotizacionConceptos(){
        $coti = $this->input->post('cotizacion');
        $rev = $this->input->post('revision');
        
        $query = "SELECT CC.* from cotizaciones_conceptos CC where cotizacion = $coti";

        if(isset($_POST["revision"]))
        {
            $query .= " and revision = $rev";
        }

        $res = $this->Conexion->consultar($query);
        if($res)
        {
            echo json_encode($res);
        }
    }

    function ajax_setRevision(){
        $cotizacion = json_decode($this->input->post("cotizacion"));
        $conceptos = json_decode($this->input->post("conceptos"));
        $id = $cotizacion->id;
        unset($cotizacion->id);

        $rv = $this->Conexion->consultar("SELECT (max(CC.revision) + 1) as Rev from cotizaciones_conceptos CC where CC.cotizacion = $id", TRUE);
        
        foreach ($conceptos as $key => $elem) {
            $elem->cotizacion = $id;
            $elem->revision = $rv->Rev;
            $this->Conexion->insertar('cotizaciones_conceptos', $elem);
        }
        $this->Conexion->modificar('cotizaciones', $cotizacion, null, $id);

        echo "1";
    }

    function ajax_setComentarios(){
        $comentario = json_decode($this->input->post('comentario'));
        $comentario->usuario = $this->session->id;
        $funciones = array('fecha' => 'CURRENT_TIMESTAMP()');
        

        $res = $this->Conexion->insertar('cotizaciones_comentarios', $comentario, $funciones);
        if($res > 0)
        {
            echo "1";
        }
    }

    function ajax_getComentarios(){
        $id = $this->input->post('id');

        $query = "SELECT C.*, concat(U.nombre, ' ', U.paterno) as User from cotizaciones_comentarios C inner join usuarios U on U.id = C.usuario where 1 = 1";

        if($id)
        {
            $query .= " and C.cotizacion = '$id'";
        }

        $res = $this->Conexion->consultar($query);
        if($res)
        {
            echo json_encode($res);
        }
    }

    function ajax_getSAData(){
        $id_equipo = $this->input->post('id_equipo');
        $res = shell_exec("C:/xampp/htdocs/MASMetrologia/sa_reader/sa_reader.exe \"$id_equipo\"");
        echo $res;
    }


    function ajax_getClientes(){
        $id = $this->input->post('id');
        $nombre = $this->input->post('nombre');

        $query = "SELECT E.* from empresas E where E.cliente = 1 and JSON_LENGTH(E.moneda_cotizacion) > 0";

        if($id)
        {
            $query .= " and E.id = '$id'";
        }
        else
        {
            if($nombre)
            {
                $query .= " and E.nombre like '%$nombre%'";
            }
        }


        $res = $this->Conexion->consultar($query, $id);
        if($res)
        {
            echo json_encode($res);
        }
    }

    function ajax_getPlanta(){
        $id = $this->input->post('id');

        $query = "SELECT * from empresa_plantas where id = $id";
        
        $res = $this->Conexion->consultar($query, TRUE);
        if($res){
            echo json_encode($res);
        }
    }

    function ajax_getbuscarAutores(){
        $id = $this->input->post('id');

        $query = "SELECT U.id, concat(U.nombre, ' ', U.paterno) as Nombre, P.puesto as Puesto, U.correo from usuarios U inner join puestos P on U.puesto = P.id inner join privilegios PR on PR.usuario = U.id where U.activo = 1 and PR.administrar_cotizaciones = 1";

        if($id)
        {
            $query .= " and U.id = '$id'";
        }

        $res = $this->Conexion->consultar($query, $id);
        if($res)
        {
            echo json_encode($res);
        }
    }
    
    function ajax_getContactos(){
        $id = $this->input->post('id');
        $empresa = $this->input->post('id_cliente');

        $query = "SELECT * from empresas_contactos where activo = 1 and cotizable = 1";

        if($id)
        {
            $query .= " and id = '$id'";
        }
        else
        {
            if($empresa)
            {
                $query .= " and empresa = '$empresa'";
            }
        }

        $res = $this->Conexion->consultar($query, $id);
        if($res)
        {
            echo json_encode($res);
        }
    }

    function ajax_getServicio(){
        $codigo = $this->input->post('codigo');

        $query = "SELECT S.id, S.codigo, S.sitio, S.descripcion as DescripcionServicio, CP.alto_a as Precio from servicios S inner join claves_precio CP on S.clave_precio = CP.id where S.codigo = '$codigo'";

        $res = $this->Conexion->consultar($query);
        if($res)
        {
            echo json_encode($res);
        }
    }

    function ajax_getServicioMarMod(){ //SERVICIOS RELACIONADOS A REQUERIMIENTO POR MARCA/MODELO
        $fabricante = $this->input->post('fabricante');
        $modelo = $this->input->post('modelo');

        //$query = "SELECT S.*, S.descripcion as DescripcionServicio, CP.alto_a as Precio, R.descripcion, R.id as IdReq from requerimientos R inner join servicios S on S.id = R.servicio inner join claves_precio CP on S.clave_precio = CP.id where R.catalogado = '1' and upper(trim(R.fabricante)) = '$fabricante' and upper(trim(R.modelo)) = '$modelo' group by S.id limit 1";
        $query = "SELECT R.id, R.descripcion, R.servicio from requerimientos R where R.catalogado = '1' and upper(trim(R.fabricante)) = '$fabricante' and upper(trim(R.modelo)) = '$modelo' limit 1";

        $res = $this->Conexion->consultar($query, TRUE);

        if($res)
        {
            echo json_encode($res);
        }
    }

    function ajax_enviarCorreo(){
        $cotizacion = json_decode($this->input->post("cotizacion"));
        
        $id_cot = $cotizacion->id;
        $res = $this->Conexion->consultar("SELECT U.correo, U.password_correo from cotizaciones C inner join usuarios U on U.id = C.responsable where C.id = $id_cot", TRUE);

        $datos['res_correo'] = $res->correo;
        $datos['res_correo_pass'] = $res->password_correo;

        $datos['id'] = $cotizacion->id;        
        $datos['revision'] = $cotizacion->UltRev;
        $datos['estatus'] = $cotizacion->estatus;
        $datos['asunto'] = $this->input->post('asunto');
        $datos['para'] = $this->input->post('para');
        $datos['cc'] = $this->input->post('cc');
        $datos['body'] = $this->input->post('body');
        $datos['archivo'] = base_url("cotizaciones/cotizacion_pdf/" . $datos['id'] . "-" . $datos['revision']);

        
        //$this->correos_cotizaciones->enviarCotizacionCliente($datos);

    
        if(substr($this->correos_cotizaciones->enviarCotizacionCliente($datos), 0, 5) == "<pre>")
        {
            if($datos['estatus'] == "APROBADA")
            {
                $this->Conexion->modificar('cotizaciones', array('estatus' => 'ENVIADA'), null, array('id' => $datos['id']));
            }
            echo "1";
        }

    }

    function ajax_getDashboard(){
        $query = 'SELECT count(*) as Total, (SELECT count(*) FROM cotizaciones where estatus = "APROBADA") as Aprobadas, (SELECT min(fecha) FROM cotizaciones where estatus = "APROBADA") as ultAprobadas,';
        $query .= ' (SELECT count(*) FROM cotizaciones where estatus = "ENVIADA") as Enviadas, (SELECT min(fecha) FROM cotizaciones where estatus = "ENVIADA") as ultEnviadas,';
        $query .= ' (SELECT count(*) FROM cotizaciones where estatus = "CONFIRMADA") as Confirmadas, (SELECT min(fecha) FROM cotizaciones where estatus = "CONFIRMADA") as ultConfirmadas,';
        $query .= ' (SELECT count(*) FROM cotizaciones where estatus = "EN REVISION") as EnRevision, (SELECT min(fecha) FROM cotizaciones where estatus = "EN REVISION") as ultEnRevision,';
        $query .= ' (SELECT count(*) FROM cotizaciones where estatus = "EN AUTORIZACION") as EnAutorizacion, (SELECT min(fecha) FROM cotizaciones where estatus = "EN AUTORIZACION") as ultEnAutorizacion,';
        $query .= ' (SELECT count(*) FROM cotizaciones where estatus = "AUTORIZADO PARCIAL") as AutorizadoParcial, (SELECT min(fecha) FROM cotizaciones where estatus = "AUTORIZADO PARCIAL") as ultAutorizadoParcial,';
        $query .= ' (SELECT count(*) FROM cotizaciones where estatus = "AUTORIZADO TOTAL") as AutorizadoTotal, (SELECT min(fecha) FROM cotizaciones where estatus = "AUTORIZADO PARCIAL") as ultAutorizadoTotal';
        $query .= ' FROM cotizaciones;';
        $res = $this->Conexion->consultar($query, TRUE);
        echo json_encode($res);
    }





}
