<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class AOS_funciones {

    function no_semana(){
        $date = new DateTime();
        $week = $date->format("W");
        //echo $date->format("Y-m-d h:m");
        return $week;
    }

    function fecha_semana($year, $week1, $week2){        
        $week_date1 = new DateTime();
        $week_date1->setISODate($year, $week1);

        $week_date2 = new DateTime();
        $week_date2->setISODate($year, $week2);

        $date = array('0' => $week_date1->format('Y-m-d 00:00:00'), '1' => $week_date2->modify('+6 day')->format('Y-m-d 23:59:59') );
        return $date;
    }

    function fecha($date){
        switch(date('N', strtotime($date)))
        {
            case 1: 
                $dia = "Lunes";
                break;

            case 2: 
                $dia = "Martes";
                break;

            case 3: 
                $dia = "Miercoles";
                break;

            case 4: 
                $dia = "Jueves";
                break;

            case 5: 
                $dia = "Viernes";
                break;

            case 6: 
                $dia = "Sabado";
                break;

            case 7: 
                $dia = "Domingo";
                break;
        }

        switch(date('n', strtotime($date)))
        {
            case 1: 
                $mes = "Enero";
                break;

            case 2: 
                $mes = "Febrero";
                break;

            case 3: 
                $mes = "Marzo";
                break;

            case 4: 
                $mes = "Abril";
                break;

            case 5: 
                $mes = "Mayo";
                break;

            case 6: 
                $mes = "Junio";
                break;

            case 7: 
                $mes = "Julio";
                break;

            case 8: 
                $mes = "Agosto";
                break;

            case 9: 
                $mes = "Septiembre";
                break;

            case 10: 
                $mes = "Octubre";
                break;

            case 11: 
                $mes = "Noviembre";
                break;

            case 12: 
                $mes = "Diciembre";
                break;
        }

        return $dia . " " . date('j', strtotime($date)) . " de " . $mes;
    }

    function file_image($archivo) {
      $ext = explode(".", $archivo);
      $ext = strtolower($ext[count($ext) - 1]);

      switch ($ext)
      {
          case "avi":
              return base_url("template/images/files/") . "avi.png";
          case "css":
              return base_url("template/images/files/") . "css.png";
          case "csv":
              return base_url("template/images/files/") . "csv.png";
          case "dbf":
              return base_url("template/images/files/") . "dbf.png";
          case "doc":
              return base_url("template/images/files/") . "doc.png";
          case "docx":
              return base_url("template/images/files/") . "doc.png";
          case "dwg":
              return base_url("template/images/files/") . "dwg.png";
          case "exe":
              return base_url("template/images/files/") . "exe.png";
          case "html":
              return base_url("template/images/files/") . "html.png";
          case "iso":
              return base_url("template/images/files/") . "iso.png";
          case "js":
              return base_url("template/images/files/") . "js.png";
          case "jpg":
              return base_url("template/images/files/") . "jpg.png";
          case "json":
              return base_url("template/images/files/") . "json.png";
          case "mp3":
              return base_url("template/images/files/") . "mp3.png";
          case "mp4":
              return base_url("template/images/files/") . "mp4.png";
          case "pdf":
              return base_url("template/images/files/") . "pdf.png";
          case "png":
              return base_url("template/images/files/") . "png.png";
          case "ppt":
              return base_url("template/images/files/") . "ppt.png";
          case "pptx":
              return base_url("template/images/files/") . "ppt.png";
          case "ppsx":
              return base_url("template/images/files/") . "ppt.png";
          case "psd":
              return base_url("template/images/files/") . "psd.png";
          case "rtf":
              return base_url("template/images/files/") . "rtf.png";
          case "search":
              return base_url("template/images/files/") . "search.png";
          case "rar":
              return base_url("template/images/files/") . "rar.png";
          case "svg":
              return base_url("template/images/files/") . "svg.png";
          case "txt":
              return base_url("template/images/files/") . "txt.png";
          case "xls":
              return base_url("template/images/files/") . "xls.png";
          case "xlsx":
              return base_url("template/images/files/") . "xls.png";
          case "xml":
              return base_url("template/images/files/") . "xml.png";
          case "zip":
              return base_url("template/images/files/") . "zip.png";
          default:
              return base_url("template/images/files/") . "file.png";
      }
    }

    function is_image($archivo){
      $ext = explode(".", $archivo);
      $ext = strtolower($ext[count($ext) - 1]);

      switch ($ext)
      {
          case "bmp":
          case "gif":
          case "jpg":
          case "jpeg":
          case "tif":
          case "tiff":
          case "png":
              return true;
          default:
              return false;
      }
    }

    function getUSD(){
        ini_set('display_errors', 0);
        $CI = & get_instance();
        $CI->load->model('conexion_model', 'Conexion');
        
        $res = $CI->Conexion->consultar("SELECT usd, usd_actualizacion from variables_globales where id = 1", TRUE);
        $USD = $res->usd;
        $FECHA = $res->usd_actualizacion;

        $USD_DATE = null;

        $dom = new DomDocument;
        $dom->preserveWhiteSpace = FALSE;
        $dom->loadXML(file_get_contents("http://dof.gob.mx/indicadores.xml"));
        $items = $dom->getElementsByTagName('item');

        foreach ($items as $elem)
        {
            $i = 0;
            $tagTitle = $elem->getElementsByTagName('title');
            $tagDesc = $elem->getElementsByTagName('description');

            foreach ($tagTitle as $elem2)
            {
                if($tagTitle->item($i)->nodeValue == "DOLAR")
                {
                    $USD = $tagDesc->item($i)->nodeValue;
                    $USD_DATE = array('usd_actualizacion' => 'CURRENT_TIMESTAMP');
                }
                $i++;
            }  
        }

        $CI->Conexion->modificar("variables_globales", array('usd' => $USD), $USD_DATE, array('id' => 1));

        return array($USD, $FECHA);
    }
}
