<!-- page content -->
<div class="right_col" role="main">
    <div class="">

        <div class="row">

          <div class="col-md-3 col-xs-12">
            <div class="x_panel fixed_height_390">
              <div class="x_title">
                <h2>Automóvil</h2>
                <div class="clearfix"></div>
              </div>
              <div class="x_content">

                <div style="text-align: center; overflow: hidden; margin: 10px;">
                  <img width="100%" height="190" src="<?= 'data:image/bmp;base64,' . base64_encode($foto); ?>">
                </div>

                <div>
                  <ul class="list-inline widget_tally">
                    <li>
                      <p>
                        <span style="width: 50%; float: left; text-align: left" >Marca:</span>
                        <span style="width: 50%; float: left; text-align: left;"><?= $marca ?></span>
                      </p>
                    </li>
                    <li>
                      <p>
                        <span style="width: 50%; float: left; text-align: left" >Combustible:</span>
                        <span style="width: 50%; float: left; text-align: left;"><?= $combustible ?></span>
                      </p>
                    </li>
                    <li>
                      <p>
                        <span style="width: 50%; float: left; text-align: left" >Placas:</span>
                        <span style="width: 50%; float: left; text-align: left;"><?= $placas ?></span>
                      </p>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>

            <div class="col-md-9 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Generar Ticket de Servicio <small>Mantenimiento</small></h2>
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




                        <form method="POST" action=<?= base_url('tickets_AT/registrar') ?> class="form-horizontal form-label-left" novalidate>

                              <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tipo">Tipo:</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <p>
                                        Mantenimiento
                                        <input type="hidden" id="tipo" name="tipo" value="MANTENIMIENTO">
                                    </p>
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="titulo">Titulo:</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <p>
                                        Mantenimiento Correspondiente a los <?= number_format($proximo_mtto) ?> KM
                                        <input type="hidden" id="titulo" name="titulo" value="<?= 'Mantenimiento Correspondiente a los ' . number_format($proximo_mtto) . ' KM' ?>">
                                    </p>
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Descripción <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea id="textarea" placeholder="Descripción o Comentarios" required="required" name="descripcion" class="form-control col-md-7 col-xs-12"></textarea>
                                </div>
                            </div>



                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-3">
                                    <input type="hidden" name="auto" value="<?= $auto ?>">
                                    <button id="send" type="submit" class="btn btn-success">Abrir Ticket</button>
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
<!-- Custom Theme Scripts -->
<script src=<?= base_url("template/build/js/custom.min.js"); ?>></script>



</body>
</html>
