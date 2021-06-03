<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Compras_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function get($tabla, $where)
    {
        //$this->db->where($where);
        $res = $this->db->get($tabla);
        if($res->num_rows() > 0)
        {
            return $res->result();
        }
        else{ return false; }
    }

    function getRequisiciones()
    {
        $this->db->select('R.*, concat(U.nombre, " ", U.paterno) as User, ifnull((SELECT count(*) from qr_proveedores where qr = R.id), 0) as Prov');
        $this->db->from('requisiciones_cotizacion R');
        $this->db->join('usuarios U', 'R.usuario = U.id', 'LEFT');
        $res = $this->db->get();
        if($res->num_rows() > 0)
        {
            return $res->result();
        }
        else{ return false; }
    }

    function getMisQrs($user){
        $this->db->select('R.*, concat(U.nombre, " ", U.paterno) as User, ifnull((SELECT count(*) from qr_proveedores where qr = R.id and nominado = 1), 0) as Prov');
        $this->db->where('R.usuario', $user);
        $this->db->from('requisiciones_cotizacion R');
        $this->db->join('usuarios U', 'R.usuario = U.id', 'LEFT');
        $res = $this->db->get();
        if($res->num_rows() > 0)
        {
            return $res->result();
        }
        else{ return false; }
    }

    function getQRProv($id)
    {
        $query = "SELECT QP.id, QP.qr, QP.empresa, QP.costos, QP.monto, QP.moneda, QP.factor, QP.total, QP.tiempo_entrega, QP.comentarios, QP.nominado, QP.seleccionado, QP.vencimiento, QP.nombre_archivo";
        $query .= " from qr_proveedores QP where id=$id";

        $res = $this->db->query($query);
        if($res->num_rows() > 0)
        {
            return $res->row();
        }
        else{ return false; }
    }

    function generarQR($info)
    {
        $this->db->set('fecha', 'current_timestamp()', FALSE);
        $this->db->set('maximo_vencimiento', 'current_timestamp()', FALSE);
        $this->db->insert('requisiciones_cotizacion', $info);
        return $this->db->insert_id();
    }

    function editarQR($info)
    {
        $this->db->where('id', $info['id']);
        $this->db->update('requisiciones_cotizacion', $info);
        if ($this->db->affected_rows() >= 0)
        {
            
            $destino = $info['destino'];
            $qr = $info['id'];

            if($destino == "VENTA")
            {
                $query = "UPDATE qr_proveedores QP set QP.factor = if((SELECT P.entrega from proveedores P where P.empresa = QP.id) = 'USA', 1.35, 1.19), QP.total = QP.monto * QP.factor where QP.qr = $qr";
            }
            else
            {
                $query = "UPDATE qr_proveedores set factor = 1, total = monto * factor where qr = $qr";
            }
            
            $this->db->query($query);

            return TRUE;
        } else {
            return FALSE;
        }
    }

    function insertarConcepto($id_requisicion, $concepto)
    {
        $this->db->set('requisicion', $id_requisicion);
        $this->db->insert('requisiciones_conceptos', $concepto);
    }

    function getDetalleQR($id)
    {
        $this->db->select("RC.id, RC.fecha, RC.usuario, RC.prioridad, RC.tipo, RC.subtipo, RC.cantidad, RC.cantidad_aprobada, RC.unidad, RC.clave_unidad, RC.descripcion, RC.atributos, RC.critico, RC.destino, RC.lugar_entrega, RC.comentarios, RC.estatus, RC.notificaciones, RC.nombre_archivo, concat(U.nombre,' ',U.paterno) as User, U.correo, ifnull(concat(A.nombre,' ',A.paterno), 'N/A') as Liberador, RC.fecha_liberacion");
        $this->db->from('requisiciones_cotizacion RC');
        $this->db->join('usuarios U', 'U.id = RC.usuario');
        $this->db->join('usuarios A', 'A.id = RC.liberador', 'LEFT');
        $this->db->where('RC.id', $id);
        $query = $this->db->get();
        if($query->num_rows() > 0)
        {
            return $query->row();
        }
        else{ return false; }
    }

    function getPR($id)
    {
        $this->db->select("PR.id, PR.fecha, PR.qr, PR.qr_proveedor, PR.usuario, PR.prioridad, PR.tipo, PR.subtipo, PR.cantidad, PR.precio_unitario, PR.importe, PR.unidad, PR.clave_unidad, PR.descripcion, PR.atributos, PR.critico, PR.destino, PR.lugar_entrega, PR.comentarios, PR.estatus, concat(U.nombre,' ',U.paterno) as User, U.correo, ifnull(concat(A.nombre,' ',A.paterno), 'N/A') as Aprobador, PR.fecha_aprobacion");
        $this->db->from('prs PR');
        $this->db->join('usuarios U', 'U.id = PR.usuario');
        $this->db->join('usuarios A', 'A.id = PR.aprobador', 'LEFT');
        $this->db->where('PR.id', $id);
        $query = $this->db->get();
        if($query->num_rows() > 0)
        {
            return $query->row();
        }
        else{ return false; }
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

    function getCorreosQR()
    {
        $query = "SELECT U.correo from privilegios P inner join usuarios U on P.usuario = U.id where P.liberar_qr = 1";
        $res = $this->db->query($query);
        $correos = $res->result_array();
        $arreglo_correos = [];

        foreach ($correos as $key => $value) {
            array_push($arreglo_correos, $value['correo']);
        }
        return $arreglo_correos;
    }

    function getCorreosAprobadoresPR()
    {
        $query = "SELECT U.correo from privilegios P inner join usuarios U on P.usuario = U.id where P.aprobar_pr = 1";
        $res = $this->db->query($query);
        $correos = $res->result_array();
        $arreglo_correos = [];

        foreach ($correos as $key => $value) {
            array_push($arreglo_correos, $value['correo']);
        }
        return $arreglo_correos;
    }

    function getAprobadorPR($id, $destino)
    {
        $campo = 'autorizador_compras';
        if($destino == 'VENTA')
        {
            $campo = 'autorizador_compras_venta';
        }

        $query = "SELECT U.correo from usuarios U where id = (SELECT $campo from usuarios where id=$id)";
        $res = $this->db->query($query);
        $correos = $res->result_array();
        $arreglo_correos = [];

        foreach ($correos as $key => $value) {
            array_push($arreglo_correos, $value['correo']);
        }
        return $arreglo_correos;
    }

    /*BORRAME SI NO ME VAS A USAR 
    function getRequisitorQR($idQR)
    {
        $query = "SELECT concat(U.nombre,' ' U.paterno) as Nombre, U.correo from requisiciones_cotizacion QR inner join usuarios U on QR.usuario = U.id";
        $res = $this->db->query($query);
        return $res->result();
    }*/

    function update($query){
        $this->db->query($query);
        if ($this->db->affected_rows() >= 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function agregar_comentario($datos) {
        $this->db->set('fecha', 'current_timestamp()', FALSE);
        $this->db->insert('qr_comentarios', $datos);
    }

    function agregar_comentarioPR($datos) {
        $this->db->set('fecha', 'current_timestamp()', FALSE);
        $this->db->insert('pr_comentarios', $datos);
    }

    function verQr_comentarios($idQr) {
        $this->db->select('QRC.fecha, ifnull(concat(U.nombre," ",U.paterno), "N/A") as User, QRC.usuario, QRC.comentario');
        $this->db->from('qr_comentarios QRC');
        $this->db->join('usuarios U', 'QRC.usuario = U.id', 'LEFT');
        $this->db->where('QRC.qr', $idQr);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return false;
        }
    }

    function verQr_comentarios_fotos($idQr) {
        $this->db->select('QRC.usuario, U.foto');
        $this->db->from('qr_comentarios QRC');
        $this->db->join('usuarios U', 'QRC.usuario = U.id', 'LEFT');
        $this->db->where('QRC.qr', $idQr);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return false;
        }
    }

    function verPr_comentarios($id) {
        $this->db->select('PRC.fecha, ifnull(concat(U.nombre," ",U.paterno), "N/A") as User, PRC.usuario, PRC.comentario');
        $this->db->from('pr_comentarios PRC');
        $this->db->join('usuarios U', 'PRC.usuario = U.id', 'LEFT');
        $this->db->where('PRC.pr', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return false;
        }
    }

    function verPr_comentarios_fotos($id) {
        $this->db->select('PRC.usuario, U.foto');
        $this->db->from('pr_comentarios PRC');
        $this->db->join('usuarios U', 'PRC.usuario = U.id', 'LEFT');
        $this->db->where('PRC.pr', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return false;
        }
    }

    function verPo_comentarios($id) {
        $this->db->select('POC.fecha, ifnull(concat(U.nombre," ",U.paterno), "N/A") as User, POC.usuario, POC.comentario');
        $this->db->from('po_comentarios POC');
        $this->db->join('usuarios U', 'POC.usuario = U.id', 'LEFT');
        $this->db->where('POC.po', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return false;
        }
    }

    function verPo_comentarios_fotos($id) {
        $this->db->select('POC.usuario, U.foto');
        $this->db->from('po_comentarios POC');
        $this->db->join('usuarios U', 'POC.usuario = U.id', 'LEFT');
        $this->db->where('POC.po', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return false;
        }
    }

    function setProveedor($data){
        $this->db->set('vencimiento', 'current_timestamp()', FALSE);
        $this->db->insert('qr_proveedores', $data);
        return $this->db->insert_id();
    }

    function updateProveedor($data)
    {
        $this->db->where('id', $data['id']);
        $this->db->update('qr_proveedores', $data);
        if ($this->db->affected_rows() >= 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function setQRFile($data)
    {
        $this->db->where('id', $data['id']);
        $this->db->update('requisiciones_cotizacion', $data);
        if ($this->db->affected_rows() >= 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function deleteProveedor($data)
    {
        $this->db->where($data);
        return $this->db->delete('qr_proveedores');
    }


}

?>
