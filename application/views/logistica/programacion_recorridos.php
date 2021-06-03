<!-- page content -->
<div class="right_col" role="main">
    <div class="">

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">

                <div class="x_panel">
                    <div class="x_title">
                        <h2>Programación de Recorrido</h2>
                        <button style="display: none;" id="btnContinuar" onclick="continuar()" class="btn btn-primary btn-md pull-right"><i class='fa fa-truck'></i> Determinar Recorrido</button>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <!--AQUI EMPIEZO -->
                        <div class="" role="tabpanel" data-example-id="togglable-tabs">
                        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">FACTURAS</a>
                            </li>
                            <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">EQUIPOS</a>
                            </li>
                            <li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">DOCUMENTOS</a>
                            </li>
                        </ul>
                        <div id="myTabContent" class="tab-content">
                            <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
                                <div class="table-responsive">
                                    <h3>Entrega</h3>
                                    <table style="margin-bottom:60px;" id="tblEntregaFacturas" class="table table-striped">
                                        <thead>
                                            <tr class="headings">
                                                <th class="column-title">Selecc.</th>
                                                <th class="column-title">Folio Factura</th>
                                                <th class="column-title">Ejecutivo</th>
                                                <th class="column-title">Cliente</th>
                                                <th class="column-title">Orden de Compra</th>
                                                <th class="column-title">Reporte de Servicio</th>
                                                <th class="column-title">Estatus</th>
                                                <th class="column-title">Otros Recorridos</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="table-responsive">
                                    <h3>Retorno</h3>
                                    <table style="margin-bottom:60px;" id="tblRecolectaFacturas" class="table table-striped">
                                        <thead>
                                            <tr class="headings">
                                                <th class="column-title">Selecc.</th>
                                                <th class="column-title">Folio Factura</th>
                                                <th class="column-title">Ejecutivo</th>
                                                <th class="column-title">Cliente</th>
                                                <th class="column-title">Orden de Compra</th>
                                                <th class="column-title">Reporte de Servicio</th>
                                                <th class="column-title">Estatus</th>
                                                <th class="column-title">Fecha de Retorno</th>
                                                <th class="column-title">Otros Recorridos</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            

                            <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
                                <div class="table-responsive">
                                    <h3>Entrega</h3>
                                    <table style="margin-bottom:60px;" id="tblEntregaEquipos" class="table table-striped">
                                        <thead>
                                            <tr class="headings">
                                                <th class="column-title">Selecc.</th>
                                                <th class="column-title">Item</th>
                                                <th class="column-title">Reporte de Servicio</th>
                                                <th class="column-title">Nombre Corto</th>
                                                <th class="column-title">Descripción</th>
                                                <th class="column-title">Estatus</th>
                                                <th class="column-title">Otros Recorridos</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="table-responsive">
                                    <h3>Retorno</h3>
                                    <table style="margin-bottom:60px;" id="tblRecolectaEquipos" class="table table-striped">
                                        <thead>
                                            <tr class="headings">
                                                <th class="column-title">Selecc.</th>
                                                <th class="column-title">Folio Factura</th>
                                                <th class="column-title">Ejecutivo</th>
                                                <th class="column-title">Cliente</th>
                                                <th class="column-title">Orden de Compra</th>
                                                <th class="column-title">Reporte de Servicio</th>
                                                <th class="column-title">Estatus</th>
                                                <th class="column-title">Fecha de Retorno</th>
                                                <th class="column-title">Otros Recorridos</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab">
                            <p>DOCUMENTOS!!!!!!!</p>
                            </div>
                        </div>
                        </div>
                        <!--AQUI TERMINO -->
                        

                        

                        <div id="divCierreRecorridos" style="display: none;" class="table-responsive">
                            <h3>Recorridos pendientes de cierre</h3>
                            <table style="margin-bottom:60px;" id="tblCierre" class="table table-striped">
                                <thead>
                                    <tr class="headings">
                                        <th class="column-title">Recorrido</th>
                                        <th class="column-title">Mensajero</th>
                                        <th class="column-title">Fecha Recorrido</th>
                                        <th class="column-title">Estatus</th>
                                        <th class="column-title">Ver</th>
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
<div id="mdlRecorrido" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Programación de Recorrido</h4>
            </div>
            <div class="modal-body">
                <form>

                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <table data-user="0" id="tblUsuario" class="table table-striped">
                            <tbody>
                                <tr style="cursor: pointer" onclick="catalogoUsuarios()">
                                    <td><img id="imgUser" src='<?= base_url("template/images/avatar.png") ?>' class='avatar' alt='Avatar'></td>
                                    <td id="lblUserName">Mensajero</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-4">
                        <label>Fecha de Recorrido:</label>
                        <div id="fechaCobro" class="daterangepicker dropdown-menu ltr single opensright show-calendar picker_4 xdisplay"><div class="calendar left single" style="display: block;"><div class="daterangepicker_input"><input class="input-mini form-control active" type="text" name="daterangepicker_start" value="" style="display: none;"><i class="fa fa-calendar glyphicon glyphicon-calendar" style="display: none;"></i><div class="calendar-time" style="display: none;"><div></div><i class="fa fa-clock-o glyphicon glyphicon-time"></i></div></div><div class="calendar-table"><table class="table-condensed"><thead><tr><th class="prev available"><i class="fa fa-chevron-left glyphicon glyphicon-chevron-left"></i></th><th colspan="5" class="month">Oct 2016</th><th class="next available"><i class="fa fa-chevron-right glyphicon glyphicon-chevron-right"></i></th></tr><tr><th>Su</th><th>Mo</th><th>Tu</th><th>We</th><th>Th</th><th>Fr</th><th>Sa</th></tr></thead><tbody><tr><td class="weekend off available" data-title="r0c0">25</td><td class="off available" data-title="r0c1">26</td><td class="off available" data-title="r0c2">27</td><td class="off available" data-title="r0c3">28</td><td class="off available" data-title="r0c4">29</td><td class="off available" data-title="r0c5">30</td><td class="weekend available" data-title="r0c6">1</td></tr><tr><td class="weekend available" data-title="r1c0">2</td><td class="available" data-title="r1c1">3</td><td class="available" data-title="r1c2">4</td><td class="available" data-title="r1c3">5</td><td class="available" data-title="r1c4">6</td><td class="available" data-title="r1c5">7</td><td class="weekend available" data-title="r1c6">8</td></tr><tr><td class="weekend available" data-title="r2c0">9</td><td class="available" data-title="r2c1">10</td><td class="available" data-title="r2c2">11</td><td class="available" data-title="r2c3">12</td><td class="available" data-title="r2c4">13</td><td class="available" data-title="r2c5">14</td><td class="weekend available" data-title="r2c6">15</td></tr><tr><td class="weekend available" data-title="r3c0">16</td><td class="available" data-title="r3c1">17</td><td class="today active start-date active end-date available" data-title="r3c2">18</td><td class="available" data-title="r3c3">19</td><td class="available" data-title="r3c4">20</td><td class="available" data-title="r3c5">21</td><td class="weekend available" data-title="r3c6">22</td></tr><tr><td class="weekend available" data-title="r4c0">23</td><td class="available" data-title="r4c1">24</td><td class="available" data-title="r4c2">25</td><td class="available" data-title="r4c3">26</td><td class="available" data-title="r4c4">27</td><td class="available" data-title="r4c5">28</td><td class="weekend available" data-title="r4c6">29</td></tr><tr><td class="weekend available" data-title="r5c0">30</td><td class="available" data-title="r5c1">31</td><td class="off available" data-title="r5c2">1</td><td class="off available" data-title="r5c3">2</td><td class="off available" data-title="r5c4">3</td><td class="off available" data-title="r5c5">4</td><td class="weekend off available" data-title="r5c6">5</td></tr></tbody></table></div></div><div class="calendar right" style="display: none;"><div class="daterangepicker_input"><input class="input-mini form-control" type="text" name="daterangepicker_end" value="" style="display: none;"><i class="fa fa-calendar glyphicon glyphicon-calendar" style="display: none;"></i><div class="calendar-time" style="display: none;"><div></div><i class="fa fa-clock-o glyphicon glyphicon-time"></i></div></div><div class="calendar-table"><table class="table-condensed"><thead><tr><th></th><th colspan="5" class="month">Nov 2016</th><th class="next available"><i class="fa fa-chevron-right glyphicon glyphicon-chevron-right"></i></th></tr><tr><th>Su</th><th>Mo</th><th>Tu</th><th>We</th><th>Th</th><th>Fr</th><th>Sa</th></tr></thead><tbody><tr><td class="weekend off available" data-title="r0c0">30</td><td class="off available" data-title="r0c1">31</td><td class="available" data-title="r0c2">1</td><td class="available" data-title="r0c3">2</td><td class="available" data-title="r0c4">3</td><td class="available" data-title="r0c5">4</td><td class="weekend available" data-title="r0c6">5</td></tr><tr><td class="weekend available" data-title="r1c0">6</td><td class="available" data-title="r1c1">7</td><td class="available" data-title="r1c2">8</td><td class="available" data-title="r1c3">9</td><td class="available" data-title="r1c4">10</td><td class="available" data-title="r1c5">11</td><td class="weekend available" data-title="r1c6">12</td></tr><tr><td class="weekend available" data-title="r2c0">13</td><td class="available" data-title="r2c1">14</td><td class="available" data-title="r2c2">15</td><td class="available" data-title="r2c3">16</td><td class="available" data-title="r2c4">17</td><td class="available" data-title="r2c5">18</td><td class="weekend available" data-title="r2c6">19</td></tr><tr><td class="weekend available" data-title="r3c0">20</td><td class="available" data-title="r3c1">21</td><td class="available" data-title="r3c2">22</td><td class="available" data-title="r3c3">23</td><td class="available" data-title="r3c4">24</td><td class="available" data-title="r3c5">25</td><td class="weekend available" data-title="r3c6">26</td></tr><tr><td class="weekend available" data-title="r4c0">27</td><td class="available" data-title="r4c1">28</td><td class="available" data-title="r4c2">29</td><td class="available" data-title="r4c3">30</td><td class="off available" data-title="r4c4">1</td><td class="off available" data-title="r4c5">2</td><td class="weekend off available" data-title="r4c6">3</td></tr><tr><td class="weekend off available" data-title="r5c0">4</td><td class="off available" data-title="r5c1">5</td><td class="off available" data-title="r5c2">6</td><td class="off available" data-title="r5c3">7</td><td class="off available" data-title="r5c4">8</td><td class="off available" data-title="r5c5">9</td><td class="weekend off available" data-title="r5c6">10</td></tr></tbody></table></div></div><div class="ranges" style="display: none;"><div class="range_inputs"><button class="applyBtn btn btn-sm btn-success" type="button">Apply</button> <button class="cancelBtn btn btn-sm btn-default" type="button">Cancel</button></div></div></div>
                        <fieldset>
                            <div class="control-group">
                                <div class="controls">
                                    <div class="col-md-12 xdisplay_inputx form-group has-feedback">
                                        <input type="text" class="form-control has-feedback-left" id="dtpFecha" placeholder="Fecha" name="dtpFecha" aria-describedby="inputSuccess2Status4">
                                        <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                        <span id="inputSuccess2Status4" class="sr-only">(success)</span>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-2">
                        <button type="button" style="margin-top: 25px;" id="btnAceptar" onclick="aceptar()" class="btn btn-primary btn-md"><i class='fa fa-check'></i> Aceptar</button>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <table id="tblFolios" class="data table table-striped no-margin">
                            <thead>
                                <tr>
                                    <th>Folio Factura</th>
                                    <th>Cliente</th>
                                    <th>Orden de Compra</th>
                                    <th>Reporte de Servicio</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>

                    
                    

                </form>
            </div>

        </div>
    </div>
