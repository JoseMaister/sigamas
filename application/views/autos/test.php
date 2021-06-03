<!-- page content -->
<div class="right_col" role="main">
    <div class="">

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Revisiones de Autos</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            </li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <form id="formulario" method="POST" action=<?= base_url('autos/test') ?> class="form-horizontal form-label-left" novalidate>
                            <input type="hidden" name="auto" value="">
                              <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="placas">Placas:
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <h3>TEST</h3>
                                    <input type="hidden" name="placas" value="">
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kilometraje">Kilometraje <span class="">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="name" class="form-control col-md-7 col-xs-12" name="kilometraje" placeholder="" type="text">
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="gasolina">Combustible <span class="">*</span></label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <center>
                                        <h2>TEST</h2>
                                        <input name="gasolina" class="knob" data-width="100" data-height="120" data-angleOffset=-125 data-angleArc=250 data-fgColor="#34495E" value="0">
                                    </center>
                                </div>

                            </div>
                            <div class="ln_solid"></div>
                            <section class="niveles">
                              <h3>Niveles</h3>
                              <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Aceite de Motor </label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                      <p>
                                          MIN:
                                          <input type="radio" class="flat" name="aceite" value="MIN" checked />
                                          1/2:
                                          <input type="radio" class="flat" name="aceite" value="1/2"/>
                                          MAX:
                                          <input type="radio" class="flat" name="aceite" value="MAX"/>
                                      </p>
                                  </div>
                              </div>
                              <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="condAceite">Condiciones de Aceite </label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                      <p>
                                          OK:
                                          <input type="radio" class="flat" name="condAceite" value="OK" checked />
                                          Cambiar:
                                          <input type="radio" class="flat" name="condAceite" value="CAMBIO" />
                                      </p>
                                  </div>
                              </div>
                              <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Liquido Limpia Parabrisas </label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                      <p>
                                          Delantero:
                                          <input type="checkbox" class="flat" name="llpbDelantero" value="OK"/>
                                          Trasero:
                                          <input type="checkbox" class="flat" name="llpbTrasero"/>
                                      </p>
                                  </div>
                              </div>
                              <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Refrigerante</label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                      <p>
                                          Deposito:
                                          <input type="checkbox" class="flat" name="deposito" value="OK" />
                                          Radiador:
                                          <input type="checkbox" class="flat" name="radiador" value="OK" />
                                      </p>
                                  </div>
                              </div>
                              <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Liquido de Frenos</label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                      <p>
                                          Nivel:
                                          <input type="checkbox" class="flat" name="ldfNivel" value="OK" />
                                          Pedal:
                                          <input type="checkbox" class="flat" name="ldfPedal" value="OK" />
                                      </p>
                                  </div>
                              </div>
                              <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="direccionH">Dirección Hidraulica</label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                      <p>
                                          MIN:
                                          <input type="radio" class="flat" name="direccionH" id="direccionHMin" value="MIN" checked />
                                          1/2:
                                          <input type="radio" class="flat" name="direccionH" id="direccionHMid" value="MID" />
                                          MAX:
                                          <input type="radio" class="flat" name="direccionH" id="direccionHMax" value="MAX" />
                                      </p>
                                  </div>
                              </div>
                              <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Comentarios <span class="">*</span>
                                  </label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                      <textarea rows='4' name="comentariosNiveles" class="form-control col-md-7 col-xs-12" ></textarea>
                                  </div>
                              </div>
                              <div class="ln_solid"></div>
                            </section>

                            <section class="luces">
                              <h3>Luces</h3>
                              <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Direccionales</label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                      <p>
                                          Izquierda:
                                          <input type="checkbox" class="flat" name="direccionalesLeft" value="OK" />
                                          Derecha:
                                          <input type="checkbox" class="flat" name="direccionalesRight" value="OK" />
                                      </p>
                                  </div>
                              </div>
                              <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Lamparas Bajas/Altas</label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                      <p>
                                          Izquierda:
                                          <input type="checkbox" class="flat" name="lampLeft" value="OK" />
                                          Derecha:
                                          <input type="checkbox" class="flat" name="lampRight" value="OK" />
                                      </p>
                                  </div>
                              </div>
                              <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Traseras y Freno</label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                      <p>
                                          Izquierda:
                                          <input type="checkbox" class="flat" name="rearLeft" value="OK" />
                                          Derecha:
                                          <input type="checkbox" class="flat" name="rearRight" value="OK" />
                                      </p>
                                  </div>
                              </div>
                              <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Otras</label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                      <p>
                                          Emergencia:
                                          <input type="checkbox" class="flat" name="emergencia" value="OK" />
                                          Reversa:
                                          <input type="checkbox" class="flat" name="reversa" value="OK" />
                                      </p>
                                  </div>
                              </div>
                              <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Comentarios <span class="">*</span>
                                  </label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                      <textarea rows='4' name="comentariosLuces" class="form-control col-md-7 col-xs-12"></textarea>
                                  </div>
                              </div>
                              <div class="ln_solid"></div>
                            </section>

                          <section class="interiores">
                            <h3>Interiores</h3>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="asientos">Tapiceria de Asientos</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="checkbox" class="flat" name="asientos" value="OK" />
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="controles">Controles y Manivelas en Puertas</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="checkbox" class="flat" name="controles" value="OK" />
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="herramientas">Kit de Herramientas</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="checkbox" class="flat" name="herramientas" value="OK" />
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tapetes">Tapetes Completos</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="checkbox" class="flat" name="tapetes" value="OK" />
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Comentarios<span>*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea rows='4' name="comentariosInteriores" class="form-control col-md-7 col-xs-12"></textarea>
                                </div>
                            </div>
                            <div class="ln_solid"></div>
                          </section>

                          <section class="documentacion">
                            <h3>Documentación</h3>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Placas</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <p>
                                        Delantera:
                                        <input type="checkbox" class="flat" name="placaDelantera" value="OK" />
                                        Trasera:
                                        <input type="checkbox" class="flat" name="placaTrasera" value="OK" />
                                    </p>
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarjeta de Gasolina</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="checkbox" class="flat" name="tarjetaGas" value="OK" />
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarjeta de Circulacion</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="checkbox" class="flat" name="tarjetaCirculacion" value="OK" />
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Poliza de Seguro</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="checkbox" class="flat" name="poliza" value="OK" />
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Vencimiento de Poliza</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div id="datetimepicker1" class="daterangepicker dropdown-menu ltr single opensright show-calendar picker_4 xdisplay"><div class="calendar left single" style="display: block;"><div class="daterangepicker_input"><input class="input-mini form-control active" type="text" name="daterangepicker_start" value="" style="display: none;"><i class="fa fa-calendar glyphicon glyphicon-calendar" style="display: none;"></i><div class="calendar-time" style="display: none;"><div></div><i class="fa fa-clock-o glyphicon glyphicon-time"></i></div></div><div class="calendar-table"><table class="table-condensed"><thead><tr><th class="prev available"><i class="fa fa-chevron-left glyphicon glyphicon-chevron-left"></i></th><th colspan="5" class="month">Oct 2016</th><th class="next available"><i class="fa fa-chevron-right glyphicon glyphicon-chevron-right"></i></th></tr><tr><th>Su</th><th>Mo</th><th>Tu</th><th>We</th><th>Th</th><th>Fr</th><th>Sa</th></tr></thead><tbody><tr><td class="weekend off available" data-title="r0c0">25</td><td class="off available" data-title="r0c1">26</td><td class="off available" data-title="r0c2">27</td><td class="off available" data-title="r0c3">28</td><td class="off available" data-title="r0c4">29</td><td class="off available" data-title="r0c5">30</td><td class="weekend available" data-title="r0c6">1</td></tr><tr><td class="weekend available" data-title="r1c0">2</td><td class="available" data-title="r1c1">3</td><td class="available" data-title="r1c2">4</td><td class="available" data-title="r1c3">5</td><td class="available" data-title="r1c4">6</td><td class="available" data-title="r1c5">7</td><td class="weekend available" data-title="r1c6">8</td></tr><tr><td class="weekend available" data-title="r2c0">9</td><td class="available" data-title="r2c1">10</td><td class="available" data-title="r2c2">11</td><td class="available" data-title="r2c3">12</td><td class="available" data-title="r2c4">13</td><td class="available" data-title="r2c5">14</td><td class="weekend available" data-title="r2c6">15</td></tr><tr><td class="weekend available" data-title="r3c0">16</td><td class="available" data-title="r3c1">17</td><td class="today active start-date active end-date available" data-title="r3c2">18</td><td class="available" data-title="r3c3">19</td><td class="available" data-title="r3c4">20</td><td class="available" data-title="r3c5">21</td><td class="weekend available" data-title="r3c6">22</td></tr><tr><td class="weekend available" data-title="r4c0">23</td><td class="available" data-title="r4c1">24</td><td class="available" data-title="r4c2">25</td><td class="available" data-title="r4c3">26</td><td class="available" data-title="r4c4">27</td><td class="available" data-title="r4c5">28</td><td class="weekend available" data-title="r4c6">29</td></tr><tr><td class="weekend available" data-title="r5c0">30</td><td class="available" data-title="r5c1">31</td><td class="off available" data-title="r5c2">1</td><td class="off available" data-title="r5c3">2</td><td class="off available" data-title="r5c4">3</td><td class="off available" data-title="r5c5">4</td><td class="weekend off available" data-title="r5c6">5</td></tr></tbody></table></div></div><div class="calendar right" style="display: none;"><div class="daterangepicker_input"><input class="input-mini form-control" type="text" name="daterangepicker_end" value="" style="display: none;"><i class="fa fa-calendar glyphicon glyphicon-calendar" style="display: none;"></i><div class="calendar-time" style="display: none;"><div></div><i class="fa fa-clock-o glyphicon glyphicon-time"></i></div></div><div class="calendar-table"><table class="table-condensed"><thead><tr><th></th><th colspan="5" class="month">Nov 2016</th><th class="next available"><i class="fa fa-chevron-right glyphicon glyphicon-chevron-right"></i></th></tr><tr><th>Su</th><th>Mo</th><th>Tu</th><th>We</th><th>Th</th><th>Fr</th><th>Sa</th></tr></thead><tbody><tr><td class="weekend off available" data-title="r0c0">30</td><td class="off available" data-title="r0c1">31</td><td class="available" data-title="r0c2">1</td><td class="available" data-title="r0c3">2</td><td class="available" data-title="r0c4">3</td><td class="available" data-title="r0c5">4</td><td class="weekend available" data-title="r0c6">5</td></tr><tr><td class="weekend available" data-title="r1c0">6</td><td class="available" data-title="r1c1">7</td><td class="available" data-title="r1c2">8</td><td class="available" data-title="r1c3">9</td><td class="available" data-title="r1c4">10</td><td class="available" data-title="r1c5">11</td><td class="weekend available" data-title="r1c6">12</td></tr><tr><td class="weekend available" data-title="r2c0">13</td><td class="available" data-title="r2c1">14</td><td class="available" data-title="r2c2">15</td><td class="available" data-title="r2c3">16</td><td class="available" data-title="r2c4">17</td><td class="available" data-title="r2c5">18</td><td class="weekend available" data-title="r2c6">19</td></tr><tr><td class="weekend available" data-title="r3c0">20</td><td class="available" data-title="r3c1">21</td><td class="available" data-title="r3c2">22</td><td class="available" data-title="r3c3">23</td><td class="available" data-title="r3c4">24</td><td class="available" data-title="r3c5">25</td><td class="weekend available" data-title="r3c6">26</td></tr><tr><td class="weekend available" data-title="r4c0">27</td><td class="available" data-title="r4c1">28</td><td class="available" data-title="r4c2">29</td><td class="available" data-title="r4c3">30</td><td class="off available" data-title="r4c4">1</td><td class="off available" data-title="r4c5">2</td><td class="weekend off available" data-title="r4c6">3</td></tr><tr><td class="weekend off available" data-title="r5c0">4</td><td class="off available" data-title="r5c1">5</td><td class="off available" data-title="r5c2">6</td><td class="off available" data-title="r5c3">7</td><td class="off available" data-title="r5c4">8</td><td class="off available" data-title="r5c5">9</td><td class="weekend off available" data-title="r5c6">10</td></tr></tbody></table></div></div><div class="ranges" style="display: none;"><div class="range_inputs"><button class="applyBtn btn btn-sm btn-success" type="button">Apply</button> <button class="cancelBtn btn btn-sm btn-default" type="button">Cancel</button></div></div></div>


                                    <fieldset>
                                        <div class="control-group">
                                            <div class="controls">
                                                <div class="col-md-11 xdisplay_inputx form-group has-feedback">
                                                    <input type="text" class="form-control has-feedback-left" id="single_cal4" placeholder="Vencimiento de Poliza" name="vencimiento_poliza" aria-describedby="inputSuccess2Status4">
                                                    <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                                    <span id="inputSuccess2Status4" class="sr-only">(success)</span>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Comentarios<span>*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea rows='4' name="comentariosDocumentacion" class="form-control col-md-7 col-xs-12"></textarea>
                                </div>
                            </div>
                            <div class="ln_solid"></div>
                          </section>

                            <h3>Carroceria</h3>

                            <div id="myModal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">

                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                                            </button>
                                            <h4 class="modal-title" id="myModalLabel2">Agregar Comentario</h4>
                                        </div>
                                        <div class="modal-body">
                                                <div class="item form-group">
                                                  <center>
                                                    <img style="margin-bottom: 10px" name='foto' src="#" width="200" id="image">
                                                  </center>
                                                    <div class="col-xs-12">
                                                        <textarea id="txtDesc" name="comentario" class="form-control col-xs-12"></textarea>
                                                    </div>
                                                </div>
                                        </div>
                                        <div class="modal-footer docs-buttons">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                            <button onclick="aceptar();" id="btnAceptar" type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <label class="btn btn-primary btn-sm" for="btnUpload"><i class="fa fa-bolt"></i> Declarar Golpe</label>
                            <input style="display: none;" id="btnUpload" type="file" onchange="subirFoto(this);">

                            <!--Inicia tabla -->

                            <div class="table-responsive">
                                <table id="tabla" class="table table-striped">
                                    <thead>
                                        <tr class="headings">
                                            <th id="fotoHeader" class="column-title">Fotos</th>
                                            <th class="column-title">Descripción</th>
                                            <th class="column-title">Eliminar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                              </div>

                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-3">
                                    <button id="send" type="submit" class="btn btn-success">Registrar Revisión</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->

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
<script src=<?= base_url("template/vendors/jquery/dist/jquery.min.js") ?>></script>
<!-- Bootstrap -->
<script src=<?= base_url("template/vendors/bootstrap/dist/js/bootstrap.min.js") ?>></script>
<!-- FastClick -->
<script src=<?= base_url("template/vendors/fastclick/lib/fastclick.js") ?>></script>
<!-- NProgress -->
<script src=<?= base_url("template/vendors/nprogress/nprogress.js") ?>></script>
<!-- validator -->
<script src=<?= base_url("template/vendors/validator/validator.js") ?>></script>
<!-- iCheck -->
<script src=<?= base_url("template/vendors/iCheck/icheck.min.js"); ?>></script>
<!-- jQuery Knob -->
<script src=<?= base_url("template/vendors/jquery-knob/dist/jquery.knob.min.js") ?>></script>
<!-- Custom Theme Scripts -->
<script src=<?= base_url("template/build/js/custom.js"); ?>></script>
<!-- bootstrap-daterangepicker -->
<script src=<?= base_url("template/vendors/moment/min/moment.min.js") ?>></script>
<script src=<?= base_url("template/vendors/bootstrap-daterangepicker/daterangepicker.js") ?>></script>


