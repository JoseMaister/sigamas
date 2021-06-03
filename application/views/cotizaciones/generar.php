<!-- page content -->
<div class="right_col" role="main">
    <div class="">

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2 id="frmTitulo">Generar Cotización</h2>
                        <button style="display: none;" type='button' onclick="mdlAutorizar(this)" class='btn btn-success btn-md pull-right' id="btnAutorizado"></button>
                        <button style="display: none;" type='button' onclick="cerrar()" class='btn btn-dark btn-md pull-right cierre'><i class='fa fa-check'></i> Cerrar</button>
                        <button style="display: none;" type='button' onclick="en_aprobacion()" class='btn btn-warning btn-md pull-right en_aprobacion'><i class='fa fa-clock-o'></i> En Aprobación</button>
                        <button style="display: none;" type='button' onclick="ver_pdf()" id="btnVerPDF" class='btn btn-primary btn-md pull-right pdf'><i class='fa fa-file-pdf-o'></i> Ver PDF Cotización</button>
                        <button style="display: none;" type='button' onclick="reactivarCotizacion()" class='btn btn-success btn-md pull-right activacion'><i class='fa fa-check'></i> Reactivar Cotización</button>

                        <div id="divCtrl">
                            <button style="display: none;" type='button' onclick="crearCotizacion()" class='btn btn-success btn-md pull-right creacion' id="btnEnviar"><i class='fa fa-send'></i> Crear Cotización</button>
                            <button style="display: none;" type='button' onclick="clonarCotizacion()" class='btn btn-default btn-md pull-right' id="btnClonar"><i class='fa fa-copy'></i> Clonar</button>
                            <button style="display: none;" type='button' id="btnSolAprob" data-toggle="modal" data-target="#mdlAprobacion" class='btn btn-success btn-md pull-right edicion'><i class='fa fa-clock-o'></i> Solicitar Autorización</button>
                            <button style="display: none;" type='button' onclick="guardarCotizacion()" class='btn btn-primary btn-md pull-right edicion'><i class='fa fa-save'></i> Guardar Cotización</button>

                            <button style="display: none;" onclick="mdlAprobar()" class='btn btn-success btn-md pull-right aprobacion'><i class='fa fa-check'></i> Autorizar Cotización</button>
                            <button style="display: none;" type='button' data-toggle="modal" data-target="#mdlRechazar" class='btn btn-danger btn-md pull-right aprobacion'><i class='fa fa-close'></i> Rechazar Cotización</button>

                            <button style="display: none;" type='button' data-toggle="modal" data-target="#mdlConfirmacion" class='btn btn-success btn-md pull-right confirmacion'><i class='fa fa-check'></i> Confirmación</button>
                            <!--<button style="display: none;" type='button' onclick="mdlCorreo()" class='btn btn-primary btn-md pull-right envio'><i class='fa fa-envelope'></i> Enviar Cotización</button>-->

                            <button style="display: none;" type='button' class='btn btn-primary btn-md pull-right capturaPO' onclick="mdlPONumbers()"><i class='fa fa-shopping-cart'></i> Captura # PO's</button>

                        </div>
                        <button style="display: none;" type='button' onclick="cancelar()" class='btn btn-default btn-md pull-right cancelacion'><i class='fa fa-close'></i> Cancelar</button>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">

                            <!-- C L I E N T E -->
                            <div class="col-md-7 col-sm-7 col-xs-12">
                                <div style="border: 0; margin-bottom: 0 px;" class="x_panel">
                                    <div class="x_title">
                                        <h3 style="display: inline;">Cliente</h3>
                                        <button type='button' onclick="mdlClientes()" id='btnClientes' class='btn btn-primary btn-xs pull-right solicitud'><i class='fa fa-plus'></i> Seleccionar</button>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div id="divCliente" style="display: none;" class="x_content">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <label>Razón Social:</label><p id="lblRazonSocialCliente"></p>
                                                <label>Dirección:</label><p id="lblDireccionCliente"></p>
                                                <label>Planta:</label><p id="lblPlantaCliente"></p>

                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <label>RFC:</label><p id="lblRFCCliente"></p>
                                                <label>Crédito:</label><p id="lblCreditoCliente"></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div id="pnlContacto" style="display: none; border: 0; margin-top: 0 px;" class="x_panel">
                                    <div class="x_title">
                                        <h3 style="display: inline;">Contactos</h3>
                                        <button type='button' onclick="buscarContactos()" id='btnContacto' class='btn btn-primary btn-xs pull-right solicitud'><i class='fa fa-plus'></i> Agregar</button>
                                        <div class="clearfix"></div>
                                    </div>

                                    <div id="divContacto" style="display: none;" class="x_content">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <table id="tablaContactos" class="data table table-striped no-margin">
                                                <thead>
                                                    <tr>
                                                        <th>Nombre</th>
                                                        <th>Teléfono</th>
                                                        <th>Correo</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    </div>
                                    
                                    <!--
                                    <div id="divContacto" style="display: none;" class="x_content">
                                        <div class="row">
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <label>Nombre:</label><p id="lblNombreContacto"></p>
                                            </div>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <label>Teléfono:</label><p id="lblTelefonoContacto"></p>
                                            </div>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <label>Correo:</label><p id="lblCorreoContacto"></p>
                                            </div>
                                        </div>
                                    </div>
                                    -->
                                </div>

                            </div>

                            <!-- D A T O S -->
                            <div id="pnlDatos" style="display: none;" class="col-md-5 col-sm-5 col-xs-12">
                                <div style="border: 0px;" class="x_panel">
                                    <div class="x_title">
                                        <h3 style="display: inline;">Datos</h3>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="x_content">
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <label style="display: block">Responsable</label>
                                                <button id="btnRequisitor" type='button' onclick="buscarAutores()" data-id="<?= $this->session->id ?>" data-nombre="<?= $this->session->nombre ?>" class='btn btn-primary btn-xs edicion'><i class='fa fa-user'></i> <?= $this->session->nombre ?></button>
                                            </div>
                                        </div>

                                        <div style="margin-top: 10px;" class="row">

                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <label>Moneda</label>
                                                <select id="opMoneda" class="form-control solicitud">
                                                </select>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <label>IVA</label>
                                                <select id="opIVA" class="form-control solicitud">
                                                    <option data-nombre='Exento (0.00%)' value='0.00'>Exento (0.00%)</option>
                                                    <option data-nombre='Frontera (16.00%)' value='0.16'>Frontera (16.00%)</option>
                                                    <option data-nombre='IVA 8% (8.00%)' value='0.08'>IVA 8% (8.00%)</option>
                                                    <option data-nombre='Interior (16.00%)' value='0.16'>Interior (16.00%)</option>
                                                    <option data-nombre='Texas (8.25%)' value='0.0825'>Texas (8.25%)</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div style="margin-top: 10px;" class="row">

                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <label>Tipo de Cotización</label>
                                                <select disabled id="opTipo" class="form-control tipo">
                                                    <option value="CALIBRACION">CALIBRACIÓN</option>
                                                    <option value="ESTUDIO DIMENSIONAL">ESTUDIO DIMENSIONAL</option>
                                                    <option value="RENTA">RENTA</option>
                                                    <option value="REPARACION">REPARACIÓN</option>
                                                    <option value="VENTA">VENTA</option>
                                                    <option value="SOPORTE">SOPORTE</option>
                                                    <option value="CALIBRACION EXTERNA">CALIBRACIÓN EXTERNA</option>
                                                    <option value="MAPEO">MAPEO</option>
                                                    <option value="LISTA PRECIOS">LISTA PRECIOS</option>
                                                </select>
                                            </div>

                                            <div id="divTipoCambio" style="display: none;" class="col-md-6 col-sm-6 col-xs-12">
                                                <label>Tipo de Cambio</label>
                                                <button style="display: block;" type='button' id="btnTipoCambio" onclick="mdlTipoCambio(this)" value=<?= $USD ?> class='btn btn-success btn-sm bloqueo'><?= $USD ?></button>
                                            </div>
                                        </div>


                                        <div style="margin-top: 10px;" class="row">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <label>Notas</label>
                                                <textarea style="resize: none;" id="txtNotas" class="form-control" readonly></textarea>
                                            </div>
                                        </div>

                                        <div id="rowEstatus" style="display: none; margin-top: 10px;" class="row">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <center>
                                                    <label style="display: block">Estatus:</label>
                                                    <button onclick="bitacoraEstatus()" id="btnEstatus" type="button" class="btn"></button>
                                                    <label style="display: block" id="lblConfirmacion"></label>
                                                </center>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row">

                            <!-- C O N C E P T O S   Y   C O M E N T A R I O S -->
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div id="pnlConceptos" style="display: none;" class="col-md-12 col-sm-12 col-xs-12">
                                    <div style="border: 0;" class="x_panel">
                                        <div class="x_title">
                                            <h3 style="display: inline;" id="lblPnlConceptos">Conceptos</h3>
                                            <button type='button' style='display: none;' onclick="cancelarRevision()" id="btnCancelarRevision" class='btn btn-danger btn-xs pull-right'><i class='fa fa-close'></i> Cancelar Revisión</button>
                                            <button type='button' style='display: none;' onclick="crearRevision()" id="btnGuardarRevision" class='btn btn-success btn-xs pull-right'><i class='fa fa-save'></i> Guardar Revisión</button>
                                            <button type='button' onclick="mdlAgregarConcepto()" id="btnAgregarPartidas" class='btn btn-primary btn-xs pull-right ctrlEdicion'><i class='fa fa-plus'></i> Agregar Partida</button>
                                            
                                            <button type='button' style="display: none;" onclick="mdlCorreo()" class='btn btn-success btn-xs pull-right pnlBtnControl'><i class='fa fa-envelope'></i> Enviar Cotización</button>
                                            <button type='button' style="display: none;" onclick="ver_pdf()" class='btn btn-success btn-xs pull-right pnlBtnControl'><i class='fa fa-file-pdf-o'></i> Ver PDF</button>
                                            <button type='button' style="display: none;" onclick="nuevaRevision()" class='btn btn-primary btn-xs pull-right revision'><i class='fa fa-plus'></i> Nueva Revisón</button>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content">
                                            <div class="row">
                                                <table id="tblConceptos" class="data table table-striped no-margin">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th style="width: 6%">Cant.</th>
                                                            <th style="width: 30%">Concepto</th>
                                                            <th style="width: 6%">Servicio</th>
                                                            <th>Comentarios</th>
                                                            <th style="width: 8%">Servicio a Realizarse</th>
                                                            <th style="width: 6%">T. Entrega</th>
                                                            <th style="width: 7%">Precio Unitario</th>
                                                            <th style="width: 4%"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div id="rowComentarios" style="display: none;" class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div style="border: 0;" class="x_panel">
                                            <div class="x_title">
                                                <h3 style="display: inline;">Comentarios</h3>
                                                <button type='button' onclick="mdlComentario()" class='btn btn-primary btn-xs pull-right'><i class='fa fa-comments'></i> Agregar</button>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="x_content">
                                                <ul id='ulComments' class="list-unstyled msg_list">
                                                <ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            


                        </div>

                        

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- /page content -->


