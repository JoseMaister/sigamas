<!-- page content -->
<div class="right_col" role="main">
    <div class="">

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Requisiciones de Cotización</h2>
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
                                    Usuario:
                                    <input type="radio" class="flat" name="rbBusqueda" id="rbUsuario" value="usuario" />
                                    Contenido:
                                    <input type="radio" class="flat" name="rbBusqueda" id="rbContenido" value="contenido" />
                                </p>

                                <input id="txtBusqueda" style="display: inline;" type="text">

                                <p style="margin-left: 10px; display: inline;">
                                    Prioridad Normal: 
                                    <input type="checkbox" class="flat cbPriori" id="cbNormal" value="NORMAL" checked />
                                    Urgente:
                                    <input type="checkbox" class="flat cbPriori" id="cbUrgente" value="URGENTE" checked/>
                                    Info Urgente: 
                                    <input type="checkbox" class="flat cbPriori" id="cbInfoUrgente" value="INFO URGENTE" checked/>
                                </p>

                                <p style="display: inline; margin-right: 10px;">
                                    Estatus: 
                                </p>
                                <select onchange="buscar()" style="display: inline; width: 12%; margin-right: 10px;" required="required" class="select2_single form-control" id="opEstatus">
                                    <option value="TODO" <?= $estatus == "TODO" ? 'selected' : '' ?>>TODO</option>
                                    <option value="ABIERTO" <?= $estatus == "ABIERTO" ? 'selected' : '' ?>>ABIERTO</option>
                                    <option value="COTIZANDO" <?= $estatus == "COTIZANDO" ? 'selected' : '' ?>>COTIZANDO</option>
                                    <option value="RECHAZADO" <?= $estatus == "RECHAZADO" ? 'selected' : '' ?>>RECHAZADO</option>
                                    <option value="CANCELADO" <?= $estatus == "CANCELADO" ? 'selected' : '' ?>>CANCELADO</option>
                                    <option value="LIBERADO" <?= $estatus == "LIBERADO" ? 'selected' : '' ?>>LIBERADO</option>
                                    <!--
                                    <option value="COMPRA APROBADA">COMPRA APROBADA</option>
                                    <option value="COMPRA RECHAZADA">COMPRA RECHAZADA</option>
                                    -->
                                </select>

                                <p style="margin-left: 10px; display: inline;">
                                    Producto: 
                                    <input type="checkbox" class="flat cbPriori" id="cbProducto" checked />
                                    Servicio:
                                    <input type="checkbox" class="flat cbPriori" id="cbServicio" checked />
                                </p>

                                <?php $check = $otros_aprobadores == 'unchecked' ? '' : 'checked'; ?>

                                <p style="margin: 10px; display: inline;">
                                    Ver solo Mis QR's:
                                    <input type="checkbox" class="flat cbPriori" id="cbMisQrs" value="NORMAL" <?= $check ?> />
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
                        <table id="tabla" class="table table-striped">
                            <thead>
                                <tr class="headings">
                                    <th class="column-title">#</th>
                                    <th class="column-title">Fecha</th>
                                    <th class="column-title">Requisitor</th>
                                    <th class="column-title">Prioridad</th>
                                    <th class="column-title">Tipo</th>
                                    <th class="column-title">Subtipo</th>
                                    <th class="column-title">Cant.</th>
                                    <th style="width: 25%" class="column-title">Descripción</th>
                                    <th class="column-title">Cotizaciones</th>
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



<!-- MODAL -->
<div id="mdlDetalle" class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title mdlTitulo">QR: </h4>
            </div>

            <div class="modal-body">
               <form>
                    
                    <p class="lead" id="lblDestino"></p>

                    <p class="lead">Descripción: </p>
                    <p id="lblDescripcion" class="lead text-muted well well-sm no-shadow" style="margin-top: 10px;">
                        
                    </p>
                    <table id="tblDetalle" class="data table table-striped no-margin">
                        <tbody>
                        </tbody>
                    </table>

                    <div id="divCommentQR">
                        <p class="lead">Notas: </p>
                        <p id="lblCommentQR" class="lead" style="margin-top: 10px;">
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<!-- MODAL PROVEEDORES -->
<div id="mdlCotizaciones" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title mdlTitulo">Seleccionar propuesta para autorización: </h4>
            </div>

            <div class="modal-body">
                <table id="tblProveedores" class="data table table-striped no-margin">
                    <thead>
                        <tr>
                            <th style="width: 10%">Selecc.</th>
                            <th>Precio</th>
                            <th>Entrega</th>
                            <th>Vigencia</th>
                            <th>Nombre</th>
                            <th>RMA Requerido</th>
                            <th>Lugar de Entrega</th>
                            <th>Evidencia</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <ul id='ulComments' class="list-unstyled msg_list">
                <ul>
            </div>

            <div class="modal-footer">
                <button type="button" class="pull-left btn btn-default" data-dismiss="modal">Cancelar</button>

                <!--
                <p style="display: inline;">
                    Prioridad Normal:
                    <input type="radio" class="flat" name="rbPrioridad" value="NORMAL" checked="" required />
                    Urgente:
                    <input type="radio" class="flat" name="rbPrioridad" value="URGENTE" />
                </p>-->

                <label style="margin-right: 5px;">Cantidad </label>
                <input id="txtQtySolicitud" style="width: 10%; text-align: center;" type='number'>
                <button type="button" class="btn btn-primary" onclick="mdlConfirmarPR()"><i class="fa fa-clock-o"></i> Solicitar Aprobación</button>
                
            </div>

        </div>
    </div>
