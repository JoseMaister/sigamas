<!-- page content -->
<div class="right_col" role="main">
    <div class="">

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Solicitud de Factura</h2>
                        <button type='button' onclick="enviarSolicitud()" class='btn btn-success btn-md pull-right solicitud' id="btnEnviar"><i class='fa fa-send'></i> Enviar Solicitud</button>
                        <button style="display: none;" type='button' onclick="editarSolicitud()" class='btn btn-warning btn-md pull-right solicitud' id="btnEditar"><i class='fa fa-pencil'></i> Editar Solicitud</button>                        
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">

                            <!-- C L I E N T E -->
                            <div class="col-md-8 col-sm-8 col-xs-12">
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
                                                <label>Direccion:</label><p id="lblDireccionCliente"></p>
                                                <label>Horario para facturas:</label><p id="lblHorarioFacturas"></p>

                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <label>RFC:</label><p id="lblRFCCliente"></p>
                                                <label>Crédito:</label><p id="lblCreditoCliente"></p>
                                                <label>Ultimo dia para entregar factura:</label><p id="lblUltimoDiaFacturas"></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div id="pnlContacto" style="display: none; border: 0; margin-top: 0 px;" class="x_panel">
                                    <div class="x_title">
                                        <h3 style="display: inline;">Contacto</h3>
                                        <button type='button' onclick="buscarContactos()" id='btnContacto' class='btn btn-primary btn-xs pull-right solicitud'><i class='fa fa-plus'></i> Seleccionar</button>
                                        <div class="clearfix"></div>
                                    </div>
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
                                </div>

                                <div id="pnlFactura" style="display: none; border: 0; margin-top: 0 px;" class="x_panel">
                                    <div class="x_title">
                                        <h3 style="display: inline;">Factura</h3>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div id="divContacto" class="x_content">
                                        <div class="row">
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <label>Serie:</label><p id="lblSerie"></p>
                                            </div>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <label>Folio:</label><p id="lblFolio"></p>
                                            </div>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <label>Monto:</label><p id="lblMontoFactura"></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <!-- D A T O S -->
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div style="border: 0px;" class="x_panel">
                                    <div class="x_title">
                                        <h3 style="display: inline;">Datos</h3>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="x_content">
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <label style="display: block">Ejecutivo</label>
                                                <button id="btnRequisitor" type='button' onclick="buscarRequisitores()" data-id="<?= $this->session->id ?>" data-nombre="<?= $this->session->nombre ?>" class='btn btn-primary btn-xs'><i class='fa fa-user'></i> <?= $this->session->nombre ?></button>
                                            </div>
                                        </div>

                                        <div style="margin-top: 10px;" class="row">

                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <label># Orden de Compra</label>
                                                <input maxlength="15" id="txtOrdenCompra" type="text" class="form-control bloqueo">
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <label>Reporte de Servicio</label>
                                                <input maxlength="50" id="txtRS" type="text" class="form-control bloqueo">
                                            </div>
                                        </div>

                                        <div style="margin-top: 10px;" class="row">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <label>Notas</label>
                                                <textarea style="resize: none;" id="txtNotas" class="form-control bloqueo" ></textarea>
                                            </div>
                                        </div>

                                        <div style="margin-top: 10px;" class="row">
                                            <div class="col-md-5 col-sm-5 col-xs-12">
                                                <label style="display: block">Forma de Pago</label>
                                                <select id="optFormaPago" required="required" class="select2_single form-control">
                                                    <option value='N/A'>N/A</option>
                                                    <option value='CHEQUE'>CHEQUE</option>
                                                    <option value='EFECTIVO'>EFECTIVO</option>
                                                    <option value='TARJETA CREDITO'>TARJETA CREDITO</option>
                                                    <option value='TARJETA DEBITO'>TARJETA DEBITO</option>
                                                    <option value='TRANSFERENCIA'>TRANSFERENCIA</option>
                                                </select>
                                            </div>
                                            <div class="col-md-7 col-sm-7 col-xs-12">
                                                <div class="row">
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <label style="display: block">Factura Pagada</label>
                                                        <input id="cbPagada" type="checkbox" class="flat">
                                                    </div>

                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <label style="display: block">Urgente</label>
                                                        <input id="cbUrgente" type="checkbox" class="flat">
                                                    </div>
                                                </div>

                                                
                                            </div>
                                        </div>

                                        <div id="rowEstatus" style="display: none; margin-top: 30px;" class="row">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <center>
                                                    <label style="display: block">Estatus:</label>
                                                    <button onclick="bitacoraEstatus()" id="btnEstatus" type="button" class="btn"></button>
                                                </center>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>



                        </div>

                        <div class="row">

                            <!-- C O N C E P T O S   Y   C O M E N T A R I O S -->
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div style="border: 0;" class="x_panel">
                                            <div class="x_title">
                                                <h3 style="display: inline;">Conceptos de Facturación</h3>
                                                <button type='button' onclick="agregarConcepto(true)" class='btn btn-primary btn-xs pull-right solicitud'><i class='fa fa-plus'></i> Agregar</button>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="x_content">
                                                <div class="row">
                                                    <table id="tblConceptos" class="data table table-striped no-margin">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Tipo de Servicio</th>
                                                                <th>Partidas (0 = Todas)</th>
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

                                

                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div style="border: 0;" class="x_panel">
                                            <div class="x_title">
                                                <h3 style="display: inline;">Items RS</h3>
                                                
                                                <button type='button' onclick="mdlRS()" class='btn btn-primary btn-xs pull-right solicitud'><i class='fa fa-plus'></i> Agregar</button>
                                                
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="x_content">
                                                <div class="row">
                                                    <h4 class="pull-right" id="lblItemsCount"></h4>
                                                    <table id="tblConceptosRS" class="data table table-striped no-margin">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>RS</th>
                                                                <th>Item</th>
                                                                <th>Descripción</th>
                                                                <th>Precio</th>
                                                                <th>Opciones</th>
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

                            <!-- D O C U M E N T O S   Y   R E S P U E S T A-->
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div style="border: 0;" class="x_panel">
                                            <div class="x_title">
                                                <h3 style="display: inline;">Documentos</h3>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="x_content">
                                                <div class="row">
                                                    <table id="tblDocumentos" class="data table table-striped no-margin">
                                                        <thead>
                                                            <tr>
                                                                <th>Documento</th>
                                                                <th>Archivo</th>
                                                                <th style="width: 20%">Opciones</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            
                                                        </tbody>
                                                    </table>
                                                    <div id="divImprimir" style="display: none;">
                                                        <center>
                                                            <label>Código de Impresión</label>
                                                            <input maxlength="15" id="txtCodigoImpresion" style="text-transform: uppercase; width: 170px; display: inline-block; margin: 10px;" onkeypress="codigoImpresion(event, this)" class="form-control" type="text">
                                                            <button id="btnImprimir" class="btn btn-primary btn-sm" onclick="imprimir()" type="button"><i class="fa fa-print"></i> Imprimir</button>
                                                            <button id="btnCorreo" class="btn btn-primary btn-sm" onclick="mdlCorreo()" type="button"><i class="fa fa-envelope"></i> Enviar Correo</button>
                                                        </center>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="rowRespuesta" style="display: none;" class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div style="border: 0;" class="x_panel">
                                            <div class="x_title">
                                                <h3 style="display: inline;">Respuesta</h3>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="x_content">
                                                <div class="row">
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <center>
                                                            <button class="btn btn-danger" onclick="mdlRechazar()" type="button"><i class="fa fa-close"></i> Rechazar</button>
                                                        </center>
                                                    </div>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <center>
                                                            <button class="btn btn-success" onclick="enviarDoc()" type="button"><i class="fa fa-send"></i> Enviar Documentos</button>
                                                        </center>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="rowRespuestaDocs" style="display: none;" class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div style="border: 0;" class="x_panel">
                                            <div class="x_title">
                                                <h3 style="display: inline;">Respuesta</h3>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="x_content">
                                                <div class="row">
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <center>
                                                            <button class="btn btn-danger" onclick="mdlRechazarDocs()" type="button"><i class="fa fa-close"></i> Rechazar Documentos</button>
                                                        </center>
                                                    </div>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <center>
                                                            <button class="btn btn-success" onclick="aceptarDocs()" type="button"><i class="fa fa-check"></i> Aceptar Documentos</button>
                                                        </center>
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
                <h4 class="modal-title">Selecciona Ejecutivo</h4>
            </div>
            <div class="modal-body">
                <form>
                    <table id="tblRequisitor" class="data table table-striped no-margin">
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