<!-- MODAL CLIENTES -->
<div id="mdlClientes" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Buscar Cliente</h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="input-group">
                        <input id="txtBuscarCliente" type="text" class="form-control" placeholder="Buscar Cliente...">
                        <span class="input-group-btn">
                            <button onclick="buscarCliente()" class="btn btn-default" type="button">Buscar</button>
                        </span>
                    </div>
                    <table id="tblClientes" class="data table table-striped no-margin">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th style="width: 20%">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                </form>
            </div>

        </div>
    </div>
</div>

<!-- MODAL PLANTAS -->
<div id="mdlPlanta" class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Seleccione Planta</h4>
            </div>
            <div class="modal-body">
                <form>
                    <table id="tblPlantas" class="table table-striped no-margin">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th style="width: 20%">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                </form>
            </div>

        </div>
    </div>
</div>

<!-- MODAL CONTACTO -->
<div id="mdlContactos" class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Seleccionar Contacto</h4>
            </div>
            <div class="modal-body">
                <form>
                    <table id="tblContactos" class="data table table-striped no-margin">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Puesto</th>
                                <th style="width: 20%">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                </form>
            </div>

        </div>
    </div>
</div>

<!-- MODAL REQUISITOR -->
<div id="mdlRequisitor" class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Seleccionar Responsable</h4>
            </div>
            <div class="modal-body">
                <form>
                    <table id="tblAutores" class="data table table-striped no-margin">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Puesto</th>
                                <th style="width: 20%">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                </form>
            </div>

        </div>
    </div>
