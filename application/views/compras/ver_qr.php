<!-- page content -->
<div class="right_col" role="main">
    <div class="">

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>QR # <?= $qr->id; ?></h2>
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
                            <p class="lead">Fecha:  <small><?= $qr->fecha ?></small></p>
                            <p class="lead">Requisitor:  <small><?= $qr->User ?></small></p>
                            <p class="lead">Destino:  <small><?= $qr->destino ?></small></p>

                            <p class="lead">Descripción: </p>
                            <p class="lead text-muted well well-sm no-shadow" style="margin-top: 10px;">
                                <?= $qr->descripcion ?>
                            </p>
                            <p class="lead">Detalles: </p>
                            <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                <tr>
                                    <th style="width:35%">Tipo</th>
                                    <td><?= $qr->tipo ?></td>
                                </tr>
                                <tr>
                                    <th>Subtipo</th>
                                    <td><?= $qr->subtipo ?></td>
                                </tr>
                                <tr>
                                    <th>Cantidad</th>
                                    <td><?= $qr->cantidad ?></td>
                                </tr>
                                <tr>
                                    <th>Unidad de Medida</th>
                                    <td><?= $qr->unidad ?></td>
                                </tr>
                                
                                <?php $att = json_decode($qr->atributos, TRUE);
                                foreach ($att as $key => $value) { ?>
                                    <tr>
                                        <th><?= ucfirst($key) ?></th>
                                        <?php 
                                        if(ucfirst($key) == "Marca") {
                                            $value = "<div class='txtSugerencias' style='display: none;'>".$value."</div><button type='button' onclick='buscarProveedorMarca(this)' class='btn btn-primary btn-xs sugerencias'>" . $value . " <i class='fa fa-search'></i></button>";
                                        }
                                        if(ucfirst($key) == "Modelo") {
                                            $value = "<div class='txtSugerencias' style='display: none;'>".$value."</div><button type='button' onclick='buscarProveedorModelo(this)' class='btn btn-primary btn-xs sugerencias'>" . $value . " <i class='fa fa-search'></i></button>";
                                        }
                                        ?>
                                        <td><?= $value ?></td>
                                    </tr>
                                <?php } ?>
                                

                                <?php if($qr->nombre_archivo) { ?>
                                <tr>
                                    <th>Archivo</th>
                                    <td><?= "<a target='_blank' href='" . base_url('compras/getQrFile/') . $qr->id . "'><img height='25px' src='" . $this->aos_funciones->file_image($qr->nombre_archivo) . "'> <u>" . $qr->nombre_archivo . "</u></a>" ?></td>
                                </tr>
                                <?php } ?>
                                

                                </tbody>
                            </table>

                            <?php if($qr->comentarios) { ?>
                                <p class="lead">Notas: </p>
                                <p id="lblComentarios" style="margin-top: 10px;">
                                    <?= $qr->comentarios ?>
                                </p>
                                <?php } ?>
                                
                                <br><br>
                                <center>
                                    <?php if($this->session->privilegios['editar_qr']) { ?>
                                        <h4><b>Estatus:</b></h4><button id="btnEstatus" onclick="mdlEstatus(this)" value="<?= $qr->estatus ?>" type="button" class="<?= 'btn ' . $btn_estatus . ' btn-lg' ?>"><?= $qr->estatus ?></button>
                                    <?php } else { ?>
                                        <h4><b>Estatus:</b></h4><button type="button" class="<?= 'btn ' . $btn_estatus . ' btn-lg' ?>"><?= $qr->estatus ?></button>
                                    <?php } ?>


                                    <div style="margin-top: 15px;" id="divLiberador">
                                        <label id="lblLiberador"><?= $qr->Liberador == "N/A" ? "" : ("Liberado por: " . $qr->Liberador) ?></label><br>
                                        <?php $date = date_create($qr->fecha_liberacion); ?>
                                        <label id="lblFechaLiberacion"><?= $qr->Liberador == "N/A" ? "" : date_format($date, 'd-m-Y h:i A'); ?></label>
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
                            <h2>Propuestas</h2>
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

                                    <button id='btnBuscarProveedor' onclick="modalAsignarProveedor()" style="margin-left: 15px;" type="button" class="btn btn-primary btn-xs"><i class="fa fa-truck"></i> Asignar Proveedor</button>
                                    <table id="tblProveedores" class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th style="width: 3%">Info</th>
                                                <th style="width: 45%">Nombre</th>
                                                <th>Precio</th>
                                                <th>Entrega</th>
                                                <th>Opciones</th>
                                                <th style="display: none;">Costeo</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                    
                                    
                                </div>

                                <?php if($this->session->privilegios['cancelar_pr'] && ($qr->estatus == "LIBERADO" | $qr->estatus == "RECHAZADO")) { ?>
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




<!-- MODAL PROVEEDOR -->
<div id="mdlProveedores" class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 id= "mdlBusquedaTitulo" class="modal-title">QR # <?= $qr->id; ?></h4>
            </div>

            <div class="modal-body">
                <form>
                    <div style="display: none;" id="divBusqueda">
                        <label>Buscar: </label>
                        <div class="input-group">
                            <input id="txtBuscarProveedor" type="text" class="form-control" placeholder="Buscar Proveedor...">
                            <span class="input-group-btn">
                            <button onclick="buscarProveedor()" class="btn btn-default" type="button">Buscar</button>
                            </span>
                        </div>
                    </div>
                    <br>
                    <table id="tblBuscarProveedores" class="data table table-striped no-margin">
                        <tbody>
                        </tbody>
                    </table>
                </form>
            </div> 
        </div>
    </div>
</div>

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

<div id="mdlPrecio" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 id="lblTituloMdlPrecio" class="modal-title">Proveedor</h4>
            </div>

            <div class="modal-body">
                <form>                    
                    <table class="data table table-striped no-margin">
                        <thead class="headings">
                            <tr>
                                <th>Concepto</th>
                                <th>Monto</th>
                                <th>Opción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="width: 60%">
                                    <select style="width: 90%;" required="required" class="select2_single form-control" id="opConcepto" name="opConcepto">
                                        <option value='Costo'>Costo</option>
                                        <option value='Gastos de envio o retorno'>Gastos de envio o retorno</option>
                                        <option value='Gastos de Ida'>Gastos de Ida</option>
                                        <option value='Importacion Franja'>Importacion Franja</option>
                                        <option value='Importacion al Interior'>Importacion al Interior</option>
                                        <option value='Calibracion Externo'>Calibracion Externo</option>
                                        <option value='Calibracion Local'>Calibracion Local</option>
                                        <option value='Aranceles por envio o retorno'>Aranceles por envio o retorno</option>
                                        <option value='Aranceles por envio de ida'>Aranceles por envio de ida</option>
                                        <option value='Logistica'>Logística</option>
                                        <option value='Impuestos'>Impuestos</option>
                                        <option value='Otros'>Otros</option>
                                    </select>
                                </td>
                                <td><input id="txtCostoConcepto" type="number" class="form-control" value="0.00" min="0.00"></td>
                                <td><button type="button" onclick="agregarCosto()" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i> Agregar</button></td>
                            </tr>
                        </tbody>
                    </table>
                    <br>

                    <div style="margin-bottom: 10px;">    
                        <h3 style="display: inline;">Total: <h3 id="lblTotal" style="display: inline;"></h3></h3>
                    </div>

                    <table id="tblPrecios" class="data table table-striped no-margin">
                        <tbody>
                        </tbody>
                    </table>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <label>Tiempo de entrega: </label><input id="txtEntrega" style="margin-left: 10px; margin-right: 10px; width: 20%; display: inline; text-align: center;" type="number" class="form-control" value="1" min="1"><label> Dias</label><br>
                            <label>Destino: <?= $qr->destino ?></label><br>
                            <label>Lugar de Entrega: <?= $qr->lugar_entrega ?></label>
                        </div>

                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Moneda</label>
                                    <select required="required" class="select2_single form-control" id="opMoneda" name="opMoneda">
                                        <option value='MXN'>MXN</option>
                                        <option value='USD'>USD</option>
                                        <option value='EUR'>EUR</option>
                                    </select>
                                </div>

                                <div class="col-md-8">
                                    <label>Vigencia:</label>
                                    <div id="dtpVencimiento" class="daterangepicker dropdown-menu ltr single opensright show-calendar picker_3 xdisplay"><div class="calendar left single" style="display: block;"><div class="daterangepicker_input"><input class="input-mini form-control active" type="text" name="daterangepicker_start" value="" style="display: none;"><i class="fa fa-calendar glyphicon glyphicon-calendar" style="display: none;"></i><div class="calendar-time" style="display: none;"><div></div><i class="fa fa-clock-o glyphicon glyphicon-time"></i></div></div><div class="calendar-table"><table class="table-condensed"><thead><tr><th class="prev available"><i class="fa fa-chevron-left glyphicon glyphicon-chevron-left"></i></th><th colspan="5" class="month">Oct 2016</th><th class="next available"><i class="fa fa-chevron-right glyphicon glyphicon-chevron-right"></i></th></tr><tr><th>Su</th><th>Mo</th><th>Tu</th><th>We</th><th>Th</th><th>Fr</th><th>Sa</th></tr></thead><tbody><tr><td class="weekend off available" data-title="r0c0">25</td><td class="off available" data-title="r0c1">26</td><td class="off available" data-title="r0c2">27</td><td class="off available" data-title="r0c3">28</td><td class="off available" data-title="r0c4">29</td><td class="off available" data-title="r0c5">30</td><td class="weekend available" data-title="r0c6">1</td></tr><tr><td class="weekend available" data-title="r1c0">2</td><td class="available" data-title="r1c1">3</td><td class="available" data-title="r1c2">4</td><td class="available" data-title="r1c3">5</td><td class="available" data-title="r1c4">6</td><td class="available" data-title="r1c5">7</td><td class="weekend available" data-title="r1c6">8</td></tr><tr><td class="weekend available" data-title="r2c0">9</td><td class="available" data-title="r2c1">10</td><td class="available" data-title="r2c2">11</td><td class="available" data-title="r2c3">12</td><td class="available" data-title="r2c4">13</td><td class="available" data-title="r2c5">14</td><td class="weekend available" data-title="r2c6">15</td></tr><tr><td class="weekend available" data-title="r3c0">16</td><td class="available" data-title="r3c1">17</td><td class="today active start-date active end-date available" data-title="r3c2">18</td><td class="available" data-title="r3c3">19</td><td class="available" data-title="r3c4">20</td><td class="available" data-title="r3c5">21</td><td class="weekend available" data-title="r3c6">22</td></tr><tr><td class="weekend available" data-title="r4c0">23</td><td class="available" data-title="r4c1">24</td><td class="available" data-title="r4c2">25</td><td class="available" data-title="r4c3">26</td><td class="available" data-title="r4c4">27</td><td class="available" data-title="r4c5">28</td><td class="weekend available" data-title="r4c6">29</td></tr><tr><td class="weekend available" data-title="r5c0">30</td><td class="available" data-title="r5c1">31</td><td class="off available" data-title="r5c2">1</td><td class="off available" data-title="r5c3">2</td><td class="off available" data-title="r5c4">3</td><td class="off available" data-title="r5c5">4</td><td class="weekend off available" data-title="r5c6">5</td></tr></tbody></table></div></div><div class="calendar right" style="display: none;"><div class="daterangepicker_input"><input class="input-mini form-control" type="text" name="daterangepicker_end" value="" style="display: none;"><i class="fa fa-calendar glyphicon glyphicon-calendar" style="display: none;"></i><div class="calendar-time" style="display: none;"><div></div><i class="fa fa-clock-o glyphicon glyphicon-time"></i></div></div><div class="calendar-table"><table class="table-condensed"><thead><tr><th></th><th colspan="5" class="month">Nov 2016</th><th class="next available"><i class="fa fa-chevron-right glyphicon glyphicon-chevron-right"></i></th></tr><tr><th>Su</th><th>Mo</th><th>Tu</th><th>We</th><th>Th</th><th>Fr</th><th>Sa</th></tr></thead><tbody><tr><td class="weekend off available" data-title="r0c0">30</td><td class="off available" data-title="r0c1">31</td><td class="available" data-title="r0c2">1</td><td class="available" data-title="r0c3">2</td><td class="available" data-title="r0c4">3</td><td class="available" data-title="r0c5">4</td><td class="weekend available" data-title="r0c6">5</td></tr><tr><td class="weekend available" data-title="r1c0">6</td><td class="available" data-title="r1c1">7</td><td class="available" data-title="r1c2">8</td><td class="available" data-title="r1c3">9</td><td class="available" data-title="r1c4">10</td><td class="available" data-title="r1c5">11</td><td class="weekend available" data-title="r1c6">12</td></tr><tr><td class="weekend available" data-title="r2c0">13</td><td class="available" data-title="r2c1">14</td><td class="available" data-title="r2c2">15</td><td class="available" data-title="r2c3">16</td><td class="available" data-title="r2c4">17</td><td class="available" data-title="r2c5">18</td><td class="weekend available" data-title="r2c6">19</td></tr><tr><td class="weekend available" data-title="r3c0">20</td><td class="available" data-title="r3c1">21</td><td class="available" data-title="r3c2">22</td><td class="available" data-title="r3c3">23</td><td class="available" data-title="r3c4">24</td><td class="available" data-title="r3c5">25</td><td class="weekend available" data-title="r3c6">26</td></tr><tr><td class="weekend available" data-title="r4c0">27</td><td class="available" data-title="r4c1">28</td><td class="available" data-title="r4c2">29</td><td class="available" data-title="r4c3">30</td><td class="off available" data-title="r4c4">1</td><td class="off available" data-title="r4c5">2</td><td class="weekend off available" data-title="r4c6">3</td></tr><tr><td class="weekend off available" data-title="r5c0">4</td><td class="off available" data-title="r5c1">5</td><td class="off available" data-title="r5c2">6</td><td class="off available" data-title="r5c3">7</td><td class="off available" data-title="r5c4">8</td><td class="off available" data-title="r5c5">9</td><td class="weekend off available" data-title="r5c6">10</td></tr></tbody></table></div></div><div class="ranges" style="display: none;"><div class="range_inputs"><button class="applyBtn btn btn-sm btn-success" type="button">Apply</button> <button class="cancelBtn btn btn-sm btn-default" type="button">Cancel</button></div></div></div>
                                    <fieldset>
                                        <div class="control-group">
                                            <div class="controls">
                                                <div class="col-md-11 xdisplay_inputx form-group has-feedback">
                                                <input id="txtVencimiento" type="text" class="form-control has-feedback-left" aria-describedby="inputSuccess2Status3">
                                                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                                <span id="inputSuccess2Status3" class="sr-only">(success)</span>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div id="btnArchivo">
                                        <label class="btn btn-default btn-sm" for="userfile">
                                        <input accept="application/pdf" target="_blank" onchange="uploadFile();" type="file" class="sr-only" id="userfile" name="userfile">
                                            <i class="fa fa-file"></i> Subir Evidencia
                                        </label>
                                    </div>

                                    <button style="display: none;" onclick="eliminarEvidencia()" id="btnBorrarArchivo" type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Eliminar Evidencia</button>
                                </div>

                                <div class="col-md-8">
                                    <div id="divArchivo" style="margin-left: 8px;">
                                        <a id="lnkArchivo" href="#"><img id="imgArchivo" height="25px" src=""><p style="display: inline;" id="lblArchivo"></p></a>
                                    </div>
                                </div>


                            </div>

                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="guardarCostos()">Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>


<div id="mdlEstatus" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 id= "mdlBusquedaTitulo" class="modal-title">QR # <?= $qr->id; ?></h4>
            </div>

            <div class="modal-body">
                <form>
                    <center>
                        <button id="btnRechazar" onclick="mdlRechazar(this)" value='RECHAZADO' style="display: inline;" type="button" class="btn btn-danger"><i class="fa fa-close"></i> RECHAZAR</button>
                        <button id="btnLiberar" onclick="seleccionarProveedor()" value='LIBERADO' style="display: inline;" type="button" class="btn btn-success"><i class="fa fa-check"></i> LIBERAR</button>
                        <button id="btnRechazarCompra" onclick="mdlRechazar(this)" value='COMPRA RECHAZADA' style="display: inline;" type="button" class="btn btn-danger"><i class="fa fa-close"></i> RECHAZAR COMPRA</button>
                        <button id="btnLiberarCompra" onclick="liberarProveedor()" value='COMPRA LIBERADA' style="display: inline;" type="button" class="btn btn-success"><i class="fa fa-check"></i> LIBERAR COMPRA</button>
                    </center>
                </form>
            </div>

        </div>
    </div>
</div>

<div id="mdlSelectProveedor" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Seleccione Proveedores</h4>
            </div>

            <div class="modal-body">
                <form>
                    <table id="tblSelectProveedores" class="table table-striped">
                        <thead>
                            <tr>
                                <th style="width: 10%">Selecc.</th>
                                <th style="width: 50%">Nombre</th>
                                <th>Precio</th>
                                <th>Entrega</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button id="btnLiberarProv" type="button" class="btn btn-success" onclick="guardarProveedoresSeleccionados()"><i class='fa fa-check'></i> LIBERAR</button>
                <button id="btnLiberarCompraProv" type="button" class="btn btn-success" onclick="liberarCompra()"><i class='fa fa-check'></i> LIBERAR COMPRA</button>
            </div>
        </div>
    </div>
</div>
<!-- /MODAL -->

<div id="mdlQRs" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 id= "lblTituloQrs" class="modal-title"></h4>
            </div>

            <div class="modal-body">
                <!--<p style="display: inline;">
                    Mostrar vencidos:
                    <input type="checkbox" class="flat" id="cbVencido" />
                </p>-->
                <form>
                    <br>
                    <table id="tblQRs" class="data table table-striped no-margin">
                        <thead>
                            <tr>
                                <th>QR</th>
                                <th>Descripción</th>
                                <th>Total</th>
                                <th>Entrega</th>
                                <th>Vigencia</th>
                                <th>Evidencia</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
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
            <form method="POST" action=<?= base_url('compras/agregarComentario') ?> id="frmComentarios">
                
                <label style="margin-left:15px;">Comentarios</label>
                <div class="item form-group">
                    <div class="col-xs-12">
                        <input type="hidden" name="idQr" value=<?= $qr->id ?>>
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
                    <input id="btnAgregarComentario" onclick="bloquearBotton(this)" type="submit" class="btn btn-primary" value="Agregar">
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
<!-- CUSTOM JS FILE -->
<script src=<?=base_url("template/js/custom/funciones.js"); ?>></script>
<!-- JS FILE -->
<script src=<?= base_url("application/views/compras/js/ver_qr.js"); ?>></script>
<script>
    var CURRENT_QR = '<?= $qr->id ?>';
    var CURRENT_QR_ESTATUS = '<?= $qr->estatus ?>';
    var DESTINO = '<?= $qr->destino ?>';
    const ED = '<?= $this->session->privilegios['editar_qr'] ?>';
    const LQ = '<?= $this->session->privilegios['liberar_qr'] ?>';
    const RV = '<?= $this->session->privilegios['revisar_qr'] ?>';

    $(function(){
        load();
    });

</script>

</body>
</html>