<!-- MODAL RECHAZAR -->
<div id="mdlComentario" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 id='mdlComentarioTitle' class="modal-title">Rechazar Solicitud</h4>
            </div>
            <div class="modal-body">
                <form>
                    <label>Comentario</label>
                    <textarea style="height: 60px; resize: none;" id="txtComentarios" class="form-control"></textarea>
                </form>
            </div>
            <div class="modal-footer">
                <button id="btnCancelar" type="button" data-dismiss="modal" class="btn btn-default btn-sm pull-left"><i class="fa fa-close"></i> Cancelar</button>
                <button id="btnRechazar" type="button" onclick="rechazar()" class="btn btn-danger btn-sm"><i class='fa fa-times-circle'></i> Rechazar</button>
                <button id="btnComentario" type="button" onclick="agregarComentario()" class="btn btn-primary btn-sm"><i class='fa fa-times-comment'></i> Agregar</button>
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
                            <label id="lblDe">Para:</label><input id="tags_1" type="text" class="form-control"/>
                            <label style="margin-top: 5px;" id="lblPara">CC:</label><input id="tags_2" type="text" class="form-control" value="<?= $this->session->correo ?>" />
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
                        <!--
                            <div id="divConNombre"></div>
                            <div><br></div>
                            <div>Por este medio le estamos enviando la orden de compra <?= 'PO-' . str_pad($id, 6, "0", STR_PAD_LEFT) ?>. Favor de confirmar la recepción de la presente y su fecha de entrega.</div>
                            <div>Favor de contactarme si hay alguna duda o cambio respecto a la orden de compra.</div>
                            <div><br></div>
                            <div>Me despido quedando a la espera de sus comentarios.<br></div>
                            <div><br></div>
                            <div>We are sending you the attached purchase order <?= 'PO-' . str_pad($id, 6, "0", STR_PAD_LEFT) ?>. Please confirm receipt and date of delivery. Do not hesitate to contact me if there is any doubt or change regarding the purchase order.</div>
                            <div><br></div>
                            <div>Thank you for your attention and we wait your comments.</div>
                            <div><br></div>
                            <div><?= ucwords(strtolower($this->session->nombre)) ?> | Compras / Purchasing | Masmetrología</div>
                            <div><?= $this->session->correo ?></div>
                            <div><br></div>
                            <div><img src='<?= base_url('template/images/phone.png') ?>'/>  México (656)980-0807 / USA: (915) 201-4011</div>
                        -->
                        </div>

                        <div style="margin-top: 10px;">
                            Documentos Adjuntos: <br><br>
                            <p id="divAdjuntos" style="display: inline;">
                            </p>
                        </div>
                        
                    </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button onclick="" data-dismiss="modal" style="display: inline;" type="button" class="btn btn-default pull-left"><i class="fa fa-close"></i> Cancelar</button>
                <button onclick="enviarCorreo()" style="display: inline;" type="button" class="btn btn-primary"><i class="fa fa-send"></i> Enviar</button>
            </div>
            

        </div>
    </div>
