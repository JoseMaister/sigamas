<!-- page content -->
<div class="right_col" role="main">
    <div class="">

        <div class="clearfix"></div>

        <div class="row">

            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Construcción de PO</h2>
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
                        <div class="col-md-4 col-sm-12">
                                <p class="lead" id="lblProveedor" style="display: inline;"></p><br>
                                <br>
                                <p class="lead" style="display: inline; margin-right: 15px;">Contacto: </p>
                                <button type="button" onclick='mdlContactos()' class="btn btn-primary btn-xs"><i class="fa fa-users"></i> Ver Contactos</button>
                                <br>
                                <div id='divContacto' style='display: none;'>
                                    <p class="lead" style="display: inline;">Nombre:  <small id='lblConNombre'></small></p><br>
                                    <p class="lead" style="display: inline;">Puesto:  <small id='lblConPuesto'></small></p><br>
                                    <p class="lead" style="display: inline;">Correo:  <small id='lblConCorreo'></small></p>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <p class="lead" style="display: inline; margin-right: 15px;">Shipping Address: </p>
                                <select onchange="selectShipp()" style="display: inline; width: 40%; margin-bottom: 10px;" required="required" class="select2_single form-control" id="opShipping">
                                </select>

                                <p class="lead" style="display: inline; margin-top: 10px; font-size: 20px;"><br><small id="txtShipping"></small></p>
                                <p class="lead" style="display: inline; margin-top: 10px; font-size: 20px;"><br><b><small id="txtShippingWarning"></small></b></p>

                                <br>
                                <p class="lead" style="display: inline; margin-right: 15px; margin-top: 20px;">Billing Address: </p>
                                <select onchange="selectBill()" style="display: inline; width: 40%; margin-bottom: 10px;" required="required" class="select2_single form-control" id="opBilling">
                                </select>
                                <p class="lead" style="display: inline; font-size: 20px;"><br><small id="txtBilling"></small></p>
                            </div>

                            <div class="col-md-4 col-sm-12">
                                <p class="lead" style="display: inline; margin-right: 15px;">Método de Pago: </p>
                                <button type="button" onclick='mdlMetodosPago()' class="btn btn-primary btn-xs"><i class="fa fa-credit-card"></i> Métodos de Pago</button>
                                <p class="lead" style="display: inline; margin-top: 10px;"><br><small id="txtMetodo"></small></p>

                                <br><br>
                                <div style="display:none;" id="divRecurso">
                                    <p class="lead" style="display: inline; margin-right: 15px;">Recurso: </p>
                                    <select style="display: inline; width: 40%; margin-bottom: 10px;" required="required" class="select2_single form-control" id="opRecurso">
                                    </select>
                                </div>

                                <br><br>
                                <p class="lead" style="display: inline; margin-right: 15px;">Fecha de Cobro: </p>
                                <div id="fechaCobro" class="daterangepicker dropdown-menu ltr single opensright show-calendar picker_4 xdisplay"><div class="calendar left single" style="display: block;"><div class="daterangepicker_input"><input class="input-mini form-control active" type="text" name="daterangepicker_start" value="" style="display: none;"><i class="fa fa-calendar glyphicon glyphicon-calendar" style="display: none;"></i><div class="calendar-time" style="display: none;"><div></div><i class="fa fa-clock-o glyphicon glyphicon-time"></i></div></div><div class="calendar-table"><table class="table-condensed"><thead><tr><th class="prev available"><i class="fa fa-chevron-left glyphicon glyphicon-chevron-left"></i></th><th colspan="5" class="month">Oct 2016</th><th class="next available"><i class="fa fa-chevron-right glyphicon glyphicon-chevron-right"></i></th></tr><tr><th>Su</th><th>Mo</th><th>Tu</th><th>We</th><th>Th</th><th>Fr</th><th>Sa</th></tr></thead><tbody><tr><td class="weekend off available" data-title="r0c0">25</td><td class="off available" data-title="r0c1">26</td><td class="off available" data-title="r0c2">27</td><td class="off available" data-title="r0c3">28</td><td class="off available" data-title="r0c4">29</td><td class="off available" data-title="r0c5">30</td><td class="weekend available" data-title="r0c6">1</td></tr><tr><td class="weekend available" data-title="r1c0">2</td><td class="available" data-title="r1c1">3</td><td class="available" data-title="r1c2">4</td><td class="available" data-title="r1c3">5</td><td class="available" data-title="r1c4">6</td><td class="available" data-title="r1c5">7</td><td class="weekend available" data-title="r1c6">8</td></tr><tr><td class="weekend available" data-title="r2c0">9</td><td class="available" data-title="r2c1">10</td><td class="available" data-title="r2c2">11</td><td class="available" data-title="r2c3">12</td><td class="available" data-title="r2c4">13</td><td class="available" data-title="r2c5">14</td><td class="weekend available" data-title="r2c6">15</td></tr><tr><td class="weekend available" data-title="r3c0">16</td><td class="available" data-title="r3c1">17</td><td class="today active start-date active end-date available" data-title="r3c2">18</td><td class="available" data-title="r3c3">19</td><td class="available" data-title="r3c4">20</td><td class="available" data-title="r3c5">21</td><td class="weekend available" data-title="r3c6">22</td></tr><tr><td class="weekend available" data-title="r4c0">23</td><td class="available" data-title="r4c1">24</td><td class="available" data-title="r4c2">25</td><td class="available" data-title="r4c3">26</td><td class="available" data-title="r4c4">27</td><td class="available" data-title="r4c5">28</td><td class="weekend available" data-title="r4c6">29</td></tr><tr><td class="weekend available" data-title="r5c0">30</td><td class="available" data-title="r5c1">31</td><td class="off available" data-title="r5c2">1</td><td class="off available" data-title="r5c3">2</td><td class="off available" data-title="r5c4">3</td><td class="off available" data-title="r5c5">4</td><td class="weekend off available" data-title="r5c6">5</td></tr></tbody></table></div></div><div class="calendar right" style="display: none;"><div class="daterangepicker_input"><input class="input-mini form-control" type="text" name="daterangepicker_end" value="" style="display: none;"><i class="fa fa-calendar glyphicon glyphicon-calendar" style="display: none;"></i><div class="calendar-time" style="display: none;"><div></div><i class="fa fa-clock-o glyphicon glyphicon-time"></i></div></div><div class="calendar-table"><table class="table-condensed"><thead><tr><th></th><th colspan="5" class="month">Nov 2016</th><th class="next available"><i class="fa fa-chevron-right glyphicon glyphicon-chevron-right"></i></th></tr><tr><th>Su</th><th>Mo</th><th>Tu</th><th>We</th><th>Th</th><th>Fr</th><th>Sa</th></tr></thead><tbody><tr><td class="weekend off available" data-title="r0c0">30</td><td class="off available" data-title="r0c1">31</td><td class="available" data-title="r0c2">1</td><td class="available" data-title="r0c3">2</td><td class="available" data-title="r0c4">3</td><td class="available" data-title="r0c5">4</td><td class="weekend available" data-title="r0c6">5</td></tr><tr><td class="weekend available" data-title="r1c0">6</td><td class="available" data-title="r1c1">7</td><td class="available" data-title="r1c2">8</td><td class="available" data-title="r1c3">9</td><td class="available" data-title="r1c4">10</td><td class="available" data-title="r1c5">11</td><td class="weekend available" data-title="r1c6">12</td></tr><tr><td class="weekend available" data-title="r2c0">13</td><td class="available" data-title="r2c1">14</td><td class="available" data-title="r2c2">15</td><td class="available" data-title="r2c3">16</td><td class="available" data-title="r2c4">17</td><td class="available" data-title="r2c5">18</td><td class="weekend available" data-title="r2c6">19</td></tr><tr><td class="weekend available" data-title="r3c0">20</td><td class="available" data-title="r3c1">21</td><td class="available" data-title="r3c2">22</td><td class="available" data-title="r3c3">23</td><td class="available" data-title="r3c4">24</td><td class="available" data-title="r3c5">25</td><td class="weekend available" data-title="r3c6">26</td></tr><tr><td class="weekend available" data-title="r4c0">27</td><td class="available" data-title="r4c1">28</td><td class="available" data-title="r4c2">29</td><td class="available" data-title="r4c3">30</td><td class="off available" data-title="r4c4">1</td><td class="off available" data-title="r4c5">2</td><td class="weekend off available" data-title="r4c6">3</td></tr><tr><td class="weekend off available" data-title="r5c0">4</td><td class="off available" data-title="r5c1">5</td><td class="off available" data-title="r5c2">6</td><td class="off available" data-title="r5c3">7</td><td class="off available" data-title="r5c4">8</td><td class="off available" data-title="r5c5">9</td><td class="weekend off available" data-title="r5c6">10</td></tr></tbody></table></div></div><div class="ranges" style="display: none;"><div class="range_inputs"><button class="applyBtn btn btn-sm btn-success" type="button">Apply</button> <button class="cancelBtn btn btn-sm btn-default" type="button">Cancel</button></div></div></div>
                                
                                

                                <fieldset>
                                    <div class="control-group">
                                        <div class="controls">
                                            <div class="col-md-8 xdisplay_inputx form-group has-feedback">
                                                <input type="text" class="form-control has-feedback-left" id="single_cal" placeholder="Fecha tentativa de cobro" name="fechaCobro" aria-describedby="inputSuccess2Status4">
                                                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                                <span id="inputSuccess2Status4" class="sr-only">(success)</span>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>

                                <br>

                                <div id="divRMA" style="display: none;">
                                    <p class="lead" style="display: inline; margin-right: 15px;">RMA:</p>
                                    <input id="txtRMA" maxlength="25" style="margin-left: 12px; width: 62%;" class="form-control" type="text"/>
                                </div>

                            </div>
                        </div>

                        

                    </div>
                </div>
            </div>





            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_content">
                    <div class="table-responsive">
                        <table id="tabla" class="table">
                            <thead>
                                <tr class="headings">
                                    <th style='width: 04%;' class="column-title">#</th>
                                    <th style='width: 06%;' class="column-title">Cant.</th>
                                    <th style='width: 60%;' class="column-title">Concepto</th>
                                    <th style='width: 10%; text-align: right' class="column-title">Precio U.</th>
                                    <th style='width: 10%; text-align: right' class="column-title">Importe</th>
                                    <th style='width: 08%; text-align: right' class="column-title">Opciones</th>
                                </tr>
                            </thead>
                            <tbody class='con'>
                            </tbody>
                            <tbody class='sub'>
                            </tbody>
                        </table>

                        <button type="button" onclick='cancelar()' class="btn btn-danger btn-md"><i class="fa fa-close"></i> Cancelar</button>
                        <button type="button" onclick='aprobacion()' class="btn btn-success btn-md pull-right"><i class="fa fa-clock-o"></i> Solicitar Aprobación</button>
                    </div>
                    </div>
                </div>
            </div>




        </div>



    </div>
