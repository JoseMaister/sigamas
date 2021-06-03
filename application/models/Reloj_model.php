<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Reloj_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

   /* public function getUsuario($no_empleado) {
        $this->db->select('U.id, U.ultima_sesion, concat(U.nombre," ",U.paterno," ",U.materno) as User, concat(U.nombre," ",U.paterno) as UserShort, U.no_empleado, U.departamento, U.correo');
        $this->db->from('usuarios U');
        $this->db->where('U.no_empleado', $no_empleado);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            false;
        }
    }*/

    function getUsuario($no_empleado) {
        $query = $this->db->query('SELECT U.id, concat(U.nombre," ",U.paterno) as UserShort, C.hora, ifnull(C.tipo,"N/A") as tipo from usuarios U left join checador C on U.id = C.usuario and C.hora = (SELECT max(hora) from checador where usuario = U.id) and C.hora between current_date() and current_date() + interval 1 day where (U.id="' . $no_empleado . '" or U.correo= "' . $no_empleado . '" or U.no_empleado="' . $no_empleado . '")');
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            false;
        }
    }

    function getEntrada($id){
        $this->db->where('id', $id);
        $query = $this->db->get('checador');
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    function checarEntrada($data){
        $this->db->set('hora', 'current_timestamp()', FALSE);
        if($this->db->insert('checador', $data))
        {
            return $this->db->insert_id();
        } else {
            return FALSE;
        }
    }

    function getChecadas($usuario){
        $this->db->select('C.*, concat(U.nombre, " ", U.paterno) as User');
        $this->db->from('checador C');
        $this->db->join('usuarios U', 'U.id = C.usuario');
        $this->db->where('C.hora >', 'current_date()', FALSE);
        $this->db->where('C.usuario', $usuario);
        $this->db->order_by("C.hora", "asc");
        $query = $this->db->get();
        if($query->num_rows() > 0)
        {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    function getReporte($data)
    {
        $consulta = "SELECT C.usuario, U.no_empleado, concat(U.nombre,' ',U.paterno) as User, DATE_FORMAT(C.hora, '%Y-%m-%d') as Fecha, DATE_FORMAT(C.hora, '%h:%i %p') as Entrada, C.foto as Entrada_foto, ";
        $consulta .= " ifnull((SELECT DATE_FORMAT(hora, '%h:%i %p') from checador where usuario = C.usuario and tipo = 'DESAYUNO' and DATE_FORMAT(hora, '%Y-%m-%d') = DATE_FORMAT(C.hora, '%Y-%m-%d')),'S/R') as Desayuno,";
        $consulta .= " ifnull((SELECT foto from checador where usuario = C.usuario and tipo = 'DESAYUNO' and DATE_FORMAT(hora, '%Y-%m-%d') = DATE_FORMAT(C.hora, '%Y-%m-%d')),'') as Desayuno_foto,";
        $consulta .= " ifnull((SELECT DATE_FORMAT(hora, '%h:%i %p') from checador where usuario = C.usuario and tipo = 'REGRESO DESAYUNO' and DATE_FORMAT(hora, '%Y-%m-%d') = DATE_FORMAT(C.hora, '%Y-%m-%d')),'S/R') as R_desayuno,";
        $consulta .= " ifnull((SELECT foto from checador where usuario = C.usuario and tipo = 'REGRESO DESAYUNO' and DATE_FORMAT(hora, '%Y-%m-%d') = DATE_FORMAT(C.hora, '%Y-%m-%d')),'') as R_desayuno_foto,";
        $consulta .= " ifnull((SELECT DATE_FORMAT(hora, '%h:%i %p') from checador where usuario = C.usuario and tipo = 'COMIDA' and DATE_FORMAT(hora, '%Y-%m-%d') = DATE_FORMAT(C.hora, '%Y-%m-%d')),'S/R') as Comida,";
        $consulta .= " ifnull((SELECT foto from checador where usuario = C.usuario and tipo = 'COMIDA' and DATE_FORMAT(hora, '%Y-%m-%d') = DATE_FORMAT(C.hora, '%Y-%m-%d')),'') as Comida_foto,";
        $consulta .= " ifnull((SELECT DATE_FORMAT(hora, '%h:%i %p') from checador where usuario = C.usuario and tipo = 'REGRESO COMIDA' and DATE_FORMAT(hora, '%Y-%m-%d') = DATE_FORMAT(C.hora, '%Y-%m-%d')),'S/R') as R_comida,";
        $consulta .= " ifnull((SELECT foto from checador where usuario = C.usuario and tipo = 'REGRESO COMIDA' and DATE_FORMAT(hora, '%Y-%m-%d') = DATE_FORMAT(C.hora, '%Y-%m-%d')),'') as R_comida_foto,";
        $consulta .= " ifnull((SELECT DATE_FORMAT(hora, '%h:%i %p') from checador where usuario = C.usuario and tipo = 'SALIDA' and DATE_FORMAT(hora, '%Y-%m-%d') = DATE_FORMAT(C.hora, '%Y-%m-%d')),'S/R') as Salida,";
        $consulta .= " ifnull((SELECT foto from checador where usuario = C.usuario and tipo = 'SALIDA' and DATE_FORMAT(hora, '%Y-%m-%d') = DATE_FORMAT(C.hora, '%Y-%m-%d')),'') as Salida_foto";
        $consulta .= " from checador C inner join usuarios U on C.usuario = U.id where C.tipo = 'ENTRADA' and C.hora between '" . $data['inicio'] . "' and '" . $data['final'] . "' order by usuario;";
        $query = $this->db->query($consulta);
         //= $this->db->get();
        if($query->num_rows() > 0)
        {
            return $query->result();
        } else {
            return FALSE;
        }
    }

}

?>