</div>

<!-- MODAL TIPO DE CAMBIO -->
<div id="mdlTipoCambio" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="mdlTitulo">Tipo de Cambio</h4>
            </div>
            <div class="modal-body">
            <form>

                
                <div class="item form-group">
                    <div class="col-xs-offset-3 col-xs-6">
                    <center>
                        <label>Tipo de Cambio</label>
                        <input min="1" style="text-align: right;" id="txtTipoCambio" type="number" class="form-control" /><br>
                        <p>USD: $<?= number_format((float)$USD, 4, '.', '') . " <small>(Act. " . date("m/d h:i a", strtotime($USD_ACT)) . ") </small>" ?></p>
                    </center>
                    </div>
                </div>
            </form>
            </div>
            <div class="modal-footer">
                <button id="btnCancelar" type="button" data-dismiss="modal" class="btn btn-default pull-left"><i class="fa fa-close"></i> Cancelar</button>
                <button id="btnGuardarTipoCambio" type="button" onclick="setTipoCambio(this)" class="btn btn-primary"><i class='fa fa-check'></i> Aceptar</button>
            </div>
            

        </div>
    </div>
</div>

<!-- MODAL CONCEPTO -->
<div id="mdlConcepto" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Agregar Concepto</h4>
            </div>
            <div class="modal-body">
                <form>
                    

                    <div class="row">

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <p style="display: block;">
                            <!--
                                <div id="divrbIdEquipo" style="display: inline;" class="divRb">
                                    ID Equipo:
                                    <input type="radio" class="flat" name="rbBusquedaConcepto" id="rbIdEquipo" value="id_equipo" disabled>
                                </div>
                            -->
                                <div id="divrbIdEquipo" style="display: inline;" class="divRb">
                                    ID Equipo:
                                    <input type="radio" class="flat" name="rbBusquedaConcepto" id="rbIdEquipo" value="id_equipo">
                                </div>
                                <div id="divrbMarMod" style="display: inline;" class="divRb">
                                    Marca / Modelo:
                                    <input type="radio" class="flat" name="rbBusquedaConcepto" id="rbMarMod" value="marca_modelo">
                                </div>
                                <div id="divrbManual" style="display: inline;" class="divRb">
                                    Ingreso Manual:
                                    <input type="radio" class="flat" name="rbBusquedaConcepto" id="rbManual" value="manual">
                                </div>
                                <div id="divrbConcepto" style="display: inline;" class="divRb">
                                    Concepto:
                                    <input type="radio" class="flat" name="rbBusquedaConcepto" id="rbConcepto" value="concepto">
                                </div>
                                <div id="divrbOtro" style="display: inline;" class="divRb">
                                    Otros:
                                    <input type="radio" class="flat" name="rbBusquedaConcepto" id="rbOtro" value="otro">
                                </div>
                            </p>

                            <div id="divOtro" data-id="0" style="display: none; margin-top: 15px;" class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div style="display: inline;">
                                        Cabezal:
                                        <input type="radio" class="flat" name="rbOtros" value="cabezal">
                                    </div>
                                    <div style="display: inline;">
                                        Separador:
                                        <input type="radio" class="flat" name="rbOtros" value="separador">
                                    </div>
                                </div>
                            </div>

                            <div id="divrbControls" style="display: inline;" class="divRb">
                                <input id="txtBusqueda1" class="form-control" placeholder="ID Equipo" style="width: 25%; display: inline; margin-top: 15px; margin-right: 10px;" type="text">
                                <input id="txtBusqueda2" class="form-control" style="width: 25%; display: inline; margin-right: 10px;" type="text">
                                <button onclick="buscarEquipo()" id="btnBuscarConcepto" style="display: inline;" class="btn btn-success" type="button"><i class="fa fa-search"></i> Buscar</button>
                            </div>
                        </div>

                        


                    </div>

                    <div id="divEquipo" data-id="0" style="display: none; margin-top: 15px;" class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <h4><u>Equipo</u></h4>
                            <table id="tblEquipos" class="data table table-striped no-margin">
                                <thead>
                                    <tr>
                                        <th style="width: 15%;">ID Equipo</th>
                                        <th>Descripción</th>
                                        <th>Marca</th>
                                        <th>Modelo</th>
                                        <th style="width: 15%;">Serie</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div id="divServicio" data-id="0" style="display: none;" class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <h4 style="display: inline;"><u>Servicio: </u></h4>
                            <select style="margin-left: 10px; width:100px; display: inline;" id="opSitio" class="form-control">
                            </select>
                            <button type='button' id='btnServicioCatalogo' onclick="mdlServicios()" class='btn btn-primary btn-xs pull-right'><i class='fa fa-plus'></i> Catalogo</button>
                            <button type='button' id='btnServicioManual' onclick="agregarServicioManual()" class='btn btn-primary btn-xs pull-right'><i class='fa fa-plus'></i> Manual</button>
                            <table id="tblServicio" class="data table table-striped no-margin">
                                <thead>
                                    <tr>
                                        <th style="width: 15%;">Código</th>
                                        <th>Descripción</th>
                                        <th style="width: 12%;">Precio</th>
                                        <th style="width: 6%;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div id="divConcepto" data-id="0" style="display: none; margin-top: 15px;" class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <h4 style="display: inline;"><u>Concepto: </u></h4>
                            <select style="margin-left: 10px; width:100px; display: inline;" id="opSitioConcepto" class="form-control">
                                <option value="N/A">N/A</option>
                                <option value="OS">OS</option>
                                <option value="LAB">LAB</option>
                            </select>
                            <table id="tblConcepto" class="data table table-striped no-margin">
                                <thead>
                                    <tr>
                                        <th>Descripción</th>
                                        <th style="width: 15%;">Precio</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default btn-sm pull-left"><i class="fa fa-close"></i> Cancelar</button>
                <button type="button" onclick="limpiarBusquedaEquipo()" class="btn btn-warning btn-sm pull-left"><i class="fa fa-trash-o"></i> Limpiar</button>
                <button id="btnAgregarConcepto" type="button" onclick="validacionAgregarConcepto()" class="btn btn-primary btn-sm"><i class='fa fa-check'></i> Agregar</button>
            </div>
            

        </div>
    </div>
