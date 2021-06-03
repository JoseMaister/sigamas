<!-- page content -->
<div class="right_col" role="main">
    <div class="">

        <div class="clearfix"></div>


        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Métodos de Pago</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>

                    <div class="x_content">
                    <div class="table-responsive">
                        <button type="button" onclick="modalAgregar()" class="btn btn-primary btn-xs"><i class='fa fa-plus'></i> Agregar</button>
                        <table id="tabla" class="table table-striped">
                            <thead>
                                <tr class="headings">
                                    <th style="width: 5%;" class="column-title">#</th>
                                    <th style="width: 15%;" class="column-title">Tipo</th>
                                    <th class="column-title">Nombre</th>
                                    <th class="column-title">Dia de Corte</th>
                                    <th class="column-title">Fecha de vencimiento</th>
                                    <th class="column-title">Comentarios</th>
                                    <th style="width: 15%;" class="column-title">Opciones</th>
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



<div id="mdlDatos" class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel2">Métodos de Pago</h4>
            </div>
            <div class="modal-body">
            <form>
                <div class="col-xs-12">
                    <label style="margin-left:15px;">Nombre</label>
                    <div class="item form-group">
                        <input maxlength="60" id="txtNombre" type="text" class="form-control" />
                    </div>
                </div>

                <div class="col-xs-12">
                    <label style="margin-left:15px; margin-top: 10px;">Comentarios</label>
                    <div class="item form-group">
                        <textarea maxlength="300" style="resize: none;" id="txtComentarios" required="required" class="form-control"></textarea>
                    </div>
                </div>

                <div class="col-xs-8">
                    <label style="margin-left:15px; margin-top: 10px;">Tipo</label>
                    <div class="item form-group">
                        <select id="opTipo" class="select2_single form-control">
                            <option value='MASTER CARD'>TARJETA MASTER CARD</option>
                            <option value='VISA'>TARJETA VISA</option>
                            <option value='AMERICAN EXPRESS'>TARJETA AMERICAN EXPRESS</option>
                            <option value='TRANSFERENCIA'>TRANSFERENCIA</option>
                            <option value='CHEQUE'>CHEQUE</option>
                        </select>
                    </div>
                </div>

                <div class="col-xs-4">
                    <label style="margin-left:15px; margin-top: 10px;">Dia de Corte</label>
                    <div class="item form-group">
                        <input min="1" max="31" id="txtDiaCorte" type="number" class="form-control" />
                    </div>
                </div>

                <div class="col-xs-12">
                    <label style="margin-left:15px; margin-top: 10px;">Fecha de Vencimiento</label>
                    <div id="fechaVencimiento" class="daterangepicker dropdown-menu ltr single opensright show-calendar picker_4 xdisplay"><div class="calendar left single" style="display: block;"><div class="daterangepicker_input"><input class="input-mini form-control active" type="text" name="daterangepicker_start" value="" style="display: none;"><i class="fa fa-calendar glyphicon glyphicon-calendar" style="display: none;"></i><div class="calendar-time" style="display: none;"><div></div><i class="fa fa-clock-o glyphicon glyphicon-time"></i></div></div><div class="calendar-table"><table class="table-condensed"><thead><tr><th class="prev available"><i class="fa fa-chevron-left glyphicon glyphicon-chevron-left"></i></th><th colspan="5" class="month">Oct 2016</th><th class="next available"><i class="fa fa-chevron-right glyphicon glyphicon-chevron-right"></i></th></tr><tr><th>Su</th><th>Mo</th><th>Tu</th><th>We</th><th>Th</th><th>Fr</th><th>Sa</th></tr></thead><tbody><tr><td class="weekend off available" data-title="r0c0">25</td><td class="off available" data-title="r0c1">26</td><td class="off available" data-title="r0c2">27</td><td class="off available" data-title="r0c3">28</td><td class="off available" data-title="r0c4">29</td><td class="off available" data-title="r0c5">30</td><td class="weekend available" data-title="r0c6">1</td></tr><tr><td class="weekend available" data-title="r1c0">2</td><td class="available" data-title="r1c1">3</td><td class="available" data-title="r1c2">4</td><td class="available" data-title="r1c3">5</td><td class="available" data-title="r1c4">6</td><td class="available" data-title="r1c5">7</td><td class="weekend available" data-title="r1c6">8</td></tr><tr><td class="weekend available" data-title="r2c0">9</td><td class="available" data-title="r2c1">10</td><td class="available" data-title="r2c2">11</td><td class="available" data-title="r2c3">12</td><td class="available" data-title="r2c4">13</td><td class="available" data-title="r2c5">14</td><td class="weekend available" data-title="r2c6">15</td></tr><tr><td class="weekend available" data-title="r3c0">16</td><td class="available" data-title="r3c1">17</td><td class="today active start-date active end-date available" data-title="r3c2">18</td><td class="available" data-title="r3c3">19</td><td class="available" data-title="r3c4">20</td><td class="available" data-title="r3c5">21</td><td class="weekend available" data-title="r3c6">22</td></tr><tr><td class="weekend available" data-title="r4c0">23</td><td class="available" data-title="r4c1">24</td><td class="available" data-title="r4c2">25</td><td class="available" data-title="r4c3">26</td><td class="available" data-title="r4c4">27</td><td class="available" data-title="r4c5">28</td><td class="weekend available" data-title="r4c6">29</td></tr><tr><td class="weekend available" data-title="r5c0">30</td><td class="available" data-title="r5c1">31</td><td class="off available" data-title="r5c2">1</td><td class="off available" data-title="r5c3">2</td><td class="off available" data-title="r5c4">3</td><td class="off available" data-title="r5c5">4</td><td class="weekend off available" data-title="r5c6">5</td></tr></tbody></table></div></div><div class="calendar right" style="display: none;"><div class="daterangepicker_input"><input class="input-mini form-control" type="text" name="daterangepicker_end" value="" style="display: none;"><i class="fa fa-calendar glyphicon glyphicon-calendar" style="display: none;"></i><div class="calendar-time" style="display: none;"><div></div><i class="fa fa-clock-o glyphicon glyphicon-time"></i></div></div><div class="calendar-table"><table class="table-condensed"><thead><tr><th></th><th colspan="5" class="month">Nov 2016</th><th class="next available"><i class="fa fa-chevron-right glyphicon glyphicon-chevron-right"></i></th></tr><tr><th>Su</th><th>Mo</th><th>Tu</th><th>We</th><th>Th</th><th>Fr</th><th>Sa</th></tr></thead><tbody><tr><td class="weekend off available" data-title="r0c0">30</td><td class="off available" data-title="r0c1">31</td><td class="available" data-title="r0c2">1</td><td class="available" data-title="r0c3">2</td><td class="available" data-title="r0c4">3</td><td class="available" data-title="r0c5">4</td><td class="weekend available" data-title="r0c6">5</td></tr><tr><td class="weekend available" data-title="r1c0">6</td><td class="available" data-title="r1c1">7</td><td class="available" data-title="r1c2">8</td><td class="available" data-title="r1c3">9</td><td class="available" data-title="r1c4">10</td><td class="available" data-title="r1c5">11</td><td class="weekend available" data-title="r1c6">12</td></tr><tr><td class="weekend available" data-title="r2c0">13</td><td class="available" data-title="r2c1">14</td><td class="available" data-title="r2c2">15</td><td class="available" data-title="r2c3">16</td><td class="available" data-title="r2c4">17</td><td class="available" data-title="r2c5">18</td><td class="weekend available" data-title="r2c6">19</td></tr><tr><td class="weekend available" data-title="r3c0">20</td><td class="available" data-title="r3c1">21</td><td class="available" data-title="r3c2">22</td><td class="available" data-title="r3c3">23</td><td class="available" data-title="r3c4">24</td><td class="available" data-title="r3c5">25</td><td class="weekend available" data-title="r3c6">26</td></tr><tr><td class="weekend available" data-title="r4c0">27</td><td class="available" data-title="r4c1">28</td><td class="available" data-title="r4c2">29</td><td class="available" data-title="r4c3">30</td><td class="off available" data-title="r4c4">1</td><td class="off available" data-title="r4c5">2</td><td class="weekend off available" data-title="r4c6">3</td></tr><tr><td class="weekend off available" data-title="r5c0">4</td><td class="off available" data-title="r5c1">5</td><td class="off available" data-title="r5c2">6</td><td class="off available" data-title="r5c3">7</td><td class="off available" data-title="r5c4">8</td><td class="off available" data-title="r5c5">9</td><td class="weekend off available" data-title="r5c6">10</td></tr></tbody></table></div></div><div class="ranges" style="display: none;"><div class="range_inputs"><button class="applyBtn btn btn-sm btn-success" type="button">Apply</button> <button class="cancelBtn btn btn-sm btn-default" type="button">Cancel</button></div></div></div>

                    <fieldset>
                        <div class="control-group">
                            <div class="controls">
                                <div class="col-md-8 xdisplay_inputx form-group has-feedback">
                                    <input type="text" class="form-control has-feedback-left" id="single_cal" placeholder="Fecha de Vencimiento" name="fechaVencimiento" aria-describedby="inputSuccess2Status4">
                                    <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                    <span id="inputSuccess2Status4" class="sr-only">(success)</span>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>


                <div class="col-xs-4">
                    <label style="margin-left:15px; margin-top: 10px;">Capital Mínimo</label>
                    <div class="item form-group">
                        <input style="text-align: right;" min="0" id="txtMinimo" type="number" class="form-control" />
                    </div>
                </div>

                <div class="col-xs-4">
                    <label style="margin-left:15px; margin-top: 10px;">Notificaciones</label>
                    <button id="btnNotificaciones" onclick="mdlUsuarios(this)" style="margin-left:25px; display: block;" class="btn btn-primary btn-sm" type="button"></button>
                </div>

                <div class="col-xs-4">
                    <label style="margin-left:15px; margin-top: 10px;">Activo / Inactivo</label>
                    <p style="margin-left: 10px;">
                        Activo:
                        <input type="checkbox" class="flat" id="cbActivo" value="1"/>
                    </p>
                </div>

                

            </div>
                <div class="modal-footer">
                    <button id="btnCancelar" type="button" data-dismiss="modal" class="btn btn-default pull-left"><i class="fa fa-close"></i> Cancelar</button>
                    <button id="btnEditar" type="button" onclick="modificar(this)" class="btn btn-warning"><i class='fa fa-pencil'></i> Editar</button>
                    <button id="btnAgregar" type="button" onclick="agregar()" class="btn btn-primary"><i class='fa fa-plus'></i> Agregar</button>
                </div>
            </form>

        </div>
    </div>
