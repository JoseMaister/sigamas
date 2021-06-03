<!-- page content -->
<div class="right_col" role="main">
    <div class="">

        <div class="row">


            <div class="col-md-9 col-sm-9 col-xs-12">
            <div class="x_panel">
                    <div class="x_title">
                    <h2>Ordenes de Compra</h2>

                    <h4 class='pull-right'>USD: $<?= number_format((float)$usd, 4, '.', '') . " <small>(Act. " . date("m/d h:i a", strtotime($usd_actualizacion)) . ") </small>" ?></h4>
                    <div class="clearfix"></div>
                    </div>

                    <div class="x_content">

                    <div class="row top_tiles">
                        <div class="col-md-3 col-sm-3 col-xs-6 tile">
                            <label>Pendiente</label>
                            <h2 id='lblPendiente' class='total'>0</h2>
                            <span class="sparkline_one">
                                <canvas width="200" height="20" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
                            </span>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-6 tile">
                            <label>Provisionado</label>
                            <h2 id='lblProvisionado' class='total'>0</h2>
                            <span class="sparkline_two">
                                <canvas width="200" height="20" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
                            </span> 
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-6 tile">
                            <label>Pagado</label>
                            <h2 id='lblPagado' class='total'>0</h2>
                            <span class="sparkline_one">
                                <canvas width="200" height="20" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
                            </span>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-6 tile">
                            <label>Metodo de Pago</label>
                            <select onchange="buscar()" required="required" class="select2_single form-control" id="opFiltroMetodo">
                            </select>
                        </div>
                    </div>

                    </div>
            </div>


                <div class="x_panel">

                    <div class="x_content">
                    <div class="table-responsive">
                        <table id="tabla" class="table table-striped">
                            <thead>
                                <tr class="headings">
                                    <th class="column-title"># PO</th>                                    
                                    <th style="cursor: pointer" onclick=dateSort() class="column-title"><i class='fa fa-sort-amount-desc'></i> Fecha de Cobro</th>
                                    <th class="column-title">Monto</th>
                                    <th class="column-title">Monto (MXN)</th>
                                    <th class="column-title">Tipo de Cambio</th>
                                    <th class="column-title">Forma de Pago</th>
                                    <th class="column-title">Recurso</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    </div>
                </div>


            </div>

            <div class="col-md-3 col-sm-3 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Formas de Pago</h2>
                        <div class="clearfix"></div>
                    </div>


                    <div class="x_content">
                        <div id='divPagos' class="row top_tiles">

                            


                        </div>
                    </div>
                </div>
            </div>

        
            

        </div>


    </div>
</div>
<!-- /page content -->


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
                        <input min="1" id="txtTipoCambio" type="number" class="form-control" />
                    </center>
                    </div>
                </div>
                



                
            </form>
            </div>
            <div class="modal-footer">
                <button id="btnCancelar" type="button" data-dismiss="modal" class="btn btn-default pull-left"><i class="fa fa-close"></i> Cancelar</button>
                <button id="btnGuardarTipoCambio" type="button" onclick="modificarTipoCambio(this)" class="btn btn-primary"><i class='fa fa-check'></i> Aceptar</button>
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
<!-- jquery.redirect -->
<script src=<?= base_url("template/vendors/jquery.redirect/jquery.redirect.js"); ?>></script>
<!-- Custom Theme Scripts -->
<script src=<?= base_url("template/build/js/custom.js"); ?>></script>
<!-- JS FILE -->
<script src=<?= base_url("application/views/recursos/js/asignar_recursos.js"); ?>></script>
<script>

    $(function(){
        load();
    });

    
</script>
</body>
</html>