</div>

<!-- MODAL VER SERVICIO -->
<div id="mdlVerServicio" class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="mdlVerServicio_title">Servicios Asignados</h4>
            </div>
            <div class="modal-body">
            <form>
                <table id="tblMdlServicios" class="table table-striped">
                    <thead>
                        <tr class="headings">
                            <th class="column-title">Código</th>
                            <th class="column-title">Descripción</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </form>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default pull-left"><i class="fa fa-close"></i> Cerrar</button>
            </div>
            

        </div>
    </div>
</div>

<div id="mdlServicios" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title" id="mdlServicios-titulo">Servicios</h4>
            </div>
            <div class="modal-body">
            <label>Buscar</label>
            <input id="txtBuscarServicio" class="form-control" type="text">
            <form>
                <table id="tblServicios" class="table table-striped">
                    <thead>
                        <tr class="headings">
                            <th class="column-title">Código</th>
                            <th class="column-title">Descripción</th>
                            <th class="column-title">Sitio</th>
                            <th class="column-title">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </form>
            </div>
        </div>
    </div>
</div>

<!-- MODAL SOLICITAR AUTORIZACION -->
<div id="mdlAprobacion" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 id='mdlComentarioTitle' class="modal-title">Solicitar Autorización</h4>
            </div>
            <div class="modal-body">
                <form>
                    <label>Comentarios</label>
                    <textarea style="height: 60px; resize: none;" id="txtComentariosAprobacion" class="form-control"></textarea>
                    <p style="margin-top: 8px">
                        Enviar al autorizar:
                        <input type="checkbox" id="cbEnviarAutorizar" class="flat"/>
                    </p>
                </form>
            </div>
            <div class="modal-footer">
                <button id="btnCancelar" type="button" data-dismiss="modal" class="btn btn-default btn-sm pull-left"><i class="fa fa-close"></i> Cancelar</button>
                <button id="btnComentario" type="button" onclick="solicitarAprobacion(this)" class="btn btn-success btn-sm"><i class='fa fa-clock-o'></i> Solicitar Autorización</button>
            </div>
            

        </div>
    </div>
