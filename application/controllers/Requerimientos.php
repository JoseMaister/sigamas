<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Requerimientos extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('conexion_model', 'Conexion');
        $this->load->library('correos_servicios');
    }

    function index(){
        $this->load->view('header');
        $this->load->view('requerimientos/catalogo');
    }

    function crear_requerimiento(){
        $data["id"] = 0;

        $this->load->view('header');
        $this->load->view('requerimientos/crear_requerimiento', $data);
    }

    function editar($id = 0){
        if(isset($_POST["id"]))
        {
            $id = $this->input->post('id');
        }
        else if ($id == 0){
            redirect(base_url('inicio'));
        }

        $data["id"] = $id;

        $this->load->view('header');
        $this->load->view('requerimientos/crear_requerimiento', $data);
    }

    function ver($id = 0){
        if(isset($_POST["id"]))
        {
            $id = $this->input->post('id');
        }
        else if ($id == 0){
            redirect(base_url('inicio'));
        }

        $data["id"] = $id;

        $this->load->view('header');
        $this->load->view('requerimientos/ver', $data);
    }

    //                         __
    //                       .'  '.
    //                   _.-'/  |  \
    //      ,        _.-"  ,|  /    `-.
    //      |\    .-"       `--""-.__.'======================,
    //      \ '-'`        .___.--._)=========================|
    //       \            .'      |                          |
    //        |     /,_.-'        |        CODIGO AJAX       |
    //      _/   _.'(             |            BY            |
    //     /  ,-' \  \            |        ALEKS ORTIZ       |
    //     \  \    `-'            |                          |
    //      `-'                   '--------------------------'

    function ajax_getRequerimientos(){
        $texto = $this->input->post('texto');
        $parametro = $this->input->post('parametro');

        $query = "SELECT R.*, concat(U.nombre,' ',U.paterno) as User from requerimientos R inner join usuarios U on R.usuario = U.id where 1 = 1";

        if(!empty($texto))
        {
            /*if($parametro == "codigo")
            {
                $query .= " and S.codigo = '$texto'";
            }
            if($parametro == "contenido")
            {
                $query .= " and S.descripcion like '%$texto%'";
            }
            if($parametro == "magnitud")
            {
                $query .= " and S.magnitud = '$texto'";
            }*/
        }

        $query .= " order by R.fecha desc";

        $res = $this->Conexion->consultar($query);
        if($res)
        {
            echo json_encode($res);
        }
    }

    function ajax_getRequerimiento(){
        $id = $this->input->post('id');

        $query = "SELECT R.*, concat(U.nombre,' ',U.paterno) as User, concat(UC.nombre,' ',UC.paterno) as Cerrador from requerimientos R inner join usuarios U on R.usuario = U.id left join usuarios UC on R.despachador = UC.id where 1 = 1 and R.id = '$id'";

        $res = $this->Conexion->consultar($query, TRUE);
        if($res)
        {
            echo json_encode($res);
        }
        else{
            echo "";
        }
    }

    function ajax_setRequerimiento(){
        $requerimiento = json_decode($this->input->post('requerimiento'));

        if(!isset($requerimiento->id))
        {
            $requerimiento->usuario = $this->session->id;
            $func["fecha"] = "CURRENT_TIMESTAMP()";
            $res = $this->Conexion->insertar('requerimientos', $requerimiento, $func);
            $requerimiento->id = $res;
            $res = $res > 0;
        }
        else
        {
            $fc = $requerimiento->estatus == "EVALUADO" | $requerimiento->estatus == "NO PROCEDE";
            $res = $this->Conexion->modificar('requerimientos', $requerimiento, $fc ? array('fecha_cierre' => 'CURRENT_TIMESTAMP()') : null, array('id' => $requerimiento->id)) >= 0;
        }

        $evaluador = json_decode($requerimiento->evaluadores);
        switch($requerimiento->estatus)
        {
            case "ABIERTO":
            case "CANALIZADO":
                $u = array_pop($evaluador);
                $res = $this->Conexion->consultar("SELECT ifnull(correo, 'N/A') as Mail from usuarios where id = $u", TRUE);
                $requerimiento->correo = $res->Mail;
                break;

            case "RECHAZADO":
            case "EVALUADO":
            case "NO PROCEDE":
                $res = $this->Conexion->consultar("SELECT ifnull(correo, 'N/A') as Mail from usuarios where id = $requerimiento->id", TRUE);
                $requerimiento->correo = $res->Mail;
                break;
        }

        $this->correos_servicios->requerimiento($requerimiento);
        

        if($res)
        {
            echo "1";
        }
    }

    function ajax_getEvaluadores(){
        $query = "SELECT U.id, concat(U.nombre,' ',U.paterno) as User from usuarios U inner join privilegios P on U.id = P.usuario where U.activo = '1' and P.evaluar_requerimientos = '1'";

        $res = $this->Conexion->consultar($query);
        if($res)
        {
            echo json_encode($res);
        }
        else{
            echo "";
        }
    }

    function ajax_getServicios(){ //SERVICIOS RELACIONADOS A REQUERIMIENTO
        $fabricante = $this->input->post('fabricante');
        $modelo = $this->input->post('modelo');

        $query = "SELECT S.*, S.descripcion as DescripcionServicio, R.descripcion, R.id as IdReq from requerimientos R inner join servicios S on S.id = R.servicio where R.catalogado = '1' and upper(trim(R.fabricante)) = '$fabricante' and upper(trim(R.modelo)) = '$modelo' group by S.id";

        $res = $this->Conexion->consultar($query);
        if($res)
        {
            echo json_encode($res);
        }
        else{
            echo "";
        }
    }

    function ajax_getRequerimientoArchivos(){
        $id = $this->input->post('id');

        $query = "SELECT RA.id, RA.fecha, RA.nombre, RA.comentarios, concat(U.nombre, ' ', U.paterno) as User from requerimiento_archivos RA inner join usuarios U on U.id = RA.usuario where RA.requerimiento = '$id'";

        $res = $this->Conexion->consultar($query);
        if($res)
        {
            echo json_encode($res);
        }
        else{
            echo "";
        }
    }

    function ajax_subirArchivo(){
        $datos['usuario'] = $this->session->id;
        $datos['requerimiento'] = $this->input->post('requerimiento');
        $datos['nombre'] = $this->input->post('nombre');
        $datos['comentarios'] = $this->input->post('comentarios');
        $datos['archivo'] = file_get_contents($_FILES['file']['tmp_name']);

        $func['fecha'] = "CURRENT_TIMESTAMP()";

        $this->Conexion->insertar("requerimiento_archivos", $datos, $func);

    }

    function test(){
        echo date("Y-m-d h:i:s");
    }

    function ajax_setRequerimientoComentario(){
        //$this->output->enable_profiler(TRUE);

        $id = $this->input->post('id');
        $comentario = $this->input->post('comentario');
        $id_user = $this->session->id;

        if($this->Conexion->comando("UPDATE requerimientos set comentarios = JSON_MERGE(comentarios, JSON_ARRAY(JSON_ARRAY($id_user, CURRENT_TIMESTAMP(), '$comentario'))) where id = $id"))
        {
            echo "1";
        }

        echo "UPDATE requerimientos set comentarios = JSON_MERGE(comentarios, JSON_ARRAY(JSON_ARRAY($id_user, CURRENT_TIMESTAMP(), '$comentario'))) where id = $id";
    }


}
