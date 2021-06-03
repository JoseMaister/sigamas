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
                        <form id="formulario" method="POST" action=<?= base_url('autos/registrarRev') ?> class="form-horizontal form-label-left" novalidate>
                            <input type="hidden" name="auto" value=<?= $auto ?>>
                            <input type="hidden" name="iu" value="<?= $iu ?>">

                            <div class="item form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="placas">Placas</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                  <h3><?= $placas ?></h3>
                                  <input type="hidden" name="placas" value="<?= $placas ?>">
                              </div>
                            </div>

                            <div class="item form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="placas">Kilometraje Anterior</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                  <h3><?= number_format($kilometraje) . ' KM'?></h3>
                              </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kilometraje">Kilometraje Actual</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input onblur="comprobarKM()" maxlength="10" min="<?= $kilometraje ?>" id="kilometraje" class="form-control col-md-7 col-xs-12" name="kilometraje" placeholder="" required="required" type="number">
                                    <!-- onkeypress='return event.charCode >= 48 && event.charCode <= 57' -->
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="gasolina">Combustible</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <center>
                                        <h2><?= $combustible ?></h2>
                                        <input name="combustible" class="knob" data-width="100" data-height="120" data-angleOffset=-125 data-angleArc=250 data-fgColor="#34495E" value="0">
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
                                          OK
                                          <input type="radio" class="flat" name="aceiteMotor" value="OK"/>
                                          NG
                                          <input type="radio" class="flat" name="aceiteMotor" value="NG"/>
                                      </p>
                                      <input style="display: none;" id="com_aceiteMotor" class="form-control col-md-7 col-xs-12" name="com_aceiteMotor" placeholder="Comentarios" type="text">
                                  </div>
                              </div>
                              <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="condicionesAceite">Condiciones de Aceite </label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                      <p>
                                          OK
                                          <input type="radio" class="flat" name="condicionesAceite" value="OK"/>
                                          NG
                                          <input type="radio" class="flat" name="condicionesAceite" value="NG" />
                                      </p>
                                      <input style="display: none;" id="com_condicionesAceite" class="form-control col-md-7 col-xs-12" name="com_condicionesAceite" placeholder="Comentarios" type="text">
                                  </div>
                              </div>

                              <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12"><span>Liquido Limpia Parabrisas</span></label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">

                                  </div>
                              </div>

                              <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Delantero</label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                      <p>
                                        OK
                                        <input type="radio" class="flat" name="llpbDelantero" value="OK"/>
                                        NG
                                        <input type="radio" class="flat" name="llpbDelantero" value="NG" />
                                      </p>
                                      <input style="display: none; margin-bottom: 10px;" id="com_llpbDelantero" class="form-control col-md-7 col-xs-12" name="com_llpbDelantero" placeholder="Comentarios" type="text">
                                  </div>
                              </div>

                              <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Trasero</label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                      <p>
                                        OK
                                        <input type="radio" class="flat" name="llpbTrasero" value="OK"/>
                                        NG
                                        <input type="radio" class="flat" name="llpbTrasero" value="NG" />
                                      </p>
                                      <input style="display: none;" id="com_llpbTrasero" class="form-control col-md-7 col-xs-12" name="com_llpbTrasero" placeholder="Comentarios" type="text">
                                  </div>
                              </div>

                              <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Refrigerante</label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                  </div>
                              </div>

                              <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Deposito</label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                      <p>
                                        OK
                                        <input type="radio" class="flat" name="refrigeranteDeposito" value="OK"/>
                                        NG
                                        <input type="radio" class="flat" name="refrigeranteDeposito" value="NG" />
                                      </p>
                                      <input style="display: none; margin-bottom: 10px;" id="com_refrigeranteDeposito" class="form-control col-md-7 col-xs-12" name="com_refrigeranteDeposito" placeholder="Comentarios" type="text">
                                  </div>
                              </div>

                              <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Radiador</label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                      <p>
                                        OK
                                        <input type="radio" class="flat" name="refrigeranteRadiador" value="OK"/>
                                        NG
                                        <input type="radio" class="flat" name="refrigeranteRadiador" value="NG"/>
                                      </p>
                                      <input style="display: none;" id="com_refrigeranteRadiador" class="form-control col-md-7 col-xs-12" name="com_refrigeranteRadiador" placeholder="Comentarios" type="text">
                                  </div>
                              </div>

                              <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Liquido de Frenos</label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                      <p>
                                        OK
                                        <input type="radio" class="flat" name="liquidoFrenos" value="OK"/>
                                        NG
                                        <input type="radio" class="flat" name="liquidoFrenos" value="NG" />
                                      </p>
                                      <input style="display: none;" id="com_liquidoFrenos" class="form-control col-md-7 col-xs-12" name="com_liquidoFrenos" placeholder="Comentarios" type="text">
                                  </div>
                              </div>

                              <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="direccionH">Dirección Hidraulica</label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                    <p>
                                      OK
                                      <input type="radio" class="flat" name="direccionH" value="OK"/>
                                      NG
                                      <input type="radio" class="flat" name="direccionH" value="NG" />
                                    </p>
                                      <input style="display: none;" id="com_direccionH" class="form-control col-md-7 col-xs-12" name="com_direccionH" placeholder="Comentarios" type="text">
                                  </div>
                              </div>
                              <div class="ln_solid"></div>
                            </section>

                            <section class="luces">
                              <h3>Luces</h3>
                              <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Direccionales</label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                  </div>
                              </div>

                              <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Izquierda</label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                    <p>
                                      OK
                                      <input type="radio" class="flat" name="direccionalIzq" value="OK"/>
                                      NG
                                      <input type="radio" class="flat" name="direccionalIzq" value="NG" />
                                    </p>
                                    <input style="display: none;" id="com_direccionalIzq" class="form-control col-md-7 col-xs-12" name="com_direccionalIzq" placeholder="Comentarios" type="text">
                                  </div>
                              </div>

                              <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Derecha</label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                    <p>
                                      OK
                                      <input type="radio" class="flat" name="direccionalDer" value="OK"/>
                                      NG
                                      <input type="radio" class="flat" name="direccionalDer" value="NG" />
                                    </p>
                                    <input style="display: none;" id="com_direccionalDer" class="form-control col-md-7 col-xs-12" name="com_direccionalDer" placeholder="Comentarios" type="text">
                                  </div>
                              </div>

                              <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Lamparas Bajas/Altas</label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                  </div>
                              </div>

                              <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Izquierda</label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                    <p>
                                      OK
                                      <input type="radio" class="flat" name="lamparaIzq" value="OK"/>
                                      NG
                                      <input type="radio" class="flat" name="lamparaIzq" value="NG" />
                                    </p>
                                    <input style="display: none; margin-bottom: 10px;" id="com_lamparaIzq" class="form-control col-md-7 col-xs-12" name="com_lamparaIzq" placeholder="Comentarios" type="text">
                                  </div>
                              </div>

                              <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Derecha</label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                    <p>
                                      OK
                                      <input type="radio" class="flat" name="lamparaDer" value="OK"/>
                                      NG
                                      <input type="radio" class="flat" name="lamparaDer" value="NG" />
                                    </p>
                                    <input style="display: none;" id="com_lamparaDer" class="form-control col-md-7 col-xs-12" name="com_lamparaDer" placeholder="Comentarios" type="text">
                                  </div>
                              </div>

                              <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Traseras y Freno</label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                  </div>
                              </div>

                              <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Izquierda</label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                    <p>
                                      OK
                                      <input type="radio" class="flat" name="traseraIzq" value="OK"/>
                                      NG
                                      <input type="radio" class="flat" name="traseraIzq" value="NG" />
                                    </p>
                                    <input style="display: none; margin-bottom: 10px;" id="com_traseraIzq" class="form-control col-md-7 col-xs-12" name="com_traseraIzq" placeholder="Comentarios" type="text">
                                  </div>
                              </div>

                              <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Derecha</label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                    <p>
                                      OK
                                      <input type="radio" class="flat" name="traseraDer" value="OK"/>
                                      NG
                                      <input type="radio" class="flat" name="traseraDer" value="NG" />
                                    </p>
                                    <input style="display: none;" id="com_traseraDer" class="form-control col-md-7 col-xs-12" name="com_traseraDer" placeholder="Comentarios" type="text">
                                  </div>
                              </div>

                              <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Otras</label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                  </div>
                              </div>

                              <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Emergencia</label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                    <p>
                                      OK
                                      <input type="radio" class="flat" name="emergencia" value="OK"/>
                                      NG
                                      <input type="radio" class="flat" name="emergencia" value="NG" />
                                    </p>
                                    <input style="display: none; margin-bottom: 10px;" id="com_emergencia" class="form-control col-md-7 col-xs-12" name="com_emergencia" placeholder="Comentarios" type="text">
                                  </div>
                              </div>

                              <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Reversa</label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                    <p>
                                      OK
                                      <input type="radio" class="flat" name="reversa" value="OK"/>
                                      NG
                                      <input type="radio" class="flat" name="reversa" value="NG" />
                                    </p>
                                    <input style="display: none;" id="com_reversa" class="form-control col-md-7 col-xs-12" name="com_reversa" placeholder="Comentarios" type="text">
                                  </div>
                              </div>

                              <div class="ln_solid"></div>
                            </section>

                          <section class="interiores">
                            <h3>Interiores</h3>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tapiceria">Tapiceria de Asientos</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <p>
                                        OK
                                        <input type="radio" class="flat" name="tapiceria" value="OK"/>
                                        NG
                                        <input type="radio" class="flat" name="tapiceria" value="NG"/>
                                    </p>
                                    <input style="display: none;" id="com_tapiceria" class="form-control col-md-7 col-xs-12" name="com_tapiceria" placeholder="Comentarios" type="text">
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="controles">Controles y Manivelas en Puertas</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <p>
                                        OK
                                        <input type="radio" class="flat" name="controles" value="OK"/>
                                        NG
                                        <input type="radio" class="flat" name="controles" value="NG"/>
                                    </p>
                                    <input style="display: none;" id="com_controles" class="form-control col-md-7 col-xs-12" name="com_controles" placeholder="Comentarios" type="text">
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kitHerramientas">Kit de Herramientas</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <p>
                                        OK
                                        <input type="radio" class="flat" name="kitHerramientas" value="OK"/>
                                        NG
                                        <input type="radio" class="flat" name="kitHerramientas" value="NG"/>
                                    </p>
                                    <input style="display: none;" id="com_kitHerramientas" class="form-control col-md-7 col-xs-12" name="com_kitHerramientas" placeholder="Comentarios" type="text">
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tapetes">Tapetes Completos</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <p>
                                        OK
                                        <input type="radio" class="flat" name="tapetes" value="OK"/>
                                        NG
                                        <input type="radio" class="flat" name="tapetes" value="NG"/>
                                    </p>
                                    <input style="display: none;" id="com_tapetes" class="form-control col-md-7 col-xs-12" name="com_tapetes" placeholder="Comentarios" type="text">
                                </div>
                            </div>
                            <div class="ln_solid"></div>
                          </section>

                          <section class="documentacion">
                            <h3>Documentación</h3>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Placas</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Delantera</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <p>
                                    OK
                                    <input type="radio" class="flat" name="placaDelantera" value="OK"/>
                                    NG
                                    <input type="radio" class="flat" name="placaDelantera" value="NG" />
                                  </p>
                                  <input style="display: none;" id="com_placaDelantera" class="form-control col-md-7 col-xs-12" name="com_placaDelantera" placeholder="Comentarios" type="text">
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Trasera</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <p>
                                    OK
                                    <input type="radio" class="flat" name="placaTrasera" value="OK"/>
                                    NG
                                    <input type="radio" class="flat" name="placaTrasera" value="NG" />
                                  </p>
                                  <input style="display: none;" id="com_placaTrasera" class="form-control col-md-7 col-xs-12" name="com_placaTrasera" placeholder="Comentarios" type="text">
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarjeta de Combustible</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <p>
                                        OK
                                        <input type="radio" class="flat" name="tarjetaCombustible" value="OK"/>
                                        NG
                                        <input type="radio" class="flat" name="tarjetaCombustible" value="NG"/>
                                    </p>
                                    <input style="display: none;" id="com_tarjetaCombustible" class="form-control col-md-7 col-xs-12" name="com_tarjetaCombustible" placeholder="Comentarios" type="text">
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarjeta de Circulacion</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <p>
                                        OK
                                        <input type="radio" class="flat" name="tarjetaCirculacion" value="OK"/>
                                        NG
                                        <input type="radio" class="flat" name="tarjetaCirculacion" value="NG"/>
                                    </p>
                                    <input style="display: none;" id="com_tarjetaCirculacion" class="form-control col-md-7 col-xs-12" name="com_tarjetaCirculacion" placeholder="Comentarios" type="text">
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Poliza de Seguro</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <p>
                                        OK
                                        <input type="radio" class="flat" name="poliza" value="OK" required="required"/>
                                        NG
                                        <input type="radio" class="flat" name="poliza" value="NG"/>
                                    </p>
                                    <input style="display: none;" id="com_poliza" class="form-control col-md-7 col-xs-12" name="com_poliza" placeholder="Comentarios" type="text">
                                </div>
                            </div>


                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Vencimiento de Poliza</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div id="vencimientoPoliza" class="daterangepicker dropdown-menu ltr single opensright show-calendar picker_4 xdisplay"><div class="calendar left single" style="display: block;"><div class="daterangepicker_input"><input class="input-mini form-control active" type="text" name="daterangepicker_start" value="" style="display: none;"><i class="fa fa-calendar glyphicon glyphicon-calendar" style="display: none;"></i><div class="calendar-time" style="display: none;"><div></div><i class="fa fa-clock-o glyphicon glyphicon-time"></i></div></div><div class="calendar-table"><table class="table-condensed"><thead><tr><th class="prev available"><i class="fa fa-chevron-left glyphicon glyphicon-chevron-left"></i></th><th colspan="5" class="month">Oct 2016</th><th class="next available"><i class="fa fa-chevron-right glyphicon glyphicon-chevron-right"></i></th></tr><tr><th>Su</th><th>Mo</th><th>Tu</th><th>We</th><th>Th</th><th>Fr</th><th>Sa</th></tr></thead><tbody><tr><td class="weekend off available" data-title="r0c0">25</td><td class="off available" data-title="r0c1">26</td><td class="off available" data-title="r0c2">27</td><td class="off available" data-title="r0c3">28</td><td class="off available" data-title="r0c4">29</td><td class="off available" data-title="r0c5">30</td><td class="weekend available" data-title="r0c6">1</td></tr><tr><td class="weekend available" data-title="r1c0">2</td><td class="available" data-title="r1c1">3</td><td class="available" data-title="r1c2">4</td><td class="available" data-title="r1c3">5</td><td class="available" data-title="r1c4">6</td><td class="available" data-title="r1c5">7</td><td class="weekend available" data-title="r1c6">8</td></tr><tr><td class="weekend available" data-title="r2c0">9</td><td class="available" data-title="r2c1">10</td><td class="available" data-title="r2c2">11</td><td class="available" data-title="r2c3">12</td><td class="available" data-title="r2c4">13</td><td class="available" data-title="r2c5">14</td><td class="weekend available" data-title="r2c6">15</td></tr><tr><td class="weekend available" data-title="r3c0">16</td><td class="available" data-title="r3c1">17</td><td class="today active start-date active end-date available" data-title="r3c2">18</td><td class="available" data-title="r3c3">19</td><td class="available" data-title="r3c4">20</td><td class="available" data-title="r3c5">21</td><td class="weekend available" data-title="r3c6">22</td></tr><tr><td class="weekend available" data-title="r4c0">23</td><td class="available" data-title="r4c1">24</td><td class="available" data-title="r4c2">25</td><td class="available" data-title="r4c3">26</td><td class="available" data-title="r4c4">27</td><td class="available" data-title="r4c5">28</td><td class="weekend available" data-title="r4c6">29</td></tr><tr><td class="weekend available" data-title="r5c0">30</td><td class="available" data-title="r5c1">31</td><td class="off available" data-title="r5c2">1</td><td class="off available" data-title="r5c3">2</td><td class="off available" data-title="r5c4">3</td><td class="off available" data-title="r5c5">4</td><td class="weekend off available" data-title="r5c6">5</td></tr></tbody></table></div></div><div class="calendar right" style="display: none;"><div class="daterangepicker_input"><input class="input-mini form-control" type="text" name="daterangepicker_end" value="" style="display: none;"><i class="fa fa-calendar glyphicon glyphicon-calendar" style="display: none;"></i><div class="calendar-time" style="display: none;"><div></div><i class="fa fa-clock-o glyphicon glyphicon-time"></i></div></div><div class="calendar-table"><table class="table-condensed"><thead><tr><th></th><th colspan="5" class="month">Nov 2016</th><th class="next available"><i class="fa fa-chevron-right glyphicon glyphicon-chevron-right"></i></th></tr><tr><th>Su</th><th>Mo</th><th>Tu</th><th>We</th><th>Th</th><th>Fr</th><th>Sa</th></tr></thead><tbody><tr><td class="weekend off available" data-title="r0c0">30</td><td class="off available" data-title="r0c1">31</td><td class="available" data-title="r0c2">1</td><td class="available" data-title="r0c3">2</td><td class="available" data-title="r0c4">3</td><td class="available" data-title="r0c5">4</td><td class="weekend available" data-title="r0c6">5</td></tr><tr><td class="weekend available" data-title="r1c0">6</td><td class="available" data-title="r1c1">7</td><td class="available" data-title="r1c2">8</td><td class="available" data-title="r1c3">9</td><td class="available" data-title="r1c4">10</td><td class="available" data-title="r1c5">11</td><td class="weekend available" data-title="r1c6">12</td></tr><tr><td class="weekend available" data-title="r2c0">13</td><td class="available" data-title="r2c1">14</td><td class="available" data-title="r2c2">15</td><td class="available" data-title="r2c3">16</td><td class="available" data-title="r2c4">17</td><td class="available" data-title="r2c5">18</td><td class="weekend available" data-title="r2c6">19</td></tr><tr><td class="weekend available" data-title="r3c0">20</td><td class="available" data-title="r3c1">21</td><td class="available" data-title="r3c2">22</td><td class="available" data-title="r3c3">23</td><td class="available" data-title="r3c4">24</td><td class="available" data-title="r3c5">25</td><td class="weekend available" data-title="r3c6">26</td></tr><tr><td class="weekend available" data-title="r4c0">27</td><td class="available" data-title="r4c1">28</td><td class="available" data-title="r4c2">29</td><td class="available" data-title="r4c3">30</td><td class="off available" data-title="r4c4">1</td><td class="off available" data-title="r4c5">2</td><td class="weekend off available" data-title="r4c6">3</td></tr><tr><td class="weekend off available" data-title="r5c0">4</td><td class="off available" data-title="r5c1">5</td><td class="off available" data-title="r5c2">6</td><td class="off available" data-title="r5c3">7</td><td class="off available" data-title="r5c4">8</td><td class="off available" data-title="r5c5">9</td><td class="weekend off available" data-title="r5c6">10</td></tr></tbody></table></div></div><div class="ranges" style="display: none;"><div class="range_inputs"><button class="applyBtn btn btn-sm btn-success" type="button">Apply</button> <button class="cancelBtn btn btn-sm btn-default" type="button">Cancel</button></div></div></div>


                                    <fieldset>
                                        <div class="control-group">
                                            <div class="controls">
                                                <div class="col-md-11 xdisplay_inputx form-group has-feedback">
                                                    <input type="text" class="form-control has-feedback-left" id="single_cal4" placeholder="Vencimiento de Poliza" name="vencimientoPoliza" aria-describedby="inputSuccess2Status4">
                                                    <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                                    <span id="inputSuccess2Status4" class="sr-only">(success)</span>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>

                            <div class="item form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Vencimiento de Ecológico</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <div id="vencimientoEcologico" class="daterangepicker dropdown-menu ltr single opensright show-calendar picker_3 xdisplay"><div class="calendar left single" style="display: block;"><div class="daterangepicker_input"><input class="input-mini form-control active" type="text" name="daterangepicker_start" value="" style="display: none;"><i class="fa fa-calendar glyphicon glyphicon-calendar" style="display: none;"></i><div class="calendar-time" style="display: none;"><div></div><i class="fa fa-clock-o glyphicon glyphicon-time"></i></div></div><div class="calendar-table"><table class="table-condensed"><thead><tr><th class="prev available"><i class="fa fa-chevron-left glyphicon glyphicon-chevron-left"></i></th><th colspan="5" class="month">Oct 2016</th><th class="next available"><i class="fa fa-chevron-right glyphicon glyphicon-chevron-right"></i></th></tr><tr><th>Su</th><th>Mo</th><th>Tu</th><th>We</th><th>Th</th><th>Fr</th><th>Sa</th></tr></thead><tbody><tr><td class="weekend off available" data-title="r0c0">25</td><td class="off available" data-title="r0c1">26</td><td class="off available" data-title="r0c2">27</td><td class="off available" data-title="r0c3">28</td><td class="off available" data-title="r0c4">29</td><td class="off available" data-title="r0c5">30</td><td class="weekend available" data-title="r0c6">1</td></tr><tr><td class="weekend available" data-title="r1c0">2</td><td class="available" data-title="r1c1">3</td><td class="available" data-title="r1c2">4</td><td class="available" data-title="r1c3">5</td><td class="available" data-title="r1c4">6</td><td class="available" data-title="r1c5">7</td><td class="weekend available" data-title="r1c6">8</td></tr><tr><td class="weekend available" data-title="r2c0">9</td><td class="available" data-title="r2c1">10</td><td class="available" data-title="r2c2">11</td><td class="available" data-title="r2c3">12</td><td class="available" data-title="r2c4">13</td><td class="available" data-title="r2c5">14</td><td class="weekend available" data-title="r2c6">15</td></tr><tr><td class="weekend available" data-title="r3c0">16</td><td class="available" data-title="r3c1">17</td><td class="today active start-date active end-date available" data-title="r3c2">18</td><td class="available" data-title="r3c3">19</td><td class="available" data-title="r3c4">20</td><td class="available" data-title="r3c5">21</td><td class="weekend available" data-title="r3c6">22</td></tr><tr><td class="weekend available" data-title="r4c0">23</td><td class="available" data-title="r4c1">24</td><td class="available" data-title="r4c2">25</td><td class="available" data-title="r4c3">26</td><td class="available" data-title="r4c4">27</td><td class="available" data-title="r4c5">28</td><td class="weekend available" data-title="r4c6">29</td></tr><tr><td class="weekend available" data-title="r5c0">30</td><td class="available" data-title="r5c1">31</td><td class="off available" data-title="r5c2">1</td><td class="off available" data-title="r5c3">2</td><td class="off available" data-title="r5c4">3</td><td class="off available" data-title="r5c5">4</td><td class="weekend off available" data-title="r5c6">5</td></tr></tbody></table></div></div><div class="calendar right" style="display: none;"><div class="daterangepicker_input"><input class="input-mini form-control" type="text" name="daterangepicker_end" value="" style="display: none;"><i class="fa fa-calendar glyphicon glyphicon-calendar" style="display: none;"></i><div class="calendar-time" style="display: none;"><div></div><i class="fa fa-clock-o glyphicon glyphicon-time"></i></div></div><div class="calendar-table"><table class="table-condensed"><thead><tr><th></th><th colspan="5" class="month">Nov 2016</th><th class="next available"><i class="fa fa-chevron-right glyphicon glyphicon-chevron-right"></i></th></tr><tr><th>Su</th><th>Mo</th><th>Tu</th><th>We</th><th>Th</th><th>Fr</th><th>Sa</th></tr></thead><tbody><tr><td class="weekend off available" data-title="r0c0">30</td><td class="off available" data-title="r0c1">31</td><td class="available" data-title="r0c2">1</td><td class="available" data-title="r0c3">2</td><td class="available" data-title="r0c4">3</td><td class="available" data-title="r0c5">4</td><td class="weekend available" data-title="r0c6">5</td></tr><tr><td class="weekend available" data-title="r1c0">6</td><td class="available" data-title="r1c1">7</td><td class="available" data-title="r1c2">8</td><td class="available" data-title="r1c3">9</td><td class="available" data-title="r1c4">10</td><td class="available" data-title="r1c5">11</td><td class="weekend available" data-title="r1c6">12</td></tr><tr><td class="weekend available" data-title="r2c0">13</td><td class="available" data-title="r2c1">14</td><td class="available" data-title="r2c2">15</td><td class="available" data-title="r2c3">16</td><td class="available" data-title="r2c4">17</td><td class="available" data-title="r2c5">18</td><td class="weekend available" data-title="r2c6">19</td></tr><tr><td class="weekend available" data-title="r3c0">20</td><td class="available" data-title="r3c1">21</td><td class="available" data-title="r3c2">22</td><td class="available" data-title="r3c3">23</td><td class="available" data-title="r3c4">24</td><td class="available" data-title="r3c5">25</td><td class="weekend available" data-title="r3c6">26</td></tr><tr><td class="weekend available" data-title="r4c0">27</td><td class="available" data-title="r4c1">28</td><td class="available" data-title="r4c2">29</td><td class="available" data-title="r4c3">30</td><td class="off available" data-title="r4c4">1</td><td class="off available" data-title="r4c5">2</td><td class="weekend off available" data-title="r4c6">3</td></tr><tr><td class="weekend off available" data-title="r5c0">4</td><td class="off available" data-title="r5c1">5</td><td class="off available" data-title="r5c2">6</td><td class="off available" data-title="r5c3">7</td><td class="off available" data-title="r5c4">8</td><td class="off available" data-title="r5c5">9</td><td class="weekend off available" data-title="r5c6">10</td></tr></tbody></table></div></div><div class="ranges" style="display: none;"><div class="range_inputs"><button class="applyBtn btn btn-sm btn-success" type="button">Apply</button> <button class="cancelBtn btn btn-sm btn-default" type="button">Cancel</button></div></div></div>
                               <fieldset>
                                 <div class="control-group">
                                   <div class="controls">
                                     <div class="col-md-11 xdisplay_inputx form-group has-feedback">
                                       <input name="vencimientoEcologico" type="text" class="form-control has-feedback-left" id="single_cal3" placeholder="First Name" aria-describedby="inputSuccess2Status3">
                                       <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                       <span id="inputSuccess2Status3" class="sr-only">(success)</span>
                                     </div>
                                   </div>
                                 </div>
                               </fieldset>
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
                                                        <textarea id="txtDesc" required="required" name="comentario" class="form-control col-xs-12"></textarea>
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
                                    <button id="send" onclick="return confirmar();" type="submit" class="btn btn-success">Registrar Revisión</button>
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
<script src=<?= base_url("template/build/js/custom_revision.js"); ?>></script>
<!-- bootstrap-daterangepicker -->
<script src=<?= base_url("template/vendors/moment/min/moment.min.js") ?>></script>
<script src=<?= base_url("template/vendors/bootstrap-daterangepicker/daterangepicker.js") ?>></script>
<!-- JS Aleks -->
<script src=<?= base_url("template/js/views/autos/registrar_revision.js"); ?>></script>

