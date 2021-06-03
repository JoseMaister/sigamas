<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Privilegios extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('privilegios_model');
        $this->load->model('conexion_model','Conexion');
    }

    function index() {
        //$this->output->enable_profiler(TRUE);
        $datos['privilegios'] = $this->privilegios_model->listadoPuestos();
        $this->load->view('header');
        $this->load->view('privilegios/roles', $datos);
    }

    public function administrar($id_privilegio) {
        $datos['privilegio'] = $this->privilegios_model->getPrivilegios($id_privilegio);
        $this->load->view('header');
        $this->load->view('cambiar_privilegios', $datos);
    }

    function agregar() {
      $ACIERTOS = array(); $ERRORES = array();

        $nombre_puesto = trim(strtoupper($this->input->post('puesto')));
        $datos = array('puesto' => $nombre_puesto);
        if($this->privilegios_model->agregarPuesto($datos))
        {
          $acierto = array('titulo' => $nombre_puesto, 'detalle' => 'Se han agregado Rol');
          array_push($ACIERTOS, $acierto);
        }
        else {
          $error = array('titulo' => 'ERROR', 'detalle' => 'Error al agregar Rol');
          array_push($ERRORES, $error);
        }

        $this->session->aciertos = $ACIERTOS;
        $this->session->errores = $ERRORES;
        redirect(base_url('privilegios'));
    }

    public function modificar() {
        $ACIERTOS = array(); $ERRORES = array();
        $aprobador_compras = $this->input->post('opAprobadorCompra');
        $aprobador_compras_venta = $this->input->post('opAprobadorCompra_venta');
        $aprobador_cotizacion = $this->input->post('opAprobadorCotizacion');
        $usuario = $this->input->post('usuario');


        //SET APROBADOR
        $query = "UPDATE usuarios set autorizador_compras = $aprobador_compras, autorizador_compras_venta = $aprobador_compras_venta, autorizador_cotizacion = $aprobador_cotizacion where id=$usuario";
        $this->Conexion->comando($query);


        $datos = array(
            'usuario' => $usuario,
            'administrar_usuarios' => filter_var($this->input->post('administrar_usuarios'), FILTER_VALIDATE_BOOLEAN),
            'administrar_empresas' => filter_var($this->input->post('administrar_empresas'), FILTER_VALIDATE_BOOLEAN),
            'generar_tickets' => filter_var($this->input->post('generar_tickets'), FILTER_VALIDATE_BOOLEAN),
            'tickets_it_soporte' => filter_var($this->input->post('tickets_it_soporte'), FILTER_VALIDATE_BOOLEAN),
            'tickets_at_soporte' => filter_var($this->input->post('tickets_at_soporte'), FILTER_VALIDATE_BOOLEAN),
            'tickets_ed_soporte' => filter_var($this->input->post('tickets_ed_soporte'), FILTER_VALIDATE_BOOLEAN),
            'crear_qr_interno' => filter_var($this->input->post('crear_qr_interno'), FILTER_VALIDATE_BOOLEAN),
            'crear_qr_venta' => filter_var($this->input->post('crear_qr_venta'), FILTER_VALIDATE_BOOLEAN),
            'editar_qr' => filter_var($this->input->post('editar_qr'), FILTER_VALIDATE_BOOLEAN),
            'revisar_qr' => filter_var($this->input->post('revisar_qr'), FILTER_VALIDATE_BOOLEAN),
            'liberar_qr' => filter_var($this->input->post('liberar_qr'), FILTER_VALIDATE_BOOLEAN),
            'cancelar_pr' => filter_var($this->input->post('cancelar_pr'), FILTER_VALIDATE_BOOLEAN),
            'aprobar_pr' => filter_var($this->input->post('aprobar_pr'), FILTER_VALIDATE_BOOLEAN),
            'aprobar_compra' => filter_var($this->input->post('aprobar_compra'), FILTER_VALIDATE_BOOLEAN),
            'qr_critico' => filter_var($this->input->post('qr_critico'), FILTER_VALIDATE_BOOLEAN),
            'retroceder_qr' => filter_var($this->input->post('retroceder_qr'), FILTER_VALIDATE_BOOLEAN),
            'retroceder_po' => filter_var($this->input->post('retroceder_po'), FILTER_VALIDATE_BOOLEAN),
            'administrar_servicios' => filter_var($this->input->post('administrar_servicios'), FILTER_VALIDATE_BOOLEAN),
            'evaluar_requerimientos' => filter_var($this->input->post('evaluar_requerimientos'), FILTER_VALIDATE_BOOLEAN),
            'asignar_recursos' => filter_var($this->input->post('asignar_recursos'), FILTER_VALIDATE_BOOLEAN),
            'gestionar_recursos' => filter_var($this->input->post('gestionar_recursos'), FILTER_VALIDATE_BOOLEAN),
            'solicitar_facturas' => filter_var($this->input->post('solicitar_facturas'), FILTER_VALIDATE_BOOLEAN),
            'responder_facturas' => filter_var($this->input->post('responder_facturas'), FILTER_VALIDATE_BOOLEAN),
            'documentacion_cliente' => filter_var($this->input->post('documentacion_cliente'), FILTER_VALIDATE_BOOLEAN),
            'documentacion_global' => filter_var($this->input->post('documentacion_global'), FILTER_VALIDATE_BOOLEAN),
            'bitacora_autos' => filter_var($this->input->post('bitacora_autos'), FILTER_VALIDATE_BOOLEAN),
            'generar_cotizaciones' => filter_var($this->input->post('generar_cotizaciones'), FILTER_VALIDATE_BOOLEAN),
            'administrar_cotizaciones' => filter_var($this->input->post('administrar_cotizaciones'), FILTER_VALIDATE_BOOLEAN),
            'aprobar_cotizacion' => filter_var($this->input->post('aprobar_cotizacion'), FILTER_VALIDATE_BOOLEAN),
            'compras_dashboard' => filter_var($this->input->post('compras_dashboard'), FILTER_VALIDATE_BOOLEAN),
            'administrar_equipos_it' => filter_var($this->input->post('administrar_equipos_it'), FILTER_VALIDATE_BOOLEAN),
            'mensajero' => filter_var($this->input->post('mensajero'), FILTER_VALIDATE_BOOLEAN),
            'administrar_parametros_cotizacion' => filter_var($this->input->post('administrar_parametros_cotizacion'), FILTER_VALIDATE_BOOLEAN),
            'administrar_empresas_facturacion' => filter_var($this->input->post('administrar_empresas_facturacion'), FILTER_VALIDATE_BOOLEAN),
            'administrar_empresas_logistica' => filter_var($this->input->post('administrar_empresas_logistica'), FILTER_VALIDATE_BOOLEAN),
            'administrar_empresas_proveedor' => filter_var($this->input->post('administrar_empresas_proveedor'), FILTER_VALIDATE_BOOLEAN),
            'editar_facturas' => filter_var($this->input->post('editar_facturas'), FILTER_VALIDATE_BOOLEAN),
            'autorizar_facturas' => filter_var($this->input->post('autorizar_facturas'), FILTER_VALIDATE_BOOLEAN),
            'enviar_facturas_logistica' => filter_var($this->input->post('enviar_facturas_logistica'), FILTER_VALIDATE_BOOLEAN),
        );

        if ($this->privilegios_model->setPrivilegios($datos, $usuario)) {
            if($this->session->id == $usuario)
            {
              $this->load->model('usuarios_model');
              $this->session->privilegios = $this->usuarios_model->getPrivilegios($this->session->id);
            }
            $acierto = array('titulo' => 'Privilegios', 'detalle' => 'Se han modificado Privilegios');
            array_push($ACIERTOS, $acierto);
        } else {
            $error = array('titulo' => 'ERROR', 'detalle' => 'Error al modificar Privilegios');
            array_push($ERRORES, $error);
        }
        $this->session->aciertos = $ACIERTOS;
        $this->session->errores = $ERRORES;
        redirect(base_url('usuarios/ver/'). $usuario);
    }

}
