<!-- page content -->
<div class="right_col" role="main">
    <div class="">

        <div class="clearfix"></div>

        <div class="row">

            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Orden de Compra:
                            <?= 'PO-' . str_pad($id, 6, "0", STR_PAD_LEFT) ?>
                        </h2>
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

                            <div class="col-md-4 col-sm-12">
                                <p class="lead" id="lblProveedor" style="display: inline;"></p><br>
                                <br>
                                <p class="lead" style="display: inline; margin-right: 15px;">Contacto: </p>
                                <br>
                                <div id='divContacto' style='display: none;'>
                                    <p class="lead" style="display: inline;">Nombre: <small id='lblConNombre'></small></p><br>
                                    <p class="lead" style="display: inline;">Puesto: <small id='lblConPuesto'></small></p><br>
                                    <p class="lead" style="display: inline;">Correo: <small id='lblConCorreo'></small></p>
                                </div>

                                <div id="divPDF">
                                    <a target='_blank' href='<?= base_url() . 'ordenes_compra/po_pdf/' . $id ?>'><button id='btnPDF' class="btn btn-primary btn-md" style="display: inline; margin-top: 10px;"><i class='fa fa-file-pdf-o'></i> Ver PDF</button></a>
                                    <button onclick='mdlCorreo()' style="display: inline; margin-top: 10px;" class="btn btn-primary btn-md" type="button"><i class='fa fa-envelope'></i>  Enviar PO</button>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-12">
                                <p class="lead" style="display: inline; margin-right: 15px;">Shipping Address: </p>
                                <p class="lead" style="display: inline; margin-top: 10px; font-size: 20px;"><br><small id="txtShipping"></small></p><br><br><br>

                                <p class="lead" style="display: inline; margin-right: 15px; margin-top: 20px;">Billing Address: </p>
                                <p class="lead" style="display: inline; margin-top: 10px; font-size: 20px;"><br><small id="txtBilling"></small></p>

                                <div id="divRMA" style="margin-top: 20px;">
                                    <p class="lead" style="display: inline; margin-right: 15px;">RMA:</p>
                                    <p class="lead" style="display: inline; margin-top: 10px; font-size: 20px;"><br><small id="lblRMA"></small></p>
                                </div>

                                <div id="divRMA" style="margin-top: 10px;">
                                    <p class="lead" style="display: inline; margin-right: 15px;">Numero de Confirmación:</p>
                                    <input id="txtNoConfirmacion" maxlength="25" style="display: inline; margin-left: 12px; width: 62%;" class="form-control" type="text"/>
                                    <button id="btnGuardarNoConfirmacion" onclick="guardarNumero()" style="display: none; margin-left: 15px;" type="button" class="btn btn-xs btn-primary"><i class="fa fa-save"></i> Guardar</button>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-12">
                                <p class="lead" style="display: inline; margin-right: 15px;">Método de Pago: </p>
                                <p class="lead" style="display: inline; margin-top: 10px;"><br><small id="txtMetodoPago"></small></p><br><br><br>

                                <p class="lead" style="display: inline; margin-right: 15px; margin-top: 20px;">Estatus Actual: </p><br>
                                <button class="btn btn-success btn-md" id='btnEstatus' style="display: inline; margin-top: 10px;"></button>

                                <div id='divAprobador' style='display: none;'>
                                    <br><p class="lead" style="display: inline; margin-right: 15px; margin-top: 20px;">Aprobado por:</p><br>
                                    <p class="lead" style="display: inline; margin-right: 15px; margin-top: 20px; font-size: 20px;"><small id='lblAprobador'></small></p><br>
                                </div>

                                
                            </div>

                        </div>



                    </div>
                </div>
            </div>





            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_content">
                        <div class="table-responsive">
                            <table id="tabla" class="table">
                                <thead>
                                    <tr class="headings">
                                        <th style='width: 5%;' class="column-title">#</th>
                                        <th style='width: 5%;' class="column-title">Cant.</th>
                                        <th style='width: 80%;' class="column-title">Concepto</th>
                                        <th class="column-title">Costo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>

                            
                            <div id='divPendiente' style='display: none;'>
                                <?php if($this->session->privilegios['aprobar_pr'] == "1") { ?>
                                    <button onclick='mdlRechazar(this)' value='RECHAZADA' class='btn btn-danger btn-md' type='button'><i class='fa fa-close'></i> Rechazar</button>
                                    <button onclick='setEstatus(this)' value='AUTORIZADA' class='btn btn-success btn-md pull-right' type='button'><i class='fa fa-check'></i> Autorizar PO</button>
                                <?php } ?>
                            </div>
                            

                            <div id='divAutorizada' style='display: none;'>
                                <?php if($this->session->privilegios['editar_qr'] == "1" | $this->session->privilegios['liberar_qr'] == "1") { ?>
                                    <button onclick='setEstatus(this)' value='CANCELADA' class='btn btn-default btn-md' type='button'><i class='fa fa-close'></i> Cancelar</button>
                                    <button onclick='setEstatus(this)' value='ORDENADA' class='btn btn-primary btn-md pull-right' type='button'><i class='fa fa-send'></i> Ordenar PO</button>
                                <?php } ?>
                            </div>

                            <div id='divOrdenada' style='display: none;'>
                                <?php if($this->session->privilegios['editar_qr'] == "1" | $this->session->privilegios['liberar_qr'] == "1") { ?>
                                    <button onclick='setEstatus(this)' value='CANCELADA' class='btn btn-default btn-md' type='button'><i class='fa fa-close'></i> Cancelar</button>
                                    <button onclick='mdlRecibir()' class='btn btn-primary btn-md pull-right' type='button'><i class='fa fa-truck'></i> Recibir PO</button>
                                <?php } ?>
                            </div>

                            <div id='divRecibida' style='display: none;'>
                                <?php if($this->session->privilegios['editar_qr'] == "1" | $this->session->privilegios['liberar_qr'] == "1") { ?>
                                    <button onclick='setEstatus(this)' value='CANCELADA' class='btn btn-default btn-md' type='button'><i class='fa fa-close'></i> Cancelar</button>
                                    <button onclick='setEstatus(this)' value='CERRADA' class='btn btn-primary btn-md pull-right' type='button'><i class='fa fa-check'></i> Cerrar</button>
                                <?php } ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>



            <!-- SECCION ACCIONES -->
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Seguimiento</h2>
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
                                <button onclick="mdlAccion()" type="button" class="btn btn-xs btn-primary"><i class="fa fa-bolt"></i> Crear Seguimiento</button>
                            </div>

                            <table id="tblAcciones" class="table table-striped projects">
                                <thead>
                                  <tr>
                                    <th>Creado</th>
                                    <th>Usuario</th>
                                    <th>Acción</th>
                                    <th>Fecha Limite</th>
                                    <th>Estatus</th>
                                  </tr>
                                </thead>
                                <tbody>
                                </tbody>
                              </table>


                            <!--
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div id='divEvidencia2' style='display: none;'>
                                    <div style='display: inline-block;'>
                                        <img style="width: 50px;" src='<?=base_url('template/images/files/pdf.png') ?>'/>
                                    </div>
                                    <div style='display: inline-block;'>
                                        <label style='display: block;'>Evidencia 2</label>
                                        <button style='display: block;' type='button' class='btn btn-danger btn-xs'><i class='fa fa-trash'></i> Eliminar</button>
                                    </div>
                                </div>
                            </div>
                            -->
                        </div>



                    </div>
                </div>
            </div>


            <!-- SECCION EVIDENCIAS -->

            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Evidencias</h2>
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
                                <div id="btnArchivo">
                                    <label class="btn btn-primary btn-xs" for="userfile">
                                        <input accept="application/pdf" target="_blank" onchange="uploadFile();" type="file" class="sr-only" id="userfile" name="userfile">
                                        <i class="fa fa-file"></i> Subir Archivo
                                    </label>
                                </div>
                            </div>

                            <table id="tablaArchivos" class="table table-striped projects">
                                <thead>
                                  <tr>
                                    <th>Fecha</th>
                                    <th>Archivo</th>
                                    <th>Subido Por:</th>
                                    <th>Tipo:</th>
                                    <th>Opciones</th>
                                  </tr>
                                </thead>
                                <tbody>
                                </tbody>
                              </table>


                            <!--
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div id='divEvidencia2' style='display: none;'>
                                    <div style='display: inline-block;'>
                                        <img style="width: 50px;" src='<?=base_url('template/images/files/pdf.png') ?>'/>
                                    </div>
                                    <div style='display: inline-block;'>
                                        <label style='display: block;'>Evidencia 2</label>
                                        <button style='display: block;' type='button' class='btn btn-danger btn-xs'><i class='fa fa-trash'></i> Eliminar</button>
                                    </div>
                                </div>
                            </div>
                            -->
                        </div>



                    </div>
                </div>
            </div>



            <!-- SECCION COMENTARIOS -->
            <div class="col-md-12 col-sm-12 col-xs-12">
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
                            <button style="vertical-align: middle;" type="button" class="btn btn-primary btn-xs"
                                onclick="mdlComentarios()"><i class="fa fa-comment"></i> Agregar Comentario</button>

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
                                        <span>
                                            <?= $comm->User ?>
                                            <?php $date2 = date_create($comm->fecha); ?>
                                            <small>
                                                <?= date_format($date2, 'd/m/Y h:i A') ?></small>
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


