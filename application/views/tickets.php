<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Tickets de Servicio</h2>
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
                        <!--
                            
                        -->

                        <?php if($modulo != 'administrar/activos' | $this->session->privilegios['tickets_it_soporte']) { ?>
                            <a style="cursor: pointer;" onclick=generarTicketIT()>
                                <div class="animated flipInY col-md-12 col-sm-12 col-xs-12">
                                    <div class="tile-stats">
                                        <div class="icon"><i class="fa fa-laptop"></i>
                                        </div>
                                        <div class="count">Tickets de IT</div>
                                        <h3>Soporte Técnico de IT</h3>
                                    </div>
                                </div>
                            </a>

                        </div>
                        <div class="row">
                            <?php }
                          if($modulo != 'administrar/activos' | $this->session->privilegios['tickets_at_soporte']) { ?>
                            <a href=<?= base_url('tickets_AT/'.$modulo); ?>>
                                <div class="animated flipInY col-md-12 col-sm-12 col-xs-12">
                                    <div class="tile-stats">
                                        <div class="icon"><i class="fa fa-automobile"></i>
                                        </div>
                                        <div class="count">Automóviles</div>
                                        <h3>Servicio a Autos</h3>
                                    </div>
                                </div>
                            </a>
                          </div>
                          <div class="row">
                            <?php }
                            if($modulo != 'administrar/activos' | $this->session->privilegios['tickets_ed_soporte']) { ?>
                            <a href=<?= base_url('tickets_ED/'.$modulo); ?>>
                                <div class="animated flipInY col-md-12 col-sm-12 col-xs-12">
                                    <div class="tile-stats">
                                        <div class="icon"><i class="fa fa-building"></i>
                                        </div>
                                        <div class="count">Edificio</div>
                                        <h3>Mtto General y de Edificio</h3>
                                    </div>
                                </div>
                            </a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->


<div id="mdl" class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title mdlTitulo">Tickets Abiertos</h4>
            </div>

            <div class="modal-body">
                <p>
                    Tienes 2 o mas Tickets de IT solucionados, es necesario cerrarlos para generar nuevos tickets.
                </p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
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
<!-- jquery.redirect -->
<script src=<?= base_url("template/vendors/jquery.redirect/jquery.redirect.js"); ?>></script>
<!-- PNotify -->
<script src=<?= base_url("template/vendors/pnotify/dist/pnotify.js"); ?>></script>
<script src=<?= base_url("template/vendors/pnotify/dist/pnotify.buttons.js"); ?>></script>
<script src=<?= base_url("template/vendors/pnotify/dist/pnotify.nonblock.js"); ?>></script>
<script>
var USER = '<?= $this->session->id; ?>';
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

function generarTicketIT()
{
    var modulo = '<?= $modulo ?>';

    if(modulo == "generar")
    {
        var URL = base_url + 'tickets/ajax_getTicketsSolucionados';
        $.ajax({
            type: "POST",
            url: URL,
            data: { usuario : USER },
            success: function(result) {
                if(result)
                {
                    var rs = JSON.parse(result);
                    if(rs.Conteo > 1)
                    {
                        $('#mdl').modal();
                    }
                    else{
                        $.redirect( base_url + "tickets_IT/generar");
                    }
                }
            },
        });
    }
    else
    {
        $.redirect(base_url + "tickets_IT/" + modulo);
    }
}

</script>
<!-- Custom Theme Scripts -->
<script src=<?= base_url("template/build/js/custom.js"); ?>></script>
</body>
</html>
