<!-- page content -->
<div class="right_col" role="main">
    <div class="">

        <div class="clearfix"></div>


        <div class="row">

            




            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Conceptos de Compra</h2>
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
                            <div class="col-md-12 col-sm-12">
                                
                                <!-- start accordion -->
                            <div class="accordion" id="accordion1" role="tablist" aria-multiselectable="true">
                                <div id="paneles">

                                    
                                </div>
                            </div>
                            <!-- end of accordion -->

                            </div>


                        </div>
                        <div style='padding: 10px;'>
                        <button type="button" onclick='cancelar()' class="btn btn-danger btn-md"><i class="fa fa-close"></i> Cancelar</button>
                        <button type="button" onclick='mdlGenerarPO()' class="btn btn-primary btn-md pull-right"><i class="fa fa-send"></i> Generar PO</button>
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



<div id="mdlGenerarPO" class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Generar PO</h4>
            </div>

            <div class="modal-body">
                <form>
                    <center>
                        <button id="btnPOExistente" onclick='mdlPOExistentes()' class='btn btn-success btn-lg' type='button'><i class='fa fa-shopping-cart'></i> Agregar a PO existente</button>
                        <button id="btnNuevaPO" onclick='generarPO(this)' data-p='<?= $id_prov ?>' data-m='<?= $moneda ?>' data-t='<?= $tipo ?>' class='btn btn-primary btn-lg' type='button'><i class='fa fa-plus'></i> Crear nueva PO</button>
                    </center>
                </form>
            </div> 
        </div>
    </div>
</div>

<div id="mdlPOExistentes" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Agregar a PO existente</h4>
            </div>

            <div class="modal-body">
                <form>
                    <table id="tblPOExistentes" class="data table table-striped no-margin">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Fecha de creación</th>
                                <th>Requisitor</th>
                                <th>Proveedor</th>
                                <th>Opciones</th>
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
<script src=<?= base_url("application/views/ordenes_compra/js/construccion_po.js"); ?>></script>
<script>
    var PRS =  JSON.parse('<?= $prs ?>');
    var idtemp = '<?= $idtemp ?>';

    $(function(){
        load();
    });
    

    
</script>
</body>
</html>