</div>

<!-- MODAL AUTORIZACION -->
<div id="mdlAtorizacion" class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Autorización</h4>
            </div>
            <div class="modal-body">
                <form>
                    <label>Comentarios</label>
                    <textarea style="height: 60px; resize: none;" id="txtComentariosAutorizacion" class="form-control"></textarea>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default btn-sm pull-left"><i class="fa fa-close"></i> Cancelar</button>
                <button type="button" onclick="autorizar()" class="btn btn-success btn-sm"><i class='fa fa-check'></i> Aprobar</button>
            </div>
            

        </div>
    </div>
</div>

<!-- MODAL APROBACION -->
<div id="mdlAprobar" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 id='mdlComentarioTitle' class="modal-title">Autorizar Cotización</h4>
            </div>
            <div class="modal-body">
                <form>
                    <label>Comentarios</label>
                    <textarea style="height: 60px; resize: none;" id="txtComentariosAprobar" class="form-control"></textarea>
                    <p style="display: none;" id="txtEnviarAprobar" style="margin-top: 8px">
                        El usuario solicitó enviar cotización al autorizar
                    </p>
                </form>
            </div>
            <div class="modal-footer">
                <button id="btnCancelar" type="button" data-dismiss="modal" class="btn btn-default btn-sm pull-left"><i class="fa fa-close"></i> Cancelar</button>
                <button id="btnAprobar" type="button" onclick="aprobarCotizacion(this)" class="btn btn-success btn-sm"><i class='fa fa-check'></i> Autorizar</button>
            </div>
            

        </div>
    </div>
