<!-- page content -->
<div class="right_col" role="main">
    <div class="">

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Logística</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">

                            <div class="col-lg-12 col-md-12 col-sm-12">

                                <p style="display: inline;">
                                    Solo recorridos pendientes:
                                    <input type="checkbox" class="flat busqueda" name="rbBusqueda" id="rbPendientes" checked />
                                </p>
                            </div>


                        </div>
                    </div>
                </div>
                
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="x_panel">
                    <div class="x_content">
                        <div class="accordion" id="accordion1" role="tablist" aria-multiselectable="true">
                            <div id="paneles">

                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>
<!-- /page content -->



<!-- MODALS -->
<div id="mdlEntrega" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Entrega</h4>
            </div>
            <div class="modal-body">
                <form>

                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <center>
                                <label style="margin-right: 5px;" id="lbl1" for="rb1" class="control-label">Entregado</label>
                                <input name="rbModal" id="rb1" value="1" type="radio" class="flat">
                                <label style="margin-right: 5px;" id="lbl2" for="rb2" class="control-label">No Entregado</label>
                                <input name="rbModal" id="rb2" value="0" type="radio" class="flat">
                                <!--
                                    <button type="button" class="btn btn-danger"><i class='fa fa-close'></i> No Entregado</button>
                                    <button type="button" class="btn btn-success"><i class='fa fa-check'></i> Entregado</button>
                                -->
                            </center>
                        </div>
                    </div>

                    <div style="margin-top: 5px;" class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <center style="margin: 5%;">
                                <h3 id="mdlLblCliente"></h3>
                                <label class="control-label">Comentarios</label>
                                <div class="item form-group">
                                    <textarea style="resize: none; width: 75%;" id="txtComentarios" class="form-control"></textarea>
                                </div>
                                <button type="button" id="btnAgregarFactura" onclick="mdlFacturas()" class="btn btn-primary btn-xs pull-left"><i class='fa fa-plus'></i> Agregar</button>    
                                <table id="mdlTable" class="table">
                                    <thead>
                                        <tr>
                                            <th>Factura</th>
                                            <th>Acción</th>
                                            <th>Estatus</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </center>
                            
                        </div>
                    </div>

                    
                    <div id="divReqRecolecta" style="margin-top: 25px; display:none;" class="row">
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <center>
                                <!--
                                    <label style="margin-right: 7px;" class="control-label">Dejada con cliente</label>
                                    <input id="cbRecolecta" type="checkbox" class="flat">
                                -->
                                <p style="display: inline;">
                                    <label for="rbRetornada">Retornada:</label>
                                    <input type="radio" class="flat" name="rbRecolecta" id="rbRetornada" value="0"/>
                                    <label for="rbDejada">Dejada con cliente:</label>
                                    <input type="radio" class="flat" name="rbRecolecta" id="rbDejada" value="1" />
                                </p>
                            </center>
                        </div>

                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <div id="divFecha" style="width: 80%; display: none;">
                                <center>
                                    <label>Fecha de Retorno:</label>
                                    <div id="dtpRetorno" class="daterangepicker dropdown-menu ltr single opensright show-calendar picker_4 xdisplay"><div class="calendar left single" style="display: block;"><div class="daterangepicker_input"><input class="input-mini form-control active" type="text" name="daterangepicker_start" value="" style="display: none;"><i class="fa fa-calendar glyphicon glyphicon-calendar" style="display: none;"></i><div class="calendar-time" style="display: none;"><div></div><i class="fa fa-clock-o glyphicon glyphicon-time"></i></div></div><div class="calendar-table"><table class="table-condensed"><thead><tr><th class="prev available"><i class="fa fa-chevron-left glyphicon glyphicon-chevron-left"></i></th><th colspan="5" class="month">Oct 2016</th><th class="next available"><i class="fa fa-chevron-right glyphicon glyphicon-chevron-right"></i></th></tr><tr><th>Su</th><th>Mo</th><th>Tu</th><th>We</th><th>Th</th><th>Fr</th><th>Sa</th></tr></thead><tbody><tr><td class="weekend off available" data-title="r0c0">25</td><td class="off available" data-title="r0c1">26</td><td class="off available" data-title="r0c2">27</td><td class="off available" data-title="r0c3">28</td><td class="off available" data-title="r0c4">29</td><td class="off available" data-title="r0c5">30</td><td class="weekend available" data-title="r0c6">1</td></tr><tr><td class="weekend available" data-title="r1c0">2</td><td class="available" data-title="r1c1">3</td><td class="available" data-title="r1c2">4</td><td class="available" data-title="r1c3">5</td><td class="available" data-title="r1c4">6</td><td class="available" data-title="r1c5">7</td><td class="weekend available" data-title="r1c6">8</td></tr><tr><td class="weekend available" data-title="r2c0">9</td><td class="available" data-title="r2c1">10</td><td class="available" data-title="r2c2">11</td><td class="available" data-title="r2c3">12</td><td class="available" data-title="r2c4">13</td><td class="available" data-title="r2c5">14</td><td class="weekend available" data-title="r2c6">15</td></tr><tr><td class="weekend available" data-title="r3c0">16</td><td class="available" data-title="r3c1">17</td><td class="today active start-date active end-date available" data-title="r3c2">18</td><td class="available" data-title="r3c3">19</td><td class="available" data-title="r3c4">20</td><td class="available" data-title="r3c5">21</td><td class="weekend available" data-title="r3c6">22</td></tr><tr><td class="weekend available" data-title="r4c0">23</td><td class="available" data-title="r4c1">24</td><td class="available" data-title="r4c2">25</td><td class="available" data-title="r4c3">26</td><td class="available" data-title="r4c4">27</td><td class="available" data-title="r4c5">28</td><td class="weekend available" data-title="r4c6">29</td></tr><tr><td class="weekend available" data-title="r5c0">30</td><td class="available" data-title="r5c1">31</td><td class="off available" data-title="r5c2">1</td><td class="off available" data-title="r5c3">2</td><td class="off available" data-title="r5c4">3</td><td class="off available" data-title="r5c5">4</td><td class="weekend off available" data-title="r5c6">5</td></tr></tbody></table></div></div><div class="calendar right" style="display: none;"><div class="daterangepicker_input"><input class="input-mini form-control" type="text" name="daterangepicker_end" value="" style="display: none;"><i class="fa fa-calendar glyphicon glyphicon-calendar" style="display: none;"></i><div class="calendar-time" style="display: none;"><div></div><i class="fa fa-clock-o glyphicon glyphicon-time"></i></div></div><div class="calendar-table"><table class="table-condensed"><thead><tr><th></th><th colspan="5" class="month">Nov 2016</th><th class="next available"><i class="fa fa-chevron-right glyphicon glyphicon-chevron-right"></i></th></tr><tr><th>Su</th><th>Mo</th><th>Tu</th><th>We</th><th>Th</th><th>Fr</th><th>Sa</th></tr></thead><tbody><tr><td class="weekend off available" data-title="r0c0">30</td><td class="off available" data-title="r0c1">31</td><td class="available" data-title="r0c2">1</td><td class="available" data-title="r0c3">2</td><td class="available" data-title="r0c4">3</td><td class="available" data-title="r0c5">4</td><td class="weekend available" data-title="r0c6">5</td></tr><tr><td class="weekend available" data-title="r1c0">6</td><td class="available" data-title="r1c1">7</td><td class="available" data-title="r1c2">8</td><td class="available" data-title="r1c3">9</td><td class="available" data-title="r1c4">10</td><td class="available" data-title="r1c5">11</td><td class="weekend available" data-title="r1c6">12</td></tr><tr><td class="weekend available" data-title="r2c0">13</td><td class="available" data-title="r2c1">14</td><td class="available" data-title="r2c2">15</td><td class="available" data-title="r2c3">16</td><td class="available" data-title="r2c4">17</td><td class="available" data-title="r2c5">18</td><td class="weekend available" data-title="r2c6">19</td></tr><tr><td class="weekend available" data-title="r3c0">20</td><td class="available" data-title="r3c1">21</td><td class="available" data-title="r3c2">22</td><td class="available" data-title="r3c3">23</td><td class="available" data-title="r3c4">24</td><td class="available" data-title="r3c5">25</td><td class="weekend available" data-title="r3c6">26</td></tr><tr><td class="weekend available" data-title="r4c0">27</td><td class="available" data-title="r4c1">28</td><td class="available" data-title="r4c2">29</td><td class="available" data-title="r4c3">30</td><td class="off available" data-title="r4c4">1</td><td class="off available" data-title="r4c5">2</td><td class="weekend off available" data-title="r4c6">3</td></tr><tr><td class="weekend off available" data-title="r5c0">4</td><td class="off available" data-title="r5c1">5</td><td class="off available" data-title="r5c2">6</td><td class="off available" data-title="r5c3">7</td><td class="off available" data-title="r5c4">8</td><td class="off available" data-title="r5c5">9</td><td class="weekend off available" data-title="r5c6">10</td></tr></tbody></table></div></div><div class="ranges" style="display: none;"><div class="range_inputs"><button class="applyBtn btn btn-sm btn-success" type="button">Apply</button> <button class="cancelBtn btn btn-sm btn-default" type="button">Cancel</button></div></div></div>
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

                                    <label>Entregado a:</label>
                                    <select style="margin: 0px;" required="required" class="select2_single form-control" id="opContactos" name="opContactos">
                                    </select>
                                </center>
                            </div>
                        </div>
                    </div>
                    
                </form>
            </div>
            <div class="modal-footer" style="display: none;">
                <button type="button" id="btnCancelar" class="btn btn-default pull-left" data-dismiss="modal"><i class='fa fa-close'></i> Cancelar</button>
                <button type="button" id="btn1" onclick="marcarComo(this)" value="ENTREGADA" class="btn btn-success"><i class='fa fa-check'></i> Entregada</button>
                <button type="button" id="btn2" onclick="marcarComo(this)" value="NO ENTREGADA" class="btn btn-danger"><i class='fa fa-close'></i> No Entregada</button>
            </div>

        </div>
    </div>
