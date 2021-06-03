<!-- page content -->
<div class="right_col" role="main">
    <div class="">

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Generar Orden de Compra</h2>
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
                                    # PR:
                                    <input type="radio" class="flat" name="rbBusqueda" id="rbFolio" value="folio" checked />
                                    Proveedor:
                                    <input type="radio" class="flat" name="rbBusqueda" id="rbProveedor" value="proveedor" />
                                    Contenido:
                                    <input type="radio" class="flat" name="rbBusqueda" id="rbContenido" value="contenido" />
                                </p>

                                <input id="txtBusqueda" style="display: inline;" type="text">

                                <button onclick="buscar()" style="display: inline; margin-left: 15px;" class="btn btn-success" type="button"><i class="fa fa-search"></i> Buscar</button>

                            </div>



                           
                        </div>

                        <div class="row">

                        <div id="divProveedor" style="display: none; margin-top: 10px;" class="col-md-12 col-sm-12 col-xs-12">
                            <h2 style="vertical-align: middle; display: inline;" id="lblNombreProveedor"></h2>
                            <button onclick="continuar()" style=" margin-left: 15px;" class="btn btn-primary btn-sm" type="button"><i class="fa fa-check"></i> Continuar</button>
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
                                    <th class="column-title"><i class='fa fa-check'></i></th>
                                    <th class="column-title">PR</th>
                                    <th class="column-title">Proveedor</th>
                                    <th class="column-title">Tipo</th>
                                    <th class="column-title">Cantidad</th>
                                    <th class="column-title">Modelo</th>
                                    <th style="width: 25%" class="column-title">Descripción</th>
                                    <th class="column-title">Monto</th>
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
<script src=<?= base_url("application/views/ordenes_compra/js/generar_po.js"); ?>></script>
<script>

    $(function(){
        load();
    });
    

    
</script>
</body>
</html>
