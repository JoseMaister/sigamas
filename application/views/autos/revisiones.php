<!-- page content -->
<div class="right_col" role="main">
    <div class="">

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Registro de Revisiones</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <a href=<?= base_url('autos/registrar_revision/' . $auto); ?> class="btn btn-primary btn-xs"><i class="fa fa-check"></i> Registrar Revisión</a>
                    <div class="x_content">

                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr class="headings">
                                        <th class="column-title">No</th>
                                        <th class="column-title">Fecha de Registro</th>
                                        <th class="column-title">Usuario</th>
                                        <th class="column-title">Ver Revisión</th>
                                        <th class="column-title">Hallazgos</th>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php
                                if ($rev) { $i = 1;
                                    foreach ($rev->result() as $elem) {
                                        ?>
                                            <tr class="even pointer">
                                                <td><?= $i ?></td>
                                                <td>
                                                    <?php $date = date_create($elem->fecha); ?>
                                                    <a><?= date_format($date, 'd/m/Y h:i A'); ?></a>
                                                </td>
                                                <td><?= $elem->User ?></td>
                                                <td><a target="_blank" href=<?= base_url("pdf/revision/" . $elem->id) ?>><button type="button" class="btn btn-dark btn-sm"><i class="fa fa-file-pdf-o"></i> Ver Checklist</button></a></td>
                                                <?php
                                                if($elem->Hallazgos > 0)
                                                {
                                                  echo '<td><a href="'.base_url("autos/hallazgos/" . $elem->id).'" class="btn btn-danger btn-sm"><i class="fa fa-close"></i> '.$elem->Hallazgos.'</a></td>';
                                                }
                                                else
                                                {
                                                  echo '<td><a href="'.base_url("autos/hallazgos/" . $elem->id).'" class="btn btn-success btn-sm"><i class="fa fa-check"></i> '.$elem->Hallazgos.'</a></td>';
                                                  //echo '<td><a href="#" onclick="noHallazgos()" class="btn btn-success btn-sm"><i class="fa fa-check"></i> 0</a></td>';
                                                }

                                                ?>
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

function noHallazgos()
{
  new PNotify({ title: 'Revisión Exitosa', text: 'No se reportaron problemas en la Revisión', type: 'success', styling: 'bootstrap3' });
}

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