</div>

<!-- MODAL RECHAZAR -->
<div id="mdlRechazar" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 id='mdlComentarioTitle' class="modal-title">Rechazar Cotización</h4>
            </div>
            <div class="modal-body">
                <form>
                    <label>Comentario</label>
                    <textarea style="height: 60px; resize: none;" id="txtComentariosRechazar" class="form-control"></textarea>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default btn-sm pull-left"><i class="fa fa-close"></i> Cancelar</button>
                <button type="button" onclick="rechazarCotizacion(this)" class="btn btn-danger btn-sm"><i class='fa fa-times-circle'></i> Rechazar</button>
            </div>
            

        </div>
    </div>
</div>

<!-- MODAL CONFIRMACION -->
<div id="mdlConfirmacion" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 id='mdlComentarioTitle' class="modal-title">Medio de Confirmación</h4>
            </div>
            <div class="modal-body">
                <form>
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <td width="5%"><input type="radio" class="flat" name="rbConfirmacion" value="CORREO"></td>
                                <td><i class='fa fa-envelope'></i> Correo</td>
                            </tr>
                            <tr>
                                <td><input type="radio" class="flat" name="rbConfirmacion" value="TELEFONO"></td>
                                <td><i class='fa fa-phone'></i> Teléfono</td>
                            </tr>
                            <tr>
                                <td><input type="radio" class="flat" name="rbConfirmacion" value="WHATSAPP"></td>
                                <td><i class='fa fa-whatsapp'></i> WhatsApp</td>
                            </tr>
                            <tr>
                                <td><input type="radio" class="flat" name="rbConfirmacion" value="MOSTRADOR"></td>
                                <td><i class='fa fa-building'></i> Mostrador</td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default btn-sm pull-left"><i class="fa fa-close"></i> Cancelar</button>
                <button type="button" onclick="confirmarCotizacion()" class="btn btn-success btn-sm"><i class='fa fa-check'></i> Aceptar</button>
            </div>
            

        </div>
    </div>