</div>

<!-- MODAL CONFIRMAR PR -->
<div id="mdlConfirmarPR" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="lblPRRecientes">PR's recientes</h4>
            </div>

            <div class="modal-body">
                <table id="tblPRs" class="data table table-striped no-margin">
                    <thead>
                        <tr>
                            <th style="width: 10%">PR</th>
                            <th>Fecha</th>
                            <th>Usuario</th>
                            <th>Estatus</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>

            <div class="modal-footer">
                <button type="button" class="pull-left btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="generarPR()"><i class="fa fa-check"></i> Confirmar PR</button>
                
            </div>

        </div>
    </div>
</div>

<!-- MODAL Descripción -->
<div id="mdlDescripcionQR" class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title mdlTitulo">Editar Descripción: </h4>
            </div>

            <div class="modal-body">
                <form>
                    <div style="margin-top: 10px;" class="col-xs-12">
                        <label style="display: block;">Descripción</label>
                        <input maxlength="200" id="txtDescripcion" class="form-control" type="text">
                    </div>
                    <div style="margin-top: 10px;" class="col-xs-12">
                        <label style="display: block;">Item</label>
                        <input id="txtItem" style="width:50%" class="form-control" type="text">
                    </div>
                    <div style="margin-top: 10px;" class="col-xs-12">
                        <label style="display: block;">ID</label>
                        <input id="txtID" style="width:50%" class="form-control" type="text">
                    </div>
                    <div style="margin-top: 10px;" class="col-xs-12">
                        <label style="display: block;">Serie</label>
                        <input id="txtSerie" style="width:50%" class="form-control" type="text">
                    </div>
                </form>
            </div>
            

            <div class="modal-footer">
                <button type="button" class="pull-left btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="registrarPR()"><i class="fa fa-send"></i> Generar PR</button>
                
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
<!-- JS FILE -->
<script src=<?= base_url("application/views/compras/js/catalogo_qr.js"); ?>></script>
<script>
    var usuario = '<?= $this->session->id ?>';
    var RV = '<?= $this->session->privilegios['revisar_qr'] ?>';
    var C = '<?= $this->session->privilegios['editar_qr'] ?>';
    var L = '<?= $this->session->privilegios['liberar_qr'] ?>';
    
    var I = '<?= $this->session->privilegios['crear_qr_interno'] ?>';
    var V = '<?= $this->session->privilegios['crear_qr_venta'] ?>';

    $(function(){
        load();
        eventos();
    });

    function eventos(){
        $( '#mdlCotizaciones' ).on( 'keypress', function( e ) {
            if( e.keyCode === 13 ) {
                e.preventDefault();
                buscarProv();
            }
        });

        $( '#txtBusqueda' ).on( 'keypress', function( e ) {
            if( e.keyCode === 13 ) {
                buscar();
            }
        });

        $('.cbPriori').on( 'ifChanged', function( e ) {
            buscar();
        });

        $('#btnAsignarProveedor').on('click', function(){
            var url = '<?= base_url('compras/ajax_getProveedoresAsignados') ?>';
            modalAsignarProveedor(this, url);
        })
    }

    function load(){
        buscar();
    }

    function verDetalle(btn){
        var id = btn.dataset.id;
        var url = '<?= base_url("compras/ajax_getDetalleQR") ?>';
        getDetalle(id, url);
    }

    function buscarProv()
    {
        var url = '<?= base_url("empresas/ajax_getProveedores") ?>';
        buscarProveedor(url);
    }

    function asignarProv(btn)
    {
        var url = '<?= base_url("compras/ajax_setProveedor") ?>';
        asignarProveedor(btn, url);
    }

    
</script>
</body>
</html>