<script>
var Maximo = 25;//MAX MB
var alto=0;
var ancho=0;
var tamano=0;
var tamanoMB=0;
var tam_MG=0;
function subirFoto(input) {
  if (input.files && input.files[0])
  {
    var reader = new FileReader();
    reader.onload = function(e)
    {
      var img = new Image();
      img.src=e.target.result;
      img.onload = function()
      {
        ancho = this.width;
        alto = this.height;
      }

      if(tamanoMB <= 3.5)
      {
        $("#image").attr('src', img.src);
        document.getElementById("txtDesc").value = '';
        document.getElementById("btnUpload").value = '';
        $("#myModal").modal();
      }
      else
      {
        alert("Tamaño maximo permitido: 3.5 MB");
      }

    };
    tamano = input.files[0].size;
    tamanoMB = (tamano/(1024))/1024;
    reader.readAsDataURL(input.files[0]);

  }
}

function aceptar()
{
  var texto = document.getElementById("txtDesc").value;

  if(texto.length > 0)
  {
    tam_MG += tamanoMB;
    document.getElementById("fotoHeader").innerText = "Fotos (" + tam_MG.toFixed(2) +" MB)";
    if(tam_MG > Maximo)
    {
      document.getElementById("btnUpload").disabled = true;
      document.getElementById("fotoHeader").innerText = "Fotos (MAX " + Maximo + " MB)";
    }

    var datos = $('#image').attr('src');
    var n = datos.search(',');
    datos = datos.substr( n + 1);

    $.ajax({
        type: "POST",
        url: '<?= base_url('autos/temp_photos') ?>',
        data: { 'foto' : datos},
        //contentType: "application/x-www-form-urlencoded",
        success: function(result){
          $('#tabla').append(
          '<tr class="even pointer">'+
            '<td width="20%"><img width="100" src=data:image/jpeg;base64,' + result + '></td>'+
            '<td><input name="texto[]" type="hidden" value=' + texto + '>' + texto + '</td>'+
            '<td><button onclick="eliminar(this)" value=' + tamano + ' class="btn btn-danger">Eliminar</button></td>'+
          '</tr>');
        },
        error: function(data){
          alert("Error");
          console.log(data);
        },
      });
  }
  else {
    alert("Ingrese Descripción");
  }
}

function eliminar(btn)
{
    tam_MG -= (btn.value/(1024))/1024;
    if(tam_MG > Maximo)
    {
      document.getElementById("btnUpload").disabled = true;
      document.getElementById("fotoHeader").innerText = "Fotos (MAX " + Maximo + " MB)";
    }
    else
    {
      document.getElementById("btnUpload").disabled = false;
      document.getElementById("fotoHeader").innerText = "Fotos (" + tam_MG.toFixed(2) +" MB)";
    }
    var i = btn.parentNode.parentNode.rowIndex;
    document.getElementById("tabla").deleteRow(i);
}

</script>



</body>
</html>