</div>

<!-- MODAL COMENTARIOS -->
<div id="mdlComentario" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 id='mdlComentarioTitle' class="modal-title">Agregar Comentario</h4>
            </div>
            <div class="modal-body">
                <form>
                    <label>Comentario</label>
                    <textarea style="height: 60px; resize: none;" id="txtComentarios" class="form-control"></textarea>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default btn-sm pull-left"><i class="fa fa-close"></i> Cancelar</button>
                <button type="button" onclick="agregarComentario()" class="btn btn-primary btn-sm"><i class='fa fa-comment'></i> Agregar</button>
            </div>
            

        </div>
    </div>
</div>

<!-- MODAL CORREO -->
<div id="mdlCorreo" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel2"><i class='fa fa-file-pdf-o'></i> Enviar Correo</h4>
            </div>

            <div class="modal-body">
                <form>
                        <div style="margin-left:15px;">
                            <label>Asunto:</label><input id="txtAsunto" type="text" class="form-control" value="Cotización de Servicios"/>
                            <label style="margin-top: 5px;">Para:</label><input id="tags_1" type="text" class="form-control"/>
                            <label style="margin-top: 5px;">CC:</label><input id="tags_2" type="text" class="form-control" />
                        </div>
                        <div class="item form-group">
                            <div class="col-xs-12">
                            <div id="alerts"></div>
                            <div class="btn-toolbar editor" data-role="editor-toolbar" data-target="#editor-one">
                  

                        <div class="btn-group">
                        <a class="btn dropdown-toggle" data-toggle="dropdown" title="Tamaño de fuente"><i class="fa fa-text-height"></i>&nbsp;<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                            <a data-edit="fontSize 5">
                                <p style="font-size:17px">Grande</p>
                            </a>
                            </li>
                            <li>
                            <a data-edit="fontSize 3">
                                <p style="font-size:14px">Normal</p>
                            </a>
                            </li>
                            <li>
                            <a data-edit="fontSize 1">
                                <p style="font-size:11px">Pequeña</p>
                            </a>
                            </li>
                        </ul>
                        </div>

                        <div class="btn-group">
                        <a class="btn" data-edit="bold" title="Negrita"><i class="fa fa-bold"></i></a>
                        <a class="btn" data-edit="italic" title="Itálico"><i class="fa fa-italic"></i></a>
                        <a class="btn" data-edit="strikethrough" title="Tachado"><i class="fa fa-strikethrough"></i></a>
                        <a class="btn" data-edit="underline" title="Subrayado"><i class="fa fa-underline"></i></a>
                        </div>

                        <div class="btn-group">
                        <a class="btn" data-edit="justifyleft" title="Alineado a la izquierda"><i class="fa fa-align-left"></i></a>
                        <a class="btn" data-edit="justifycenter" title="Alineado al centro"><i class="fa fa-align-center"></i></a>
                        <a class="btn" data-edit="justifyright" title="Alineado a la derecha"><i class="fa fa-align-right"></i></a>
                        <a class="btn" data-edit="justifyfull" title="Justificado"><i class="fa fa-align-justify"></i></a>
                        </div>



                    </div>

                        <div id="editor-one" class="editor-wrapper">
                        </div>
                        
                    </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button data-dismiss="modal" style="display: inline;" type="button" class="btn btn-default pull-left"><i class="fa fa-close"></i> Cancelar</button>
                <button onclick="enviarCorreo()" style="display: inline;" type="button" class="btn btn-primary"><i class="fa fa-send"></i> Enviar</button>
            </div>
            

        </div>
    </div>
