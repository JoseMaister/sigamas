<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tickets_IT_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function getTickets($estatus) {
        $this->db->select('TS.id, TS.fecha, ifnull(concat(U.nombre," ",U.paterno),"N/A") as User, TS.tipo, TS.titulo, TS.descripcion, TS.estatus, TS.usuario');
        $this->db->from('tickets_sistemas TS');
        $this->db->join('usuarios U', 'TS.usuario = U.id', 'LEFT');
        if($estatus == 'activos')
        {
          $this->db->where('TS.estatus', 'ABIERTO');
          $this->db->or_where('TS.estatus', 'DETENIDO');
          $this->db->or_where('TS.estatus', 'EN CURSO');
        }
        if($estatus == 'solucionados')
        {
          $this->db->where('TS.estatus', 'SOLUCIONADO');
        }
        if($estatus == 'cerrados')
        {
          $this->db->where('TS.estatus', 'CERRADO');
        }
        if($estatus == 'cancelados')
        {
          $this->db->where('TS.estatus', 'CANCELADO');
        }

        $this->db->order_by('TS.fecha', 'DESC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return false;
        }
    }

    function getReporteUsuarios($datos){
        $query = $this->db->query("SELECT T.usuario, concat(U.nombre, ' ', U.paterno) as User ,count(T.usuario) as conteo from tickets_sistemas T inner join usuarios U on U.id = T.usuario where T.fecha between '" . $datos[0] . "' and '" . $datos[1] . "' group by T.usuario order by conteo desc limit 5;");
        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return FALSE;
        }
    }
    
    function getReporteTipo($datos){
        $query = $this->db->query("SELECT T.tipo, count(T.tipo) as conteo from tickets_sistemas T where T.fecha between '" . $datos[0] . "' and '" . $datos[1] . "' group by T.tipo order by conteo desc;");
        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return FALSE;
        }
    }

    function getReporteTickets($datos){
        $this->db->select('TS.id, TS.fecha, ifnull(concat(U.nombre," ",U.paterno),"N/A") as User, TS.tipo, TS.titulo, TS.descripcion, TS.estatus, TS.usuario');
        $this->db->from('tickets_sistemas TS');
        $this->db->join('usuarios U', 'TS.usuario = U.id', 'LEFT');
        $this->db->where($datos);
        $this->db->order_by('TS.fecha', 'DESC');
        
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function getTicketsCount(){
      $comando = "count(*) as todos";
      $comando .=", (SELECT count(*) from tickets_sistemas where (estatus = 'ABIERTO' or estatus = 'DETENIDO' or estatus = 'EN CURSO')) as activos";
      $comando .= ", (SELECT count(*) from tickets_sistemas where (estatus = 'SOLUCIONADO')) as solucionados";
      $comando .= ", (SELECT count(*) from tickets_sistemas where (estatus = 'CERRADO')) as cerrados";
      $comando .= ", (SELECT count(*) from tickets_sistemas where (estatus = 'CANCELADO')) as cancelados";

      $this->db->select($comando);
      $this->db->from('tickets_sistemas TS');
      $query = $this->db->get();
      return $query->row();
    }

    public function getMis_tickets() {
        $this->db->select('TS.id, TS.fecha, ifnull(concat(U.nombre," ",U.paterno),"N/A") as User, TS.tipo, TS.titulo, TS.descripcion, TS.estatus, TS.usuario');
        $this->db->from('tickets_sistemas TS');
        $this->db->join('usuarios U', 'TS.usuario = U.id', 'LEFT');
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
        $this->db->insert('tickets_sistemas', $datos);
        return $this->db->insert_id();
    }

    ///////////////////////// VER TICKET DE SERVICIO IT /////////////////////////
    public function verTicket($idTicket) {
        $this->db->select('TS.id, TS.fecha, ifnull(concat(U.nombre," ",U.paterno),"N/A") as User, U.correo, ifnull((SELECT concat(nombre," ",paterno) from usuarios where id = TS.cierre), "0") as Cierre, TS.fecha_cierre, TS.tipo, TS.titulo, TS.descripcion, TS.estatus, TS.usuario, TS.calificacion');
        $this->db->from('tickets_sistemas TS');
        $this->db->join('usuarios U', 'TS.usuario = U.id', 'LEFT');
        $this->db->where('TS.id', $idTicket);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return false;
        }
    }

    public function verTicket_comentarios($idTicket) {
        $this->db->select('TC.fecha, ifnull(concat(U.nombre," ",U.paterno), "N/A") as User, TC.usuario, TC.comentario');
        $this->db->from('tickets_sistemas_comentarios TC');
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
        $this->db->from('tickets_sistemas_comentarios TC');
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
        $this->db->insert('tickets_sistemas_comentarios', $datos);
    }

    public function update($id, $datos) {
        if($datos['estatus'] == 'SOLUCIONADO')
        {
            $this->db->set('cierre',$this->session->id);
            $this->db->set('fecha_cierre','CURRENT_TIMESTAMP()',FALSE);
        }
        $this->db->where('id', $id);
        $this->db->update('tickets_sistemas', $datos);
    }

    public function subir_archivos($datos) {
        return $this->db->insert('tickets_sistemas_archivos', $datos);
    }

    function verTicketArchivos($id_ticket) {
        $this->db->where('ticket', $id_ticket);
        $query = $this->db->get('tickets_sistemas_archivos');

        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return false;
        }
    }

    function getUsuarioTicket($idTicket){
        $this->db->select('concat(U.nombre," ",U.paterno) as User, U.correo');
        $this->db->from('tickets_sistemas TS');
        $this->db->join('usuarios U', 'TS.usuario = U.id', 'LEFT');
        $this->db->where('TS.id', $idTicket);
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
      $res = $this->db->get('tickets_sistemas_archivos');
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
