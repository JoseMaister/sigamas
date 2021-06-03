<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Modificar Estatus QR / PR / PO</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                    <?php if ($this->session->privilegios['retroceder_qr']) { ?>
                        <div class="row">
                            <a href=<?= base_url('ordenes_compra/retroceder_qr'); ?>>
                                <div class="animated flipInY col-md-12 col-sm-12 col-xs-12">
                                    <div class="tile-stats">
                                        <div class="icon"><i class="fa fa-file-text-o"></i>
                                        </div>
                                        <div class="count">QR's</div>
                                        <h3>Requisición de cotización</h3>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php } ?>

                    <?php if ($this->session->privilegios['retroceder_qr'] || $this->session->privilegios['retroceder_po']) { ?>
                        <div class="row">
                            <a href=<?= base_url('ordenes_compra/recibir_pr'); ?>>
                                <div class="animated flipInY col-md-12 col-sm-12 col-xs-12">
                                    <div class="tile-stats">
                                        <div class="icon"><i class="fa fa-shopping-cart"></i>
                                        </div>
                                        <div class="count">PR's</div>
                                        <h3>Solicitud de Compra</h3>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php } ?>
                    
                    <?php if ($this->session->privilegios['retroceder_po']) { ?>
                        <div class="row">
                            <a href=<?= base_url('ordenes_compra/retroceder_po'); ?>>
                                <div class="animated flipInY col-md-12 col-sm-12 col-xs-12">
                                    <div class="tile-stats">
                                        <div class="icon"><i class="fa fa-shopping-cart"></i>
                                        </div>
                                        <div class="count">PO's</div>
                                        <h3>Ordenes de Compra</h3>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php } ?>


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
<script>
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
