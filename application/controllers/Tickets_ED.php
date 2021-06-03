<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tickets_ED extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('tickets_ED_model','Modelo');
        $this->load->model('conexion_model', 'Conexion');
        $this->load->library('correos');
        $this->load->library('AOS_funciones');
    }

    public function generar() {
        $this->load->view('header');
        $this->load->view('generar_ticket_edificio');
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
      $datos['controlador'] = 'tickets_ED';
      $this->load->view('header');
      $this->load->view('tickets_sistemas', $datos);
    }

    public function registrar() {
        $data = array(
            'usuario' => $this->session->id,
            'tipo' => $this->input->post('tipo'),
            'titulo' => $this->input->post('titulo'),
            'descripcion' => $this->input->post('descripcion'),
            'estatus' => 'ABIERTO',
            'cierre' => '0',
        );
        $last_id = $this->Modelo->crear_ticket($data);

        $datosCorreo['id'] = $last_id;
        $datosCorreo['prefijo'] = substr($this->router->fetch_class(), 8);
        $datosCorreo['titulo'] = $data['titulo'];
        $datosCorreo['fecha'] = date('d/m/Y h:i A');
        $datosCorreo['usuario'] = $this->session->nombre;
        $datosCorreo['correo'] = $this->session->correo;
        $this->correos->creacionTicket($datosCorreo);

        redirect(base_url('tickets_ED/archivos/') . $last_id);
    }

    function archivos($id_ticket) {
        $datos['id_ticket'] = $id_ticket;
        $datos['controlador'] = 'tickets_ED';
        $this->load->view('header');
        $this->load->view('subir_archivos', $datos);
    }

    public function ver($id) {
        $Renglon = $this->Modelo->verTicket($id);
        $datos['ticket'] = $Renglon->row(); // 1 SOLO RENGLON
        $datos['comentarios'] = $this->Modelo->verTicket_comentarios($id);
        $datos['comentarios_fotos'] = $this->Modelo->verTicket_comentarios_fotos($id);
        $datos['archivos'] = $this->Modelo->verTicketArchivos($id);
        $datos['controlador'] = $this->router->fetch_class();
        $this->load->view('header');
        $this->load->view('ver_ticket', $datos);
    }

    public function agregarComentario() {
        $idTicket = $this->input->post('idticket');
        $data = array(
            'ticket' => $idTicket,
            'usuario' => $this->session->id,
            'comentario' => $this->input->post('comentario'),
        );
        $this->Modelo->agregar_comentario($data);
        redirect(base_url('tickets_ED/ver/' . $idTicket));
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

        redirect(base_url('tickets_ED/ver/' . $idTicket));
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


        $this->Conexion->modificar('tickets_edificio', $t, null, array('id' => $id));

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

}