</div>

<!-- MODAL CIERRE -->
<div id="mdlPONumbers" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Capturar # PO</h4>
            </div>
            <div class="modal-body">
                <form>
                    <table id="tblPONumbers" class="table table-striped">
                        <thead>
                            <tr class="headings">
                                <th class="column-title">Cant.</th>
                                <th width="50%" class="column-title">Concepto</th>
                                <th class="column-title">Donde</th>
                                <th width="25%" class="column-title"># PO</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </form>
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" type="button" class="btn btn-default pull-left"><i class="fa fa-close"></i> Cerrar</button>
                <button onclick="guardarPONumbers()" id="btnGuardarPONumbers" type="button" class="btn btn-primary"><i class="fa fa-save"></i> Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL BITACORA ESTATUS -->
<div id="mdlBitacora" class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Bitacora de Estatus</h4>
            </div>
            <div class="modal-body">
                <form>
                <table id="tblBitacora" class="data table table-striped no-margin">
                    <thead>
                        <tr>
                            <th>Estatus</th>
                            <th>Fecha</th>
                            <th>Usuario</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default btn-sm"><i class="fa fa-close"></i> Cerrar</button>
            </div>
            

        </div>
    </div>
</div>




<!-- footer content -->
<footer>
    <div class="pull-right">
        Equipo de Desarrollo | MAS Metrología
    </div>
    <div class="clearfix"></div>
</footer>
<!-- /footer content -->
</div>
</div>

<!-- jQuery -->
<script src=<?= base_url("template/vendors/jquery/dist/jquery.min.js"); ?>></script>
<!-- Bootstrap -->
<script src=<?= base_url("template/vendors/bootstrap/dist/js/bootstrap.min.js"); ?>></script>
<!-- PNotify -->
<script src=<?= base_url("template/vendors/pnotify/dist/pnotify.js"); ?>></script>
<script src=<?= base_url("template/vendors/pnotify/dist/pnotify.buttons.js"); ?>></script>
<script src=<?= base_url("template/vendors/pnotify/dist/pnotify.nonblock.js"); ?>></script>
<!-- iCheck -->
<script src=<?= base_url("template/vendors/iCheck/icheck.min.js"); ?>></script>
<!-- formatCurrency -->
<script src=<?= base_url("template/vendors/formatCurrency/jquery.formatCurrency-1.4.0.js"); ?>></script>
<!-- Custom Theme Scripts -->
<script src=<?= base_url("template/build/js/custom.js"); ?>></script>
<!-- bootstrap-wysiwyg -->
<script src=<?=base_url("template/vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js"); ?>></script>
<script src=<?=base_url("template/vendors/jquery.hotkeys/jquery.hotkeys.js"); ?>></script>
<script src=<?=base_url("template/vendors/google-code-prettify/src/prettify.js"); ?>></script>
<!-- jQuery Tags Input -->
<script src=<?= base_url("template/vendors/jquery.tagsinput/src/jquery.tagsinput.js") ?>></script>
<!-- jquery.redirect -->
<script src=<?= base_url("template/vendors/jquery.redirect/jquery.redirect.js"); ?>></script>
<!-- CUSTOM JS FILE -->
<script src=<?=base_url("template/js/custom/funciones.js"); ?>></script>
<!-- JS FILE -->
<script src=<?= base_url("application/views/cotizaciones/js/generar.js"); ?>></script>
<script>
    const USD = parseFloat('<?= $USD ?>');
    var ID = '<?= $id ?>';
    const UID = '<?= $this->session->id ?>';
    const RES = '<?= $this->session->privilegios['responder_facturas'] ?>';
    const COPY = '<?= $COPY ?>';
    const EDIT = '<?= isset($editar) ? '1' : '0' ?>';

    $(function(){
        load();
    });

    
</script>
</body>
</html>
