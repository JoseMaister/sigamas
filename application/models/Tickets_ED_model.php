<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tickets_ED_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function getTickets($estatus) {
        $this->db->select('TE.id, TE.fecha, ifnull(concat(U.nombre," ",U.paterno),"N/A") as User, TE.tipo, TE.titulo, TE.descripcion, TE.estatus, TE.usuario');
        $this->db->from('tickets_edificio TE');
        $this->db->join('usuarios U', 'TE.usuario = U.id', 'LEFT');
        if($estatus == 'activos')
        {
          $this->db->where('TE.estatus', 'ABIERTO');
          $this->db->or_where('TE.estatus', 'DETENIDO');
          $this->db->or_where('TE.estatus', 'EN CURSO');
        }
        if($estatus == 'solucionados')
        {
          $this->db->where('TE.estatus', 'SOLUCIONADO');
        }
        if($estatus == 'cerrados')
        {
          $this->db->where('TE.estatus', 'CERRADO');
        }
        if($estatus == 'cancelados')
        {
          $this->db->where('TE.estatus', 'CANCELADO');
        }

        $this->db->order_by('TE.fecha', 'DESC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return false;
        }
    }

    function getTicketsCount(){
      $comando = "count(*) as todos";
      $comando .=", (SELECT count(*) from tickets_edificio where (estatus = 'ABIERTO' or estatus = 'DETENIDO' or estatus = 'EN CURSO')) as activos";
      $comando .= ", (SELECT count(*) from tickets_edificio where (estatus = 'SOLUCIONADO')) as solucionados";
      $comando .= ", (SELECT count(*) from tickets_edificio where (estatus = 'CERRADO')) as cerrados";
      $comando .= ", (SELECT count(*) from tickets_edificio where (estatus = 'CANCELADO')) as cancelados";

      $this->db->select($comando);
      $this->db->from('tickets_edificio TE');
      $query = $this->db->get();
      return $query->row();
    }

    public function getMis_tickets() {
        $this->db->select('TE.id, TE.fecha, ifnull(concat(U.nombre," ",U.paterno),"N/A") as User, TE.tipo, TE.titulo, TE.descripcion, TE.estatus, TE.usuario');
        $this->db->from('tickets_edificio TE');
        $this->db->join('usuarios U', 'TE.usuario = U.id', 'LEFT');
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
        $this->db->insert('tickets_edificio', $datos);
        return $this->db->insert_id();
    }

    ///////////////////////// VER TICKET DE SERVICIO IT /////////////////////////
    public function verTicket($idTicket) {
        $this->db->select('TE.id, TE.fecha, ifnull(concat(U.nombre," ",U.paterno),"N/A") as User, ifnull((SELECT concat(nombre," ",paterno) from usuarios where id = TE.cierre), "0") as Cierre, TE.fecha_cierre, TE.tipo, TE.titulo, TE.descripcion, TE.estatus, TE.usuario, TE.calificacion');
        $this->db->from('tickets_edificio TE');
        $this->db->join('usuarios U', 'TE.usuario = U.id', 'LEFT');
        $this->db->where('TE.id', $idTicket);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return false;
        }
    }

    public function verTicket_comentarios($idTicket) {
        $this->db->select('TC.fecha, ifnull(concat(U.nombre," ",U.paterno), "N/A") as User, TC.usuario, TC.comentario');
        $this->db->from('tickets_edificio_comentarios TC');
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
        $this->db->from('tickets_edificio_comentarios TC');
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
        $this->db->insert('tickets_edificio_comentarios', $datos);
    }

    public function update($id, $datos) {
        if($datos['estatus'] == 'SOLUCIONADO')
        {
            $this->db->set('cierre',$this->session->id);
            $this->db->set('fecha_cierre','CURRENT_TIMESTAMP()',FALSE);
        }
        $this->db->where('id', $id);
        $this->db->update('tickets_edificio', $datos);
    }

    public function subir_archivos($datos) {
        return $this->db->insert('tickets_edificio_archivos', $datos);
    }

    function verTicketArchivos($id_ticket) {
        $this->db->where('ticket', $id_ticket);
        $query = $this->db->get('tickets_edificio_archivos');

        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return false;
        }
    }

    function getUsuarioTicket($idTicket){
        $this->db->select('concat(U.nombre," ",U.paterno) as User, U.correo');
        $this->db->from('tickets_edificio TE');
        $this->db->join('usuarios U', 'TE.usuario = U.id', 'LEFT');
        $this->db->where('TE.id', $idTicket);
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
      $res = $this->db->get('tickets_edificio_archivos');
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
