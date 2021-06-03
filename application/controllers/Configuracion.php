<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Configuracion extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('conexion_model','Conexion');
    }

    function compras() {
        $this->load->view('header');
        $this->load->view('configuracion/compra_opciones');
    }

    function servicios() {
        $this->load->view('header');
        $this->load->view('configuracion/servicios_opciones');
    }

    function requerimientos() {
        $this->load->view('header');
        $this->load->view('configuracion/requerimientos_opciones');
    }


    //SERVICIOS
    function claves_precio(){
        $this->load->view('header');
        $this->load->view('configuracion/servicios/claves_precio');
    }

    function magnitudes(){
        $this->load->view('header');
        $this->load->view('configuracion/servicios/magnitudes');
    }

    //COMPRAS//
    function shipping_address()
    {
        $this->load->view('header');
        $this->load->view('configuracion/compras/shipping_address');
    }
    
    function billing_address()
    {
        $this->load->view('header');
        $this->load->view('configuracion/compras/billing_address');
    }

    function pagos()
    {
        $this->load->view('header');
        $this->load->view('configuracion/compras/pagos');
    }

    /*
        ///////////////////////////// A        /////////////////////////////
        /////////////////////////////   J      /////////////////////////////
        /////////////////////////////     A    /////////////////////////////
        /////////////////////////////       X  /////////////////////////////
    */
    
    function ajax_getClavesPrecio(){
        $id = 0;
        if(isset($_POST['id']))
        {
            $id = $this->input->post('id');
        }

        $query = "SELECT * from claves_precio";

        $row = $id > 0;
        if($row)
        {
            $query .= " where id = $id";
        }
        
        $res = $this->Conexion->consultar($query, $row);
        if($res)
        {
            echo json_encode($res);
        }
        else
        {
            echo "0";
        }
    }

    function ajax_setClavesPrecio(){
        $id = $this->input->post('id');
        $bajo = $this->input->post('bajo');
        $alto = $this->input->post('alto');

        $datos['bajo'] = $bajo;
        $datos['alto'] = $alto;
        $where['id'] = $id;

        $this->Conexion->modificar('claves_precio', $datos, null, $where);
        echo "1";
    }


    function ajax_getMagnitudes(){
        $id = 0;
        if(isset($_POST['id']))
        {
            $id = $this->input->post('id');
        }

        $query = "SELECT * from magnitudes";
        
        $row = $id > 0;
        if($row)
        {
            $query .= " where id = $id";
        }

        $res = $this->Conexion->consultar($query, $row);
        if($res)
        {
            echo json_encode($res);
        }
        else
        {
            echo "0";
        }
    }

    function ajax_setMagnitudes(){
        $id = 0;
        if(isset($_POST['id']))
        {
            $id = $this->input->post('id');
        }

        $magnitud = $this->input->post('magnitud');        
        $prefijo = $this->input->post('prefijo');
        
        $datos['magnitud'] = $magnitud;
        $datos['prefijo'] = $prefijo;

        $res = FALSE;
        if($id == 0)
        {
            $res = $this->Conexion->insertar('magnitudes', $datos) > 0;
        }
        else
        {
            $where['id'] = $id;
            $res = $this->Conexion->modificar('magnitudes', $datos, null, $where) >= 0;
        }

        if($res)
        {
            echo "1";
        }
    }

    function ajax_deleteMagnitudes(){
        $id = $this->input->post('id');

        $where['id'] = $id;

        if($this->Conexion->eliminar('magnitudes', $where))
        {
            echo "1";
        }
    }

    function ajax_prefijoExists(){
        $prefijo = $this->input->post('prefijo');

        $query = "SELECT count(M.prefijo) as Qty from magnitudes M where 1 = 1 and prefijo = '$prefijo'";

        $res = $this->Conexion->consultar($query, TRUE);
        if($res)
        {
            echo json_encode($res);
        }
        else{
            echo "";
        }
    }



    function ajax_getShippingAddresses(){
        $id = 0;
        if(isset($_POST['id']))
        {
            $id = $this->input->post('id');
        }

        $query = "SELECT * from shipping_address";
        
        $row = $id > 0;
        if($row)
        {
            $query .= " where id = $id";
        }

        $res = $this->Conexion->consultar($query, $row);
        if($res)
        {
            echo json_encode($res);
        }
        else
        {
            echo "0";
        }
    }

    function ajax_setShippingAddresses(){
        $id = 0;
        if(isset($_POST['id']))
        {
            $id = $this->input->post('id');
        }

        $nombre = $this->input->post('nombre');
        $direccion = $this->input->post('direccion');
        $pais = $this->input->post('pais');

        $datos['nombre'] = $nombre;
        $datos['direccion'] = $direccion;
        $datos['pais'] = $pais;

        $res = FALSE;
        if($id == 0)
        {
            $datos['default']= '0';
            $res = $this->Conexion->insertar('shipping_address', $datos) > 0;
        }
        else
        {
            $where['id'] = $id;
            $res = $this->Conexion->modificar('shipping_address', $datos, null, $where) >= 0;
        }

        if($res)
        {
            echo "1";
        }
    }

    function ajax_deleteShippingAddresses(){
        $id = $this->input->post('id');

        $where['id'] = $id;

        if($this->Conexion->eliminar('shipping_address', $where))
        {
            echo "1";
        }
    }

    function ajax_setDefaultShippingAddresses(){
        
        $where['pais'] = $this->input->post('pais');
        $datos['default'] = '0';
        $this->Conexion->modificar('shipping_address', $datos, null, $where);
        
        $where['id'] = $this->input->post('id');
        $datos['default'] = '1';
        $this->Conexion->modificar('shipping_address', $datos, null, $where);
        echo "1";
    }


    function ajax_getBillingAddresses(){
        $id = 0;
        if(isset($_POST['id']))
        {
            $id = $this->input->post('id');
        }

        $query = "SELECT * from billing_address";
        
        $row = $id > 0;
        if($row)
        {
            $query .= " where id = $id";
        }

        $res = $this->Conexion->consultar($query, $row);
        if($res)
        {
            echo json_encode($res);
        }
        else
        {
            echo "0";
        }
    }

    function ajax_setBillingAddresses(){
        $id = 0;
        if(isset($_POST['id']))
        {
            $id = $this->input->post('id');
        }

        $nombre = $this->input->post('nombre');
        $direccion = $this->input->post('direccion');

        $datos['nombre'] = $nombre;
        $datos['direccion'] = $direccion;

        $res = FALSE;
        if($id == 0)
        {
            $datos['default'] = '0';
            $res = $this->Conexion->insertar('billing_address', $datos) > 0;
        }
        else
        {
            $where['id'] = $id;
            $res = $this->Conexion->modificar('billing_address', $datos, null, $where) >= 0;
        }

        if($res)
        {
            echo "1";
        }
    }

    function ajax_deleteBillingAddresses(){
        $id = $this->input->post('id');

        $where['id'] = $id;

        if($this->Conexion->eliminar('billing_address', $where))
        {
            echo "1";
        }
    }

    function ajax_setDefaultBillingAddresses(){
        $where['id'] = $this->input->post('id');
        
        $datos['default'] = '0';
        $this->Conexion->modificar('billing_address', $datos, null, null);
        
        $datos['default'] = '1';
        $this->Conexion->modificar('billing_address', $datos, null, $where);
        echo "1";
    }


    function ajax_getPagos(){
        $id = 0;
        if(isset($_POST['id']))
        {
            $id = $this->input->post('id');
        }

        $query = "SELECT * from empresa_metodos_pago";
        
        $row = $id > 0;
        if($row)
        {
            $query .= " where id = $id";
        }

        $res = $this->Conexion->consultar($query, $row);
        if($res)
        {
            echo json_encode($res);
        }
        else
        {
            echo "0";
        }
    }

    function ajax_setPagos(){
        $metodo = json_decode($this->input->post('metodo_pago'));
        $metodo->fecha_vencimiento = date("Y-m-d", strtotime($metodo->fecha_vencimiento));


        $res = FALSE;
        if($metodo->id == 0)
        {
            $res = $this->Conexion->insertar('empresa_metodos_pago', $metodo) > 0;
        }
        else
        {
            $where['id'] = $metodo->id;
            $res = $this->Conexion->modificar('empresa_metodos_pago', $metodo, null, $where) >= 0;
        }

        if($res)
        {
            echo "1";
        }
    }

    function ajax_deletePagos(){
        $id = $this->input->post('id');

        $where['id'] = $id;

        if($this->Conexion->eliminar('empresa_metodos_pago', $where))
        {
            echo "1";
        }
    }

    //////////// R E Q U E R I M I E N T O S ////////////
    function evaluador_requerimiento(){
        $this->load->view('header');
        $this->load->view('configuracion/requerimientos/evaluador');
    }

    function ajax_getEvaluador(){

        $query = "SELECT evaluador_default from requerimientos_config where id = 1";
        
        $res = $this->Conexion->consultar($query, TRUE);
        echo json_encode($res);
        
    }

    function ajax_setEvaluador(){
        
        $datos['evaluador_default'] = $this->input->post('id');

        $res = $this->Conexion->modificar('requerimientos_config', $datos, null, array('id' => 1)) >= 0;

        if($res)
        {
            echo "1";
        }
    }



}
