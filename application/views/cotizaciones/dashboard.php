<!-- page content -->
<div class="right_col" role="main">
    <div class="">

        <div class="clearfix"></div>

        <div class="row">
            <div class="x_content">
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Cotizaciones</h2>
                            <div class="clearfix"></div>
                        </div>

                        <div class="x_content">
                            <table class="table table-striped projects">
                                <thead>
                                    <tr>
                                        <th style="width: 20%">Estatus</th>
                                        <th>Cantidad</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <a>APROBADA</a>
                                        </td>
                                        <td class="project_progress">
                                            <a target="_blank" href="<?= base_url('cotizaciones') ?>">
                                                <div class="progress">
                                                    <div id="pbAprobadas" class="progress-bar bg-blue" role="progressbar"></div>
                                                </div>
                                                <small id="lblAprobadas"></small>
                                            </a>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <a>ENVIADA</a>
                                        </td>
                                        
                                        <td class="project_progress">
                                            <a target="_blank" href="<?= base_url('cotizaciones') ?>">
                                                <div class="progress">
                                                    <div id="pbEnviadas" class="progress-bar bg-blue" role="progressbar"></div>
                                                </div>
                                                <small id="lblEnviadas"></small>
                                            </a>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <a>CONFIRMADA</a>
                                        </td>
                                        <td class="project_progress">
                                            <a target="_blank" href="<?= base_url('cotizaciones') ?>">
                                                <div class="progress">
                                                    <div id="pbConfirmadas" class="progress-bar bg-blue" role="progressbar"></div>
                                                </div>
                                                <small id="lblConfirmadas"></small>
                                            </a>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <a>EN REVISION</a>
                                        </td>
                                        <td class="project_progress">
                                            <a target="_blank" href="<?= base_url('cotizaciones') ?>">
                                                <div class="progress">
                                                    <div id="pbEnRevision" class="progress-bar bg-orange" role="progressbar"></div>
                                                </div>
                                                <small id="lblEnRevision"></small>
                                            </a>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <a>EN AUTORIZACION</a>
                                        </td>
                                        <td class="project_progress">
                                            <a target="_blank" href="<?= base_url('cotizaciones') ?>">
                                                <div class="progress">
                                                    <div id="pbEnAutorizacion" class="progress-bar bg-orange" role="progressbar"></div>
                                                </div>
                                                <small id="lblEnAutorizacion"></small>
                                            </a>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <a>AUTORIZADO PARCIAL</a>
                                        </td>
                                        <td class="project_progress">
                                            <a target="_blank" href="<?= base_url('cotizaciones') ?>">
                                                <div class="progress">
                                                    <div id="pbAutorizadoParcial" class="progress-bar bg-green" role="progressbar"></div>
                                                </div>
                                                <small id="lblAutorizadoParcial"></small>
                                            </a>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <a>AUTORIZADO TOTAL</a>
                                        </td>
                                        <td class="project_progress">
                                            <a target="_blank" href="<?= base_url('cotizaciones') ?>">
                                                <div class="progress">
                                                    <div id="pbAutorizadoTotal" class="progress-bar bg-green" role="progressbar"></div>
                                                </div>
                                                <small id="lblAutorizadoTotal"></small>
                                            </a>
                                        </td>
                                    </tr>

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
<!-- bootstrap-progressbar -->
<script src=<?= base_url("template/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"); ?>></script>
<!-- Custom Theme Scripts -->
<script src=<?= base_url("template/build/js/custom.js"); ?>></script>

<!-- PNotify -->
<script src=<?= base_url("template/vendors/pnotify/dist/pnotify.js"); ?>></script>
<script src=<?= base_url("template/vendors/pnotify/dist/pnotify.buttons.js"); ?>></script>
<script src=<?= base_url("template/vendors/pnotify/dist/pnotify.nonblock.js"); ?>></script>
<!-- iCheck -->
<script src=<?= base_url("template/vendors/iCheck/icheck.min.js"); ?>></script>
<!-- CUSTOM JS FILE -->
<script src=<?=base_url("template/js/custom/funciones.js"); ?>></script>
<!-- JS File -->
<script src=<?= base_url("application/views/cotizaciones/js/dashboard.js"); ?>></script>

<script>
    

    $(document).ready(function(){
        load();
    });
</script>
</body>
</html>