<div id="mdlComentarios" class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel2">Agregar Comentario</h4>
            </div>

            <div class="modal-body">
                <form method="POST" id="frmComentarios" action=<?=base_url('ordenes_compra/agregarComentarioPO') ?>>

                    <label style="margin-left:15px;">Comentarios</label>
                    <div class="item form-group">
                        <div class="col-xs-12">
                            <input type="hidden" name="id" value=<?=$id ?>>
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
                    <button id="btnConfirmarRechazo" onclick="estatus_msj(this)" style="display: inline;" type="button"
                        class="btn btn-danger"><i class="fa fa-close"></i> RECHAZAR</button>
                    <input id="btnAgregarComentario" type="submit" class="btn btn-primary" value="Agregar">
                </center>
            </div>
            </form>

        </div>
    </div>
</div>

<div id="mdlArchivos" class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel2">Subir Evidencia</h4>
            </div>
            <div class="modal-body">
                <center>
                    <button id='btnEvidencia1' onclick='subirEvidencia(1)' style='display: block; width: 60%;' class='btn btn-primary btn-lg'
                        type='button'><i class='fa fa-file'></i> Comprobante de Pago</button>
                    <button id='btnEvidencia2' onclick='subirEvidencia(2)' style='display: block; width: 60%; margin-top: 15px;' class='btn btn-primary btn-lg'
                        type='button'><i class='fa fa-file'></i> Factura</button>
                    <button id='btnEvidencia3' onclick='subirEvidencia(3)' style='display: block; width: 60%; margin-top: 15px;' class='btn btn-success btn-lg'
                        type='button'><i class='fa fa-file'></i> <i class='fa fa-file'></i> Comprobante / Factura</button>
                </center>
            </div>


        </div>
    </div>