</div>

<!-- MODAL RS -->
<div id="mdlRS" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Ingrese RS</h4>
            </div>
            <div class="modal-body">
                <form>
                    <!--
                    <div style="margin-bottom: 10px;">
                    <p style="display: inline;">
                        RS:
                        <input type="radio" class="flat" name="rbBusquedaRS" value="folio_id" checked />
                        ID Item:
                        <input type="radio" class="flat" name="rbBusquedaRS" value="item_id" />
                        ID Equipo:
                        <input type="radio" class="flat" name="rbBusquedaRS" value="Equipo_ID" />
                        Modelo:
                        <input type="radio" class="flat" name="rbBusquedaRS" value="Modelo" />
                        Serie:
                        <input type="radio" class="flat" name="rbBusquedaRS" value="Serie" />
                    </p>
                    </div>
                    -->
                    <h3 style="display: none;" id="lblRS"></h3>
                    <div class="input-group">
                        <input id="txtBuscarRS" type="text" class="form-control" placeholder="Buscar RS...">
                        <span class="input-group-btn">
                        <button onclick="buscarRS()" class="btn btn-default" type="button">Buscar</button>
                        </span>
                    </div>
                    <div id="divSelectTodo" style="display: none"><input id="iptTodo" type="checkbox" class="flat"> Seleccionar Todo</div>
                    <table class="data table table-striped no-margin">
                        <thead>
                            <tr>
                                <th>Selecc.</th>
                                <th>RS</th>
                                <th>Item</th>
                                <th>Descripción</th>
                                <th>Monto</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                </form>
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" style="display: inline;" type="button" class="btn btn-default pull-left"><i class="fa fa-close"></i> Cerrar</button>
                <button onclick="agregarRSItems()" type="button" class="btn btn-primary"><i class='fa fa-check'></i> Agregar</button>
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
<script src=<?= base_url("application/views/facturas/js/solicitud_facturas.js"); ?>></script>
<script>
    var ID = '<?= $id ?>';
    var UID = '<?= $this->session->id ?>';
    var RES = '<?= $this->session->privilegios['responder_facturas'] ?>';
    var EDIT = '<?= isset($editar) ? '1' : '0' ?>';

    $(function(){
        load();
    });

    
</script>
</body>
</html>
