<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pdf extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    function revision($id_rev)
    {
      ini_set('display_errors', 0);
      $this->load->library('pdfview');
      $this->load->model('autos_model');


      $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

      // set document information
      $pdf->SetCreator(PDF_CREATOR);
      $pdf->SetAuthor('AleksOrtiz');
      $pdf->SetTitle('Masmetrologia');
      $pdf->SetSubject('Reporte PDF');
      // set default header data
      $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
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
      // set font
      $pdf->SetFont('helvetica', 'B', 15);
      // add a page
      $pdf->AddPage();
      $pdf->Write(0, 'Checklist de Revisión Vehicular', '', 0, 'L', true, 0, false, false, 0);
      $pdf->SetFont('helvetica', '', 12);


      //DATOS DE LA REVISION
      $datosRevision = $this->autos_model->getRevision($id_rev);
      $auto = $this->autos_model->getAuto($datosRevision->auto);

      //HALLAZGOS
      $carroceria = $this->autos_model->getHallazgosCarroceria($id_rev);
      $otros = $this->autos_model->getHallazgosOtros($id_rev);

      $coche =
      '<table cellpadding="4">
          <tr>
            <td align="center">
              <img width="180" height="130" src="data:image/bmp;base64,' . base64_encode($auto->foto).'">
            </td>
          </tr>
          <tr align="left">
            <td><b>Marca:</b> '.$auto->marca.' </td>
          </tr>
          <tr align="left">
            <td><b>Combustible:</b> '.$auto->combustible.'</td>
          </tr>
          <tr align="left">
            <td><b>Placas:</b> '.$auto->placas.'</td>
          </tr>

      </table>';

      $info_rev =
      '<table cellpadding="4">
          <tr align="left">
            <td>No. Revisión:</td>
            <td>'.$datosRevision->id.'</td>
          </tr>
          <tr align="left">
            <td>Fecha de Revisión:</td>
            <td>'.$datosRevision->fecha.'</td>
          </tr>
          <tr align="left">
            <td>Revisión por:</td>
            <td>'.$datosRevision->User.'</td>
          </tr>
          <tr align="left">
            <td>Kilometraje:</td>
            <td>'.$datosRevision->kilometraje.'</td>
          </tr>
          <tr align="left">
            <td>Combustible:</td>
            <td>'.$datosRevision->combustible.'%</td>
          </tr>
          <tr align="left">
            <td>Placas:</td>
            <td>'.$datosRevision->placas.'</td>
          </tr>
          <tr align="left">
            <td>Vencimiento de Poliza:</td>
            <td>'.$datosRevision->vencimiento_poliza.'</td>
          </tr>
          <tr align="left">
            <td>Vecimiento de Ecológico:</td>
            <td>'.$datosRevision->vencimiento_ecologico.'</td>
          </tr>

      </table>';

      $tabla_general = '<table border="1" cellpadding="4">
          <tr style="font-size: 18px;" align="center">
              <th width="35%">Automóvil</th>
              <th width="65%">Resultado de la Revisión</th>
          </tr>
          <tr align="center">
              <td> '.$coche.' </td>
              <td> '.$info_rev.' </td>
          </tr>
      </table>';

      $pdf->writeHTML($tabla_general, true, false, false, false, '');


      //HALLAZGOS
      $hallazgosCarroceria = '<table cellpadding="4">';
      $pdf->SetFont('helvetica', '', 10);
      if($carroceria)
      {

        foreach ($carroceria->result() as $elem)
        {
          $hallazgosCarroceria .=
          '<tr>
            <td align="center">
              <img width="130" height="90" src="'.base_url('autos/Hallazgo_foto/'.$elem->id).'">
            </td>
            <td>'.$elem->descripcion.'</td>
          </tr>';
        }

      }
      $hallazgosCarroceria .= '</table>';


      $hallazgosOtros = '<table cellpadding="4">';
      if($otros)
      {
        foreach ($otros->result() as $elem)
        {
          $hallazgosOtros .=
          '<tr align="left">
            <td>'.$elem->tipo.'</td>
            <td>'.$elem->descripcion.'</td>
          </tr>';
        }
      }
      $hallazgosOtros .= '</table>';

      $tablaHallazgos = '<table border="1" cellpadding="4">
          <tr style="font-size: 18px;" align="center">
              <th width="50%">Carroceria</th>
              <th width="50%">Hallazgos</th>
          </tr>
          <tr align="center">
              <td> ' . $hallazgosCarroceria . ' </td>
              <td> ' . $hallazgosOtros . ' </td>
          </tr>
      </table>';

      $pdf->writeHTML($tablaHallazgos, true, false, false, false, '');

      $pdf->Output('example_048.pdf', 'I');

    }


}
