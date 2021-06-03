<!-- page content -->
<div class="right_col" role="main">
    <div class="">

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Retroceder QR</h2>
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
                                <label># QR: </label>
                                <input id="txtBusqueda" style="margin-left: 10px; display: inline;" type="text">
                                <button onclick="buscar()" style="display: inline; margin-left: 15px;" class="btn btn-success" type="button"><i class="fa fa-search"></i> Buscar</button>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="table-responsive">
                                    <table id="tabla" class="table table-striped">
                                        <thead>
                                            <tr class="headings">
                                                <th class="column-title">QR #</th>
                                                <th class="column-title">Fecha</th>
                                                <th class="column-title">Requisitor</th>
                                                <th class="column-title">Tipo</th>
                                                <th class="column-title">Subtipo</th>
                                                <th class="column-title">Cant.</th>
                                                <th style="width: 25%" class="column-title">Descripción</th>
                                                <th class="column-title">Estatus</th>
                                                <th class="column-title">Opciones</th>
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



<div id="mdlRetroceso" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel2">Motivo de retroceso</h4>
            </div>

            <div class="modal-body">
                <form>
                    <div class="item form-group">
                        <div class="col-xs-12">
                            <textarea style="resize: none;" id="txtComentarios" required="required" name="comentario" class="form-control col-xs-12"></textarea>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button data-dismiss="modal" style="display: inline;" type="button" class="btn btn-default pull-left"><i class="fa fa-close"></i> Cancelar</button>
                <button onclick="retroceder(this)" id="btnRetroceder" style="display: inline;" type="button" class="btn btn-primary"><i class="fa fa-reply"></i> Retroceder</button>
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
<script src=<?= base_url("application/views/ordenes_compra/js/retroceder_qr.js"); ?>></script>
<script>

    $(function(){
        load();
    });
    

    
</script>
</body>
</html>