</div>

<div id="mdlRecorridos" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Otros Recorridos</h4>
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
                                            <th class="column-title">Comentarios</th>
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

<div id="mdlUsuarios" class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Usuarios</h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-xs-12">
                            <p style="display: inline;">
                                Mensajeros:
                                <input type="radio" class="flat" name="rbUsuarios" id="rbMensajeros" value="1" checked/>
                                Ver Otros:
                                <input type="radio" class="flat" name="rbUsuarios" value="0" />
                            </p>
                            <table id="tblUsuarios" class="table table-striped">
                                <thead>
                                    <tr class="headings">
                                        <th class="column-title" style="width: 7%;">Foto</th>
                                        <th class="column-title">Nombre</th>
                                        <th class="column-title">Seleccionar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
            

        </div>
    </div>
</div>

<div id="mdlVerRecorrido" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="table-responsive">
                                <table id="tblVerRecorrido" class="table table-striped">
                                    <thead>
                                        <tr class="headings">
                                            <th class="column-title">Selecc.</th>
                                            <th class="column-title">Factura</th>
                                            <th class="column-title">Acción</th>
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
            <div class="modal-footer" style="display: none;">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class='fa fa-close'></i> Cancelar</button>
                <button type="button" id="btnRechazarRecorrido" onclick="rechazarCierre(this)" class="btn btn-danger"><i class='fa fa-close'></i> Rechazar</button>
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
<!-- bootstrap-daterangepicker -->
<script src=<?= base_url("template/vendors/moment/min/moment.min.js") ?>></script>
<script src=<?= base_url("template/vendors/bootstrap-daterangepicker/daterangepicker.js") ?>></script>
<!-- jquery.redirect -->
<script src=<?= base_url("template/vendors/jquery.redirect/jquery.redirect.js"); ?>></script>
<!-- CUSTOM JS FILE -->
<script src=<?=base_url("template/js/custom/funciones.js"); ?>></script>
<!-- JS FILE -->
<script src=<?= base_url("application/views/logistica/js/programacion_recorridos.js"); ?>></script>
<script>

    $(function(){
        load();
    });


</script>
</body>
</html>
