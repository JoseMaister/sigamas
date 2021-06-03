        <!-- page content -->
        <div class="right_col" role="main">

          <div class="">

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><?= $auto->fabricante . ' ' . $auto->marca . ' ' . $auto->modelo ?></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <div class="col-md-7 col-sm-7 col-xs-12">
                      <div class="product-image">
                        <img src=<?= 'data:image/bmp;base64,' . base64_encode($auto->foto); ?> />
                      </div>


                    </div>

                    <div class="col-md-5 col-sm-5 col-xs-12" style="border:0px solid #e5e5e5;">
                      <h3>No. Serie:</h3>
                      <div class="product_price">
                        <center>
                        <h2><font color="black"><?= $auto->serie ?></font></h2>
                        </center>
                      </div>

                      <h3>Placas:</h3>
                      <div class="product_price">
                        <center>
                        <h1><font color="black"><?= $auto->placas ?></font></h1>
                        </center>
                      </div>

                      <h3>Kilometraje Actual:</h3>
                      <div class="product_price">
                        <center>
                        <h1><font color="black"><?= number_format($auto->kilometraje) . ' KM' ?></font></h1>
                        </center>
                      </div>

                      <!-- RESPONSABLE -->
                      <?php if($responsable)
                      { ?>
                        <a href='<?= base_url("usuarios/ver/" . $responsable->id) ?>'>
                        <div style="padding-left: 0px;" class="col-md-4 col-sm-4 col-xs-12">
                          <img class="usuario" width="100%" src=<?= 'data:image/bmp;base64,' . base64_encode($responsable->foto); ?>>
                        </div>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <h3 style="margin-top: 2px;">Responsable: </h3>
                          <p><?= $responsable->UserShort ?></p>
                          <p><?= ucfirst(strtolower($responsable->puesto)) ?></p></a>
                          <button type="button" class="btn btn-default" data-toggle="modal" data-target=".bs-example-modal-lg">Cambiar Responsable</button>
                        </div>
                      <?php } ?>
                    </div>




                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
        <!-- /page content -->

        <!--MODAL -->
        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">

              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Seleccione Responsable</h4>
              </div>
              <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr class="headings">
                                <th class="column-title">Foto</th>
                                <th class="column-title">Nombre</th>
                                <th class="column-title">Puesto</th>
                                <th class="column-title">Opciones</th>
                            </tr>
                        </thead>

                        <tbody>
                        <?php foreach ($usuarios->result() as $elem) { ?>

                              <tr class="even pointer">
                                <td><img src=<?= 'data:image/bmp;base64,' . base64_encode($elem->foto); ?> class="avatar"></td>
                                <td>
                                    <?= strtoupper($elem->User) ?><br/>
                                    <?php $date = date_create($elem->ultima_sesion); ?>
                                    <small>Ultima Sesión: <?= date_format($date, 'd/m/Y h:i A'); ?></small>
                                </td>
                                <td><?= $elem->puesto ?></td>
                                <td>
                                  <form action='<?= base_url("autos/ver/" . $auto->id); ?>' method="POST">
                                    <button name="responsable" value="<?= $elem->id; ?>" class="btn btn-primary" type="submit">Seleccionar</button>
                                  </form>
                                </td>
                              </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
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
    <!-- Custom Theme Scripts -->
    <script src=<?= base_url("template/build/js/custom.min.js"); ?>></script>
  </body>
</html>