</div>

<div id="mdlCorreo" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel2"><i class='fa fa-file-pdf-o'></i> Enviar Orden de Compra</h4>
            </div>

            <div class="modal-body">
                <form>

                        <label id="lblDe" style="margin-left:15px;">De: <?= $this->session->correo ?></label><br>
                        <label id="lblPara" style="margin-left:15px;">Para:</label>
                        <div class="item form-group">
                            <div class="col-xs-12">
                            <div id="alerts"></div>
                            <div class="btn-toolbar editor" data-role="editor-toolbar" data-target="#editor-one">
                  

                        <div class="btn-group">
                        <a class="btn dropdown-toggle" data-toggle="dropdown" title="Tamaño de fuente"><i class="fa fa-text-height"></i>&nbsp;<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                            <a data-edit="fontSize 5">
                                <p style="font-size:17px">Huge</p>
                            </a>
                            </li>
                            <li>
                            <a data-edit="fontSize 3">
                                <p style="font-size:14px">Normal</p>
                            </a>
                            </li>
                            <li>
                            <a data-edit="fontSize 1">
                                <p style="font-size:11px">Small</p>
                            </a>
                            </li>
                        </ul>
                        </div>

                        <div class="btn-group">
                        <a class="btn" data-edit="bold" title="Negrita"><i class="fa fa-bold"></i></a>
                        <a class="btn" data-edit="italic" title="Itálico"><i class="fa fa-italic"></i></a>
                        <a class="btn" data-edit="strikethrough" title="Tachado"><i class="fa fa-strikethrough"></i></a>
                        <a class="btn" data-edit="underline" title="Subrayado"><i class="fa fa-underline"></i></a>
                        </div>

                        <div class="btn-group">
                        <a class="btn" data-edit="justifyleft" title="Alineado a la izquierda"><i class="fa fa-align-left"></i></a>
                        <a class="btn" data-edit="justifycenter" title="Alineado al centro"><i class="fa fa-align-center"></i></a>
                        <a class="btn" data-edit="justifyright" title="Alineado a la derecha"><i class="fa fa-align-right"></i></a>
                        <a class="btn" data-edit="justifyfull" title="Justificado"><i class="fa fa-align-justify"></i></a>
                        </div>



                    </div>

                    <div id="editor-one" class="editor-wrapper"><div id="divConNombre"></div><div><br></div><div>Por este medio le estamos enviando la orden de compra <?= 'PO-' . str_pad($id, 6, "0", STR_PAD_LEFT) ?>. Favor de confirmar la recepción de la presente y su fecha de entrega.</div><div>Favor de contactarme si hay alguna duda o cambio respecto a la orden de compra.</div><div><br></div><div>Me despido quedando a la espera de sus comentarios.<br></div><div><br></div><div>We are sending you the attached purchase order <?= 'PO-' . str_pad($id, 6, "0", STR_PAD_LEFT) ?>. Please confirm receipt and date of delivery. Do not hesitate to contact me if there is any doubt or change regarding the purchase order.</div><div><br></div><div>Thank you for your attention and we wait your comments.</div><div><br></div><div><?= ucwords(strtolower($this->session->nombre)) ?> | Compras / Purchasing | Masmetrología</div><div><?= $this->session->correo ?></div><div><br></div><div><img src='<?= base_url('template/images/phone.png') ?>'/>  México (656)980-0807 / USA: (915) 201-4011</div></div>

                    <!--<textarea name="descr" id="descr" style="display:none;"></textarea>-->





                            <!--
                            <textarea id="txtMailBody" style="height: 150px; resize: none;" required="required" name="comentario" class="form-control col-xs-12">Buen día,&#13&#13Adjunto OC para procesar el requerimiento cotizado anteriormente.&#13&#13Favor de confirmar de recibido y fecha de envío.
                            </textarea>-->





                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button onclick="" data-dismiss="modal" style="display: inline;" type="button" class="btn btn-default pull-left"><i class="fa fa-close"></i> Cancelar</button>
                <button onclick="enviarCorreo()" style="display: inline;" type="button" class="btn btn-primary"><i class="fa fa-send"></i> Enviar</button>
            </div>
            

        </div>
    </div>
