<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tickets_AT extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('tickets_AT_model','Modelo');
        $this->load->model('conexion_model', 'Conexion');
        $this->load->library('correos');
    }

    public function generar() {
      //$this->output->enable_profiler(TRUE);
        $this->load->model('autos_model');
        $auto = $this->input->post('auto');
        if(isset($this->session->POST_auto))
        {
          $auto = $this->session->POST_auto;
          $this->session->unset_userdata('POST_auto');
        }

        if(isset($auto))
        {
          $datosCoche = $this->autos_model->getAuto($auto);
          if($datosCoche)
          {
            $datos['foto'] = $datosCoche->foto;
            $datos['marca'] = $datosCoche->marca;
            $datos['combustible'] = $datosCoche->combustible;
            $datos['placas'] = $datosCoche->placas;
            $datos['auto'] = $auto;
            $this->load->view('header');
            $this->load->view('generar_ticket_auto', $datos);
          }
          else
          {
            redirect(base_url('inicio'));
          }
        }
        else {
          $datos['autos'] = $this->autos_model->getCatalogo();
          $this->load->view('header');
          $this->load->view('tickets_autos/seleccion',$datos);
        }
    }

    public function generar_qr($id){
      $this->session->POST_auto = $id;
      redirect(base_url('tickets_AT/generar'));
    }

    public function mantenimiento($auto){
        $this->load->model('autos_model');
        $datosCoche = $this->autos_model->getAuto($auto);
        $datos['auto'] = $auto;
        $datos['foto'] = $datosCoche->foto;
        $datos['marca'] = $datosCoche->marca;
        $datos['combustible'] = $datosCoche->combustible;
        $datos['placas'] = $datosCoche->placas;
        $datos['aumento'] = $datosCoche->combustible == 'DIESEL' ? 15000 : 10000;
        $datos['kilometraje'] = $datosCoche->kilometraje;
        $datos['proximo_mtto'] = $datosCoche->proximo_mtto;
        $this->load->view('header');
        $this->load->view('tickets_autos/generar_ticket_mtto', $datos);
    }

    public function mtto_solucionado(){
      $this->load->model('autos_model');

      $idTicket = $this->input->post('id_ticket');
      $id_auto = $this->input->post('auto');
      $proxMtto = $this->input->post('proxMtto');
      $kilometraje = $this->input->post('kilometraje');
      $carData = array(
          'kilometraje' => $kilometraje,
          'ultimo_mtto' => $kilometraje,
          'proximo_mtto' => str_replace(',', '', $proxMtto),
          'ticket_mtto' => '0',
      );
      $this->autos_model->updateAuto($id_auto,$carData);

      $Res = $this->Modelo->getUsuarioTicket($idTicket);
      $correo = $Res->correo;
      $usuario = $Res->User;

      $data = array(
          'estatus' => 'MTTO',
      );

      $this->Modelo->update($idTicket, $data);

      if (isset($correo)) {
          $datosCorreo['id'] = $idTicket;
          $datosCorreo['prefijo'] = substr($this->router->fetch_class(), 8);
          $datosCorreo['fecha'] = date('d/m/Y h:i A');
          $datosCorreo['usuario'] = $usuario;
          $datosCorreo['tecnico'] = $this->session->nombre;
          $datosCorreo['correo'] = $correo;
          $this->correos->ticketSolucionado($datosCorreo);
      }

      redirect(base_url('tickets_AT/ver/' . $idTicket));
    }

    function administrar($estatus) {
      $count = $this->Modelo->getTicketsCount();
      $datos['c_activos'] = $count->activos;
      $datos['c_solucionados'] = $count->solucionados;
      $datos['c_cerrados'] = $count->cerrados;
      $datos['c_cancelados'] = $count->cancelados;
      $datos['c_todos'] = $count->todos;

      $datos['filtro'] = $estatus;
      $datos['tickets'] = $this->Modelo->getTickets($estatus);
      $datos['controlador'] = 'tickets_AT';
      $this->load->view('header');
      $this->load->view('tickets_sistemas', $datos);
    }

    public function registrar(){
        $auto = $this->input->post('auto');
        $tipo = $this->input->post('tipo');

        $data = array(
            'usuario' => $this->session->id,
            'auto' => $auto,
            'tipo' => $tipo,
            'titulo' => $this->input->post('titulo'),
            'descripcion' => $this->input->post('descripcion'),
            'estatus' => 'ABIERTO',
            'cierre' => '0',
        );
        $last_id = $this->Modelo->crear_ticket($data);

        if($tipo == 'MANTENIMIENTO')
        {
          $this->load->model('autos_model');
          $this->autos_model->updateAuto($auto,array('ticket_mtto' => $last_id));
        }

        $datosCorreo['id'] = $last_id;
        $datosCorreo['prefijo'] = substr($this->router->fetch_class(), 8);
        $datosCorreo['titulo'] = $data['titulo'];
        $datosCorreo['fecha'] = date('d/m/Y h:i A');
        $datosCorreo['usuario'] = $this->session->nombre;
        $datosCorreo['correo'] = $this->session->correo;
        $this->correos->creacionTicket($datosCorreo);

        redirect(base_url('tickets_AT/archivos/') . $last_id);
    }

    function archivos($id_ticket) {
        $datos['id_ticket'] = $id_ticket;
        $datos['controlador'] = 'tickets_AT';
        $this->load->view('header');
        $this->load->view('subir_archivos', $datos);
    }

    public function ver($id){
        $this->load->model('autos_model');

        $Renglon = $this->Modelo->verTicket($id);
        $datos['ticket'] = $Renglon->row(); // 1 SOLO RENGLON
        $datos['comentarios'] = $this->Modelo->verTicket_comentarios($id);
        $datos['comentarios_fotos'] = $this->Modelo->verTicket_comentarios_fotos($id);
        $datos['archivos'] = $this->Modelo->verTicketArchivos($id);
        $datos['controlador'] = $this->router->fetch_class();

        $datosCoche = $this->autos_model->getAuto($datos['ticket']->auto);
        $datos['auto_id'] = $datosCoche->id;
        $datos['auto_foto'] = $datosCoche->foto;
        $datos['auto_marca'] = $datosCoche->marca;
        $datos['auto_combustible'] = $datosCoche->combustible;
        $datos['auto_placas'] = $datosCoche->placas;
        $datos['auto_mttoActual'] = $datosCoche->proximo_mtto;
        $datos['auto_kilometraje'] = $datosCoche->kilometraje;

        $this->load->view('header');
        $this->load->view('tickets_autos/ver_ticket', $datos);
    }

    public function agregarComentario() {
        $idTicket = $this->input->post('idticket');
        $data = array(
            'ticket' => $idTicket,
            'usuario' => $this->session->id,
            'comentario' => $this->input->post('comentario'),
        );
        $this->Modelo->agregar_comentario($data);
        redirect(base_url('tickets_AT/ver/' . $idTicket));
    }

    public function estatus($idTicket, $estatus) {
        switch ($estatus) {

            case '1':
                $Stat = 'ABIERTO';
                break;

            case '2':
                $Stat = 'EN CURSO';
                break;

            case '3':
                $Stat = 'DETENIDO';
                break;

            case '4':
                $Stat = 'CANCELADO';
                break;

            case '5':
                $Stat = 'SOLUCIONADO';
                $Res = $this->Modelo->getUsuarioTicket($idTicket);
                $correo = $Res->correo;
                $usuario = $Res->User;
                break;

            case '6':
                $Stat = 'CERRADO';
                break;

            default:
                redirect(base_url('inicio'));
                exit();
                break;
        }

        $data = array(
            'estatus' => $Stat,
        );

        $this->Modelo->update($idTicket, $data);

        if (isset($correo)) {
            $datosCorreo['id'] = $idTicket;
            $datosCorreo['prefijo'] = substr($this->router->fetch_class(), 8);
            $datosCorreo['fecha'] = date('d/m/Y h:i A');
            $datosCorreo['usuario'] = $usuario;
            $datosCorreo['tecnico'] = $this->session->nombre;
            $datosCorreo['correo'] = $correo;
            $this->correos->ticketSolucionado($datosCorreo);
        }

        redirect(base_url('tickets_AT/ver/' . $idTicket));
    }

    function subir_archivos() {
        $idTicket = $this->input->post('id_ticket');

        for ($i=0; $i < count($_FILES['file']['tmp_name']) ; $i++) {
          $datos = array('ticket' => $idTicket, 'nombre' => $_FILES['file']['name'][$i], 'archivo' => file_get_contents($_FILES['file']['tmp_name'][$i]));
          if(!$this->Modelo->subir_archivos($datos))
          {
            trigger_error("Error al subir archivo", E_USER_ERROR);
          }
        }
    }

    function ver_foto($id){
      $photo = $this->Modelo->getFoto($id);
      if($photo)
      {
        header("Content-type: image/png");
        echo $photo->archivo;
      }
      else {
        echo "ERROR";
      }
    }

    function ajax_cerrarTicket(){
      $id = $this->input->post('id');
      $comentario = $this->input->post('comentario');
      $t->calificacion = $this->input->post('calificacion');
      $t->estatus = "CERRADO";


      $this->Conexion->modificar('tickets_autos', $t, null, array('id' => $id));

      if(!empty($comentario))
      {
          $data = array(
              'ticket' => $id,
              'usuario' => $this->session->id,
              'comentario' => $comentario
          );
          $this->Modelo->agregar_comentario($data);
      }

  }

    //PRUEBAS

    function prueba(){
      $this->load->view('prueba');
    }

    function prueba_post() {
      foreach ($_FILES as $value)
      {
        echo $value['tmp_name'] . "<br>";
      }

      echo '//////////////////////// <br>';
      echo print_r($_FILES);
      echo '//////////////////////// <br>';
      echo print_r($_FILES['file']);
      echo '//////////////////////// <br>';
    }

}