<script>

function confirmar()
{
  var totalIpts = $('input[type=radio]');
  var chkIpts = $('input[type=radio]:checked');
  if(chkIpts.length == (totalIpts.length / 2))
  {
      return confirm('¿Desea continuar?');
  }
  else {
      alert('Capture todos los puntos de revisión');
      return false;
  }
}

function comprobarKM()
{
  var kmAnt = <?= $kilometraje ?>;
  var inpKM = document.getElementById('kilometraje').value;

  if(inpKM < kmAnt && inpKM.length != 0)
  {
    alert('Kilometraje no puede ser menor a los ' + kmAnt.toLocaleString() + ' KM');
    document.getElementById('kilometraje').value = '';
  }
}

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
    datos = datos.substr( datos.search(',') + 1);

    $.ajax({
        type: "POST",
        url: '<?= base_url('autos/temp_photos') ?>',
        data: { 'archivo' : datos, 'texto' : texto, 'auto' : '<?= $auto ?>', 'iu' : '<?= $iu ?>'},
        success: function(result){
          var ob = JSON.parse(result);
          $('#tabla').append(
          '<tr class="even pointer">'+
            '<td width="20%"><img width="100" src=data:image/jpeg;base64,' + ob.file + '></td>'+
            '<td><input name="texto[]" type="hidden" value=' + texto + '>' + texto + '</td>'+
            '<td><button onclick="eliminar(this)" data-idtemp=' + ob.id + ' value=' + tamano + ' class="btn btn-danger">Eliminar</button></td>'+
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
    var id_temp = btn.dataset.idtemp;
    alert(id_temp);
    $.ajax({
        type: "POST",
        url: '<?= base_url('autos/delete_temp_photos') ?>',
        data: { 'id' : id_temp },
        success: function(result){
          document.getElementById("tabla").deleteRow(i);
        },
        error: function(data){
          alert("Error");
          console.log(data);
        },
      });
}

</script>



</body>
</html>
