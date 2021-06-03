<!-- page content -->
<div class="right_col" role="main">
    <div class="">

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Catalogo de Facturas</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">

                            <div class="col-md-12 col-sm-12 col-xs-12">

                                <p style="display: inline;">
                                    XXXX:
                                    <input type="radio" class="flat" name="rbBusqueda" id="rbCodigo" value="codigo" checked />
                                    XXXX:
                                    <input type="radio" class="flat" name="rbBusqueda" id="rbContenido" value="contenido" />
                                </p>

                                <input id="txtBusqueda" style="display: inline;" type="text">



                                <button onclick="buscar()" style="display: inline;" class="btn btn-success" type="button"><i class="fa fa-search"></i> Buscar</button>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_content">
                        <div class="table-responsive">
                            <table style="margin-bottom:60px;" id="tabla" class="table table-striped">
                                <thead>
                                    <tr class="headings">
                                        <th class="column-title">#</th>
                                        <th class="column-title">Ejecutivo</th>
                                        <th class="column-title">Cliente</th>
                                        <th class="column-title">Orden de Compra</th>
                                        <th class="column-title">Reporte de Servicio</th>
                                        <th class="column-title">Estatus</th>
                                        <th class="column-title">Recorridos</th>
                                        <th class="column-title">Envíos</th>
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


    </div>
</div>
<!-- /page content -->





<!-- MODALS -->
<div id="mdlEnviar" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
            <center>
                <button type="button" class="btn btn-primary" onclick="mdlCorreo()"><i class="fa fa-envelope"></i> Correo</button>
                <button type="button" class="btn btn-success" onclick="enviarLogistica()"><i class="fa fa-truck"></i> Logística</button>
            </center>
            </div>
            <div class="modal-footer">
                
            </div>
            

        </div>
    </div>
</div>

<div id="mdlRecorridos" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Recorridos</h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="table-responsive">
                                <table id="tblRecorridos" class="table table-striped">
                                    <thead>
                                        <tr class="headings">
                                            <th class="column-title">Recorrido</th>
                                            <th class="column-title">Cliente</th>
                                            <th class="column-title">Acción</th>
                                            <th class="column-title">Mensajero</th>
                                            <th class="column-title">Estatus</th>
                                            <th class="column-title">Reporte de Recorrido</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<div id="mdlEnvios" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Envios de Correo</h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="table-responsive">
                                <table id="tblEnvios" class="table table-striped">
                                    <thead>
                                        <tr class="headings">
                                            <th class="column-title">Fecha</th>
                                            <th class="column-title">Usuario</th>
                                            <th class="column-title">Estatus</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<div id="mdlDetalleEnvios" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Envios de Correo</h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div>
                                <p style="display: inline; margin-right: 10px;">
                                    <label>Estatus:</label>
                                </p>
                                <select onchange="cambiarEstatusEnvio()" id="cbEstatusEnvio" style="display: inline; width: 25%; margin-right: 10px;" required="required" class="select2_single form-control" id="opEstatus">
                                    <option value="ENVIADA">ENVIADA</option>
                                    <option value="RESPONDIDO">RESPONDIDO</option>
                            </select>
                            </div>

                            <br>
                            <div>
                                
                                <p style="margin-bottom: 5px;">
                                    <label>Comentarios:</label>
                                </p>
                                <textarea id="txtEnvioComentario" style="resize: none; width: 35%"></textarea>
                                <p style="margin-top: 5px;">
                                    <button class="btn btn-xs btn-primary" onclick="agregarComentarioEnvio()" type="button"><i class='fa fa-comments'></i> Agregar Comentario</button>
                                </p>
                            
                            </div>



                            <ul id='ulComments' class="list-unstyled msg_list">

                            <ul>

                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<div id="mdlReporte" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Reporte de Recorrido</h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <label>Fecha:</label> <div id="lblRecorridoFecha" style="display: inline;"></div><br>
                            <label>Cliente:</label> <div id="lblCliente" style="display: inline;"></div><br>
                            <label>Contacto:</label> <div id="lblContacto" style="display: inline;"></div><br>
                            <label>Acción:</label> <div id="lblAccion" style="display: inline;"></div><br>
                            <label>Resultado:</label> <div id="lblResultado" style="display: inline;"></div><br><br>


                            <div id="divFirma">
                                <label>Firma:</label>
                                <center>
                                    <img id="imgFirma" style="width: 70%; border: solid;">
                                </center>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="table-responsive">
                                <table id="tblFacturasReporte" class="table table-striped">
                                    <thead>
                                        <tr class="headings">
                                            <th class="column-title">#</th>
                                            <th class="column-title">Factura</th>
                                            <th class="column-title">Ejecutivo</th>
                                            <th class="column-title"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>   
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <ul id='ulComments' class="list-unstyled msg_list">
                            <ul>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="display: none;">
                <button type="button" id="btnCancelar" class="btn btn-default pull-left" data-dismiss="modal"><i class='fa fa-close'></i> Cancelar</button>
                <button type="button" id="btn2" onclick="marcarComo(this)" value="NO ENTREGADO" class="btn btn-danger"><i class='fa fa-close'></i> No Entregado</button>
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
                            <label id="lblDe">Para:</label><div id="divTags_1"><input id="tags_1" type="text" class="form-control"/></div>
                            <label style="margin-top: 5px;" id="lblPara">CC:</label><div id="divTags_2"><input id="tags_2" type="text" class="form-control"/></div>
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
                <div style="margin-top: 10px;">
                    Documentos Adjuntos: <br><br>
                    <p id="divAdjuntos" style="display: inline;">
                    </p>
                </div>
            </div>

            <div class="modal-footer">
                <button onclick="" data-dismiss="modal" style="display: inline;" type="button" class="btn btn-default pull-left"><i class="fa fa-close"></i> Cancelar</button>
                <button onclick="enviarCorreo()" style="display: inline;" type="button" class="btn btn-primary"><i class="fa fa-send"></i> Enviar</button>
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
<!-- jQuery Tags Input -->
<script src=<?= base_url("template/vendors/jquery.tagsinput/src/jquery.tagsinput.js") ?>></script>
<!-- formatCurrency -->
<script src=<?= base_url("template/vendors/formatCurrency/jquery.formatCurrency-1.4.0.js"); ?>></script>
<!-- Custom Theme Scripts -->
<script src=<?= base_url("template/build/js/custom.js"); ?>></script>
<!-- bootstrap-wysiwyg -->
<script src=<?=base_url("template/vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js"); ?>></script>
<script src=<?=base_url("template/vendors/jquery.hotkeys/jquery.hotkeys.js"); ?>></script>
<script src=<?=base_url("template/vendors/google-code-prettify/src/prettify.js"); ?>></script>
<!-- jquery.redirect -->
<script src=<?= base_url("template/vendors/jquery.redirect/jquery.redirect.js"); ?>></script>
<!-- CUSTOM JS FILE -->
<script src=<?=base_url("template/js/custom/funciones.js"); ?>></script>
<!-- JS FILE -->
<script src=<?= base_url("application/views/facturas/js/catalogo_facturas.js"); ?>></script>
<script>
    var uid = '<?= $this->session->id ?>';

    $(function(){
        load();
    });


</script>
</body>
</html>
