<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Empresas extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('empresas_model','Modelo');
        $this->db->db_debug = FALSE;
    }

    function index() {
        //$this->output->enable_profiler(TRUE);
        //$datos['empresas'] = $this->Modelo->getEmpresas();
        $this->load->view('header');
        $this->load->view('empresas/catalogo');
    }

    function alta() {
        $this->load->view('header');
        $this->load->view('empresas/alta');
    }

    function ver($id){
      $datos['empresa'] = $this->Modelo->getEmpresa($id);
      $datos['proveedor'] = $this->Modelo->getProveedor($id);
      $datos['contactos'] = $this->Modelo->getContactos($id);
      $datos['archivos'] = $this->Modelo->getArchivos($id);
      $datos['requisitos'] = $this->Modelo->getRequisitos_empresa($id);
      
      $this->load->view('header');
      $this->load->view('empresas/ver', $datos);
    }

    function registrar() {
        $ACIERTOS = array(); $ERRORES = array();

        $data = array(
            'nombre' => trim($this->input->post('nombre')),
            'nombre_corto' => trim($this->input->post('nombre_corto')),
            'razon_social' => trim($this->input->post('razon_social')),
            'giro' => trim($this->input->post('giro')),
            'clasificacion' => trim($this->input->post('clasificacion')),
            'rfc' => trim($this->input->post('rfc')),
            'calle' => trim($this->input->post('calle')),
            'numero' => trim($this->input->post('numero')),
            'numero_interior' => trim($this->input->post('numero_interior')),
            'colonia' => trim($this->input->post('colonia')),
            'calles_aux' => trim($this->input->post('calles_aux')),
            'pais' => trim($this->input->post('pais')),
            'estado' => trim($this->input->post('estado')),
            'ciudad' => trim($this->input->post('ciudad')),
            'cp' => trim($this->input->post('cp')),
            'foto' => 'default.png',
            'ubicacion' => '',
            'cliente' => $this->input->post('cliente') != NULL ? '1' : '0',
            'proveedor' => $this->input->post('proveedor') != NULL ? '1' : '0',
            'credito_cliente' => '0',
            'credito_cliente_plazo' => '0',
            'documentos_facturacion' => '[]',
            'codigo_impresion' => '',
            'comentarios' => '',
            'moneda_cotizacion' => '[]',
            'iva_cotizacion' => '[]',
            'notas_cotizacion' => '',            
            'contacto_cotizacion' => '[]',
            'requisitos_logisticos' => '',
            'requisitos_documento' => '',
            'factura_ejemplo' => '',
            'dejar_factura' => 0,
        );

        if ($this->Modelo->crear_empresa($data)) {
            $acierto = array('titulo' => 'Agregar Empresa', 'detalle' => 'Se ha agregado Empresa con Éxito');
            array_push($ACIERTOS, $acierto);
        } else {
            $error = array('titulo' => 'ERROR', 'detalle' => 'Error al agregar Empresa');
            array_push($ERRORES, $error);
        }
        $this->session->aciertos = $ACIERTOS;
        $this->session->errores = $ERRORES;
        redirect(base_url('empresas'));
    }

    function editar() {
        $ACIERTOS = array(); $ERRORES = array();
        $id = $this->input->post('id');
        $data = array(
            'id' => trim($id),
            'nombre' => trim($this->input->post('nombre')),
            'giro' => trim($this->input->post('giro')),
            'razon_social' => trim($this->input->post('razon_social')),
            'rfc' => trim($this->input->post('rfc')),
            'calle' => trim($this->input->post('calle')),
            'numero' => trim($this->input->post('numero')),
            'numero_interior' => trim($this->input->post('numero_interior')),
            'colonia' => trim($this->input->post('colonia')),
            'calles_aux' => trim($this->input->post('calles_aux')),
            'cp' => trim($this->input->post('cp')),
            'pais' => trim($this->input->post('pais')),
            'estado' => trim($this->input->post('estado')),
            'ciudad' => trim($this->input->post('ciudad')),
            'ubicacion' => '',
            'cliente' => $this->input->post('cliente') != NULL ? '1' : '0',
            'proveedor' => $this->input->post('proveedor') != NULL ? '1' : '0',
        );

        if ($this->Modelo->update($data)) {
            $acierto = array('titulo' => 'Editar Empresa', 'detalle' => 'Se ha editado Empresa con Éxito');
            array_push($ACIERTOS, $acierto);
        } else {
            $error = array('titulo' => 'ERROR', 'detalle' => 'Error al editar Empresa');
            array_push($ERRORES, $error);
        }
        $this->session->aciertos = $ACIERTOS;
        $this->session->errores = $ERRORES;
        redirect(base_url('empresas/ver/' . $id ));
    }

    function ajax_getEmpresas(){
        //$this->output->enable_profiler(TRUE);
        $texto = $this->input->post('texto');
        $texto = trim($texto);
        $parametro = $this->input->post('parametro');
        $cliente = $this->input->post('cliente');
        $proveedor = $this->input->post('proveedor');

        $query = "SELECT E.* from empresas E where 1 = 1";

        

        if($cliente != $proveedor)
        {
            if($cliente == "1")
            {
                $query .= " and E.cliente = '1'";
            }
            else
            {
                $query .= " and E.proveedor = '1'";
            }
        }

        if(!empty($texto))
        {
            if($parametro == "nombre")
            {
                $query .= " and (E.nombre like '%$texto%' or E.razon_social like '%$texto%')";
            }
            if($parametro == "id")
            {
                $query .= " and E.id = '$texto'";
            }
        }

        //echo $query;

        $res = $this->Conexion->consultar($query);
        if($res)
        {
            echo json_encode($res);
            //echo $query;
        }
        else{
            echo "";
        }
    }

    function ajax_getContactos(){
        $id = $this->input->post('id');
        $where['empresa'] = $id;

        $res = $this->Conexion->get('empresas_contactos', $where);
        if($res)
        {
            echo json_encode($res);
        }
        else
        {
            echo "";
        }
    }

    function ajax_getContacto(){
        $id = $this->input->post('id');

        $res = $this->Conexion->consultar("SELECT EC.*, ifnull(Pl.nombre,'NO DEFINIDO') as Planta from empresas_contactos EC left join empresa_plantas Pl on Pl.id = EC.planta where EC.id = $id", TRUE);
        if($res)
        {
            echo json_encode($res);
        }
    }

    function ajax_getArchivos(){
        $empresa = $this->input->post('empresa');
        $texto = $this->input->post('texto');

        $query = "SELECT A.*, concat(U.nombre,' ',U.paterno) as User from empresas_archivos A inner join usuarios U on U.id = A.usuario where A.empresa = $empresa";

        if($texto){
            $query .= " and (A.nombre like '%$texto%' or A.comentarios like '%$texto%')";
        }

        $res = $this->Conexion->consultar($query);
        if($res){
            echo json_encode($res);
        }
    }

    function ajax_getFacturaEjemplo(){
        $empresa = $this->input->post('empresa');

        $query = "SELECT factura_ejemplo from empresas where id = $empresa";

        $res = $this->Conexion->consultar($query, TRUE);
        echo $res->factura_ejemplo;
    }

    function ajax_setFacturaEjemplo(){
        $id = $this->input->post('empresa');
        $file = $this->input->post('file');

        if($file != "undefined")
        {
            $config['upload_path'] = 'data/empresas/ejemplo_facturas/';
            $config['allowed_types'] = 'pdf';
            $config['encrypt_name'] = TRUE;
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('file'))
            {
                $data['factura_ejemplo'] = $this->upload->data('file_name');
                $this->Conexion->modificar('empresas', $data, null, array('id' => $id));
            }
        }
    }

    function ajax_deleteFacturaEjemplo(){
        $id = $this->input->post('empresa');

        $res = $this->Conexion->consultar("SELECT factura_ejemplo from empresas where id = $id", TRUE);
        unlink('data/empresas/ejemplo_facturas/' . $res->factura_ejemplo);

        $data['factura_ejemplo'] = "";
        $this->Conexion->modificar('empresas', $data, null, array('id' => $id));
    }

    function editar_otros_datos() {
        $ACIERTOS = array(); $ERRORES = array();
        $id = $this->input->post('id');
        $data = array(
            'id' => $id,
            'horario_facturas' => trim($this->input->post('horario_facturas')),
            'ultimo_dia_facturas' => trim($this->input->post('ultimo_dia_facturas')),
            'requisitos_logisticos' => trim($this->input->post('requisitos_logisticos')),
            'requisitos_documento' => trim($this->input->post('requisitos_documento')),
            'comentarios' => trim($this->input->post('comentarios')),
            'dejar_factura' => $this->input->post('dejar_factura') == '1' ? '1' : '0',
        );

        if ($this->Modelo->update($data)) {
            $acierto = array('titulo' => 'Editar Empresa', 'detalle' => 'Se ha editado Empresa con Éxito');
            array_push($ACIERTOS, $acierto);
        } else {
            $error = array('titulo' => 'ERROR', 'detalle' => 'Error al editar Empresa');
            array_push($ERRORES, $error);
        }
        $this->session->aciertos = $ACIERTOS;
        $this->session->errores = $ERRORES;
        redirect(base_url('empresas/ver/' . $id ));
    }

    //CONTACTOS
    function agregarContacto() {
        $empresa = $this->input->post('empresa');
        $data = array(
            'empresa' => trim($empresa),
            'nombre' => trim($this->input->post('nombre')),
            'telefono' => trim($this->input->post('telefono')),
            'ext' => trim($this->input->post('ext')),
            'celular' => trim($this->input->post('celular')),
            'celular2' => trim($this->input->post('celular2')),
            'correo' => trim($this->input->post('correo')),
            'puesto' => trim($this->input->post('puesto')),
            'red_social' => trim($this->input->post('red_social')),
            'activo' => $this->input->post('activo'),
            'cotizable' => $this->input->post('cotizable'),
            'planta' => $this->input->post('planta'),
        );

        $res = $this->Modelo->insertContacto($data);
        if ($res) {
            $res = json_encode($this->Modelo->getContacto($res));
        }else {
            $res = "";
        }

        echo $res;
        //redirect(base_url('empresas/ver/' . $empresa . "#tab_content2" ));
    }

    function editarContacto() {
      $id = $this->input->post('id');
      $data = array(
          'id' => trim($id),
          'nombre' => trim($this->input->post('nombre')),
          'telefono' => trim($this->input->post('telefono')),
          'ext' => trim($this->input->post('ext')),
          'celular' => trim($this->input->post('celular')),
          'celular2' => trim($this->input->post('celular2')),
          'correo' => trim($this->input->post('correo')),
          'puesto' => trim($this->input->post('puesto')),
          'red_social' => trim($this->input->post('red_social')),
          'activo' => $this->input->post('activo'),
          'cotizable' => $this->input->post('cotizable'),
          'planta' => $this->input->post('planta'),
      );

      if ($this->Modelo->updateContacto($data)) {
          $res = json_encode($this->Modelo->getContacto($id));
      }else {
          $res = "";
      }

      echo $res;
    }

    function getContacto_json(){
      $contact = $this->Modelo->getContacto($this->input->post('id'));
      if($contact){
          echo json_encode($contact);
      } else {
          echo "";
      }
    }

    function deleteContacto_json(){
      if($this->Modelo->deleteContacto($this->input->post('id'))){
          echo "1";
      } else {
          echo ""; //jQuery interpreta como FALSE (no 0)
      }
    }

    function subir_foto() {
        
        $id = $this->input->post('id_empresa');
        $foto = $this->input->post('fotoActual');
        $file = $this->input->post('iptFoto');

        if($file != "undefined")
        {
            $config['upload_path'] = 'data/empresas/fotos/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['encrypt_name'] = TRUE;
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('iptFoto'))
            {
                $data['id'] = $id;
                $data['foto'] = $this->upload->data('file_name');
                if($this->Modelo->update($data)){
                    if($foto != "default.png"){
                        unlink('data/empresas/fotos/' . $foto );
                    }
                    echo $data['foto'];
                }
            } else {
                echo "";
            }
        } else {
            $data['id'] = $id;
            $data['foto'] = 'default.png';
            if($this->Modelo->update($data)){
                if($foto != "default.png"){
                    unlink('data/empresas/fotos/' . $foto );
                }
                echo $data['foto'];
            }
        }
    }

    function subir_archivo() {
        $id = $this->input->post('id');
        $comentarios = $this->input->post('comentarios');

        if (!is_dir('data/empresas/archivos/' . $id)) {
            mkdir('data/empresas/archivos/' . $id, 0777, TRUE);
        }

        $config['upload_path'] = 'data/empresas/archivos/' . $id;
        $config['allowed_types'] = '*';

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('userfile'))
        {
            $data['empresa'] = $id;
            $data['usuario'] = $this->session->id;
            $data['nombre'] = $this->upload->data('file_name');
            $data['comentarios'] = $comentarios;
            $idFile = $this->Modelo->insertArchivo($data);
            if($idFile)
            {
                $arreglo['id'] = $idFile;
                $arreglo['nombre'] = $data['nombre'];
                $arreglo['fecha'] = date('d/m/Y h:i A');
                $arreglo['icono'] = $this->aos_funciones->file_image($data['nombre']);
                $arreglo['error'] = '';
                echo json_encode($arreglo);
            }
        } else {
                $arreglo['id'] = '0';
                $arreglo['nombre'] = 'ERROR';
                $arreglo['fecha'] = 'ERROR';
                $arreglo['icono'] = $this->aos_funciones->file_image($data['nombre']);
                $arreglo['error'] = $this->upload->display_errors();
                echo json_encode($arreglo);
        }
    }

    function deleteArchivo_json(){
        $id_file = $this->input->post('id');
        $id_empresa = $this->input->post('id_empresa');
        $nombre = $this->input->post('nombre_archivo');
        if($this->Modelo->deleteArchivo($id_file)){
            unlink('data/empresas/archivos/' . $id_empresa . '/' . $nombre);
            echo "1";
        } else {
            echo ""; //jQuery interpreta como FALSE (no 0)
        }
      }

      function editArchivo_json(){
        $data['id'] = $this->input->post('id');
        $data['comentarios'] = trim($this->input->post('comentarios'));

        if($this->Modelo->updateArchivo($data)){
            echo $data['comentarios'];
        } else {
            echo ""; //jQuery interpreta como FALSE (no 0)
        }
      }

      //////// REQUISITOS DE FACTURACION ////////////

      function requisitos(){
        $data['requisitos'] = $this->Modelo->getRequisitos('');
        $this->load->view('header');
        $this->load->view('empresas/catalogo_requisitos', $data);
      }

      function getRequisitos_json(){
        $tipo = $this->input->post('tipo');
        $requisitos = $this->Modelo->getRequisitos($tipo);
        if($requisitos){
            echo json_encode($requisitos->result());
        } else {
            echo "";
        }
      }

      function setRequisitos_json(){
        $data['empresa'] = $this->input->post('id_empresa');
        $data['requisito'] = $this->input->post('requisito');
        $data['tipo'] = $this->input->post('tipo');
        $data['detalles'] = $this->input->post('detalles');
        $id = $this->Modelo->setRequisitos($data);
        if($id) {
            $res['id'] = $id;
            $res['requisito'] = $data['requisito'];
            $res['detalles'] = $data['detalles'];
            echo json_encode($res);
        } else {
            echo "";
        }
      }

      function deleteRequisito_json(){
        if($this->Modelo->deleteRequisito($this->input->post('id'))){
            echo "1";
        } else {
            echo ""; //jQuery interpreta como FALSE (no 0)
        }
      }

      function agregarRequisito_ajax() {
        $data = array(
            'requisito' => strtoupper(trim($this->input->post('requisito'))),
            'tipo' => strtoupper(trim($this->input->post('tipo'))),
            'detalle' => $this->input->post('detalle'),
        );

        $res = $this->Modelo->insertRequisito($data);
        if ($res) 
        {
            $data['id'] = $res;
            echo json_encode($data);
        }else {
            echo "";
        }
    }

    function editarRequisito_ajax() {
        $data = array(
            'id' => strtoupper(trim($this->input->post('id'))),
            'requisito' => strtoupper(trim($this->input->post('requisito'))),
            'tipo' => strtoupper(trim($this->input->post('tipo'))),
            'detalle' => $this->input->post('detalle'),
        );

        $res = $this->Modelo->updateRequisito($data);
        if ($res) 
        {
            echo json_encode($data);
        } else {
            echo "";
        }
    }

    function eliminarRequisito_ajax() {
        $data = array(
            'id' => trim($this->input->post('id')),
        );

        $res = $this->Modelo->deleteRequisitoCatalogo($data);
        if ($res) 
        {
            echo "1";
        } else {
            echo "";
        }
    }

    function editarUbicacion_ajax() {
        $data = array(
            'id' => $this->input->post('id'),
            'lat' => $this->input->post('lat'),
            'lng' => $this->input->post('lng'),
            'zoom' => $this->input->post('zoom'),
        );

        $res = $this->Modelo->update($data);
        if ($res) 
        {
            echo "1";
        } else {
            echo "";
        }
    }

    /* BORRAR function getLugaresEntrega_ajax(){
        $res = $this->Modelo->getLugaresEntrega();
        if($res)
        {
            echo json_encode($res);
        }
        else
        {
            echo "";
        }
    }*/

    /* BORRAR function setEntrega_ajax()
    {
        $data = array(
            'empresa' => $this->input->post('id_empresa'),
            'entrega' => $this->input->post('lugar'),
        );

        $res = $this->Modelo->setLugaresEntrega($data);

        if ($res) 
        {
            //$lugares = json_decode($this->input->post('lugares'));
            $lugares = $this->input->post('lugares');
            $lugares = json_decode($lugares, TRUE);
            array_push($lugares, $data['entrega']);
            echo json_encode($lugares);
            //array_push($lugares, $data['entrega']);
            //echo json_decode($lugares);
        } else {
            echo "";
        }
    }*/

    /*function getFormasCompra_ajax()
    {
        $res = $this->Modelo->getFormasCompra();
        if($res)
        {
            echo json_encode($res);
        }
        else
        {
            echo "";
        }
    }

    function setFormasCompra_ajax()
    {
        $data = array(
            'empresa' => $this->input->post('id_empresa'),
            'forma' => $this->input->post('forma'),
        );

        $res = $this->Modelo->setFormasCompra($data);

        if ($res) 
        {
            $formas = $this->input->post('formas');
            $formas = json_decode($formas, TRUE);
            array_push($formas, $data['forma']);
            echo json_encode($formas);
        } else {
            echo "";
        }
    }

    function getMetodosPago_ajax(){
        $res = $this->Modelo->getMetodosPago();
        if($res)
        {
            echo json_encode($res);
        }
        else
        {
            echo "";
        }
    }

    function setMetodosPago_ajax()
    {
        $data = array(
            'empresa' => $this->input->post('id_empresa'),
            'forma' => $this->input->post('metodo'),
        );

        $res = $this->Modelo->setMetodosPago($data);

        if ($res) 
        {
            $metodos = $this->input->post('metodos');
            $metodos = json_decode($metodos, TRUE);
            array_push($metodos, $data['forma']);
            echo json_encode($metodos);
        } else {
            echo "";
        }
    }*/

    function ajax_setListadoDocumentos(){
        $where['id'] = $this->input->post('id');
        $data['documentos_facturacion'] = $this->input->post('documentos');
        $data['codigo_impresion'] = strtoupper($this->input->post('codigo'));

        $this->Conexion->modificar('empresas', $data, null, $where);
        echo "1";
    }

    function ajax_setProveedor(){
        $this->output->enable_profiler(TRUE);
        $data = array(
            'empresa' => $this->input->post('id_empresa'),
            'aprobado' => $this->input->post('aprobado'),
            'clasificacion_proveedor' => $this->input->post('clasificacion_proveedor'),
            'tipo' => $this->input->post('tipo'),
            'credito' => $this->input->post('credito'),
            'monto_credito' => $this->input->post('monto_credito'),
            'moneda_credito' => $this->input->post('moneda_credito'),
            'terminos_pago' => $this->input->post('terminos_pago'),
            'tags' => "," . $this->input->post('tags') . ",",
            'formas_pago' => $this->input->post('formas_pago'),
            'formas_compra' => $this->input->post('formas_compra'),
            'entrega' => $this->input->post('entrega'),
            'pasos_cotizacion' => $this->input->post('pasos_cotizacion'),
            'pasos_compra' => $this->input->post('pasos_compra'),
            'rma_requerido' => $this->input->post('rma_requerido'),
        );

        $res = $this->Modelo->setProveedor($data);

        if ($res) 
        {
            echo "1";
        } else {
            echo "";
        }
    }

    function ajax_getClientes(){
        $texto = $this->input->post('texto');
        $query = "SELECT E.* from empresas E where E.nombre like '%".$texto."%'";

        $res = $this->Modelo->consulta($query);
        if($res)
        {
            echo json_encode($res);
        }
        else {
            echo "";
        }
    }

    function ajax_getProveedores(){
        $texto = $this->input->post('texto');
        $query = "SELECT E.* from empresas E inner join proveedores P on E.id = P.empresa where E.proveedor = 1 and (P.tags like '%,".$texto.",%' or E.nombre like '%".$texto."%');";

        $res = $this->Modelo->consulta($query);
        if($res)
        {
            echo json_encode($res);
        }
        else {
            echo "";
        }
    }

    function ajax_getProveedor(){
        $id = $this->input->post('id');
        $query = "SELECT P.*, E.nombre from proveedores P inner join empresas E on E.id = P.empresa where P.empresa = '" . $id . "'";
        $res = $this->Modelo->consulta($query, TRUE);
        if($res)
        {
            echo json_encode($res);
        }
        else {
            echo "";
        }
    }

    function ajax_getCiudades(){
        $query = "SELECT distinct ciudad from empresas";
        $res = $this->Modelo->consulta($query);
        if($res)
        {
            echo json_encode($res);
        }
        else {
            echo "";
        }
    }

    function ajax_setInfoCotizaciones(){
        $datos = json_decode($this->input->post('datos'));
        $datos->moneda_cotizacion = json_encode($datos->moneda_cotizacion);
        $datos->iva_cotizacion = json_encode($datos->iva_cotizacion);

        $this->Conexion->modificar('empresas', $datos, null, array('id' => $datos->id));
        echo "1";
    }

    function ajax_getContactosCotizacion(){
        $empresa = $this->input->post('empresa');
        $res = $this->Conexion->consultar("SELECT EC.*, ifnull(Pl.nombre,'NO DEFINIDO') as Planta from empresas_contactos EC left join empresa_plantas Pl on Pl.id = EC.planta where EC.empresa = '$empresa' and EC.cotizable = 1");
        echo json_encode($res);
    }

    function ajax_setPlanta(){
        $planta = json_decode($this->input->post('planta'));
        if($planta->id){
            $this->Conexion->modificar('empresa_plantas', $planta, null, array('id' => $planta->id));
        }
        else{
            $this->Conexion->insertar('empresa_plantas', $planta);
        }
    }

    function ajax_getPlantas(){
        $empresa = $this->input->post('empresa');

        $query = "SELECT * from empresa_plantas where empresa = $empresa";
        
        $res = $this->Conexion->consultar($query);
        if($res){
            echo json_encode($res);
        }
    }

    function ajax_deletePlanta(){
        $id = $this->input->post('id');
        $this->Conexion->eliminar('empresa_plantas', array('id' => $id));

    }

}
