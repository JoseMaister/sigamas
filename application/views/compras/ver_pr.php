<!-- page content -->
<div class="right_col" role="main">
    <div class="">

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>PR # <?= $pr->id; ?></h2>
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
                        
                        <div class="col-md-12">                            
                            <p class="lead">Fecha:  <small><?= $pr->fecha ?></small></p>
                            <p class="lead">Requisitor:  <small><?= $pr->User ?></small></p>
                            <p class="lead">QR #: <a target="_blank" href="<?= base_url('compras/ver_qr/') . $pr->qr ?>" class="btn btn-success"><?= "QR" . str_pad($pr->qr, 6, "0", STR_PAD_LEFT) ?></a></p>
                            <p class="lead">Destino:  <small><?= $pr->destino ?></small></p>

                            <p class="lead">Descripción: </p>
                            <p class="lead text-muted well well-sm no-shadow" style="margin-top: 10px;">
                                <?= $pr->descripcion ?>
                            </p>
                            <p class="lead">Detalles: </p>
                            <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                <tr>
                                    <th style="width:35%">Tipo</th>
                                    <td><?= $pr->tipo ?></td>
                                </tr>
                                <tr>
                                    <th>Subtipo</th>
                                    <td><?= $pr->subtipo ?></td>
                                </tr>
                                <tr>
                                    <th>Cantidad</th>
                                    <td><?= $pr->cantidad ?></td>
                                </tr>
                                <tr>
                                    <th>Unidad de Medida</th>
                                    <td><?= $pr->unidad ?></td>
                                </tr>
                                
                                <?php $att = json_decode($pr->atributos, TRUE);
                                foreach ($att as $key => $value) { ?>
                                    <tr>
                                        <th><?= ucfirst($key) ?></th>
                                        <td><?= $value ?></td>
                                    </tr>
                                <?php } ?>
                                

                                </tbody>
                            </table>

                            <?php if($pr->comentarios) { ?>
                                <p class="lead">Notas: </p>
                                <p style="margin-top: 10px;">
                                    <?= $pr->comentarios ?>
                                </p>
                                <?php } ?>
                                
                                <br><br>
                                <center>
                                    <!--<?php if($this->session->privilegios['aprobar_pr']) { ?>
                                        <h4><b>Estatus Actual:</b></h4><button id="btnEstatus" onclick="mdlEstatus(this)" value="<?= $pr->estatus ?>" type="button" class="<?= 'btn ' . $btn_estatus . ' btn-lg' ?>"><?= $pr->estatus ?></button>
                                    <?php } else { ?>
                                        <h4><b>Estatus Actual:</b></h4><button type="button" class="<?= 'btn ' . $btn_estatus . ' btn-lg' ?>"><?= $pr->estatus ?></button>
                                    <?php } ?> BORRRRARRRR!!!!!!!!!!!!!!-->

                                    <h4><b>Estatus Actual:</b></h4><button type="button" class="<?= 'btn ' . $btn_estatus . ' btn-lg' ?>"><?= $pr->estatus ?></button>

                                    <div style="margin-top: 15px;" id="divAprobador">
                                        <label id="lblAprobador"><?= $pr->Aprobador == "N/A" ? "" : ("Aprobado por: " . $pr->Aprobador) ?></label><br>
                                        <?php $date = date_create($pr->fecha_aprobacion); ?>
                                        <label id="lblFechaAprobacion"><?= $pr->Aprobador == "N/A" ? "" : date_format($date, 'd-m-Y h:i A'); ?></label>
                                    </div>

                                </center>

                            

                            </div>

                            
                        </div>

                        
                      </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8 col-sm-8 col-xs-12">
                <div id="pnlProveedores" class="x_panel">
                        <div class="x_title">
                            <h2>Propuesta</h2>
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
                            
                                <div class="col-md-12">

                                    <table id="tblProveedores" class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th style="width: 3%">Info</th>
                                                <th style="width: 45%">Nombre</th>
                                                <th>Precio Unitario</th>
                                                <th>Entrega</th>
                                                <th>Evidencia</th>
                                                <th>Costeo</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>    
                                </div>

                                <div class="row top_tiles">
                                    <div class="animated flipInY col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <div class="tile-stats">
                                        <div class="icon"><i class="fa fa-cubes"></i></div>
                                        <?php if($this->session->id == $pr->usuario && $pr->estatus == "RECHAZADO") { ?>
                                            <div class="count"><input id="txtQty" min="1" onchange="calculoImporte(this)" onkeyup="calculoImporte(this)" style="border: 0; background-color : #fffdc9; height: 60%; width: 50%;" type="number" value="<?= $pr->cantidad ?>"></div>
                                        <?php } else { ?>
                                            <div class="count"><?= $pr->cantidad ?></div>
                                        <?php } ?>
                                        <h3>Cantidad</h3>
                                        </div>
                                    </div>

                                    <div class="animated flipInY col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <div class="tile-stats">
                                        <div class="icon"><i class="fa fa-usd"></i></div>
                                        <div id="lblImporte" data-pu="<?= $pr->precio_unitario ?>" class="count"><?= $pr->importe ?></div>
                                        <h3>Importe</h3>
                                        </div>
                                    </div>
                                </div>
                                
                                <?php if($this->session->privilegios['aprobar_pr'] && $pr->estatus == "PENDIENTE") { ?>
                                <div id="divBotones" class="col-md-12">
                                    <button type="button" onclick="mdlRechazar(this)" value="RECHAZADO" class="btn btn-danger btn-lg"><i class='fa fa-close'></i> Rechazar</button>
                                    <button type="button" onclick="cambiarEstatus(this)" value="APROBADO" class="pull-right btn btn-success btn-lg"><i class='fa fa-check'></i> Aprobar</button>
                                </div>
                                <?php } ?>

                                <?php if($this->session->id == $pr->usuario && $pr->estatus == "RECHAZADO") { ?>
                                <div class="col-md-12">
                                    <center>
                                        <button type="button" onclick="editar()" class="btn btn-primary btn-lg"><i class='fa fa-pencil'></i> Editar</button>
                                    </center>
                                </div>
                                <?php } ?>

                                <?php if($this->session->privilegios['cancelar_pr'] && ($pr->estatus == "APROBADO" | $pr->estatus == "RECHAZADO")) { ?>
                                <div class="col-md-12">
                                    <center>
                                        <button type="button" onclick="cambiarEstatus(this)" value="CANCELADO" class="btn btn-default btn-lg"><i class='fa fa-close'></i> Cancelar</button>
                                    </center>
                                </div>
                                <?php } ?>

                                

                            </div>

                            


                        </div>
                    </div>
            </div>


            <!-- SECCION COMENTARIOS -->
            <div class="col-md-8 col-sm-8 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Comentarios </h2>

                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <ul id="lstComentarios" class="list-unstyled msg_list">
                            <button style="vertical-align: middle;" type="button" class="btn btn-primary btn-xs" onclick="mdlComentarios()"><i class="fa fa-comment"></i> Agregar Comentario</button>

                            <?php
                            if ($comentarios) {
                                foreach ($comentarios->result() as $comm) {
                                    ?>
                                    <li>
                                        <a>
                                            <span class="image">

                                                <?php
                                                foreach ($comentarios_fotos->result() as $photo) {
                                                    if ($comm->usuario == $photo->usuario) {
                                                        echo '<img style="width: 65px; height: 65px;" src="data:image/bmp;base64,' . base64_encode($photo->foto) . '" alt="img" />';
                                                        break;
                                                    }
                                                }
                                                ?>

                                            </span>
                                            <span>
                                                <span><?= $comm->User ?>
                                                    <?php $date2 = date_create($comm->fecha); ?>
                                                    <small><?= date_format($date2, 'd/m/Y h:i A') ?></small>
                                                </span>
                                            </span>
                                            <span class="message">
                                                <?= $comm->comentario ?>
                                            </span>
                                        </a>
                                    </li>

                                    <?php
                                }
                            }
                            ?>


                        </ul>
                    </div>
                </div>
            </div>



        </div>

    </div>
