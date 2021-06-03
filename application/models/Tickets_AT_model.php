<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tickets_AT_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function getTickets($estatus) {
        $this->db->select('TA.id, TA.fecha, ifnull(concat(U.nombre," ",U.paterno),"N/A") as User, TA.tipo, TA.titulo, TA.descripcion, TA.estatus, TA.usuario');
        $this->db->from('tickets_autos TA');
        $this->db->join('usuarios U', 'TA.usuario = U.id', 'LEFT');
        if($estatus == 'activos')
        {
          $this->db->where('TA.estatus', 'ABIERTO');
          $this->db->or_where('TA.estatus', 'DETENIDO');
          $this->db->or_where('TA.estatus', 'EN CURSO');
        }
        if($estatus == 'solucionados')
        {
          $this->db->where('TA.estatus', 'SOLUCIONADO');
        }
        if($estatus == 'cerrados')
        {
          $this->db->where('TA.estatus', 'CERRADO');
        }
        if($estatus == 'cancelados')
        {
          $this->db->where('TA.estatus', 'CANCELADO');
        }

        $this->db->order_by('TA.fecha', 'DESC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return false;
        }
    }

    function getTicketsCount(){
      $comando = "count(*) as todos";
      $comando .=", (SELECT count(*) from tickets_autos where (estatus = 'ABIERTO' or estatus = 'DETENIDO' or estatus = 'EN CURSO')) as activos";
      $comando .= ", (SELECT count(*) from tickets_autos where (estatus = 'SOLUCIONADO')) as solucionados";
      $comando .= ", (SELECT count(*) from tickets_autos where (estatus = 'CERRADO')) as cerrados";
      $comando .= ", (SELECT count(*) from tickets_autos where (estatus = 'CANCELADO')) as cancelados";

      $this->db->select($comando);
      $this->db->from('tickets_autos TA');
      $query = $this->db->get();
      return $query->row();
    }

    //KITAR
    public function getMis_tickets() {
        $this->db->select('TA.id, TA.fecha, ifnull(concat(U.nombre," ",U.paterno),"N/A") as User, TA.tipo, TA.titulo, TA.descripcion, TA.estatus, TA.usuario');
        $this->db->from('tickets_sistemas TA');
        $this->db->join('usuarios U', 'TA.usuario = U.id', 'LEFT');
        $this->db->where('usuario', $this->session->id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return false;
        }
    }

    public function crear_ticket($datos) {
        $this->db->set('fecha', 'current_timestamp()', FALSE);
        $this->db->insert('tickets_autos', $datos);
        return $this->db->insert_id();
    }

    ///////////////////////// VER TICKET DE SERVICIO IT /////////////////////////
    public function verTicket($idTicket) {
        $this->db->select('TA.id, TA.fecha, ifnull(concat(U.nombre," ",U.paterno),"N/A") as User, ifnull((SELECT concat(nombre," ",paterno) from usuarios where id = TA.cierre), "0") as Cierre, TA.fecha_cierre, TA.auto, TA.tipo, TA.titulo, TA.descripcion, TA.estatus, TA.usuario, TA.calificacion');
        $this->db->from('tickets_autos TA');
        $this->db->join('usuarios U', 'TA.usuario = U.id', 'LEFT');
        $this->db->where('TA.id', $idTicket);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return false;
        }
    }

    public function verTicket_comentarios($idTicket) {
        $this->db->select('TC.fecha, ifnull(concat(U.nombre," ",U.paterno), "N/A") as User, TC.usuario, TC.comentario');
        $this->db->from('tickets_autos_comentarios TC');
        $this->db->join('usuarios U', 'TC.usuario = U.id', 'LEFT');
        $this->db->where('TC.ticket', $idTicket);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return false;
        }
    }

    public function verTicket_comentarios_fotos($idTicket) {
        $this->db->select('TC.usuario, U.foto');
        $this->db->from('tickets_autos_comentarios TC');
        $this->db->join('usuarios U', 'TC.usuario = U.id', 'LEFT');
        $this->db->where('TC.ticket', $idTicket);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return false;
        }
    }

    public function agregar_comentario($datos) {
        $this->db->set('fecha', 'current_timestamp()', FALSE);
        $this->db->insert('tickets_autos_comentarios', $datos);
    }

    public function update($id, $datos) {
        if($datos['estatus'] == 'SOLUCIONADO')
        {
            $this->db->set('cierre',$this->session->id);
            $this->db->set('fecha_cierre','CURRENT_TIMESTAMP()',FALSE);
        }
        if($datos['estatus'] == 'MTTO')
        {
            $datos['estatus'] = 'CERRADO';
            $this->db->set('cierre',$this->session->id);
            $this->db->set('fecha_cierre','CURRENT_TIMESTAMP()',FALSE);
        }
        $this->db->where('id', $id);
        $this->db->update('tickets_autos', $datos);
    }

    public function subir_archivos($datos) {
        return $this->db->insert('tickets_autos_archivos', $datos);
    }

    function verTicketArchivos($id_ticket) {
        $this->db->where('ticket', $id_ticket);
        $query = $this->db->get('tickets_autos_archivos');

        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return false;
        }
    }

    function getUsuarioTicket($idTicket){
        $this->db->select('concat(U.nombre," ",U.paterno) as User, U.correo');
        $this->db->from('tickets_autos TA');
        $this->db->join('usuarios U', 'TA.usuario = U.id', 'LEFT');
        $this->db->where('TA.id', $idTicket);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return null;
        }
    }

    function getFoto($id){
      $this->db->select('archivo');
      $this->db->where('id', $id);
      $res = $this->db->get('tickets_autos_archivos');
      if($res->num_rows() > 0)
      {
          return $res->row();
      }
      else
      {
          return false;
      }
    }

}

?>
