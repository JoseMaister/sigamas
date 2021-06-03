<!-- page content -->
<div class="right_col" role="main">
    <div class="">

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Solicitudes de Compra</h2>
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
                                    <input type="checkbox" class="flat cbPriori" id="cbNormal" value="NORMAL" checked/>
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
                                    <option value="PENDIENTE" <?= $estatus == "PENDIENTE" ? 'selected' : '' ?>>PENDIENTE</option>
                                    <option value="APROBADO" <?= $estatus == "APROBADO" ? 'selected' : '' ?>>APROBADO</option>
                                    <option value="RECHAZADO" <?= $estatus == "RECHAZADO" ? 'selected' : '' ?>>RECHAZADO</option>
                                    <option value="EN SELECCION" <?= $estatus == "EN SELECCION" ? 'selected' : '' ?>>EN SELECCION</option>
                                    <option value="PO AUTORIZADA" <?= $estatus == "PO AUTORIZADA" ? 'selected' : '' ?>>PO AUTORIZADA</option>
                                    <option value="EN PO" <?= $estatus == "EN PO" ? 'selected' : '' ?>>EN PO</option>
                                    <option value="POR RECIBIR" <?= $estatus == "POR RECIBIR" ? 'selected' : '' ?>>POR RECIBIR</option>
                                    <option value="CERRADO" <?= $estatus == "CERRADO" ? 'selected' : '' ?>>CERRADO</option>
                                    <option value="CANCELADO" <?= $estatus == "CANCELADO" ? 'selected' : '' ?>>CANCELADO</option>
                                </select>

                                <?php $vis = $this->session->privilegios['aprobar_pr'] == "1" ? "inline;" : "none;"; ?>
                                <?php $check = $this->session->privilegios['aprobar_pr'] == "1" ? "" : "checked"; ?>
                                <?php if($otros_aprobadores == 'checked') { $check = 'checked'; } ?>
                                
                                <div style="display: <?= $vis ?>">
                                    <p style="margin: 10px; display: inline;">
                                        Ver otros aprobadores:
                                        <input type="checkbox" class="flat cbPriori" id="cbMisPRs" <?= $check ?>/>
                                    </p>
                                </div>

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
                                    <th class="column-title">PO</th>
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
                <h4 class="modal-title mdlTitulo">PR: </h4>
            </div>

            <div class="modal-body">
               <form>
                    
                    <p class="lead" id="lblQR"></p>

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
                            <th style="width: 40%">Nombre</th>
                            <th>Evidencia</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>

            <div class="modal-footer">
                <button type="button" class="pull-left btn btn-default" data-dismiss="modal">Cancelar</button>
                <label style="margin-right: 5px;">Cantidad </label>
                <input id="txtQtySolicitud" style="width: 10%; text-align: center;" type='number'>
                <button type="button" class="btn btn-primary" onclick="generarPR()"><i class="fa fa-clock-o"></i> Solicitar Aprobación</button>
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
<script src=<?= base_url("application/views/compras/js/catalogo_pr.js"); ?>></script>
<script>
    var usuario = '<?= $this->session->id ?>';

    $(function(){
        load();
        eventos();
    });

    function load(){
        var est = '<?= $estatus ?>';
        if(est == "TODO")
        {
            if('<?= $this->session->privilegios['editar_qr'] ?>' == "1" | '<?= $this->session->privilegios['liberar_qr'] ?>' == "1")
            {
                est='APROBADO';
            }
            if('<?= $this->session->privilegios['aprobar_pr'] ?>' == "1")
            {
                est='PENDIENTE';
            }
            $('#opEstatus').val(est);
        }

        buscar();
    }

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
        
    }

    
</script>
</body>
</html>