</div>
<!-- /page content -->





<div id="mdlInfo" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h3 id="tituloEmpresa" class="modal-title"></h3>
            </div>

            <div class="modal-body">
                <form>
                <div class="row">
                    <div class="col-md-12">
                    <center>
                        <h3 id="tituloAprobado"></h3>
                        <img id="imgCertificado" style="display: none;" height="75" src="<?= base_url("template/images/certificado.png") ?>"/>
                    </center>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-3">
                        <h4>Proveedor:</h4>
                        <ul id="lstProveedor">
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <h4>Formas de Pago:</h4>
                        <ul id="lstFormasPago">
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <h4>Formas de Compra:</h4>
                        <ul id="lstFormasCompra">
                    </div>
                    <div class="col-md-3">
                        <h4>Credito:</h4>
                        <ul id="lstCredito">
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <h4>Lugar de Entrega:</h4>
                        <ul id="lstLugarEntrega">
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <h4>Etiquetas:</h4>
                        <ul id="lstEtiquetas">
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <h4>Proceso de Cotización:</h4>
                        <ul id="lstProcesoCotizacion">
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <h4>Proceso de Compra:</h4>
                        <ul id="lstProcesoCompra">
                        </ul>
                    </div>
                </div>
                
                </form>
            </div> 
        </div>
    </div>