</div>
<!-- /page content -->



<!-- MODALS -->

<div id="mdlContactos" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Contactos</h4>
            </div>

            <div class="modal-body">
                <form>
                    <table id="tblContactos" class="data table table-striped no-margin">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Puesto</th>
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

<div id="mdlMetodosPago" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Metodos de Pago</h4>
            </div>

            <div class="modal-body">
                <form>
                    <table id="tblMetodosPago" class="data table table-striped no-margin">
                        <thead>
                            <tr>
                                <th>Tipo</th>
                                <th>Nombre</th>
                                <th>Comentarios</th>
                                <th>Disponible</th>
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

<div id="mdlDescuento" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Descuento</h4>
            </div>

            <div class="modal-body">
                <form>
                    <center>
                        <input id='txtDescuento' class='form-control' style='width: 50%; text-align: right;' type='number'/>
                    </center>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Cancelar</button>
                <button onclick='setDescuento()' type="button" class="btn btn-primary"><i class="fa fa-check"></i> Aplicar</button>
            </div>

        </div>
    </div>
</div>

<div id="mdlImpuestos" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Seleccionar Impuesto</h4>
            </div>

            <div class="modal-body">
                <form>
                    <table id="tblImpuestos" class="data table table-striped no-margin">
                        <thead>
                            <tr>
                                <th>Impuesto</th>
                                <th>Porcentaje</th>
                                <th>Opcion</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Exento</td>
                                <td>0.00%</td>
                                <td><button data-imp='Exento (0.00%)' data-factor='0.00' type='button' class='btn btn-primary btn-xs' onclick='setImpuesto(this)'><i class='fa fa-plus'></i> Agregar</button></td>
                            </tr>
                            <tr>
                                <td>Frontera</td>
                                <td>16.00%</td>
                                <td><button data-imp='Frontera (16.00%)' data-factor='0.16' type='button' class='btn btn-primary btn-xs' onclick='setImpuesto(this)'><i class='fa fa-plus'></i> Agregar</button></td>
                            </tr>
                            <tr>
                                <td>IVA 8%</td>
                                <td>8.00%</td>
                                <td><button data-imp='IVA 8% (8.00%)' data-factor='0.08' type='button' class='btn btn-primary btn-xs' onclick='setImpuesto(this)'><i class='fa fa-plus'></i> Agregar</button></td>
                            </tr>
                            <tr>
                                <td>Interior</td>
                                <td>16.00%</td>
                                <td><button data-imp='Interior (16.00%)' data-factor='0.16' type='button' class='btn btn-primary btn-xs' onclick='setImpuesto(this)'><i class='fa fa-plus'></i> Agregar</button></td>
                            </tr>
                            <tr>
                                <td>Texas</td>
                                <td>8.25%</td>
                                <td><button data-imp='Texas (8.25%)' data-factor='0.0825' type='button' class='btn btn-primary btn-xs' onclick='setImpuesto(this)'><i class='fa fa-plus'></i> Agregar</button></td>
                            </tr>
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
<!-- bootstrap-daterangepicker -->
<script src=<?= base_url("template/vendors/moment/min/moment.min.js") ?>></script>
<script src=<?= base_url("template/vendors/bootstrap-daterangepicker/daterangepicker.js") ?>></script>
<!-- JS FILE -->
<script src=<?= base_url("application/views/ordenes_compra/js/editar_po.js"); ?>></script>
<script>
    var id = '<?= $id ?>';

    $(function(){
        load();
    });

    
</script>
</body>
</html>