</div>

<div id="mdlFacturas" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Agregar factura a recolecta</h4>
            </div>
            <div class="modal-body">
                <form>
                    <center>
                        <table id="tblFacturas" class="table">
                            <thead>
                                <tr>
                                    <th>Selecc.</th>
                                    <th>Factura</th>
                                    <th>Estatus</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </center>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class='fa fa-close'></i> Cancelar</button>
                <button type="button" onclick="agregarFacturaNueva()" class="btn btn-success"><i class='fa fa-chech'></i> Aceptar</button>
            </div>

        </div>
    </div>
</div>

<div id="mdlRequisitos" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Requisitos de empresas</h4>
            </div>
            <div class="modal-body">
                <form>
                    <center>
                        <table id="tblEmpresasRecorrido" class="table">
                            <thead>
                                <tr>
                                    <th width="15%">Selecc.</th>
                                    <th>Cliente</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </center>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class='fa fa-close'></i> Cancelar</button>
                <button type="button" onclick="aceptarRecorrido()" class="btn btn-success"><i class='fa fa-check'></i> Aceptar</button>
            </div>

        </div>
    </div>
</div>


<!-- DATOS DE CONTACTOS -->
<div id="mdlContacto" class="modal fade" role="dialog" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Contacto</h4>
              </div>
              <form id="formContacto" class="form-horizontal form-label-left">
              <div class="modal-body">
              <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Nombre</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input maxlength="200" id="nombreContacto" class="form-control col-md-7 col-xs-12" name="nombre" placeholder="" required="required" type="text">
                </div>
              </div>
              
              <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Teléfono</label>
                  <div class="col-md-3 col-sm-3 col-xs-12">
                      <input maxlength="14" oninput="phoneMask(this)" onkeypress="return event.charCode >= 48 && event.charCode <= 57" id="telefonoContacto" class="form-control col-md-7 col-xs-12" name="telefono" placeholder="" required="required" type="text">
                  </div>
                  <label class="control-label col-md-1 col-sm-1 col-xs-12" for="name">Ext</label>
                  <div class="col-md-2 col-sm-2 col-xs-12">
                      <input maxlength="5" id="ext" class="form-control col-md-7 col-xs-12" name="ext" onkeypress="return event.charCode >= 48 && event.charCode <= 57" type="text">
                  </div>
              </div>

              <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Celular 1</label>
                  <div class="col-md-3 col-sm-3 col-xs-12">
                      <input maxlength="14" oninput="phoneMask(this)" onkeypress="return event.charCode >= 48 && event.charCode <= 57" id="celularContacto" class="form-control col-md-7 col-xs-12" name="celular" placeholder="" required="required" type="text">
                  </div>
                  <div class="col-md-2 col-sm-2 col-xs-12">
                    
                  </div>
              </div>

              <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Celular 2</label>
                  <div class="col-md-3 col-sm-3 col-xs-12">
                      <input maxlength="14" oninput="phoneMask(this)" onkeypress="return event.charCode >= 48 && event.charCode <= 57" id="celularContacto2" class="form-control col-md-7 col-xs-12" name="celular2" type="text">
                  </div>
              </div>

              <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Correo</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                      <input maxlength="100" style="text-transform: lowercase;" id="correoContacto" class="form-control col-md-7 col-xs-12" name="correo" placeholder="" required="required" type="text">
                  </div>
              </div>

              <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Puesto</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                      <input maxlength="80" id="puestoContacto" class="form-control col-md-7 col-xs-12" name="puesto" placeholder="" required="required" type="text">
                  </div>
              </div>

              <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Red Social</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                      <input maxlength="80" id="red_social" class="form-control col-md-7 col-xs-12" name="red_social" type="text">
                  </div>
              </div>


              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button id="btnModalContacto" onclick="agregarContacto()" type="button" class="btn btn-primary">Agregar Contacto</button>
              </div>
              </form>
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
<script src=<?= base_url("application/views/logistica/js/recorridos.js"); ?>></script>
<script>

    $(function(){
        load();
    });


</script>
</body>
</html>