</div>

<div id="mdlRecibir" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel2">Recibir Orden de Compra</h4>
            </div>
           
            <div class="modal-body">
                <form>
                    <table id="tblRecibir" class="table table-striped">
                        <thead>
                            <tr class="headings">
                                <th style='width: 8%;' class="column-title">PR #</th>
                                <th class="column-title">Usuario</th>
                                <th class="column-title">Tipo</th>
                                <th class="column-title">Subtipo</th>
                                <th class="column-title">Cantidad</th>
                                <th class="column-title">Descripción</th>
                                <th class="column-title">Recibir</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                </table>
                </form>
            </div>

            <div class="modal-footer">
                <button data-dismiss="modal" style="display: inline;" type="button" class="btn btn-default pull-left"><i class="fa fa-close"></i> Cancelar</button>
                <button onclick="recibir()" style="display: inline;" type="button" class="btn btn-primary"><i class="fa fa-check"></i> Recibir</button>
            </div>
            

        </div>
    </div>
</div>

<div id="mdlAccion" class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel2">Crear Seguimiento</h4>
            </div>
           
            <div class="modal-body">
                <form>
                    <div style="margin-top: 10px;" class="col-xs-12">
                        <label style="display: block;">Responsable</label>
                        <input style="width:50%" class="form-control" type="text" value="<?= $this->session->nombre ?>" readonly>
                    </div>
                    <div style="margin-top: 10px;" class="col-xs-12">
                        <label style="display: block;">Acción</label>
                        <textarea id="txtAccion" style="resize: none;" class="form-control"></textarea>
                    </div>
                    
                    <div style="margin-top: 10px;" class="col-xs-12">
                        <label style="display: block;">Fecha Limite</label>
                        <input id="txtFechaAccion" style="width:50%" class="form-control" type="datetime-local">
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button data-dismiss="modal" style="display: inline;" type="button" class="btn btn-default pull-left"><i class="fa fa-close"></i> Cancelar</button>
                <button onclick="crearAccion()" style="display: inline;" type="button" class="btn btn-primary"><i class="fa fa-bolt"></i> Crear Seguimiento</button>
            </div>
            

        </div>
    </div>
