<!-- page content -->
<div class="right_col" role="main">
    <div class="">

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Mis Tickets</h2>
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
                                        <th class="column-title">ID</th>
                                        <th class="column-title">Fecha de Creación</th>
                                        <th class="column-title">Usuario</th>
                                        <th class="column-title">Ticket</th>
                                        <th class="column-title">Tipo</th>
                                        <th class="column-title">Titulo</th>
                                        <th class="column-title">Estatus</th>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php
                                if ($tickets) {
                                    $BTN_CLASS = 'btn btn-default';
                                    foreach ($tickets->result() as $elem) {
                                        switch ($elem->estatus) {

                                            case 'ABIERTO':
                                                $BTN_CLASS = 'btn btn-primary';
                                                break;

                                            case 'EN CURSO':
                                                $BTN_CLASS = 'btn btn-info';
                                                break;

                                            case 'DETENIDO':
                                                $BTN_CLASS = 'btn btn-warning';
                                                break;

                                            case 'CANCELADO':
                                                $BTN_CLASS = 'btn btn-default';
                                                break;

                                            case 'SOLUCIONADO':
                                                $BTN_CLASS = 'btn btn-success';
                                                break;

                                            case 'CERRADO':
                                                $BTN_CLASS = 'btn btn-dark';
                                                break;
                                        }
                                        ?>
                                            <tr class="even pointer">
                                                <td><?= $elem->Prefijo . str_pad($elem->id, 6, "0", STR_PAD_LEFT) ?></td>
                                                <td>
                                                    <?php $date = date_create($elem->fecha); ?>
                                                    <a><?= date_format($date, 'd/m/Y h:i A'); ?></a>
                                                </td>
                                                <td><?= $elem->User ?></td>
                                                <td><?= $elem->Ticket ?></td>
                                                <td><?= $elem->tipo ?></td>
                                                <td><?= $elem->titulo ?></td>
                                                <td><a href=<?= base_url($elem->Controlador . "/ver/" . $elem->id) ?>><button type="button" class=<?= "'" . $BTN_CLASS . "'" ?> ><?= $elem->estatus ?></button></a></td>
                                            </tr>
                                        <?php
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
<script src=<?= base_url("template/vendors/jquery/dist/jquery.min.js") ?>></script>
<!-- Bootstrap -->
<script src=<?= base_url("template/vendors/bootstrap/dist/js/bootstrap.min.js") ?>></script>
<!-- FastClick -->
<script src=<?= base_url("template/vendors/fastclick/lib/fastclick.js") ?>></script>
<!-- NProgress -->
<script src=<?= base_url("template/vendors/nprogress/nprogress.js") ?>></script>
<!-- bootstrap-progressbar -->
<script src=<?= base_url("template/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js") ?>></script>

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
