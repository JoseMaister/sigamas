<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Logística</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">
                            <a href=<?= base_url('logistica/documentacion'); ?>>
                                <div class="animated flipInY col-md-12 col-sm-12 col-xs-12">
                                    <div class="tile-stats">
                                        <div class="icon"><i class="fa fa-file-o"></i>
                                        </div>
                                        <div class="count">Documentación</div>
                                        <h3>Rececepción de Documentos</h3>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="row">
                            <a href=<?= base_url('logistica/programacion_recorridos'); ?>>
                                <div class="animated flipInY col-md-12 col-sm-12 col-xs-12">
                                    <div class="tile-stats">
                                        <div class="icon"><i class="fa fa-book"></i>
                                        </div>
                                        <div class="count">Recorridos</div>
                                        <h3>Programación de Recorridos</h3>
                                    </div>
                                </div>
                            </a>
                          </div>
                          <div class="row">
                            <a href=<?= base_url('logistica/recorridos'); ?>>
                                <div class="animated flipInY col-md-12 col-sm-12 col-xs-12">
                                    <div class="tile-stats">
                                        <div class="icon"><i class="fa fa-truck"></i>
                                        </div>
                                        <div class="count">Logística</div>
                                        <h3>Logística de Recorridos</h3>
                                    </div>
                                </div>
                            </a>
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