</div>

<div id="mdlAccionFeedback" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Acción</h4>
            </div>
           
            <div class="modal-body">
                <form>
                    
                    <div style="margin-top: 10px;" class="col-xs-12">
                        <label style="display: block;">Acción</label>
                        <p id="txtAccionFeed"></p>
                    </div>

                    <div style="margin-top: 10px;" class="col-xs-6">
                        <label style="display: block;">Fecha Limite:</label>
                        <p id="lblFechaLimite"></p>
                    </div>
                    
                    <div id="divFechaRealizada" style="margin-top: 10px; display: none;" class="col-xs-6">
                        <label style="display: block;">Fecha Realizada:</label>
                        <p id="lblFechaRealizada"></p>
                    </div>

                    <div style="margin-top: 10px;" class="col-xs-12">
                        <div id="divCommentAccionFeedback">
                            <label style="display: block;">Agregar Comentarios</label>
                            <textarea id="txtAccionComentario" style="margin-bottom: 10px; resize: none; white;" class="form-control"></textarea>
                            <button onclick="agregarComentarioAccion(this)" id="btnAgregarAccionComentario" type="button" class="btn btn-xs btn-primary"><i class="fa fa-comment"></i> Agregar Comentario</button>
                        </div>
                        <ul id='ulComments' class="list-unstyled msg_list">
                        <ul>
                        
                    </div>
                    
                    
                </form>
            </div>

            <div class="modal-footer">
                <button data-dismiss="modal" style="display: inline;" type="button" class="btn btn-default pull-left"><i class="fa fa-close"></i> Cancelar</button>
                <div id="divBtnAccionFeedback">
                    <button onclick="cancelarAccion()" style="display: inline;" type="button" class="btn btn-dark"><i class="fa fa-close"></i> Cancelar Acción</button>
                    <button onclick="realizarAccion()" style="display: inline;" type="button" class="btn btn-success"><i class="fa fa-check"></i> Marcar como realizada</button>
                </div>
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
<script src=<?=base_url("template/vendors/jquery/dist/jquery.min.js"); ?>></script>
<!-- Bootstrap -->
<script src=<?=base_url("template/vendors/bootstrap/dist/js/bootstrap.min.js"); ?>></script>
<!-- PNotify -->
<script src=<?=base_url("template/vendors/pnotify/dist/pnotify.js"); ?>></script>
<script src=<?=base_url("template/vendors/pnotify/dist/pnotify.buttons.js"); ?>></script>
<script src=<?=base_url("template/vendors/pnotify/dist/pnotify.nonblock.js"); ?>></script>
<!-- iCheck -->
<script src=<?=base_url("template/vendors/iCheck/icheck.min.js"); ?>></script>
<!-- Moment -->
<script src=<?=base_url("template/vendors/moment/min/moment.min.js") ?>></script>
<!-- formatCurrency -->
<script src=<?=base_url("template/vendors/formatCurrency/jquery.formatCurrency-1.4.0.js"); ?>></script>
<!-- jQuery Tags Input -->
<script src=<?=base_url("template/vendors/jquery.tagsinput/src/jquery.tagsinput.js") ?>></script>
<!-- Custom Theme Scripts -->
<script src=<?=base_url("template/build/js/custom.js"); ?>></script>
<!-- bootstrap-wysiwyg -->
<script src=<?=base_url("template/vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js"); ?>></script>
<script src=<?=base_url("template/vendors/jquery.hotkeys/jquery.hotkeys.js"); ?>></script>
<script src=<?=base_url("template/vendors/google-code-prettify/src/prettify.js"); ?>></script>
<!-- CUSTOM JS FILE -->
<script src=<?=base_url("template/js/custom/funciones.js"); ?>></script>
<!-- JS FILE -->
<script src=<?=base_url("application/views/ordenes_compra/js/ver_po.js"); ?>></script>
<script>
    var UID = '<?= $this->session->id ?>';
    var id = '<?= $id ?>';

    $(function () {
        load();
    });
</script>
</body>

</html>