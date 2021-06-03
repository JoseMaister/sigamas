<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Autos extends CI_Controller {
//constructor to load the database classs
    function __construct() {
        parent::__construct();
        $this->load->model('autos_model','Modelo');
        $this->load->library('correos');
    }
////Function to show the page to use
    function index()
    {
        //$this->output->enable_profiler(TRUE);
        $datos['autos'] = $this->Modelo->getCatalogo();
        $datos['titulo'] = "Autos";
        $this->load->view('header');
        $this->load->view('autos/catalogo',$datos);
    }
//Fuction to show data from use of cars
    function ver($idauto)
    {
      //update data from 'autos' according to 'responsable'
        $responsable = $this->input->post('responsable');
        //condition if the field in the form is not empty
        if(isset($responsable))
        {
          //Update data
          $this->Modelo->updateAuto($idauto, array('responsable' => $responsable));
        }
        $this->load->model('usuarios_model');
        $datos['auto'] = $this->Modelo->getAuto($idauto);
        $datos['responsable'] = $this->usuarios_model->getUsuario($datos['auto']->responsable);
        $datos['usuarios'] = $this->usuarios_model->getUsuarios();
        $this->load->view('header');
        $this->load->view('autos/ver_auto', $datos);
    }
//function to  show the page to use
    function uso_autos(){
        $this->load->view('header');
        $this->load->view('autos/uso_autos');
    }
//function to  show the page to use
    function revisiones_ANT($auto)
    {
        $datos['auto'] = $auto;
        $datos['rev'] = $this->Modelo->getRevisiones($auto);
        $this->load->view('header');
        $this->load->view('autos/revisiones', $datos);
    }
//function to  show the page to use
    function revisiones()
    {
        $this->load->view('header');
        $this->load->view('autos/revisiones_opciones');
    }
//function to  show the page to use
    function revisiones_pendientes()
    {
      //$this->output->enable_profiler(TRUE);
      $datos['autos'] = $this->Modelo->getRevPendientes();
      $datos['titulo'] = "Revisiones Pendientes";
      $this->load->view('header');
      $this->load->view('autos/catalogo',$datos);
    }
//function to  show the page to use according the date
    function revisiones_hoy()
    {
      //$this->output->enable_profiler(TRUE);
      $datos['autos'] = $this->Modelo->getRevHoy();
      $datos['titulo'] = "Revisiones de Hoy";
      $this->load->view('header');
      $this->load->view('autos/catalogo',$datos);
    }
//function to  show the page to use & get data
    function proximos_mttos()
    {
      //$this->output->enable_profiler(TRUE);
      $head['url_actual'] = current_url();
      $datos['autos'] = $this->Modelo->getProxMttos();
      $datos['titulo'] = "Proximos Mantenimientos";
      $this->load->view('header', $head);
      $this->load->view('autos/proximos_mttos',$datos);
    }
//fuction  to update data of the maitenance of vehicles
    function registrar_revision($auto)
    {
        $head['url_actual'] = current_url();
        $datos['iu'] = uniqid();
        $datos['auto'] = $auto;
        $res = $this->Modelo->getMotorPlacasKm($auto);
        $datos['combustible'] = $res->combustible;
        $datos['placas'] = $res->placas;
        $datos['kilometraje'] = $res->kilometraje;
        $this->load->view('header', $head);
        $this->load->view('autos/registrar_revision',$datos);
    }
//set a report from check of vehicles
    function ver_checklist($id)
    {
        $res = $this->Modelo->getChecklist($id);
        $pdf = $res->checklist;
        $datos['data'] = $pdf;
        $this->load->view('pdf', $datos);
    }
//show findings from the vehicle check
    function hallazgo_foto($id_foto)
    {
      $photo = $this->Modelo->getHallazgoFoto($id_foto);
      if($photo)
      {
        header("Content-type: image/png");
        //echo "<img src='data:image/png;base64," . base64_encode($photo->foto) . "'>" ;
        echo $photo->foto;
      }
      else {
        echo "ERROR";
      }
    }

    function hallazgos($id_rev)
    {
      //Data of the vehicle check
      $datosRevision = $this->Modelo->getRevision($id_rev);
      $auto = $datosRevision->auto;
      $datos['rev_id'] = $datosRevision->id;
      $datos['rev_fecha'] = $datosRevision->fecha;
      $datos['rev_User'] = $datosRevision->User;
      $datos['rev_kilometraje'] = $datosRevision->kilometraje;
      $datos['rev_combustible'] = $datosRevision->combustible;
      $datos['rev_placas'] = $datosRevision->placas;
      $datos['rev_vencimiento_poliza'] = $datosRevision->vencimiento_poliza;
      $datos['rev_ecologico'] = $datosRevision->vencimiento_ecologico;

      //vehicle data
      $datosCoche = $this->Modelo->getAuto($auto);
      $datos['auto_foto'] = $datosCoche->foto;
      $datos['auto_marca'] = $datosCoche->marca;
      $datos['auto_combustible'] = $datosCoche->combustible;
      $datos['auto_placas'] = $datosCoche->placas;

      //Findings
      $datos['carroceria'] = $this->Modelo->getHallazgosCarroceria($id_rev);
      $datos['otros'] = $this->Modelo->getHallazgosOtros($id_rev);
      $this->load->view('header');
      $this->load->view('autos/hallazgos', $datos);
    }
//Create temps file to insert in database
    function temp_photos()
    {
      $datos['iu'] = $this->input->post('iu');
      $datos['tipo'] = 'REVISION';
      $datos['usuario'] = $this->session->id;
      $datos['objeto'] = $this->input->post('auto');
      $datos['texto'] = $this->input->post('texto');
      $fotoB64 = $this->input->post('archivo');
      $datos['archivo'] = base64_decode($fotoB64);
      $res = $this->Modelo->saveTempPhotos($datos);
      if($res > 0)
      {
        $respuesta = array('id' => $res, 'file' => $fotoB64);
        echo json_encode($respuesta);
      }
    }
//delete temp files
    function delete_temp_photos()
    {
      $id_temp = $this->input->post('id');
      $res = $this->Modelo->deleteTempPhotos($id_temp);
      if($res)
      {
        echo "1";
      }
    }
//fuction to add a new car revision
    function registrarRev()
    {
        $this->output->enable_profiler(TRUE);
        $ACIERTOS = array(); $com_ERRORES = array();
        $VARIABLES = array();

        $descripcion = $this->input->post('texto');

        $usuario = $this->session->nombre;
        $AUTO = $this->input->post('auto'); //ID Vehicle
        $IU = $this->input->post('iu'); //ID unique

        //Data saved of revision
        $KILOMETRAJE = $this->input->post('kilometraje');
        $COMBUSTIBLE = $this->input->post('combustible');
        $PLACAS = $this->input->post('placas');
        $timePoliza = strtotime($this->input->post('vencimientoPoliza'));
        $VENCIMIENTO_POLIZA = date("Y-m-d", $timePoliza);
        $timeEco = strtotime($this->input->post('vencimientoEcologico'));
        $VENCIMIENTO_ECOLOGICO = date("Y-m-d", $timeEco);


        $VARIABLES['Kilometraje'] = array('Kilometraje' => $this->input->post('kilometraje'), 'comentario' => $this->input->post('com_kilometraje'));
        $VARIABLES['Aceite del motor'] = array('Aceite del motor' => $this->input->post('aceiteMotor'), 'comentario' => $this->input->post('com_aceiteMotor'));
        $VARIABLES['Condiciones del aceite'] = array('Condiciones del aceite' => $this->input->post('condicionesAceite'), 'comentario' => $this->input->post('com_condicionesAceite'));
        $VARIABLES['Limpia parabrisas delantero'] = array('Limpia parabrisas delantero' => $this->input->post('llpbDelantero'), 'comentario' => $this->input->post('com_llpbDelantero'));
        $VARIABLES['Limpia parabrisas trasero'] = array('Limpia parabrisas trasero' => $this->input->post('llpbTrasero'), 'comentario' => $this->input->post('com_llpbTrasero'));
        $VARIABLES['Deposito de refrigerante'] = array('Deposito de refrigerante' => $this->input->post('refrigeranteDeposito'), 'comentario' => $this->input->post('com_refrigeranteDeposito'));
        $VARIABLES['Radiador'] = array('Radiador' => $this->input->post('refrigeranteRadiador'), 'comentario' => $this->input->post('com_refrigeranteRadiador'));
        $VARIABLES['Liquido de frenos'] = array('Liquido de frenos' => $this->input->post('liquidoFrenos'), 'comentario' => $this->input->post('com_liquidoFrenos'));
        $VARIABLES['Direccion hidraulica'] = array('Direccion hidraulica' => $this->input->post('direccionH'), 'comentario' => $this->input->post('com_direccionH'));
        $VARIABLES['Direccional izquierda'] = array('Direccional izquierda' => $this->input->post('direccionalIzq'), 'comentario' => $this->input->post('com_direccionalIzq'));
        $VARIABLES['Direccional derecha'] = array('Direccional derecha' => $this->input->post('direccionalDer'), 'comentario' => $this->input->post('com_direccionalDer'));
        $VARIABLES['Lampara izquierda'] = array('Lampara izquierda' => $this->input->post('lamparaIzq'), 'comentario' => $this->input->post('com_lamparaIzq'));
        $VARIABLES['Lampara derecha'] = array('Lampara derecha' => $this->input->post('lamparaDer'), 'comentario' => $this->input->post('com_lamparaDer'));
        $VARIABLES['Lampara trasera izquierda'] = array('Lampara trasera izquierda' => $this->input->post('traseraIzq'), 'comentario' => $this->input->post('com_traseraIzq'));
        $VARIABLES['Lampara trasera derecha'] = array('Lampara trasera derecha' => $this->input->post('traseraDer'), 'comentario' => $this->input->post('com_traseraDer'));
        $VARIABLES['Lampara de emergencia'] = array('Lampara de emergencia' => $this->input->post('emergencia'), 'comentario' => $this->input->post('com_emergencia'));
        $VARIABLES['Reversa'] = array('Reversa' => $this->input->post('reversa'), 'comentario' => $this->input->post('com_reversa'));
        $VARIABLES['Tapiceria'] = array('Tapiceria' => $this->input->post('tapiceria'), 'comentario' => $this->input->post('com_tapiceria'));
        $VARIABLES['Controles'] = array('Controles' => $this->input->post('controles'), 'comentario' => $this->input->post('com_controles'));
        $VARIABLES['Kit de herramientas'] = array('Kit de herramientas' => $this->input->post('kitHerramientas'), 'comentario' => $this->input->post('com_kitHerramientas'));
        $VARIABLES['Tapetes'] = array('Tapetes' => $this->input->post('tapetes'), 'comentario' => $this->input->post('com_tapetes'));
        $VARIABLES['Placa delantera'] = array('Placa delantera' => $this->input->post('placaDelantera'), 'comentario' => $this->input->post('com_placaDelantera'));
        $VARIABLES['Placa trasera'] = array('Placa trasera' => $this->input->post('placaTrasera'), 'comentario' => $this->input->post('com_placaTrasera'));
        $VARIABLES['Tarjeta de combustible'] = array('Tarjeta de combustible' => $this->input->post('tarjetaCombustible'), 'comentario' => $this->input->post('com_tarjetaCombustible'));
        $VARIABLES['Tarjeta de circulacion'] = array('Tarjeta de circulacion' => $this->input->post('tarjetaCirculacion'), 'comentario' => $this->input->post('com_tarjetaCirculacion'));
        $VARIABLES['Poliza'] = array('Poliza' => $this->input->post('poliza'), 'comentario' => $this->input->post('com_poliza'));

        $FALLAS = array();
        foreach ($VARIABLES as $key => $value) {
          if($value[$key] == "NG")
          {
            $FALLAS[$key] = $value['comentario'];
          }
        }

        //Save to DB
        $datos = array('auto' => $AUTO, 'usuario' => $this->session->id, 'kilometraje' => $KILOMETRAJE, 'combustible' => $COMBUSTIBLE, 'placas' => $PLACAS, 'vencimiento_poliza' => $VENCIMIENTO_POLIZA, 'vencimiento_ecologico' => $VENCIMIENTO_ECOLOGICO);
        $db_response = $this->Modelo->saveChecklist($datos);
        if($db_response['EXITO'])
        {
            //Update Car data
            $AutoData = array('kilometraje' => $KILOMETRAJE, 'vencimiento_poliza' => $VENCIMIENTO_POLIZA, 'vencimiento_ecologico' => $VENCIMIENTO_ECOLOGICO);
            $this->Modelo->updateAuto($AUTO, $AutoData);

            //Issues in the car bodywork 
            if(isset($descripcion))
            {

            //Car failures
            if(isset($FALLAS))
            {
              foreach ($FALLAS as $key => $value)
              {
                $arreglo = array('revision' => $db_response['ID'], 'tipo' => $key, 'descripcion' => $value);
                $this->Modelo->saveHallazgos($arreglo);
              }

              //Add the 
              $acierto = array('titulo' => 'Registro de Revisión', 'detalle' => 'Se ha registrado Revisión con Éxito');
              array_push($ACIERTOS, $acierto);
            }

            //Create variable to get the methods
            $prox = $this->Modelo->getMotorPlacasKm($AUTO);
            // condition to check ir the mileage higher equal to next maintenance
            if(($prox->kilometraje + 200) >= $prox->proximo_mtto)
            {
              $Auto = $this->Modelo->getAuto($AUTO);
              $Resp = $this->Modelo->getResponsable($Auto->responsable);

              $data['auto'] = $Auto->fabricante . ' ' . $Auto->marca . ' ' . $Auto->modelo;
              $data['placas'] = $Auto->placas;
              $data['serie'] = $Auto->serie;
              $data['kmActual'] = number_format($KILOMETRAJE);
              $data['proxMtto'] = number_format($Auto->proximo_mtto);
              if($Resp)
              {
                $data['correoResponsable'] = $Resp->correo;
                $this->correos->proxMtto200($data);
              }

            }
        }
        else
        {
            $error = array('titulo' => 'ERROR', 'detalle' => 'Error al registrar revisión');
            array_push($ERRORES, $error);
        }

        $this->session->aciertos = $ACIERTOS;
        $this->session->errores = $ERRORES;

        //redirect(base_url('autos/revisiones/' . $AUTO));
        redirect(base_url('inicio'));
    }




    function ajax_getAutos(){
      $res = $this->Conexion->consultar("SELECT id, marca, placas from autos order by marca");
      if($res)
      {
        echo json_encode($res);
      }
    }

    function ajax_getEventos(){
      $res = $this->Conexion->consultar("SELECT BA.id, BA.inicio as start, BA.final as end, BA.usuario, BA.usuarios, BA.auto, concat(A.placas, ' - ', A.marca) as title, BA.destino, BA.visita, BA.rsi, BA.comentarios, BA.equipo, BA.color from bitacora_autos BA inner join autos A on A.id = BA.auto");
      if($res)
      {
        echo json_encode($res);
      }
    }

    function ajax_crearEvento(){
      $data = json_decode($this->input->post('data'));
      $data->usuario = $this->session->id;

      $f = array('fecha' => 'CURRENT_TIMESTAMP()');

      $res = $this->Conexion->insertar('bitacora_autos', $data, $f);
      echo $res;
    }

    function ajax_borrarEvento(){
      $where['id'] = $this->input->post('id');

      if($this->Conexion->eliminar('bitacora_autos', $where))
      {
          echo "1";
      }

    }

    function photo($id){
      $res = $this->Conexion->consultar("SELECT ifnull(A.foto, '') as Photo from autos A where A.id = $id", TRUE);
      header("Content-type: image/png");
      echo $res->Photo;
  }



}
