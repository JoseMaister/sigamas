<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tickets_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function getMis_tickets($id_usuario) {

        $QUERY = "SELECT IT.id,IT.fecha,IT.tipo,IT.titulo,IT.estatus, ifnull(concat(U.nombre,' ',U.paterno),'N/A') as User, 'SISTEMAS' as Ticket, 'IT' as Prefijo, 'tickets_IT' as Controlador FROM tickets_sistemas IT LEFT JOIN usuarios U on U.id = IT.usuario where IT.usuario='".$id_usuario."'";
        $QUERY .= " UNION ";
        $QUERY .= "SELECT AT.id,AT.fecha,AT.tipo,AT.titulo,AT.estatus, ifnull(concat(U.nombre,' ',U.paterno),'N/A') as User, 'AUTOMOTRIZ' as Ticket, 'AT' as Prefijo, 'tickets_AT' as Controlador FROM tickets_autos AT LEFT JOIN usuarios U on U.id = AT.usuario where AT.usuario='".$id_usuario."'";
        $QUERY .= " UNION ";
        $QUERY .= "SELECT ED.id,ED.fecha,ED.tipo,ED.titulo,ED.estatus, ifnull(concat(U.nombre,' ',U.paterno),'N/A') as User, 'EDIFICIO' as Ticket, 'ED' as Prefijo, 'tickets_ED' as Controlador FROM tickets_edificio ED LEFT JOIN usuarios U on U.id = ED.usuario where ED.usuario='".$id_usuario."' order by fecha desc";

        $query = $this->db->query($QUERY);
        if ($query->num_rows() > 0) {
            return $query;
        } else {
           return false;
        }
    }

    public function getMis_tickets_pendientes($id_usuario) {

        $QUERY = "SELECT IT.id,IT.fecha,IT.tipo,IT.titulo,IT.estatus, 'SISTEMAS' as Ticket, 'IT' as Prefijo, 'tickets_IT' as Controlador FROM tickets_sistemas IT LEFT JOIN usuarios U on U.id = IT.usuario where IT.usuario='".$id_usuario."' and (IT.estatus!='CERRADO' and IT.estatus!='CANCELADO')";
        $QUERY .= " UNION ";
        $QUERY .= "SELECT AT.id,AT.fecha,AT.tipo,AT.titulo,AT.estatus, 'AUTOMOTRIZ' as Ticket, 'AT' as Prefijo, 'tickets_AT' as Controlador FROM tickets_autos AT LEFT JOIN usuarios U on U.id = AT.usuario where AT.usuario='".$id_usuario."' and (AT.estatus!='CERRADO' and AT.estatus!='CANCELADO')";
        $QUERY .= " UNION ";
        $QUERY .= "SELECT ED.id,ED.fecha,ED.tipo,ED.titulo,ED.estatus, 'EDIFICIO' as Ticket, 'ED' as Prefijo, 'tickets_ED' as Controlador FROM tickets_edificio ED LEFT JOIN usuarios U on U.id = ED.usuario where ED.usuario='".$id_usuario."'  and (ED.estatus!='CERRADO' and ED.estatus!='CANCELADO') order by fecha desc";

        $query = $this->db->query($QUERY);
        if ($query->num_rows() > 0) {
            return $query;
        } else {
           return false;
        }
    }

}

?>
