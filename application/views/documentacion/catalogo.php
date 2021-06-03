<!-- page content -->
<div class="right_col" role="main">
    <div class="">

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Manuales de usuario</h2>
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
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <table id="tbl" class="table table-striped">
                                    <thead>
                                        <tr class="headings">
                                            <th class="column-title">Modulo</th>
                                            <th class="column-title">Autor</th>
                                            <th class="column-title">Ultima Revisión</th>
                                            <th class="column-title">Archivo</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php if($this->session->privilegios['generar_tickets'] == "1") { ?>
                                        <tr>
                                            <td>Tickets de Servicio</td>
                                            <td>EQUIPO DE DESARROLLO</td>
                                            <td>2019-01-01 11:18 AM</td>
                                            <td><a target="_blank" href=<?= base_url('template/files/manuales/tickets_servicio.pdf') ?> class='btn btn-primary btn-sm'><i class='fa fa-file-pdf-o'></i> Ver Archivo</a></td>
                                        </tr>
                                        <?php } ?>

                                        <?php if("1" == "1") { ?>
                                        <tr>
                                            <td>Revisión de Automóviles</td>
                                            <td>EQUIPO DE DESARROLLO</td>
                                            <td>2019-01-01 11:18 AM</td>
                                            <td><a target="_blank" href=<?= base_url('template/files/manuales/revisiones_autos.pdf') ?> class='btn btn-primary btn-sm'><i class='fa fa-file-pdf-o'></i> Ver Archivo</a></td>
                                        </tr>
                                        <?php } ?>

                                        <?php if("1" == "1") { ?>
                                        <tr>
                                            <td>Agenda</td>
                                            <td>EQUIPO DE DESARROLLO</td>
                                            <td>2019-01-01 11:18 AM</td>
                                            <td><a target="_blank" href=<?= base_url('template/files/manuales/agenda.pdf') ?> class='btn btn-primary btn-sm'><i class='fa fa-file-pdf-o'></i> Ver Archivo</a></td>
                                        </tr>
                                        <?php } ?>

                                        <?php if($this->session->privilegios['generar_cotizaciones'] == "1" | $this->session->privilegios['administrar_cotizaciones'] == "1" | $this->session->privilegios['aprobar_cotizacion'] == "1") { ?>
                                        <tr>
                                            <td>Cotizaciones</td>
                                            <td>EQUIPO DE DESARROLLO</td>
                                            <td>2019-09-07 08:00 AM</td>
                                            <td><a target="_blank" href=<?= base_url('template/files/manuales/cotizaciones.pdf') ?> class='btn btn-primary btn-sm'><i class='fa fa-file-pdf-o'></i> Ver Archivo</a></td>
                                        </tr>
                                        <?php } ?>

                                        <?php if($this->session->privilegios['crear_qr_interno'] == "1" | $this->session->privilegios['crear_qr_venta'] == "1") { ?>
                                        <tr>
                                            <td>Generar QR (Requisitor)</td>
                                            <td>EQUIPO DE DESARROLLO</td>
                                            <td>2019-01-01 11:18 AM</td>
                                            <td><a target="_blank" href=<?= base_url('template/files/manuales/generar_qr-pr.pdf') ?> class='btn btn-primary btn-sm'><i class='fa fa-file-pdf-o'></i> Ver Archivo</a></td>
                                        </tr>
                                        <?php } ?>

                                        <?php if($this->session->privilegios['crear_qr_interno'] == "1" | $this->session->privilegios['crear_qr_venta'] == "1") { ?>
                                        <tr>
                                            <td>Generar QR (Requisitor)</td>
                                            <td>EQUIPO DE DESARROLLO</td>
                                            <td>2019-01-01 11:18 AM</td>
                                            <td><a target="_blank" href=<?= base_url('template/files/manuales/generar_qr-pr.pdf') ?> class='btn btn-primary btn-sm'><i class='fa fa-file-pdf-o'></i> Ver Archivo</a></td>
                                        </tr>
                                        <?php } ?>

                                        <?php if($this->session->privilegios['editar_qr'] == "1" | $this->session->privilegios['liberar_qr'] == "1") { ?>
                                        <tr>
                                            <td>Editar QR (Comprador)</td>
                                            <td>EQUIPO DE DESARROLLO</td>
                                            <td>2019-01-01 11:18 AM</td>
                                            <td><a target="_blank" href=<?= base_url('template/files/manuales/editar_qr-pr.pdf') ?> class='btn btn-primary btn-sm'><i class='fa fa-file-pdf-o'></i> Ver Archivo</a></td>
                                        </tr>
                                        <?php } ?>

                                        <?php if($this->session->privilegios['editar_qr'] == "1" | $this->session->privilegios['liberar_qr'] == "1" | $this->session->privilegios['aprobar_compra'] == "1") { ?>
                                        <tr>
                                            <td>Ordenes de Compra</td>
                                            <td>EQUIPO DE DESARROLLO</td>
                                            <td>2019-01-21 16:08 PM</td>
                                            <td><a target="_blank" href=<?= base_url('template/files/manuales/ordenes_compra.pdf') ?> class='btn btn-primary btn-sm'><i class='fa fa-file-pdf-o'></i> Ver Archivo</a></td>
                                        </tr>
                                        <?php } ?>

                                        <?php if($this->session->privilegios['asignar_recursos'] == "1" | $this->session->privilegios['gestionar_recursos'] == "1") { ?>
                                        <tr>
                                            <td>Control de Recursos</td>
                                            <td>EQUIPO DE DESARROLLO</td>
                                            <td>2019-04-22 10:18 PM</td>
                                            <td><a target="_blank" href=<?= base_url('template/files/manuales/control_recursos.pdf') ?> class='btn btn-primary btn-sm'><i class='fa fa-file-pdf-o'></i> Ver Archivo</a></td>
                                        </tr>
                                        <?php } ?>

                                        <?php if($this->session->privilegios['solicitar_facturas'] == "1" | $this->session->privilegios['responder_facturas'] == "1") { ?>
                                        <tr>
                                            <td>Solicitud de Facturas</td>
                                            <td>EQUIPO DE DESARROLLO</td>
                                            <td>2019-04-22 10:18 PM</td>
                                            <td><a target="_blank" href=<?= base_url('template/files/manuales/solicitud_facturas.pdf') ?> class='btn btn-primary btn-sm'><i class='fa fa-file-pdf-o'></i> Ver Archivo</a></td>
                                        </tr>
                                        <?php } ?>

                                        <?php if($this->session->privilegios['administrar_servicios'] == "1") { ?>
                                        <tr>
                                            <td>Servicios</td>
                                            <td>EQUIPO DE DESARROLLO</td>
                                            <td>2019-01-01 11:18 AM</td>
                                            <td><a target="_blank" href=<?= base_url('template/files/manuales/servicios.pdf') ?> class='btn btn-primary btn-sm'><i class='fa fa-file-pdf-o'></i> Ver Archivo</a></td>
                                        </tr>
                                        <?php } ?>

                                    </tbody>
                                </table>
                            </div>
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
<!-- iCheck -->
<script src=<?= base_url("template/vendors/iCheck/icheck.min.js"); ?>></script>
<!-- jQuery Tags Input -->
<script src=<?= base_url("template/vendors/jquery.tagsinput/src/jquery.tagsinput.js") ?>></script>
<!-- formatCurrency -->
<script src=<?= base_url("template/vendors/formatCurrency/jquery.formatCurrency-1.4.0.js"); ?>></script>
<!-- Custom Theme Scripts -->
<script src=<?= base_url("template/build/js/custom.js"); ?>></script>
<!-- JS FILE -->
<script src=<?= base_url("application/views/servicios/js/catalogo.js"); ?>></script>
<script>
    var adm_ser = '<?= $this->session->privilegios['administrar_servicios'] ?>';

    $(function(){
        load();
    });


</script>
</body>
</html>
