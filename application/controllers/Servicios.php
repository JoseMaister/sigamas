<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Servicios extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('conexion_model', 'Conexion');
    }

    function index(){
        $this->load->view('header');
        $this->load->view('servicios/catalogo');
    }
    
    /////////////////////////////  A        /////////////////////////////
    /////////////////////////////    J      /////////////////////////////   (\(\
    /////////////////////////////      A    /////////////////////////////   (=';')
    /////////////////////////////        X  /////////////////////////////   (,,)(")(")

    function ajax_getServicios(){

        $codigo = $this->input->post('codigo');
        $id = $this->input->post('id');

        $texto = $this->input->post('texto');
        $parametro = $this->input->post('parametro');
        $tipo = json_decode($this->input->post('tipo'));

        $query = "SELECT S.*, CP.bajo_a as bajo, CP.alto_a as alto from servicios S inner join claves_precio CP on S.clave_precio = CP.id where 1 = 1";

        if(isset($codigo))
        {
            $query .= " and S.codigo = '$codigo'";
        }
        else if(isset($id))
        {
            $query .= " and S.id = '$id'";
        }
        else
        {
            if(!empty($texto))
            {
                if($parametro == "id")
                {
                    $query .= " and S.id = '$texto'";
                }
                if($parametro == "codigo")
                {
                    $query .= " and S.codigo like '$texto%'";
                }
                if($parametro == "contenido")
                {
                    $query .= " and S.descripcion like '%$texto%'";
                }
                if($parametro == "magnitud")
                {
                    $query .= " and S.magnitud = '$texto'";
                }
                if($parametro == "codigo_contenido")
                {
                    $query .= " and (S.descripcion like '%$texto%' or S.codigo like '$texto%')";
                }
            }
        }

        

        if(isset($tipo))
        {
            if(count($tipo) > 0)
            {
                $query .= " and ( 1 = 0 ";
                foreach ($tipo as $key => $value) {
                    $query .= " or S.tipo = '$value'";
                }
                $query .= " )"; 
            }
        }

        $query .= " order by S.codigo";


        $row = isset($codigo) || isset($id);
        $res = $this->Conexion->consultar($query, $row);
        if($res)
        {
            echo json_encode($res);
        }
    }

    function ajax_getServicio(){
        $id = $this->input->post('id');

        $query = "SELECT S.*, ifnull(SE.codigo,'') as CodeEst, ifnull(SE.id,0) as IdEst from servicios S left join servicios SE on S.estandar = SE.id where 1 = 1 and S.id = $id";

        $res = $this->Conexion->consultar($query, TRUE);
        if($res)
        {
            echo json_encode($res);
        }
        else{
            echo "";
        }
    }

    function ajax_setServicio(){
        $servicio = json_decode($this->input->post('servicio'));
        
        $datos['tipo'] = $servicio->tipo;
        $datos['tipo_calibracion'] = $servicio->tipo_calibracion;
        $datos['descripcion'] = $servicio->descripcion;
        $datos['observaciones'] = $servicio->observaciones;
        $datos['sitio'] = $servicio->sitio;
        $datos['interno'] = $servicio->interno;
        $datos['proveedor'] = $servicio->proveedor;
        $datos['tags'] = $servicio->tags;
        $datos['clave_precio'] = $servicio->clave_precio;
        $datos['activo'] = $servicio->activo;
        $datos['estandar'] = $servicio->estandar;

        $res = FALSE;
        if($servicio->id == 0)
        {
            $func['codigo'] = "(SELECT concat('$servicio->prefijo', LPAD(count(S.prefijo) + 1, 4, 0)) from servicios S where S.prefijo = '$servicio->prefijo')";
            $datos['magnitud'] = $servicio->magnitud;
            $datos['prefijo'] = $servicio->prefijo;
            $res = $this->Conexion->insertar('servicios', $datos, $func) > 0;
        }
        else
        {
            $where['id'] = $servicio->id;
            $res = $this->Conexion->modificar('servicios', $datos, null, $where) >= 0;
            $this->Conexion->modificar('servicios', array('activo' => $servicio->activo), null, array('estandar' => $servicio->id));
        }

        if($res)
        {
            echo "1";
        }
    }

    function ajax_deleteServicio(){
        $id = $this->input->post('id');

        $where['id'] = $id;

        if($this->Conexion->eliminar('servicios', $where))
        {
            echo "1";
        }
    }

    function ajax_codeExists(){
        $codigo = $this->input->post('codigo');

        $query = "SELECT count(S.codigo) as CodeCount from servicios S where 1 = 1 and codigo = '$codigo'";

        $res = $this->Conexion->consultar($query, TRUE);
        if($res)
        {
            echo json_encode($res);
        }
        else{
            echo "";
        }
    }

}
