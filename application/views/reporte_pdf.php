<?php


// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('AleksOrtiz');
$pdf->SetTitle('Masmetrologia');
$pdf->SetSubject('Reporte PDF');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
$pdf->setFooterData(array(0,64,0), array(0,64,128));

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
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

// ---------------------------------------------------------

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('dejavusans', '', 10, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();

// set text shadow effect
$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

$html = <<<EOD
<h1>Checklist de Revisión Vehicular</h1>
<p><b>Fecha:</b> <u> 06/Ene/18 </u>	<b>Hora de Revisión:</b> <u> 8:00 am </u>	<b>Revisa:</b> <u> ALEJANDRO ORTIZ </u></p>
<p><b>Vehiculo:</b> <u> VW Vento </u>	<b>Placas:</b> <u> $PLACAS </u>	<b>Kilometraje:</b> <u> $KILOMETRAJE </u></p>
<p><b>Nivel de Gasolina al Inicio:</b> <u> $GASOLINA% </u></p>


EOD;

$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

$tbl = <<<EOD
<table cellpadding="10" border="1">
	<tr>
		<td>
			CHEQUEO DE NIVELES
			<p><b>Aceite de Motor:</b> <u> $ACEITE_DE_MOTOR </u>	<b>Condiciones del Aceite:</b> <u> $CONDICIONES_ACEITE </u></p>
			<p><b>Limpia Parabrisas:</b> Delantero <u> $LIMPIA_PARABRISAS </u> Trasera <u> $LIMPIA_PARABRISAS_TRASERO </u>	<b>Refrigerante:</b> Deposito <u> $REFRIGERANTE_DEPOSITO </u>	Radiador<u> $REFRIGERANTE_RADIADOR </u></p>
			<p><b>Liquido de Frenos:</b> Nivel <u> $LIQUIDO_DE_FRENOS </u> Pedal <u> $LIQUIDO_DE_FRENOS_PEDAL </u>	<b>Dirección Hidraulica:</b> <u> $DIRECCION_HIDRAULICA </u></p>
			<p><b>Comentarios:</b> $COMENTARIOS_NIVELES</p>
		</td>
	</tr>
	<tr>
		<td>
			REVISIÓN DE LUCES
			<p><b>Direccionales:</b> Izquierda <u> $DIRECCIONALES_IZQUIERDA </u> Derecha <u> $DIRECCIONALES_DERECHA </u> Emergencia <u> $EMERGENCIA </u></p>
			<p><b>Lamparas Bajas/Altas:</b> Izquierda <u> $LAMPARA_IZQUIERDA </u> Derecha <u> $LAMPARA_DERECHA </u> Reversa <u> $REVERSA </u></p>
			<p><b>Traseras y Stop:</b> Izquida <u> $TRASERA_IZQUIERDA </u> Derecha <u> $TRASERA_DERECHA </u></p>
			<p><b>Comentarios:</b> $COMENTARIOS_LUCES</p>
		</td>
	</tr>
	<tr>
		<td>
			INTERIORES
			<p><b>Tapiceria:</b> <u> $TAPICERIA </u> <b>Kit de Herramientas</b> <u> $KIT_DE_HERRAMIENTAS </u></p>
			<p><b>Controles y Manivelas en Puertas:</b> <u> $CONTROLES </u> <b>Tapetes Completos</b> <u> $TAPETES_COMPLETOS </u></p>
			<p><b>Comentarios:</b> $COMENTARIOS_INTERIORES</p>
		</td>
	</tr>
	<tr>
		<td>
			DOCUMENTACIÓN
			<p><b>Placa Delantera:</b> <u> $PLACA_DELANTERA </u> <b>Tarjeta de Gasolina</b> <u> $TARJETA_GASOLINA </u> <b>Poliza de Seguro</b></p>
			<p><b>Placa Trasera:</b> <u> $PLACA_TRASERA </u> <b>Tarjeta de Circulación</b> <u> $TARJETA_CIRCULACION </u></p>
			<p><b>Vencimiento de Poliza:</b> <u> $VENCIMIENTO_POLIZA </u></p>
			<p><b>Comentarios:</b> $COMENTARIOS_DOCUMENTACION</p>
		</td>
	</tr>

</table>
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');

$pdf->Output('checklist_vehicular.pdf', 'I');