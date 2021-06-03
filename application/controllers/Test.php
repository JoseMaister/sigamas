<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }

    function sms(){
        $this->load->view('test/sms');
    }

    function index(){
        $this->load->model('compras_model','Modelo');
        $qr = $this->Modelo->getDetalleQR(11);
        $datos['correos'] = array($qr->correo);

        $Notificar = json_decode($qr->notificaciones);

        $query = "SELECT U.correo from usuarios U where 1 != 1 ";
        foreach ($Notificar as $value) {
            $query .= " or U.id = $value";
        }

        $res = $this->Conexion->consultar($query);
        foreach ($res as $key => $value) {
            //array_push($datos['correos'], $value->correo);
        }


        echo json_encode($datos['correos']);
    }










    function fecha(){
        switch(date('N', strtotime("2020-05-28")))
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

        switch(date('n', strtotime("2020-05-28")))
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

        echo $dia . " " . date('j', strtotime("2020-05-28")) . " de " . $mes;
    }

    function getLocation(){
        if(!empty($_POST['latitude']) && !empty($_POST['longitude'])){ 

            //Send request and receive json data by latitude and longitude 
        
            $url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($_POST['latitude']).','.trim($_POST['longitude']).'&key=AIzaSyBlE6J6TWRVoQ4PbrMxTr7Y2K8QsVtCuBM'; 
        
            $json = @file_get_contents($url); 
        
            $data = json_decode($json); 
        
            $status = $data->status; 
        
            if($status=="OK"){ 
                //Get address from json data 
                $location = $data->results[0]->formatted_address;         
            } else {

                $location =  '';
                
            } 
        
            //Print address 
        
            echo $location; 
        
        } 
    }

}