<!-- page content -->
<div class="right_col" role="main">
    <div class="">

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-3 col-sm-3 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Automóvil</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                      <div style="text-align: center; overflow: hidden; margin: 10px;">
                        <img width="100%" src="<?= 'data:image/bmp;base64,' . base64_encode($auto_foto); ?>">
                      </div>

                      <div>
                        <ul class="list-inline widget_tally">
                          <li>
                            <p>
                              <span style="width: 50%; float: left; text-align: left" >Marca:</span>
                              <span style="width: 50%; float: left; text-align: left;"><?= $auto_marca ?></span>
                            </p>
                          </li>
                          <li>
                            <p>
                              <span style="width: 50%; float: left; text-align: left" >Combustible:</span>
                              <span style="width: 50%; float: left; text-align: left;"><?= $auto_combustible ?></span>
                            </p>
                          </li>
                          <li>
                            <p>
                              <span style="width: 50%; float: left; text-align: left" >Placas:</span>
                              <span style="width: 50%; float: left; text-align: left;"><?= $auto_placas ?></span>
                            </p>
                          </li>
                        </ul>
                      </div>

                    </div>
                </div>
            </div>

            <div class="col-md-9 col-sm-9 col-xs-12">
              <div class="x_panel">
                  <div class="x_title">
                      <h2>Resultado de la Revisión</h2>
                      <ul class="nav navbar-right panel_toolbox">
                          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                          </li>
                          <li><a class="close-link"><i class="fa fa-close"></i></a>
                          </li>
                      </ul>
                      <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <div>
                      <ul class="list-inline widget_tally">
                        <li>
                          <a target="_blank" href=<?= base_url("pdf/revision/" . $rev_id) ?>><button type="button" class="btn btn-dark btn-sm"><i class="fa fa-file-pdf-o"></i> Ver en PDF</button></a></td>
                        </li>
                        <li>
                          <p>
                            <span style="font-size: 18px; width: 50%; float: left; text-align: left" >No. Revisión:</span>
                            <span style="font-size: 18px; width: 50%; float: left; text-align: left;"><?= $rev_id ?></span>
                          </p>
                        </li>
                        <li>
                          <p>
                            <?php
                            $date_rev_fecha = date_create($rev_fecha);
                            ?>
                            <span style="font-size: 18px; width: 50%; float: left; text-align: left" >Fecha:</span>
                            <span style="font-size: 18px; width: 50%; float: left; text-align: left;"><?= date_format($date_rev_fecha, 'd/m/Y h:i A') ?></span>
                          </p>
                        </li>
                        <li>
                          <p>
                            <span style="font-size: 18px; width: 50%; float: left; text-align: left" >Revisión por:</span>
                            <span style="font-size: 18px; width: 50%; float: left; text-align: left;"><?= $rev_User ?></span>
                          </p>
                        </li>
                        <li>
                          <p>
                            <span style="font-size: 18px; width: 50%; float: left; text-align: left" >Kilometraje:</span>
                            <span style="font-size: 18px; width: 50%; float: left; text-align: left;"><?= $rev_kilometraje ?></span>
                          </p>
                        </li>
                        <li>
                          <p>
                            <span style="font-size: 18px; width: 50%; float: left; text-align: left" >Combustible:</span>
                            <span style="font-size: 18px; width: 50%; float: left; text-align: left;"><?= $rev_combustible . "%" ?></span>
                          </p>
                        </li>
                        <li>
                          <p>
                            <span style="font-size: 18px; width: 50%; float: left; text-align: left" >Placas:</span>
                            <span style="font-size: 18px; width: 50%; float: left; text-align: left;"><?= $rev_placas ?></span>
                          </p>
                        </li>
                        <li>
                          <p>
                            <?php
                            $date_rev_vencimiento_poliza = date_create($rev_vencimiento_poliza);
                            ?>
                            <span style="font-size: 18px; width: 50%; float: left; text-align: left" >Vencimiento de Poliza:</span>
                            <span style="font-size: 18px; width: 50%; float: left; text-align: left;"><?= date_format($date_rev_vencimiento_poliza, 'd/M/Y') ?></span>
                          </p>
                        </li>
                        <li>
                          <p>
                            <?php
                            $date_rev_ecologico = date_create($rev_ecologico);
                            ?>
                            <span style="font-size: 18px; width: 50%; float: left; text-align: left" >Vecimiento de Ecológico:</span>
                            <span style="font-size: 18px; width: 50%; float: left; text-align: left;"><?= date_format($date_rev_ecologico, 'd/M/Y') ?></span>
                          </p>
                        </li>
                      </ul>
                    </div>

                  </div>
              </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Carroceria</h2>
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
                            <table class="table table-striped">
                                <thead>
                                    <tr class="headings">
                                        <th class="column-title">No</th>
                                        <th class="column-title">Foto</th>
                                        <th class="column-title">Descripción</th>
                                    </tr>
                                </thead>

                                <tbody>
                                <div id="simple_gallery" class="box-content">
                                <?php
                                if ($carroceria) { $i = 1;
                                    foreach ($carroceria->result() as $elem) {
                                      ?>
                                            <tr class="even pointer">
                                                <td width="10%"><?= $i ?></td>
                                                <td>
                                                  <a id="single_image" href=<?= base_url('autos/Hallazgo_foto/'.$elem->id) ?>>
                                                  <img class="avatar100" src=<?= base_url('autos/Hallazgo_foto/'.$elem->id) ?>>
                                                </a>
                                                </td>
                                                <td><?= $elem->descripcion ?></td>
                                            </tr>
                                        <?php $i++;
                                    }
                                }
                                ?>
                                </div>
                                </tbody>
                            </table>
                        </div>


                    </div>
                </div>
            </div>

            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Hallazgos</h2>
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
                            <table class="table table-striped">
                                <thead>
                                    <tr class="headings">
                                        <th class="column-title">No</th>
                                        <th class="column-title">Tipo</th>
                                        <th class="column-title">Comentario</th>
                                    </tr>
                                </thead>

                                <tbody>
                                <?php
                                if ($otros) { $i = 1;
                                    foreach ($otros->result() as $elem) {
                                        ?>
                                            <tr class="even pointer">
                                                <td width="10%"><?= $i ?></td>
                                                <td><?= $elem->tipo ?></td>
                                                <td><?= $elem->descripcion ?></td>
                                            </tr>
                                        <?php $i++;
                                    }
                                }
                                ?>
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
<!-- FancyBOX -->
<script src=<?= base_url("template/vendors/fancybox/dist/jquery.fancybox.min.js"); ?>></script>
<script>

$(document).ready(function () {

    /* This is basic - uses default settings */

    $("a#single_image").fancybox();

    /* Using custom settings */

    $("a#inline").fancybox({
        'hideOnContentClick': true
    });

    /* Apply fancybox to multiple items */

    $("a.group").fancybox({
        'transitionIn': 'elastic',
        'transitionOut': 'elastic',
        'speedIn': 600,
        'speedOut': 200,
        'overlayShow': false
    });

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
<!-- Custom Theme Scripts -->
<script src=<?= base_url("template/build/js/custom.js"); ?>></script>
</body>
</html>