</div>

<div id="mdlFondeo" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel2">Fondeo de Cuenta</h4>
            </div>
            <div class="modal-body">
            <form>
                <label style="margin-left:15px;">Monto</label>
                <div class="item form-group">
                    <div class="col-xs-12">
                        <input min="1" style="width: 75%; text-align: right;" id="txtMonto" type="number" value="0.00" class="form-control" />
                    </div>
                </div>
            </form>
            </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default pull-left"><i class="fa fa-close"></i> Cancelar</button>
                    <button id="btnFondeo" type="button" onclick="fondear(this)" class="btn btn-info"><i class='fa fa-usd'></i> Fondear</button>
                </div>
            

        </div>
    </div>
</div>

<div id="mdlUsuarios" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel2">Usuarios a notificar</h4>
            </div>
            <div class="modal-body">
                <form>
                    <table id="tblUsuarios" class="table table-striped">
                        <thead>
                            <tr class="headings">
                                <th style="width: 8%;" class="column-title">Selecc.</th>
                                <th class="column-title">Nombre</th>
                                <th class="column-title">Puesto</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default pull-left"><i class="fa fa-close"></i> Cancelar</button>
                <button type="button" onclick="asignarNotificaciones()" class="btn btn-primary"><i class='fa fa-check'></i> Aceptar</button>
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
<!-- Custom Theme Scripts -->
<script src=<?= base_url("template/build/js/custom.js"); ?>></script>
<!-- bootstrap-daterangepicker -->
<script src=<?= base_url("template/vendors/moment/min/moment.min.js") ?>></script>
<script src=<?= base_url("template/vendors/bootstrap-daterangepicker/daterangepicker.js") ?>></script>
<!-- CUSTOM JS FILE -->
<script src=<?=base_url("template/js/custom/funciones.js"); ?>></script>
<!-- JS FILE -->
<script src=<?= base_url("application/views/configuracion/compras/js/pagos.js"); ?>></script>
<script>
    var priv_gestion = '<?= $this->session->privilegios['gestionar_recursos'] ?>';

    $(function(){
        load();
    });
    
</script>
</body>
</html>
