

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><?= $usuario->no_empleado ?></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="col-md-3 col-sm-3 col-xs-12 profile_left">
                      <div class="profile_img">
                        <div id="crop-avatar">
                          <!-- Current avatar -->
                          <img class="usuario img-responsive avatar-view" src="<?= 'data:image/bmp;base64,' . base64_encode($usuario->foto); ?>">
                        </div>
                      </div>
                      <h3><?= ucwords(strtolower($usuario->User)) ?></h3>

                      <ul class="list-unstyled user_data">
                        <li>
                          <i class="fa fa-briefcase user-profile-icon"></i> <?= ucfirst(strtolower($usuario->puesto)) ?>
                        </li>
                        <li>
                          <i class="fa fa-envelope user-profile-icon"></i> <?= $usuario->correo ?>
                        </li>
                        <li>
                          <?php $date = date_create($usuario->ultima_sesion); ?>
                          <i class="fa fa-clock-o user-profile-icon"></i> <small>Ultima Sesión: <?= date_format($date, 'd/m/Y h:i A'); ?></small>
                        </li>
                      </ul>
                    </div>

                    <div class="col-md-9 col-sm-9 col-xs-12">

                      <div class="" role="tabpanel" data-example-id="togglable-tabs">
                        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                          
                          <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Datos de Usuario</a></li>

                          <?php if ($this->session->privilegios['administrar_usuarios']) { ?>
                            <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab4" data-toggle="tab" aria-expanded="false">Privilegios</a></li>
                          <?php } ?>
                        </ul>
                        <div id="myTabContent" class="tab-content">

                          <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
                            <div class="row">
                              <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12" style="margin-top: 20px;">
                                <label>Nombre:</label>
                                <input style="text-transform: uppercase;" maxlength="80" class="form-control" id="txtNombre" readonly>
                              </div>
                              <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12" style="margin-top: 20px;">
                                <label>A. Paterno:</label>
                                <input style="text-transform: uppercase;" maxlength="80" class="form-control" id="txtPaterno" readonly>
                              </div>
                              <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12" style="margin-top: 20px;">
                                <label>A. Materno:</label>
                                <input style="text-transform: uppercase;" maxlength="80" class="form-control" id="txtMaterno" readonly>
                              </div>
                              <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12" style="margin-top: 20px;">
                                <label>Departamento:</label>
                                <input style="text-transform: uppercase;" maxlength="80" class="form-control" id="txtDepartamento" readonly>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12" style="margin-top: 20px;">
                                <label>Correo:</label>
                                <input style="text-transform: lowercase;" maxlength="100" class="form-control" id="txtCorreo" readonly>
                              </div>
                              <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12" style="margin-top: 20px;">
                                <label>Puesto:</label>
                                <select class="select2_single form-control" id="opPuesto">
                                </select>
                              </div>
                              <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12" style="margin-top: 20px;">
                                <label>Jefe Directo:</label>
                                <select class="select2_single form-control" id="opJefeDirecto">
                                </select>
                              </div>
                              <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12" style="margin-top: 20px;">
                                <label style="display: block;">Activo:</label>
                                <input style="display: block;" type="checkbox" class="flat" id="cbActivo" readonly>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-md-12" style="margin-top: 50px;">
                                <center>
                                  <button style="display: none;" type="button" id="btnGuardarDatos" onclick="guardarDatos()" class="btn btn-success"><i class='fa fa-save'></i> Guardar Datos</button>
                                </center>
                              </div>
                            </div>
                            
                          </div>

                          <?php if ($this->session->privilegios['administrar_usuarios']) { ?>
                          <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
                            <form method="POST" id="frmPrivilegios" action=<?= base_url("privilegios/modificar/") ?> >
                              <input type="hidden" name="usuario" value=<?= $usuario->id ?>>
                              <div class="row">
                              <div class="col-xs-2">
                                <!-- required for floating -->
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs tabs-left">
                                  <li class="active"><a href="#usuarios" data-toggle="tab">Usuarios</a></li>
                                  <li><a href="#empresas" data-toggle="tab">Empresas</a></li>
                                  <li><a href="#cotizaciones" data-toggle="tab">Cotizaciones</a></li>
                                  <li><a href="#servicios" data-toggle="tab">Servicios</a></li>
                                  <li><a href="#tickets" data-toggle="tab">Tickets</a></li>
                                  <li><a href="#autos" data-toggle="tab">Autos</a></li>
                                  <li><a href="#compras" data-toggle="tab">Compras</a></li>
                                  <li><a href="#facturacion" data-toggle="tab">Facturación</a></li>
                                  <li><a href="#logistica" data-toggle="tab">Logística</a></li>
                                  <li><a href="#equipos" data-toggle="tab">Equipos</a></li>
                                  <li><a href="#requerimientos" data-toggle="tab">Requerimientos</a></li>
                                  <li><a href="#recursos" data-toggle="tab">Recursos</a></li>
                                </ul>
                              </div>
                              <div class="col-xs-10">
                                <!-- Tab panes -->
                                <div class="tab-content">

                                  <div class="tab-pane active" id="usuarios">
                                    <p class="lead">Usuarios</p>
                                    <label>
                                      Administrar Usuarios <input type="checkbox" name="administrar_usuarios" class="flat" <?= $privilegio->administrar_usuarios == '1' ? 'checked' : '' ?> />
                                    </label>
                                  </div>

                                  <div class="tab-pane" id="empresas">
                                    <p class="lead">Empresas</p>
                                    <label>
                                      Datos Generales <input type="checkbox" name="administrar_empresas" class="flat" <?= $privilegio->administrar_empresas == '1' ? 'checked' : '' ?> />
                                    </label>
                                    <label>
                                      Pestaña Facturación <input type="checkbox" name="administrar_empresas_facturacion" class="flat" <?= $privilegio->administrar_empresas_facturacion == '1' ? 'checked' : '' ?> />
                                    </label>
                                    <label>
                                      Pestaña Logística <input type="checkbox" name="administrar_empresas_logistica" class="flat" <?= $privilegio->administrar_empresas_logistica == '1' ? 'checked' : '' ?> />
                                    </label>
                                    <label>
                                      Pestaña Proveedor <input type="checkbox" name="administrar_empresas_proveedor" class="flat" <?= $privilegio->administrar_empresas_proveedor == '1' ? 'checked' : '' ?> />
                                    </label>
                                  </div>

                                  <div class="tab-pane" id="cotizaciones">
                                    <p class="lead">Cotizaciones</p>
                                    <label>
                                      Generar Cotizaciones <input type="checkbox" id="generar_cotizaciones" name="generar_cotizaciones" class="flat" <?= $privilegio->generar_cotizaciones == '1' ? 'checked' : '' ?> />
                                    </label>
                                    <label>
                                      Administrar Cotizaciones <input type="checkbox" id="administrar_cotizaciones" name="administrar_cotizaciones" class="flat" <?= $privilegio->administrar_cotizaciones == '1' ? 'checked' : '' ?> />
                                    </label>
                                    <label>
                                      Aprobar Cotizaciones <input type="checkbox" id="aprobar_cotizacion" name="aprobar_cotizacion" class="flat" <?= $privilegio->aprobar_cotizacion == '1' ? 'checked' : '' ?> />
                                    </label>
                                    <label>
                                      Administrar Parametros de Cotización <input type="checkbox" id="administrar_parametros_cotizacion" name="administrar_parametros_cotizacion" class="flat" <?= $privilegio->administrar_parametros_cotizacion == '1' ? 'checked' : '' ?> />
                                    </label>

                                    <div style="margin-top: 25px; margin-bottom: 20px;" id="divAprobadorCompras" class="row">
                                      <div class="col-md-6">
                                        <label>Aprobador de Cotizaciones</label>
                                        <select style="width:80%;" id="opAprobadorCotizacion" name="opAprobadorCotizacion" class="select2_single form-control">'
                                          <option selected value="0">N/A</option>
                                        </select>
                                      </div>
                                    </div>
                                  </div>

                                  <div class="tab-pane" id="servicios">
                                    <p class="lead">Servicios</p>
                                    <label>
                                      Administrar Servicios <input type="checkbox" name="administrar_servicios" class="flat" <?= $privilegio->administrar_servicios == '1' ? 'checked' : '' ?> />
                                    </label>
                                  </div>

                                  <div class="tab-pane" id="tickets">
                                    <p class="lead">Tickets</p>
                                    <label>
                                      Generar Tickets <input name="generar_tickets" type="checkbox" class="flat" <?= $privilegio->generar_tickets == '1' ? 'checked' : '' ?> />
                                    </label>
                                    <label>
                                      Soporte IT <input name="tickets_it_soporte" type="checkbox" class="flat" <?= $privilegio->tickets_it_soporte == '1' ? 'checked' : '' ?> />
                                    </label>
                                    <label>
                                      Soporte Autos <input name="tickets_at_soporte" type="checkbox" class="flat" <?= $privilegio->tickets_at_soporte == '1' ? 'checked' : '' ?> />
                                    </label>
                                    <label>
                                      Soporte Edificio <input name="tickets_ed_soporte" type="checkbox" class="flat" <?= $privilegio->tickets_ed_soporte == '1' ? 'checked' : '' ?> />
                                    </label>
                                  </div>

                                  <div class="tab-pane" id="autos">
                                    <p class="lead">Autos</p>
                                    <label>
                                      Bitacora de Autos <input name="bitacora_autos" type="checkbox" class="flat" <?= $privilegio->bitacora_autos == '1' ? 'checked' : '' ?> />
                                    </label>
                                  </div>

                                  <div class="tab-pane" id="compras">
                                    <p class="lead">Compras</p>

                                      <div class="row">
                                        <div class="col-md-4">
                                          <label style="display: block">
                                            Generar QR / PR (Consumo Interno) <input id="crear_qr_interno" name="crear_qr_interno" type="checkbox" class="flat" <?= $privilegio->crear_qr_interno == '1' ? 'checked' : '' ?> />
                                          </label>
                                        </div>

                                        <div class="col-md-4">
                                          <label style="display: block">
                                            Generar QR / PR (venta) <input id="crear_qr_venta" name="crear_qr_venta" type="checkbox" class="flat" <?= $privilegio->crear_qr_venta == '1' ? 'checked' : '' ?> />
                                          </label>
                                        </div>

                                        <div class="col-md-4">
                                          <label style="display: block">
                                            Editar QR <input name="editar_qr" type="checkbox" class="flat" <?= $privilegio->editar_qr == '1' ? 'checked' : '' ?> />
                                          </label>
                                        </div>
                                      
                                      </div>

                                      <div style="margin-top: 25px" class="row">
                                        <div class="col-md-4">
                                          <label style="display: block">
                                            Liberar QR <input name="liberar_qr" type="checkbox" class="flat" <?= $privilegio->liberar_qr == '1' ? 'checked' : '' ?> />
                                          </label>
                                        </div>

                                        <div class="col-md-4">
                                          <label style="display: block">
                                            QR Crítico <input name="qr_critico" type="checkbox" class="flat" <?= $privilegio->qr_critico == '1' ? 'checked' : '' ?> />
                                          </label>
                                        </div>

                                        <div class="col-md-4">
                                          <label style="display: block">
                                            Revisar QR <input name="revisar_qr" type="checkbox" class="flat" <?= $privilegio->revisar_qr == '1' ? 'checked' : '' ?> />
                                          </label>
                                        </div>
                                      
                                      </div>

                                      <div style="margin-top: 25px" class="row">
                                        <div class="col-md-4">
                                          <label style="display: block">
                                            Aprobar PR <input name="aprobar_pr" type="checkbox" class="flat" <?= $privilegio->aprobar_pr == '1' ? 'checked' : '' ?> />
                                          </label>
                                        </div>

                                        <div class="col-md-4">
                                          <label style="display: block">
                                            Aprobar Compra <input name="aprobar_compra" type="checkbox" class="flat" <?= $privilegio->aprobar_compra == '1' ? 'checked' : '' ?> />
                                          </label>
                                        </div>

                                        <div class="col-md-4">
                                          <label style="display: block">
                                            Cancelar QR/PR <input name="cancelar_pr" type="checkbox" class="flat" <?= $privilegio->cancelar_pr == '1' ? 'checked' : '' ?> />
                                          </label>
                                        </div>
                                      
                                      </div>

                                      <div style="margin-top: 25px" class="row">
                                        <div class="col-md-4">
                                          <label style="display: block">
                                            Retroceder QR <input name="retroceder_qr" type="checkbox" class="flat" <?= $privilegio->retroceder_qr == '1' ? 'checked' : '' ?> />
                                          </label>
                                        </div>

                                        <div class="col-md-4">
                                          <label style="display: block">
                                            Retroceder PO <input name="retroceder_po" type="checkbox" class="flat" <?= $privilegio->retroceder_po == '1' ? 'checked' : '' ?> />
                                          </label>
                                        </div>

                                        <div class="col-md-4">
                                          <label style="display: block">
                                            Dashboard Compras <input name="compras_dashboard" type="checkbox" class="flat" <?= $privilegio->compras_dashboard == '1' ? 'checked' : '' ?> />
                                          </label>
                                        </div>
                                      
                                      </div>

                                      <div style="margin-top: 25px; margin-bottom: 20px;" id="divAprobadorCompras" class="row">
                                        <div class="col-md-6">
                                          <label>Aprobador de Compras (Consumo Interno)</label>
                                          <select style="width:80%;" id="opAprobadorCompra" name="opAprobadorCompra" class="select2_single form-control">'
                                            <option selected value="0">N/A</option>
                                          </select>
                                        </div>
                                      </div>

                                      <div style="margin-bottom: 20px;" id="divAprobadorCompras" class="row">
                                        <div class="col-md-6">
                                          <label>Aprobador de Compras (Venta)</label>
                                          <select style="width:80%;" id="opAprobadorCompra_venta" name="opAprobadorCompra_venta" class="select2_single form-control">'
                                            <option selected value="0">N/A</option>
                                          </select>
                                        </div>
                                      </div>



                                    
                                    
                                    
                                    
                                  
                                  </div>

                                  <div class="tab-pane" id="facturacion">
                                    <p class="lead">Facturación</p>
                                    <label>
                                      Solicitar Facturas <input type="checkbox" name="solicitar_facturas" class="flat" <?= $privilegio->solicitar_facturas == '1' ? 'checked' : '' ?> />
                                    </label>
                                    <label>
                                      Responder Facturas <input type="checkbox" name="responder_facturas" class="flat" <?= $privilegio->responder_facturas == '1' ? 'checked' : '' ?> />
                                    </label>
                                    <label>
                                      Editar Facturas <input type="checkbox" name="editar_facturas" class="flat" <?= $privilegio->editar_facturas == '1' ? 'checked' : '' ?> />
                                    </label>
                                    <label>
                                      Autorizar Facturas <input type="checkbox" name="autorizar_facturas" class="flat" <?= $privilegio->autorizar_facturas == '1' ? 'checked' : '' ?> />
                                    </label>
                                    <label>
                                      Enviar a Logística <input type="checkbox" name="enviar_facturas_logistica" class="flat" <?= $privilegio->enviar_facturas_logistica == '1' ? 'checked' : '' ?> />
                                    </label>
                                    <label>
                                      Documentación de Cliente <input type="checkbox" name="documentacion_cliente" class="flat" <?= $privilegio->documentacion_cliente == '1' ? 'checked' : '' ?> />
                                    </label>
                                    <label>
                                      Documentación Global <input type="checkbox" name="documentacion_global" class="flat" <?= $privilegio->documentacion_global == '1' ? 'checked' : '' ?> />
                                    </label>
                                  </div>

                                  <div class="tab-pane" id="logistica">
                                    <p class="lead">Logística</p>
                                    <label>
                                      Mensajero <input type="checkbox" name="mensajero" class="flat" <?= $privilegio->mensajero == '1' ? 'checked' : '' ?> />
                                    </label>
                                  </div>

                                  <div class="tab-pane" id="equipos">
                                    <p class="lead">Equipos</p>
                                    <label>
                                      Administrar Equipos TI <input name="administrar_equipos_it" type="checkbox" class="flat" <?= $privilegio->administrar_equipos_it == '1' ? 'checked' : '' ?> />
                                    </label>
                                  </div>

                                  <div class="tab-pane" id="requerimientos">
                                    <p class="lead">Requerimientos</p>
                                    <label>
                                      Evaluar Requerimientos <input type="checkbox" name="evaluar_requerimientos" class="flat" <?= $privilegio->evaluar_requerimientos == '1' ? 'checked' : '' ?> />
                                    </label>
                                  </div>

                                  <div class="tab-pane" id="recursos">
                                    <p class="lead">Recursos</p>
                                    <label>
                                      Asignar Recursos <input type="checkbox" name="asignar_recursos" class="flat" <?= $privilegio->asignar_recursos == '1' ? 'checked' : '' ?> />
                                    </label>
                                    <label>
                                      Gestionar Recursos <input type="checkbox" name="gestionar_recursos" class="flat" <?= $privilegio->gestionar_recursos == '1' ? 'checked' : '' ?> />
                                    </label>
                                  </div>

                                </div>

                              </div>
                              </div>
                              <center>
                                <input type="submit" id="btnEditarPrivilegios" onclick="guardarAprobador()" class="btn btn-success" value="Editar Privilegios" />
                              </center>
                            </form>
                          </div>
                          <?php } ?>
                          
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
    <script src=<?=base_url("template/vendors/jquery/dist/jquery.min.js"); ?>></script>
    <!-- Bootstrap -->
    <script src=<?=base_url("template/vendors/bootstrap/dist/js/bootstrap.min.js"); ?>></script>
    <!-- FastClick -->
    <script src=<?=base_url("template/vendors/fastclick/lib/fastclick.js"); ?>></script>
    <!-- NProgress -->
    <script src=<?=base_url("template/vendors/nprogress/nprogress.js"); ?>></script>
    <!-- morris.js -->
    <script src=<?=base_url("template/vendors/raphael/raphael.min.js"); ?>></script>
    <script src=<?=base_url("template/vendors/morris.js/morris.min.js"); ?>></script>
    <!-- bootstrap-progressbar -->
    <script src=<?=base_url("template/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"); ?>></script>
    <!-- bootstrap-daterangepicker -->
    <script src=<?=base_url("template/vendors/moment/min/moment.min.js"); ?>></script>
    <script src=<?=base_url("template/vendors/bootstrap-daterangepicker/daterangepicker.js"); ?>></script>
    <!-- Custom Theme Scripts -->
    <script src=<?=base_url("template/build/js/custom.js"); ?>></script>
    <!-- Switchery -->
    <script src=<?= base_url("template/vendors/iCheck/icheck.min.js"); ?>></script>
    <!-- PNotify -->
    <script src=<?= base_url("template/vendors/pnotify/dist/pnotify.js"); ?>></script>
    <script src=<?= base_url("template/vendors/pnotify/dist/pnotify.buttons.js"); ?>></script>
    <script src=<?= base_url("template/vendors/pnotify/dist/pnotify.nonblock.js"); ?>></script>
    <!-- JS File -->
    <script src=<?= base_url("application/views/usuarios/js/ver.js"); ?>></script>

    <script>
    const ID = '<?= $usuario->id ?>';
    const AC = '<?= $usuario->autorizador_compras ?>';
    const ACV = '<?= $usuario->autorizador_compras_venta ?>';
    const ACOT = '<?= $usuario->autorizador_cotizacion ?>';

    $(function(){
      load();
    });



    <?php
    if (isset($this->session->errores)) {
        foreach ($this->session->errores as $error) {
            echo "new PNotify({ title: '" . $error['titulo'] . "', text: '" . $error['detalle'] . "', type: 'error', styling: 'bootstrap3' });";
        }
        $this->session->unset_userdata('errores');
    }
    if (isset($this->session->aciertos)) {
        foreach ($this->session->aciertos as $acierto) {
            echo "new PNotify({ title: '" . $acierto['titulo'] . "', text: '" . $acierto['detalle'] . "', type: 'success', styling: 'bootstrap3' });";
        }
        $this->session->unset_userdata('aciertos');
    }
    ?>
    </script>

  </body>
</html>
