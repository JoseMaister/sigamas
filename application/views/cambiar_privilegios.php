        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Privilegios <small><?= $privilegio->puesto ?></small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="col-md-12 col-sm-12 col-xs-12">

                <form method="POST" action=<?= base_url("privilegios/modificar/").$privilegio->id ?> >
                  <input type="hidden" name="id" value=<?= $privilegio->id ?>>
                  <input type="hidden" name="puesto" value='<?= $privilegio->puesto ?>'>
                <div class="x_panel">
                  <div class="x_content">
                    <div class="col-xs-2">
                      <!-- required for floating -->
                      <!-- Nav tabs -->
                      <ul class="nav nav-tabs tabs-left">
                        <li class="active"><a href="#usuarios" data-toggle="tab">Usuarios</a>
                        </li>
                        <li><a href="#tickets" data-toggle="tab">Tickets</a>
                        </li>
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
                        <div class="tab-pane" id="tickets">
                          <p class="lead">Tickets</p>
                          <label>
                            Generar Tickets <input name="generar_tickets" type="checkbox" class="flat" <?= $privilegio->generar_tickets == '1' ? 'checked' : '' ?> />
                          </label>
                          <label>
                            Administrar Tickets <input name="administrar_tickets" type="checkbox" class="flat" <?= $privilegio->administrar_tickets == '1' ? 'checked' : '' ?> />
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
                        <div class="tab-pane" id="messages">
                          <!-- TAB -->
                        </div>
                        <div class="tab-pane" id="settings">
                          <!-- TAB -->
                        </div>

                      </div>

                    </div>


                    <div class="clearfix"></div>


                  </div>
                </div>
                  <a class="btn btn-primary" href=<?= base_url('privilegios') ?>><i class="fa fa-reply"></i> Regresar</a>
                  <input type="submit" class="btn btn-success" value="Editar" />
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
    <script src=<?= base_url("template/vendors/jquery/dist/jquery.min.js"); ?>></script>
    <!-- Bootstrap -->
    <script src=<?= base_url("template/vendors/bootstrap/dist/js/bootstrap.min.js"); ?>></script>
    <!-- FastClick -->
    <script src=<?= base_url("template/vendors/fastclick/lib/fastclick.js"); ?>></script>
    <!-- NProgress -->
    <script src=<?= base_url("template/vendors/nprogress/nprogress.js"); ?>></script>

    <!-- Custom Theme Scripts -->
    <script src=<?= base_url("template/build/js/custom.min.js"); ?>></script>

    <!-- Switchery -->
    <script src=<?= base_url("template/vendors/iCheck/icheck.min.js"); ?>></script>
  </body>
</html>
