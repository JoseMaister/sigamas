<!-- page content -->
<div class="right_col" role="main">
    <div class="">

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Cotizaciones</h2>
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
                                    Folio:
                                    <input type="radio" class="flat" name="rbBusqueda" id="rbFolio" value="folio" checked />
                                    ID:
                                    <input type="radio" class="flat" name="rbBusqueda" id="rbId" value="id" />
                                    Marca:
                                    <input type="radio" class="flat" name="rbBusqueda" id="tbMarca" value="marca" />
                                    Serie:
                                    <input type="radio" class="flat" name="rbBusqueda" id="tbSerie" value="serie" />
                                    Modelo:
                                    <input type="radio" class="flat" name="rbBusqueda" id="rbModelo" value="modelo" />
                                    Responsable:
                                    <input type="radio" class="flat" name="rbBusqueda" id="rbResponsable" value="responsable" />
                                    Contenido:
                                    <input type="radio" class="flat" name="rbBusqueda" id="rbContenido" value="contenido" />
                                </p>

                                <input id="txtBusqueda" style="display: inline;" type="text">

                                <p style="display: inline; margin-right: 10px; margin-left: 10px;">
                                    Cliente: 
                                </p>
                                <input type="text" value="TODOS" data-id="0" onclick="buscarClientes()" style="background-color: #fff; display: inline; width: 12%; margin-right: 10px;" class="form-control" id="txtCliente" readonly>
                                <button id="btnRemoverCliente" onclick="removerCliente()" style="display: none;" class="btn btn-danger btn-xs" type="button"><i class="fa fa-close"></i></button>

                                <p style="display: inline; margin-right: 10px; margin-left: 10px;">
                                    Tipo de Cotización: 
                                </p>
                                <select onchange="buscar()" style="display: inline; width: 12%; margin-right: 10px;" required="required" class="select2_single form-control" id="opTipoCotizacion">
                                    <option value="TODOS">TODOS</option>
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

                                <p style="display: inline; margin-right: 10px; margin-left: 10px;">
                                    Estatus: 
                                </p>
                                <select onchange="buscar()" style="display: inline; width: 12%; margin-right: 10px;" required="required" class="select2_single form-control" id="opEstatus">
                                    <option value="TODOS">TODOS</option>
                                    <option value="CREADA">CREADA</option>
                                    <option value="PENDIENTE AUTORIZACION">PENDIENTE AUTORIZACION</option>
                                    <option value="EN REVISION">EN REVISION</option>
                                    <option value="AUTORIZADA">AUTORIZADA</option>
                                    <option value="ENVIADA">ENVIADA</option>
                                    <option value="CONFIRMADA">CONFIRMADA</option>
                                    <option value="EN APROBACION">EN APROBACION</option>
                                    <option value="CERRADO PARCIAL">CERRADO PARCIAL</option>
                                    <option value="CERRADO TOTAL">CERRADO TOTAL</option>
                                    <option value="RECHAZADA">RECHAZADA</option>
                                    <option value="CANCELADA">CANCELADA</option>
                                </select>

                                <p style="margin: 10px; display: inline;">
                                    Ver Cerradas / Canceladas:
                                    <input type="checkbox" class="flat" id="cbCerradasCanceladas"/>
                                </p>


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
                            <a href=<?= base_url("cotizaciones/crear_cotizacion") ?> class="btn btn-primary btn-xs"><i class='fa fa-plus'></i> Crear Cotización</a>
                            <label id="lblCount" class="pull-right"></label>
                            <table style="margin-bottom:60px;" id="tabla" class="table table-striped">
                                <thead>
                                    <tr class="headings">
                                        <th class="column-title">#</th>
                                        <th class="column-title">Fecha</th>
                                        <th class="column-title">Cliente</th>
                                        <th class="column-title">Contacto</th>
                                        <th class="column-title">Responsable</th>
                                        <th class="column-title">Estatus</th>
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
                            <button onclick="buscarClientes()" class="btn btn-default" type="button">Buscar</button>
                        </span>
                    </div>
                    <table id="tblClientes" class="data table table-striped no-margin">
                        <thead>
                            <tr>
                                <th style="width: 60%">Nombre</th>
                                <th style="width: 10%">Cotizaciones</th>
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

<div id="mdlQuickView" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="mdlQuickView_tittle"></h4>
            </div>
            <div class="modal-body">

                <div id="tabCtrlQuickView" class="" role="tabpanel" data-example-id="togglable-tabs">
                    <textarea style="display: none;" id="txtCopy"></textarea>
                    <ul id="tabQV" class="nav nav-tabs bar_tabs" role="tablist">
                    </ul>

                    <div id="tabContentQV" class="tab-content">

                    </div>
                </div>


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
<!-- jquery.redirect -->
<script src=<?= base_url("template/vendors/jquery.redirect/jquery.redirect.js"); ?>></script>
<!-- JS FILE -->
<script src=<?= base_url("application/views/cotizaciones/js/catalogo.js"); ?>></script>
<script>
    var uid = '<?= $this->session->id ?>';

    $(function(){
        load();
    });


</script>
</body>
</html>