</div>


<div id="mdlDetalle" class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title mdlTitulo">QR: </h4>
            </div>

            <div class="modal-body">
               <form>
                    <p class="lead">Descripción: </p>
                    <p id="lblDescripcion" class="lead text-muted well well-sm no-shadow" style="margin-top: 10px;">
                        
                    </p>
                    <table id="tblDetalle" class="data table table-striped no-margin">
                        <tbody>
                        </tbody>
                    </table>

                    <div id="divCommentQR">
                        <p class="lead">Comentarios: </p>
                        <p id="lblCommentQR" class="lead" style="margin-top: 10px;">
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<div id="mdlComentarios" class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel2">Agregar Comentario</h4>
            </div>
            <div class="modal-body">
            <form method="POST" id="frmComentarios" action=<?= base_url('compras/agregarComentarioPR') ?>>
                
                <label style="margin-left:15px;">Comentarios</label>
                <div class="item form-group">
                    <div class="col-xs-12">
                        <input type="hidden" name="id" value=<?= $pr->id ?>>
                        <textarea style="resize: none;" id="txtComentarios" required="required" name="comentario" class="form-control col-xs-12"></textarea>
                    </div>
                </div>

                <label style="margin-left:15px; margin-top: 10px;">Adjuntar Correos (Opcional)</label>
                <div class="item form-group">
                    <div class="col-xs-12">
                        <input id="txtTags" name="txtTags" type="text" class="form-control prov" value="" />
                        <!-- <textarea style="resize: none; height: 100px;" id="txtComentarios" required="required" name="comentario" class="form-control col-xs-12"></textarea>-->
                    </div>
                </div>

            </div>
                <div class="modal-footer">
                <center>
                    <button id="btnConfirmarRechazo" onclick="estatus_msj(this)" style="display: inline;" type="button" class="btn btn-danger"><i class="fa fa-close"></i> RECHAZAR</button>
                    <input id="btnAgregarComentario" type="submit" class="btn btn-primary" value="Agregar">
                </center>
                </div>
            </form>

        </div>
    </div>
</div>

<div id="mdlCosteo" class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="mdlCosteoTitulo"></h4>
            </div>

            <div class="modal-body">
               <form>
                    <table id="tblCosteo" class="data table table-striped no-margin">
                        <tbody>
                        </tbody>
                    </table>
                </form>
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
<!-- icheck -->
<script src=<?= base_url("template/vendors/iCheck/icheck.min.js"); ?>></script>
<!-- PNotify -->
<script src=<?= base_url("template/vendors/pnotify/dist/pnotify.js"); ?>></script>
<script src=<?= base_url("template/vendors/pnotify/dist/pnotify.buttons.js"); ?>></script>
<script src=<?= base_url("template/vendors/pnotify/dist/pnotify.nonblock.js"); ?>></script>
<!-- formatCurrency -->
<script src=<?= base_url("template/vendors/formatCurrency/jquery.formatCurrency-1.4.0.js"); ?>></script>
<!-- bootstrap-daterangepicker -->
<script src=<?= base_url("template/vendors/moment/min/moment.min.js") ?>></script>
<script src=<?= base_url("template/vendors/bootstrap-daterangepicker/daterangepicker.js") ?>></script>
<!-- jQuery Tags Input -->
<script src=<?= base_url("template/vendors/jquery.tagsinput/src/jquery.tagsinput.js") ?>></script>
<!-- Custom Theme Scripts -->
<script src=<?= base_url("template/build/js/custom.js"); ?>></script>
<!-- JS FILE -->
<script src=<?= base_url("application/views/compras/js/ver_pr.js"); ?>></script>
<script>
    var CURRENT_PR = '<?= $pr->id ?>';
    var QR_PROV = '<?= $pr->qr_proveedor ?>';
    var CURRENT_PR_ESTATUS = '<?= $pr->estatus ?>';
    var AP = '<?= $this->session->privilegios['aprobar_pr'] ?>';

    $(function(){
        load();
    });

</script>

</body>
</html>
