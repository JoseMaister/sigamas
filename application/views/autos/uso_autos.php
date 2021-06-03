        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Bitacora de Autos</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <div id='calendar'></div>

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

    <!-- modal -->
    <div id="mdlAlta" class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="mdlAltaTitle">Métodos de Pago</h4>
                </div>
                <div class="modal-body">
                  <form>

                      <div class="col-xs-6">
                          <label style="margin-left:15px;">Inicia</label>
                          <div class='input-group date' id='timeInicia'>
                              <input id="inicia" type='text' class="form-control" />
                              <span class="input-group-addon">
                                <span class="glyphicon glyphicon-time"></span>
                              </span>
                          </div>
                      </div>

                      <div class="col-xs-6">
                          <label style="margin-left:15px;">Final</label>
                          <div class='input-group date' id='timeTermina'>
                            <input id="termina" type='text' class="form-control"/>
                            <span class="input-group-addon">
                              <span class="glyphicon glyphicon-time"></span>
                            </span>
                        </div>
                      </div>

                      <div class="col-xs-12">
                          <label style="margin-left:15px;">RSI</label>
                          <div class="item form-group">
                              <input style="width: 47%" maxlength="45" id="txtRSI" type="text" class="form-control" />
                          </div>
                      </div>

                      <div class="col-xs-6">
                          <label style="margin-left:15px;">Destino</label>
                          <div class="item form-group">
                              <input maxlength="150" id="txtDestino" type="text" class="form-control" />
                          </div>
                      </div>

                      <div class="col-xs-6">
                          <label style="margin-left:15px;">Visita</label>
                          <div class="item form-group">
                              <input maxlength="150" id="txtVisita" type="text" class="form-control" />
                          </div>
                      </div>

                      <div class="col-xs-12">
                          <label style="margin-left:15px; margin-top: 10px;">Equipo</label>
                          <div class="item form-group">
                              <textarea maxlength="600" style="resize: none;" id="txtEquipo" required="required" class="form-control"></textarea>
                          </div>
                      </div>

                      <div class="col-xs-12">
                          <label style="margin-left:15px; margin-top: 10px;">Comentarios</label>
                          <div class="item form-group">
                              <textarea maxlength="600" style="resize: none;" id="txtComentarios" required="required" class="form-control"></textarea>
                          </div>
                      </div>

                      <div class="col-xs-8">
                          <label style="margin-left:15px; margin-top: 10px;">Auto</label>
                          <div class="item form-group">
                              <select id="opAutos" class="select2_single form-control">
                              </select>
                          </div>
                      </div>

                      <div class="col-xs-4">
                          <label style="margin-left:15px; margin-top: 10px;">Usuarios</label>
                          <button id="btnUsuarios" onclick="mdlUsuarios()" style="margin-left:25px; display: block;" class="btn btn-primary btn-sm" type="button"></button>
                      </div>



                  </form>
                </div>
                
                <div class="modal-footer">
                    <button id="btnCancelar" type="button" data-dismiss="modal" class="btn btn-default pull-left"><i class="fa fa-close"></i> Cancelar</button>
                    <button id="btnAgregar" type="button" onclick="crearEvento()" class="btn btn-primary"><i class='fa fa-plus'></i> Agregar</button>
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
                    <h4 class="modal-title" id="myModalLabel2">Usuarios</h4>
                </div>
                <div class="modal-body">
                    <form>
                    <!--
                      <div class="input-group">
                          <input id="txtBuscar" type="text" class="form-control" placeholder="Buscar Usuario...">
                          <span class="input-group-btn">
                          <button onclick="mdlUsuarios()" id="btnBuscar" class="btn btn-default" type="button">Buscar</button>
                          </span>
                      </div>
                      -->
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
                    <button type="button" onclick="asignarUsuarios()" class="btn btn-primary"><i class='fa fa-check'></i> Aceptar</button>
                </div>
                

            </div>
        </div>
    </div>

    <div id="mdlVer" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel2">Uso de Vehículo</h4>
                </div>
                <div class="modal-body">
                    <form>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-xs-6">
                                    <label style="margin-left:15px;">Inicia</label>
                                    <div class='input-group'>
                                        <input id="txtInicioRO" type='text' class="form-control" readonly>
                                    </div>
                                </div>

                                <div class="col-xs-6">
                                    <label style="margin-left:15px;">Final</label>
                                    <div class='input-group'>
                                        <input id="txtFinalPO" type='text' class="form-control" readonly>
                                    </div>
                                </div>

                                <div class="col-xs-12">
                                    <label style="margin-left:15px;">RSI</label>
                                    <div class="item form-group">
                                        <input style="width: 47%" maxlength="45" id="txtRSIRO" type="text" class="form-control" readonly>
                                    </div>
                                </div>

                                <div class="col-xs-6">
                                    <label style="margin-left:15px;">Destino</label>
                                    <div class="item form-group">
                                        <input maxlength="150" id="txtDestinoRO" type="text" class="form-control" readonly>
                                    </div>
                                </div>
                                
                                <div class="col-xs-6">
                                    <label style="margin-left:15px;">Visita</label>
                                    <div class="item form-group">
                                        <input maxlength="150" id="txtVisitaRO" type="text" class="form-control" readonly>
                                    </div>
                                </div>

                                <div class="col-xs-12">
                                    <label style="margin-left:15px; margin-top: 10px;">Equipo</label>
                                    <div class="item form-group">
                                        <textarea maxlength="600" style="resize: none;" id="txtEquipoRO" required="required" class="form-control" readonly></textarea>
                                    </div>
                                </div>

                                <div class="col-xs-12">
                                    <label style="margin-left:15px; margin-top: 10px;">Comentarios</label>
                                    <div class="item form-group">
                                        <textarea maxlength="600" style="resize: none;" id="txtComentariosRO" required="required" class="form-control" readonly></textarea>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-md-6">
                            <center>
                            <h4 id='lblAuto'></h4>
                            <div class="profile_img">
                                <img style="width: 50%;" id="imgAuto" class="usuario img-responsive avatar-view">
                            </div>
                            </center>
                            <table id="tblUsuariosRO" class="table table-striped">
                                <thead>
                                    <tr class="headings">
                                        <th width="25%" class="column-title">Foto</th>
                                        <th class="column-title">Nombre</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>

                    </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" id="btnEliminar" onclick="borrarEvento(this)" class="btn btn-danger pull-left"><i class='fa fa-trash'></i> Eliminar</button>
                    <button type="button" data-dismiss="modal" class="btn btn-default"><i class="fa fa-close"></i> Cerrar</button>
                </div>
                

            </div>
        </div>
    </div>
    <!-- /modal -->




    <!-- jQuery -->
    <script src=<?= base_url("template/vendors/jquery/dist/jquery.min.js"); ?>></script>
    <!-- Bootstrap -->
    <script src=<?= base_url("template/vendors/bootstrap/dist/js/bootstrap.min.js"); ?>></script>
    <!-- FastClick -->
    <script src=<?= base_url("template/vendors/fastclick/lib/fastclick.js"); ?>></script>
    <!-- iCheck -->
    <script src=<?= base_url("template/vendors/iCheck/icheck.min.js"); ?>></script>
    <!-- NProgress -->
    <script src=<?= base_url("template/vendors/nprogress/nprogress.js"); ?>></script>
    <!-- FullCalendar -->
    <script src=<?= base_url("template/vendors/moment/min/moment.min.js"); ?>></script>
    <script src=<?= base_url("template/vendors/fullcalendar/dist/fullcalendar.min.js"); ?>></script>
    <script src=<?= base_url("template/vendors/fullcalendar/dist/locale-all.js"); ?>></script>
    <!-- bootstrap-daterangepicker -->
    <script src=<?= base_url("template/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js") ?>></script>
    <!-- Custom Theme Scripts -->
    <script src=<?= base_url("template/build/js/custom.js"); ?>></script>
    <!-- JS FILE -->
    <script src=<?= base_url("application/views/autos/js/uso_autos.js"); ?>></script>
    <script>
        var UID = '<?= $this->session->id ?>';
        var UNAME = '<?= $this->session->nombre ?>';
        var P = '<?= $this->session->privilegios['bitacora_autos'] ?>';

        $(function(){
            load();
        });

    </script>

  </body>
</html>
