<!-- page content -->
<div class="right_col" role="main">
    <div class="">

        <div class="clearfix"></div>

        <div class="row">
            <div class="x_content">
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Reporte QR's</h2>
                            <div class="clearfix"></div>
                        </div>

                        <div class="x_content">
                            <table class="table table-striped projects">
                                <thead>
                                    <tr>
                                        <th style="width: 20%">Estatus QR</th>
                                        <th>Cantidad</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <a>ABIERTO</a>
                                        </td>
                                        <td class="project_progress">
                                            <a target="_blank" href="<?= base_url('compras/requisiciones/abierto') ?>">
                                                <div class="progress">
                                                    <div id="pbAbiertos" class="progress-bar bg-blue" role="progressbar"></div>
                                                </div>
                                                <small id="lblAbiertos"></small>
                                            </a>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <a>COTIZANDO</a>
                                        </td>
                                        
                                        <td class="project_progress">
                                            <a target="_blank" href="<?= base_url('compras/requisiciones/cotizando') ?>">
                                                <div class="progress">
                                                    <div id="pbCotizando" class="progress-bar bg-orange" role="progressbar"></div>
                                                </div>
                                                <small id="lblCotizando"></small>
                                            </a>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <a>RECHAZADO</a>
                                        </td>
                                        <td class="project_progress">
                                            <a target="_blank" href="<?= base_url('compras/requisiciones/rechazado') ?>">
                                                <div class="progress">
                                                    <div id="pbRechazados" class="progress-bar bg-red" role="progressbar"></div>
                                                </div>
                                                <small id="lblRechazados"></small>
                                            </a>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>


                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Reporte PO's</h2>
                            <div class="clearfix"></div>
                        </div>

                        <div class="x_content">
                            <table class="table table-striped projects">
                                <thead>
                                    <tr>
                                        <th style="width: 20%">Estatus PO</th>
                                        <th>Cantidad</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <a>EN PROCESO</a>
                                        </td>
                                        <td class="project_progress">
                                            <a target="_blank" href="<?= base_url('ordenes_compra/catalogo_po/en_proceso') ?>">
                                                <div class="progress">
                                                    <div id="pbPOEnProceso" class="progress-bar bg-orange" role="progressbar"></div>
                                                </div>
                                                <small id="lblPOEnProceso"></small>
                                            </a>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <a>PENDIENTE AUTORIZACIÓN</a>
                                        </td>
                                        
                                        <td class="project_progress">
                                            <a target="_blank" href="<?= base_url('ordenes_compra/catalogo_po/pendiente_autorizacion') ?>">
                                                <div class="progress">
                                                    <div id="pbPOPendienteAutorizacion" class="progress-bar bg-orange" role="progressbar"></div>
                                                </div>
                                                <small id="lblPOPendienteAutorizacion"></small>
                                            </a>
                                        </td>
                                    </tr>


                                    <tr>
                                        <td>
                                            <a>AUTORIZADA</a>
                                        </td>
                                        <td class="project_progress">
                                            <a target="_blank" href="<?= base_url('ordenes_compra/catalogo_po/autorizada') ?>">
                                                <div class="progress">
                                                    <div id="pbPOAutorizada" class="progress-bar bg-green" role="progressbar"></div>
                                                </div>
                                                <small id="lblPOAutorizada"></small>
                                            </a>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <a>RECHAZADA</a>
                                        </td>
                                        <td class="project_progress">
                                            <a target="_blank" href="<?= base_url('ordenes_compra/catalogo_po/rechazada') ?>">
                                                <div class="progress">
                                                    <div id="pbPORechazada" class="progress-bar bg-red" role="progressbar"></div>
                                                </div>
                                                <small id="lblPORechazada"></small>
                                            </a>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <a>ORDENADA</a>
                                        </td>
                                        <td class="project_progress">
                                            <a target="_blank" href="<?= base_url('ordenes_compra/catalogo_po/ordenada') ?>">
                                                <div class="progress">
                                                    <div id="pbPOOrdenada" class="progress-bar bg-green" role="progressbar"></div>
                                                </div>
                                                <small id="lblPOOrdenada"></small>
                                            </a>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <a>RECIBIDA</a>
                                        </td>
                                        <td class="project_progress">
                                            <a target="_blank" href="<?= base_url('ordenes_compra/catalogo_po/recibida') ?>">
                                                <div class="progress">
                                                    <div id="pbPORecibida" class="progress-bar bg-blue" role="progressbar"></div>
                                                </div>
                                                <small id="lblPORecibida"></small>
                                            </a>
                                        </td>
                                    </tr>


                                </tbody>
                            </table>
                        </div>
                    </div>

                    
                </div>

                <div class="col-md-6 col-sm-6 col-xs-12">
                    
                </div>

                <div class="col-md-6 col-sm-6 col-xs-12">
                    

                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Reporte PR's</h2>
                            <div class="clearfix"></div>
                        </div>

                        <div class="x_content">
                            <table class="table table-striped projects">
                                <thead>
                                    <tr>
                                        <th style="width: 20%">Estatus PR</th>
                                        <th>Cantidad</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr>
                                        <td>
                                            <a>PENDIENTE</a>
                                        </td>
                                        
                                        <td class="project_progress">
                                            <a target="_blank" href="<?= base_url('compras/solicitudes_compra/pendiente') ?>">
                                                <div class="progress">
                                                    <div id="pbPRPendientes" class="progress-bar bg-orange" role="progressbar"></div>
                                                </div>
                                                <small id="lblPRPendientes"></small>
                                            </a>
                                        </td>
                                    </tr>


                                    <tr>
                                        <td>
                                            <a>APROBADO</a>
                                        </td>
                                        <td class="project_progress">
                                            <a target="_blank" href="<?= base_url('compras/solicitudes_compra/aprobado') ?>">
                                                <div class="progress">
                                                    <div id="pbPRAprobados" class="progress-bar bg-green" role="progressbar"></div>
                                                </div>
                                                <small id="lblPRAprobados"></small>
                                            </a>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <a>RECHAZADO</a>
                                        </td>
                                        <td class="project_progress">
                                            <a target="_blank" href="<?= base_url('compras/solicitudes_compra/rechazado') ?>">
                                                <div class="progress">
                                                    <div id="pbPRRechazados" class="progress-bar bg-red" role="progressbar"></div>
                                                </div>
                                                <small id="lblPRRechazados"></small>
                                            </a>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <a>EN SELECCION</a>
                                        </td>
                                        <td class="project_progress">
                                            <a target="_blank" href="<?= base_url('compras/solicitudes_compra/en_seleccion') ?>">
                                                <div class="progress">
                                                    <div id="pbPREnSeleccion" class="progress-bar bg-orange" role="progressbar"></div>
                                                </div>
                                                <small id="lblPREnSeleccion"></small>
                                            </a>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <a>PO AUTORIZADA</a>
                                        </td>
                                        <td class="project_progress">
                                            <a target="_blank" href="<?= base_url('compras/solicitudes_compra/po_autorizada') ?>">
                                                <div class="progress">
                                                    <div id="pbPRPOAutorizada" class="progress-bar bg-green" role="progressbar"></div>
                                                </div>
                                                <small id="lblPRPOAutorizada"></small>
                                            </a>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <a>EN PO</a>
                                        </td>
                                        <td class="project_progress">
                                            <a target="_blank" href="<?= base_url('compras/solicitudes_compra/en_po') ?>">
                                                <div class="progress">
                                                    <div id="pbPREnPO" class="progress-bar bg-blue" role="progressbar"></div>
                                                </div>
                                                <small id="lblPREnPO"></small>
                                            </a>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <a>POR RECIBIR</a>
                                        </td>
                                        <td class="project_progress">
                                            <a target="_blank" href="<?= base_url('compras/solicitudes_compra/por_recibir') ?>">
                                                <div class="progress">
                                                    <div id="pbPRPorRecibir" class="progress-bar bg-orange" role="progressbar"></div>
                                                </div>
                                                <small id="lblPRPorRecibir"></small>
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
<script src=<?= base_url("application/views/compras/js/dashboard.js"); ?>></script>

<script>
    

    $(document).ready(function(){
        load();
    });
</script>
</body>
</html>
