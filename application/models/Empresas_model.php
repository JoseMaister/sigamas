<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Empresas_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function consulta($query, $row = FALSE){
        $res = $this->db->query($query);
        if($res->num_rows() > 0)
        {
            if($row)
            {
                return $res->row();
            } else {
                return $res->result();
            }
        }
        else{ return false; }
    }

    public function crear_empresa($datos) {
        $this->db->db_debug = FALSE;
        $this->db->set('fecha_registro', 'current_timestamp()', FALSE);
        if($this->db->insert('empresas', $datos)){
          $id = $this->db->insert_id();
        
          $datos2['empresa'] = $id;
          $datos2['aprobado'] = 0;
          $datos2['clasificacion_proveedor'] = "";
          $datos2['pasos_cotizacion'] = "[]";
          $datos2['pasos_compra'] = "[]";
          $datos2['tags'] = ",,";
          $this->db->insert('proveedores', $datos2);

          return $id;
        }
        else {
          return FALSE;
        }
    }

    public function update($data) {
        $this->db->where('id', $data['id']);
        $this->db->update('empresas', $data);
        if ($this->db->affected_rows() >= 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /*BORRAR public function setLugaresEntrega($data) {
        $this->db->set('entrega', 'JSON_MERGE(entrega, JSON_ARRAY("' . $data['entrega'] . '"))', FALSE);
        $this->db->where('empresa', $data['empresa']);
        $this->db->update('proveedores');
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }*/

    /*public function getEmpresas() {
        $query = $this->db->get('empresas');
        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return false;
        }
    }*/

    public function getEmpresas() {
        $query = $this->db->get('empresas');
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function getEmpresa($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('empresas');
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function getProveedor($id) {
        $this->db->where('empresa', $id);
        $query = $this->db->get('proveedores');
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    function insertContacto($data){
      $this->db->insert('empresas_contactos', $data);
      return $this->db->insert_id();
    }

    function updateContacto($data){
      $this->db->where('id', $data['id']);
      $this->db->update('empresas_contactos', $data);
      if ($this->db->affected_rows() >= 0) {
          return TRUE;
      } else {
          return FALSE;
      }
    }

    public function getContacto($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('empresas_contactos');
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return FALSE;
        }
    }

    public function getContactos($id) {
        $this->db->where('empresa', $id);
        $query = $this->db->get('empresas_contactos');
        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return false;
        }
    }

    function deleteContacto($id) {
        $this->db->where('id', $id);
        $this->db->delete('empresas_contactos');
        if($this->db->affected_rows() > 0)
        {
          return TRUE;
        } else {
          return FALSE;
        }
    }

    //////////////// ARCHIVOS ///////////////////////

    function insertArchivo($data){
        $this->db->set('fecha', 'current_timestamp()', FALSE);
        $this->db->insert('empresas_archivos', $data);
        return $this->db->insert_id();
    }

    function updateArchivo($data){
        $this->db->where('id', $data['id']);
        $this->db->update('empresas_archivos', $data);
        if ($this->db->affected_rows() >= 0) {
            return TRUE;
        } else {
            return FALSE;
        }
      }

    function deleteArchivo($id) {
        $this->db->where('id', $id);
        $this->db->delete('empresas_archivos');
        if($this->db->affected_rows() > 0)
        {
          return TRUE;
        } else {
          return FALSE;
        }
    }

    function getArchivos($empresa){
        $this->db->select('E.*, concat(U.nombre," ",U.paterno) as User');
        $this->db->join('usuarios U', 'E.usuario = U.id', 'LEFT');
        $this->db->where('E.empresa', $empresa);
        $this->db->from('empresas_archivos E');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return FALSE;
        }
    }

    function getRequisitos($tipo) {
        if($tipo != '')
        {
            $this->db->where('tipo', $tipo);
        }
        $this->db->order_by("requisito", "asc");
        $query = $this->db->get('catalogo_requisitos');
        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return FALSE;
        }
    }

    function getRequisitos_empresa($id) {
        $this->db->where('empresa', $id);
        $query = $this->db->get('empresas_requisitos');
        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return FALSE;
        }
    }

    function setRequisitos($data) {
        $this->db->insert('empresas_requisitos', $data);
        return $this->db->insert_id();
    }

    function deleteRequisito($id) {
        $this->db->where('id', $id);
        $this->db->delete('empresas_requisitos');
        if($this->db->affected_rows() > 0)
        {
          return TRUE;
        } else {
          return FALSE;
        }
    }

    function insertRequisito($data){
        $this->db->insert('catalogo_requisitos', $data);
        return $this->db->insert_id();
      }

      function updateRequisito($data){
        $this->db->where('id', $data['id']);
        $this->db->update('catalogo_requisitos', $data);
        if ($this->db->affected_rows() >= 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function deleteRequisitoCatalogo($data){
        $this->db->where('id', $data['id']);
        $this->db->delete('catalogo_requisitos', $data);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /*BORRAR function getLugaresEntrega(){
        $query = $this->db->get('catalogo_entregas');
        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return false;   
        }
    }*/

    /*function getFormasCompra(){
        $query = $this->db->get('catalogo_formas_compra');
        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return false;   
        }
    }

    function setFormasCompra($data) {
        $this->db->set('formas_compra', 'JSON_MERGE(formas_compra, JSON_ARRAY("' . $data['forma'] . '"))', FALSE);
        $this->db->where('empresa', $data['empresa']);
        $this->db->update('proveedores');
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function getMetodosPago()
    {
        $query = $this->db->get('catalogo_metodos_pago');
        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return false;   
        }
    }

    function setMetodosPago($data) {
        $this->db->set('formas_pago', 'JSON_MERGE(formas_pago, JSON_ARRAY("' . $data['forma'] . '"))', FALSE);
        $this->db->where('empresa', $data['empresa']);
        $this->db->update('proveedores');
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }*/

    function setProveedor($data)
    {
        $this->db->set('clasificacion_proveedor', $data['clasificacion_proveedor']);
        $this->db->set('aprobado', $data['aprobado']);
        $this->db->set('credito', $data['credito']);
        $this->db->set('monto_credito', $data['monto_credito']);
        $this->db->set('moneda_credito', $data['moneda_credito']);
        $this->db->set('terminos_pago', $data['terminos_pago']);
        $this->db->set('tags', $data['tags']);

        $this->db->set('tipo',              $data['tipo']);
        $this->db->set('formas_pago',       $data['formas_pago']);
        $this->db->set('formas_compra',     $data['formas_compra']);
        $this->db->set('entrega',           $data['entrega']);
        $this->db->set('pasos_cotizacion',  $data['pasos_cotizacion']);
        $this->db->set('pasos_compra',      $data['pasos_compra']);
        $this->db->set('rma_requerido',      $data['rma_requerido']);

        $this->db->where('empresa',         $data['empresa']);
        $this->db->update('proveedores');
        

        if ($this->db->affected_rows() >= 0) {
            return TRUE;
        } else {
            return FALSE;
        }

    }



}

?>
