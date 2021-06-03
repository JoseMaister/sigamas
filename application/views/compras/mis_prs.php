<!-- page content -->
<div class="right_col" role="main">
    <div class="">

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Mis PR's</h2>
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
                                    <option value="TODO">TODO</option>
                                    <option value="PENDIENTE">PENDIENTE</option>
                                    <option value="APROBADO">APROBADO</option>
                                    <option value="RECHAZADO">RECHAZADO</option>
                                    <option value="EN SELECCION">EN SELECCION</option>
                                    <option value="PO AUTORIZADA">PO AUTORIZADA</option>
                                    <option value="EN PO">EN PO</option>
                                    <option value="POR RECIBIR">POR RECIBIR</option>
                                    <option value="CERRADO">CERRADO</option>
                                    <option value="CANCELADO">CANCELADO</option>
                                </select>

                                <button onclick="buscar()" style="display: inline;" class="btn btn-success" type="button"><i class="fa fa-search"></i> Buscar</button>

                                <p style="margin-left: 10px; display: inline;">
                                    Ver otros usuarios
                                    <input type="checkbox" class="flat cbPriori" id="cbMisPrs"/>
                                </p>
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
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="table-responsive">
                                    <table id="tabla" class="table table-striped">
                                        <thead>
                                            <tr class="headings">
                                                <th class="column-title">#</th>
                                                <th class="column-title">Fecha</th>
                                                <th class="column-title">Usuario</th>
                                                <th class="column-title">Prioridad</th>
                                                <th class="column-title">Tipo</th>
                                                <th class="column-title">Subtipo</th>
                                                <th class="column-title">Cant.</th>
                                                <th style="width: 25%" class="column-title">Descripción</th>
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

<div id="mdlRecibir" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel2">Recibir PR</h4>
            </div>
           
            <div class="modal-body">
                <form>
                    <table id="tblRecibir" class="table table-striped">
                        <thead>
                            <tr class="headings">
                                <th style='width: 8%;' class="column-title">PR #</th>
                                <th class="column-title">Tipo</th>
                                <th class="column-title">Subtipo</th>
                                <th class="column-title">Cantidad</th>
                                <th class="column-title">Descripción</th>
                                <th class="column-title">Recibir</th>
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
<script src=<?= base_url("application/views/compras/js/mis_prs.js"); ?>></script>
<script>
    var usuario = '<?= $this->session->id ?>';

    $(function(){
        load();
    });
    
</script>
</body>
</html>
