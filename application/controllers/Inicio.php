<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Inicio extends CI_Controller {

    public function index() {
        //$this->output->enable_profiler(TRUE);
        if(isset($this->session->id))
        {
          $id = $this->session->id;
          $this->load->model('tickets_model');
          $datos['tickets'] = $this->tickets_model->getMis_tickets_pendientes($this->session->id);

          $queryQR = "SELECT QR.id, QR.fecha, QR.subtipo, QR.cantidad, QR.descripcion, QR.estatus from requisiciones_cotizacion QR where QR.usuario = $id";
          $queryQR .= " and QR.estatus = 'RECHAZADO'";

          $queryPR = "SELECT PR.id, PR.fecha, PR.usuario, PR.prioridad, PR.tipo, PR.subtipo, PR.cantidad, PR.unidad, PR.clave_unidad, PR.descripcion, PR.atributos, PR.critico, PR.destino, PR.lugar_entrega, PR.comentarios, PR.estatus, concat(U.nombre, ' ', U.paterno) as User";
          $queryPR .= " from prs PR left join usuarios U on PR.usuario = U.id where 1 = 1 and PR.usuario = $id and PR.estatus = 'POR RECIBIR' order by PR.fecha desc";

          $queryFact = "SELECT F.id, F.fecha, F.usuario, F.cliente, F.contacto, F.reporte_servicio, F.orden_compra, F.forma_pago, F.pagada, F.conceptos, F.notas, F.estatus, F.estatus_factura, F.documentos_requeridos, F.serie, F.folio, F.codigo_impresion, (SELECT count(id) from recorrido_facturas where factura = F.id) as Recorridos, E.nombre as Cliente, concat(U.nombre, ' ', U.paterno) as User from solicitudes_facturas F inner join empresas E on E.id = F.cliente inner join usuarios U on U.id = F.usuario";
          $queryFact .= " where (F.folio > 0 and F.estatus = 'ACEPTADO' and F.estatus_factura != 'RETORNADA AUTORIZADA') or (F.estatus = 'RECHAZADO')";


          $datos['qrs'] = $this->Conexion->consultar($queryQR, FALSE, FALSE);
          $datos['prs'] = $this->Conexion->consultar($queryPR, FALSE, FALSE);
          
          $datos['facturas'] = "";
          //$datos['facturas'] = $this->Conexion->consultar($queryFact, FALSE, FALSE);
        }

        $this->load->view('header');
        $this->load->view('inicio', $datos);
    }

    function primera_sesion()
    {
        $this->load->view('inicio/capturar_datos');
    }

    /*function manual()
    {
      $this->load->helper('download');
      echo '<a href="'.base_url('template/files/test.zip').'">asdasdas</a>';
      force_download('Manual.zip', file_get_contents(base_url('template/files/test.zip')));
    }*/

    function confirmar_datos()
    {
      $this->load->model('inicio_model','Modelo');
      $ACIERTOS = array(); $ERRORES = array();

      $data['correo'] = trim($this->input->post('correo'));
      $data['password'] = md5($this->input->post('password'));
      $data['activo'] = "1";
      if($this->Modelo->confirmarDatos($this->session->id, $data))
      {
        $this->session->correo = $data['correo'];
        $this->session->password = $data['password'];
        $acierto = array('titulo' => 'Datos Actualizados', 'detalle' => 'Recuerda que puedes iniciar sesión con tu Numero de Empleado o Correo');
        array_push($ACIERTOS, $acierto);
      }
      else
      {
        $error = array('titulo' => 'ERROR', 'detalle' => 'Error al actualizar Datos');
        array_push($ERRORES, $error);
      }
      $this->session->aciertos = $ACIERTOS;
      $this->session->errores = $ERRORES;
      redirect(base_url('inicio'));
    }

}
