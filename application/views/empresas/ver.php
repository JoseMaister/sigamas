

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><?= $empresa->nombre ?></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div  class="x_content">
  

                    <div class="col-md-12 col-sm-12 col-xs-12"> <!-- TABS PANEL -->

                      <div class="" role="tabpanel" data-example-id="togglable-tabs">
                        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                          <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Información</a></li>
                          <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Contactos</a></li>
                          <li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab3" data-toggle="tab" aria-expanded="false">Archivos</a></li>
                          <?php if($empresa->cliente) { ?>
                          <li role="presentation" class=""><a href="#tab_content4" role="tab" id="profile-tab4" data-toggle="tab" aria-expanded="false">Cotizaciones</a></li>
                          <li role="presentation" class=""><a href="#tab_content5" role="tab" id="profile-tab5" data-toggle="tab" aria-expanded="false">Facturación</a></li>
                          
                          <li role="presentation" class=""><a href="#tab_content6" role="tab" id="profile-tab6" data-toggle="tab" aria-expanded="false">Logística y Operaciones</a></li>
                          <?php } if($empresa->proveedor) { ?>
                          <li role="presentation" class=""><a href="#tab_content7" role="tab" id="profile-tab7" data-toggle="tab" aria-expanded="false">Proveedor</a></li>
                          <?php } ?>
                          <li role="presentation" class=""><a href="#tab_content8" role="tab" id="profile-tab8" data-toggle="tab" aria-expanded="false">Plantas</a></li>
                          <li role="presentation" class=""><a href="#tab_content9" role="tab" id="profile-tab9" data-toggle="tab" aria-expanded="false">Ubicación</a></li>
                        </ul>
                        <div id="myTabContent" class="tab-content">
                          <!-- INFORMACION -->
                          <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">

                            <div class="row">
                              <div class="col-md-6">
                                <ul class="messages">
                                  <li>
                                    <div class="message_wrapper">
                                      <h4 class="heading">Razon Social</h4>
                                      <blockquote class="message"><?= $empresa->razon_social ?></blockquote><br>
                                      <h4 class="heading">Domicilio</h4>
                                      <blockquote class="message"><?= $empresa->calle . ' ' . $empresa->numero . ' ' .  $empresa->colonia ?></blockquote><br>
                                      <h4 class="heading">Ciudad</h4>
                                      <blockquote class="message"><?= $empresa->ciudad . ", " . $empresa->estado ?></blockquote><br>
                                      <?php if ($empresa->giro) { ?>
                                        <h4 class="heading">Giro</h4>
                                        <blockquote class="message"><?= $empresa->giro ?></blockquote><br>
                                      <?php } ?>
                                      <br>
                                      <?php if ($this->session->privilegios['administrar_empresas']) { ?>
                                        <a class="btn btn-primary btn-sm" data-toggle="modal" data-target=".empresa"><i class="fa fa-pencil"></i> Editar datos</a>
                                      <?php } ?>
                                    </div>
                                  </li>
                                </ul>
                              </div>
                              <div class="col-md-6">
                                <ul class="messages">
                                  <li>
                                    <div class="message_wrapper">
                                      <h4 class="heading">RFC</h4>
                                      <blockquote class="message"><?= $empresa->rfc ?></blockquote><br>
                                      <h4 class="heading">CP</h4>
                                      <blockquote class="message"><?= $empresa->cp ?></blockquote><br>
                                      
                                      <?php if ($empresa->calles_aux) { ?>
                                        <h4 class="heading">Entre Calles</h4>
                                        <blockquote class="message"><?= $empresa->calles_aux ?></blockquote><br>
                                      <?php } ?>


                                    </div>
                                  </li>
                                </ul>
                              </div>

                            </div>

                          </div>
                          
                          <!-- CONTACTOS -->
                          <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">

                            <!-- start contactos -->
                            <?php if ($this->session->privilegios['administrar_empresas']) { ?>
                              <a class="btn btn-primary btn-xs" onclick="modalShow()"><i class="fa fa-plus"></i> Agregar contacto</a>
                            <?php } ?>
                            <table id="tablaContactos" class="data table table-striped no-margin">
                              <thead>
                                <tr>
                                  <th>#</th>
                                  <th>Nombre</th>
                                  <th>Telefono</th>
                                  <th>Celular</th>
                                  <th>Correo</th>
                                  <th>Puesto</th>
                                  <?php if ($this->session->privilegios['administrar_empresas']) { ?>
                                    <th>Opciones</th>
                                  <?php } ?>
                                </tr>
                              </thead>
                              <tbody>
                                <?php if($contactos) { $i=1; foreach ($contactos->result() as $elem) { $color = ""; if($elem->activo != "1") { $color = "style = 'color: red;'"; } ?>
                                  <tr <?= $color ?>>
                                    <td><?= $i ?></td>
                                    <td><?= $elem->nombre ?></td>
                                    <td><?= $elem->telefono ?></td>
                                    <td><?= $elem->celular ?></td>
                                    <td><?= $elem->correo ?></td>
                                    <td><?= $elem->puesto ?></td>
                                    <?php if ($this->session->privilegios['administrar_empresas']) { ?>
                                      <td>
                                        <button onclick="getContacto(this)" class="btn btn-warning btn-xs" value="<?= $elem->id ?>"><i class="fa fa-pencil"></i> Editar</button>
                                        <button onclick="deleteContacto(this)" class="btn btn-danger btn-xs" value="<?= $elem->id ?>"><i class="fa fa-trash"></i> Eliminar</button>
                                      </td>
                                    <?php } ?>
                                    
                                  </tr>
                                <?php $i++; } } ?>
                              </tbody>
                            </table>
                            <!-- end contactos -->

                          </div>
                          
                          <!-- ARCHIVOS -->
                          <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab">
                            <div id="archivos">
                              <!-- start project list -->
                              <form id="formFile" enctype="multipart/form-data" method="POST">
                              
                                
                              </form>
                              <div class="row">
                                  <div class="col-md-12 col-sm-12 col-xs-12">
                                      <input id="txtBuscarArchivos" style="display: inline;" type="text">
                                      <button onclick="cargarArchivos()" style="display: inline;" class="btn btn-success btn-xs" type="button"><i class="fa fa-search"></i> Buscar</button>
                                      <?php if ($this->session->privilegios['administrar_empresas']) { ?>
                                      <label class="btn btn-primary btn-xs" for="userfile">
                                        <input onchange="modalFile();" type="file" class="sr-only" id="userfile" name="file">
                                        <i class="fa fa-plus"></i> Subir Archivo
                                      </label>
                                    <?php } ?>
                                  </div>
                              </div>
                              <table id="tablaArchivos" class="table table-striped projects">
                                <thead>
                                  <tr>
                                    <th style="width: 1%">#</th>
                                    <th style="width: 5%"></th>
                                    <th>Archivo</th>
                                    <th>Subido Por:</th>
                                    <th style="width: 35%">Comentarios</th>
                                    <th style="width: 20%">Opciones</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  
                                </tbody>
                              </table>
                              <!-- end project list -->
                            </div>
                          </div>
                          
                          <!-- COTIZACIONES -->
                          <div role="tabpanel" class="tab-pane fade" id="tab_content4" aria-labelledby="profile-tab">
                            <div class="row">
                              <div class="col-md-6 col-sm-6 col-xs-6">

                                <div class="row">
                                  <div class="col-md-8 col-sm-12 col-xs-12">
                                    <h4 class="heading">Nombre Corto:</h4>
                                    <input type="text" autocomplete="off" maxlength="48" id="txtNombreCorto" class="form-control coti" name="nombre_corto" value="<?= $empresa->nombre_corto ?>">
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-8 col-sm-12 col-xs-12">
                                    <h4 class="heading">Clasificación:</h4>
                                    <input type="text" autocomplete="off" maxlength="45" id="txtClasificacion" class="form-control coti" name="clasificacion" value="<?= $empresa->clasificacion ?>">
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-8 col-sm-12 col-xs-12">
                                    <h4 class="heading">Cotizar en:</h4>
                                    <p> 
                                        MXN
                                        <input type="checkbox" class="flat coti" id="cbCotizacionMXN" value="MXN" <?php if(strpos($empresa->moneda_cotizacion, '"MXN"')) { echo 'checked'; }?>/>
                                        USD
                                        <input type="checkbox" class="flat coti" id="cbCotizacionUSD" value="USD" <?php if(strpos($empresa->moneda_cotizacion, '"USD"')) { echo 'checked'; }?>/>
                                    </p>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-8 col-sm-12 col-xs-12">
                                    <div class="item form-group">
                                        <h4 class="heading">Crédito:</h4>
                                        <input id="credito_cliente" class="flat col-md-7 col-xs-12 coti" value="1" name="credito_cliente" type="checkbox" <?= $empresa->credito_cliente == "1" ? "checked" : "" ?>>
                                        <select id="optCreditoClientePlazo" name="credito_cliente_plazo" style="height: 29px; padding: 0px; display: none; width: 35%;" class="select2_single form-control coti">
                                          <option value="15" <?= $empresa->credito_cliente_plazo == "15" ? "selected" : "" ?>>15 Días</option>
                                          <option value="30" <?= $empresa->credito_cliente_plazo == "30" ? "selected" : "" ?>>30 Días</option>
                                          <option value="45" <?= $empresa->credito_cliente_plazo == "45" ? "selected" : "" ?>>45 Días</option>
                                          <option value="60" <?= $empresa->credito_cliente_plazo == "60" ? "selected" : "" ?>>60 Días</option>
                                          <option value="90" <?= $empresa->credito_cliente_plazo == "90" ? "selected" : "" ?>>90 Días</option>
                                          <option value="120" <?= $empresa->credito_cliente_plazo == "120" ? "selected" : "" ?>>120 Días</option>
                                        </select>
                                    </div>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-8 col-sm-12 col-xs-12">
                                    <h4 class="heading">Tasa IVA:</h4>
                                    <select class="select2_single form-control coti" id="opCotizacionIva">
                                      <option data-nombre='Exento (0.00%)' value='0.00' <?php if(strpos($empresa->iva_cotizacion, '"Exento (0.00%)"')) { echo 'selected'; }?>>Exento (0.00%)</option>
                                      <option data-nombre='Frontera (16.00%)' value='0.16' <?php if(strpos($empresa->iva_cotizacion, '"Frontera (16.00%)"')) { echo 'selected'; }?>>Frontera (16.00%)</option>
                                      <option data-nombre='IVA 8% (8.00%)' value='0.08' <?php if(strpos($empresa->iva_cotizacion, '"IVA 8% (8.00%)"')) { echo 'selected'; }?>>IVA 8% (8.00%)</option>
                                      <option data-nombre='Interior (16.00%)' value='0.16' <?php if(strpos($empresa->iva_cotizacion, '"Interior (16.00%)"')) { echo 'selected'; }?>>Interior (16.00%)</option>
                                      <option data-nombre='Texas (8.25%)' value='0.0825' <?php if(strpos($empresa->iva_cotizacion, '"Texas (8.25%)"')) { echo 'selected'; }?>>Texas (8.25%)</option>
                                    </select>
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-md-8 col-sm-12 col-xs-12">
                                    <h4 class="heading">Notas de cotización:</h4>
                                    <textarea id="txtNotasCotizacion" style="resize: none;" class="form-control coti"><?= $empresa->notas_cotizacion ?></textarea>
                                  </div>
                                </div>

                                <div class="row">
                                  <div style="margin-top: 10px;" class="col-md-8 col-sm-12 col-xs-12">
                                  <h4 style="display: inline;" class="heading">Contactos por defecto:</h4><button type="button" onclick="mdlContactosCotizacion()" class="btn btn-xs btn-primary pull-right coti"><i class="fa fa-plus"></i> Agregar</button>
                                    <table class="table table-striped" id="tblContactoCotizacion">
                                      <thead>
                                          <tr class="headings">
                                              <th class="column-title">Nombre</th>
                                              <th class="column-title">Planta</th>
                                              <th width="20%" class="column-title">Opciones</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                      </tbody>
                                    </table>
                                    <button onclick="guardarInfoCotizaciones();" style="margin-top: 20px; display: none;" type="button" id="btnGuardarCotizaciones" class="btn btn-primary"><i class="fa fa-save"></i> Guardar Cambios</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                                                    
                          <!-- FACTURACION -->
                          <div role="tabpanel" class="tab-pane fade" id="tab_content5" aria-labelledby="profile-tab">
                            <div class="col-md-6">
                              <ul class="messages">
                                <li>
                                  <div class="message_wrapper">
                                    <h4 class="heading">Días y horarios para recepción de facturas</h4>
                                    <blockquote class="message"><font size=3><?= $empresa->horario_facturas ?></font></blockquote><br>
                                    <h4 class="heading">Último dia de recepción de facturas</h4>
                                    <blockquote class="message"><font size=3><?= $empresa->ultimo_dia_facturas ?></font></blockquote><br>
                                    <h4 class="heading">Requisitos Logísticos</h4>
                                    <blockquote class="message"><font size=3><?= $empresa->requisitos_logisticos ? $empresa->requisitos_logisticos : "N/A" ?></font></blockquote><br>
                                    <h4 class="heading">Requisitos de Documento</h4>
                                    <blockquote class="message"><font size=3><?= $empresa->requisitos_documento ? $empresa->requisitos_documento : "N/A" ?></font></blockquote><br>
                                    <h4 class="heading">Comentarios</h4>
                                    <blockquote class="message"><font size=3><?= $empresa->comentarios ?></font></blockquote><br>
                                    <h4 class="heading">Ejemplo de Factura</h4>
                                    <table id="tblArchivoEjemplo" class="table table-striped">
                                        <thead>
                                          <tr>
                                            <th>Archivo</th>
                                            <th>Opciones</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                    <br>
                                    <?php if ($this->session->privilegios['administrar_empresas_facturacion']) { ?>
                                      <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalOtrosDatos"><i class="fa fa-pencil"></i> Editar datos</a>
                                    <?php } ?>
                                  </div>
                                </li>
                              </ul>
                            </div>
                            
                            <div class="col-md-6">
                              <div class="row" style="margin-bottom: 15px;">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                  <h4 style="display: inline-block; margin-right: 10px;">Listado de documentos</h4>

                                  <table id="tblDocumentos" class="data table table-striped no-margin">
                                    <thead>
                                      <tr>
                                        <th>Aplica</th>
                                        <th>Documento</th>
                                        <th>Nivel</th>
                                        <th>Origen</th>
                                        <th>Código</th>
                                        <th style="display:none;">Campo</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr>
                                        <td><input type="checkbox" class="flat cbDocu" readonly></td>
                                        <td class="doc">Orden de Compra / Cotización</td>
                                        <td class="nivel">Local</td>
                                        <td class="origen">Adjunto-Solicitud</td>
                                        <td class="codigo">O</td>
                                        <td class="campo" style="display:none;">f_orden_compra</td>
                                      </tr>
                                      <tr>
                                        <td><input type="checkbox" class="flat cbDocu"></td>
                                        <td class="doc">Remisión</td>
                                        <td class="nivel">Local</td>
                                        <td class="origen">Adjunto-Solicitud</td>
                                        <td class="codigo">R</td>
                                        <td class="campo" style="display:none;">f_remision</td>
                                      </tr>
                                      <tr>
                                        <td><input type="checkbox" class="flat cbDocu"></td>
                                        <td class="doc">Factura</td>
                                        <td class="nivel">Local</td>
                                        <td class="origen">Adjunto-Respuesta</td>
                                        <td class="codigo">F</td>
                                        <td class="campo" style="display:none;">f_factura</td>
                                      </tr>
                                      <tr>
                                        <td><input type="checkbox" class="flat cbDocu"></td>
                                        <td class="doc">XML</td>
                                        <td class="nivel">Local</td>
                                        <td class="origen">Adjunto-Respuesta</td>
                                        <td class="codigo">X</td>
                                        <td class="campo" style="display:none;">f_xml</td>
                                      </tr>
                                      <tr>
                                        <td><input type="checkbox" class="flat cbDocu"></td>
                                        <td class="doc">Acuse de Portal</td>
                                        <td class="nivel">Local</td>
                                        <td class="origen">Adjunto-Respuesta</td>
                                        <td class="codigo">A</td>
                                        <td class="campo" style="display:none;">f_acuse</td>
                                      </tr>
                                      <tr>
                                        <td><input type="checkbox" class="flat cbDocu"></td>
                                        <td class="doc">Opinión Positiva</td>
                                        <td class="nivel">Global</td>
                                        <td class="origen">C:/opinion_positiva.pdf</td>
                                        <td class="codigo">P</td>
                                        <td class="campo" style="display:none;">opinion_positiva</td>
                                      </tr>
                                      <tr>
                                        <td><input type="checkbox" class="flat cbDocu"></td>
                                        <td class="doc">Emisión SUA</td>
                                        <td class="nivel">Global</td>
                                        <td class="origen">C:/emision.pdf</td>
                                        <td class="codigo">S</td>
                                        <td class="campo" style="display:none;">emision_sua</td>
                                      </tr>
                                      <tr>
                                        <td><input type="checkbox" class="flat cbDocu"></td>
                                        <td class="doc">Validación SAT</td>
                                        <td class="nivel">Local</td>
                                        <td class="origen">Proceso</td>
                                        <td class="codigo">V</td>
                                        <td class="campo" style="display:none;">N/A</td>
                                      </tr>
                                    </tbody>
                                  </table>
                                  <label>Código de Impresión</label>
                                  <input maxlength="15" style="text-transform: uppercase; width: 170px; display: inline-block; margin: 10px;" onkeypress="codigoImpresion(event, this)" id="txtCodigoImpresion" class="form-control" type="text" value="<?= $empresa->codigo_impresion ?>">
                                  <button type="button" id="btnCodigoImpresion" style="display: none;" class="btn btn-primary btn-xs" onclick="guardarListadoDocumentos()"><i class="fa fa-save"></i> Guardar Cambios</button>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                  <h4 style="display: inline-block; margin-right: 10px;">Requisitos de autorización de Facturas</h4>
                                  <?php if ($this->session->privilegios['administrar_empresas_facturacion']) { ?>
                                    <button onclick="modalRequisitos('FACTURACION')" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i> Agregar</button>
                                  <?php } ?>

                                  <table id="tablaRequisitos" class="data table table-striped no-margin">
                                    <thead>
                                      <tr>
                                        <th>#</th>
                                        <th>Requisito</th>
                                        <th>Detalles</th>
                                        <?php if ($this->session->privilegios['administrar_empresas']) { ?>
                                          <th>Opciones</th>
                                        <?php } ?>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <?php if($requisitos) { $i=1; foreach ($requisitos->result() as $elem) { if($elem->tipo == "FACTURACION") {?>
                                        <tr>
                                          <td><?= $i ?></td>
                                          <td><?= $elem->requisito ?></td>
                                          <td><?= $elem->detalles ?></td>
                                          <?php if ($this->session->privilegios['administrar_empresas']) { ?>
                                            <td><button onclick="deleteRequisito(this)" class='btn btn-danger btn-xs' value="<?= $elem->id ?>"><i class='fa fa-trash-o'></i> Borrar </button></td>
                                          <?php } ?>
                                        </tr>
                                      <?php $i++; } } } ?>
                                    </tbody>
                                  </table>
                                </div>
                              </div>

                              
                            </div> 
                          </div>

                          <!-- LOGISTICA Y OPERACIONES -->
                          <div role="tabpanel" class="tab-pane fade" id="tab_content6" aria-labelledby="profile-tab">
                            <div class="col-md-6 col-sm-12">
                              <h4 style="display: inline-block; margin-right: 10px;">Requisitos de Logística</h4>
                                <?php if ($this->session->privilegios['administrar_empresas_logistica']) { ?>
                                  <button onclick="modalRequisitos('LOGISTICA')" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i> Agregar</button>
                                <?php } ?>

                              <table id="tablaRequisitosLogistica" class="data table table-striped no-margin">
                                <thead>
                                  <tr>
                                    <th>#</th>
                                    <th>Requisito</th>
                                    <th>Detalles</th>
                                    <?php if ($this->session->privilegios['administrar_empresas_logistica']) { ?>
                                      <th>Opciones</th>
                                    <?php } ?>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php if($requisitos) { $i=1; foreach ($requisitos->result() as $elem) { if($elem->tipo == "LOGISTICA") {?>
                                    <tr>
                                      <td><?= $i ?></td>
                                      <td><?= $elem->requisito ?></td>
                                      <td><?= $elem->detalles ?></td>
                                      <?php if($this->session->privilegios['administrar_empresas_logistica']) { ?>
                                        <td><button onclick="deleteRequisito(this)" class='btn btn-danger btn-xs' value="<?= $elem->id ?>"><i class='fa fa-trash-o'></i> Borrar </button></td>
                                      <?php } ?>
                                    </tr>
                                  <?php $i++; } } } ?>
                                </tbody>
                              </table>
                            </div>

                            <div class="col-md-6 col-sm-12">
                              <h4 style="display: inline-block; margin-right: 10px;">Requisitos de Operaciones</h4>
                                <?php if ($this->session->privilegios['administrar_empresas_logistica']) { ?>
                                  <button onclick="modalRequisitos('OPERACIONES')" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i> Agregar</button>
                                <?php } ?>

                              <table id="tablaRequisitosOperaciones" class="data table table-striped no-margin">
                                <thead>
                                  <tr>
                                    <th>#</th>
                                    <th>Requisito</th>
                                    <th>Detalles</th>
                                    <?php if ($this->session->privilegios['administrar_empresas_logistica']) { ?>
                                      <th>Opciones</th>
                                    <?php } ?>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php if($requisitos) { $i=1; foreach ($requisitos->result() as $elem) { if($elem->tipo == "OPERACIONES") {?>
                                    <tr>
                                      <td><?= $i ?></td>
                                      <td><?= $elem->requisito ?></td>
                                      <td><?= $elem->detalles ?></td>
                                      <?php if ($this->session->privilegios['administrar_empresas_logistica']) { ?>
                                        <td><button onclick="deleteRequisito(this)" class='btn btn-danger btn-xs' value="<?= $elem->id ?>"><i class='fa fa-trash-o'></i> Borrar </button></td>
                                      <?php } ?>
                                    </tr>
                                  <?php $i++; } } } ?>
                                </tbody>
                              </table>
                            </div>
                          </div>

                          <!-- PROVEEDOR -->
                          <div role="tabpanel" class="tab-pane fade" id="tab_content7" aria-labelledby="profile-tab">
                            <div class="row">

                              <div class="col-md-12 col-sm-12 col-xs-12">   
                                
                                <div class="row">
                                  <div class="col-md-2 col-sm-2 col-xs-12">
                                      <h4 class="heading">Proveedor</h4>
                                      <p> 
                                          Productos
                                          <input type="checkbox" class="flat prov" id="cbProductos" value="PRODUCTOS" <?php if(strpos($proveedor->tipo, '"PRODUCTOS"')) { echo 'checked'; }?>/>
                                          Servicios
                                          <input type="checkbox" class="flat prov" id="cbServicios" value="SERVICIOS" <?php if(strpos($proveedor->tipo, '"SERVICIOS"')) { echo 'checked'; }?>/>
                                      </p>
                                  </div>

                                  <div class="col-md-2 col-sm-2 col-xs-12">
                                      <h4 class="heading">Clasificación</h4>
                                      <p> 
                                          <input type="text" maxlength="45" class="flat prov" id="txtClasificacionProveedor" value="<?= $proveedor->clasificacion_proveedor; ?>" />
                                      </p>
                                  </div>

                                  <div class="col-md-8 col-sm-8 col-xs-12">
                                      <h4 class="heading">Formas de Pago</h4>
                                      <p>
                                          MasterCard
                                          <input type="checkbox" class="flat prov" id="cbMC" value="MASTER CARD" <?php if(strpos($proveedor->formas_pago, '"MASTER CARD"')) { echo 'checked'; }?>/>
                                          Visa
                                          <input type="checkbox" class="flat prov" id="cbVS" value="VISA" <?php if(strpos($proveedor->formas_pago, '"VISA"')) { echo 'checked'; }?>/>
                                          A. Express
                                          <input type="checkbox" class="flat prov" id="cbAE" value="AMERICAN EXPRESS" <?php if(strpos($proveedor->formas_pago, '"AMERICAN EXPRESS"')) { echo 'checked'; }?>/>
                                          Transferencia
                                          <input type="checkbox" class="flat prov" id="cbTR" value="TRANSFERENCIA" <?php if(strpos($proveedor->formas_pago, '"TRANSFERENCIA"')) { echo 'checked'; }?>/>
                                          Cheque
                                          <input type="checkbox" class="flat prov" id="cbCQ" value="CHEQUE" <?php if(strpos($proveedor->formas_pago, '"CHEQUE"')) { echo 'checked'; }?>/>
                                          Efectivo
                                          <input type="checkbox" class="flat prov" id="cbEF" value="EFECTIVO" <?php if(strpos($proveedor->formas_pago, '"EFECTIVO"')) { echo 'checked'; }?>/>
                                      </p>
                                  </div>  

                                </div>
                                <br>

                                <div class="row">

                                <div class="col-md-4 col-sm-4 col-xs-12">
                                <?php $disp = strpos($proveedor->tipo, '"SERVICIOS"') ? '' : 'style="display: none;"'; ?>
                                  <div id="divRMA" <?= $disp ?>>
                                      <h4 class="heading">RMA</h4>
                                        <p>
                                            Requerido
                                            <input type="checkbox" class="flat prov" id="cbRMA" value="1" <?php if($proveedor->rma_requerido) { echo 'checked'; }?>/>
                                        </p>
                                    </div>
                                  </div>
                                  <div class="col-md-4 col-sm-4 col-xs-12">
                                    <h4 class="heading">Credito</h4>
                                      <p>
                                          Credito
                                          <input type="checkbox" class="flat prov" id="cbCredito" value="1" <?php if($proveedor->credito) { echo 'checked'; }?>/>
                                          <input style="text-align: right; width: 30%;" type="number" class="prov" id="txtCredito" value="<?= $proveedor->monto_credito; ?>" min="0.00" />
                                          
                                          <select id="optMoneda" style="height: 29px; padding: 0px; display: inline; width: 25%;" class="select2_single form-control prov">
                                            <option value="MXN" <?= $proveedor->moneda_credito == "MXN" ? "selected" : "" ?>>MXN</option>
                                            <option value="USD" <?= $proveedor->moneda_credito == "USD" ? "selected" : "" ?>>USD</option>
                                            <option value="EUR" <?= $proveedor->moneda_credito == "EUR" ? "selected" : "" ?>>EUR</option>
                                          </select>
                                      </p>
                                  </div>
                                  

                                  <div class="col-md-4 col-sm-4 col-xs-12">
                                    <h4 id="lblTerminosPago" class="heading">Terminos de Pago</h4>
                                      <p>
                                          <select id="optTerminosPago" style="height: 29px; padding: 0px; display: inline; width: 50%;" class="select2_single form-control prov">
                                            <option value="Inmediato" <?= $proveedor->terminos_pago == "Inmediato" ? "selected" : "" ?>>Inmediato</option>
                                            <option value="7 dias" <?= $proveedor->terminos_pago == "7 dias" ? "selected" : "" ?>>7 Días</option>
                                            <option value="15 dias" <?= $proveedor->terminos_pago == "15 dias" ? "selected" : "" ?>>15 Días</option>
                                            <option value="30 dias" <?= $proveedor->terminos_pago == "30 dias" ? "selected" : "" ?>>30 Días</option>
                                            <option value="45 dias" <?= $proveedor->terminos_pago == "45 dias" ? "selected" : "" ?>>45 Días</option>
                                          </select>
                                      </p>
                                  </div>

                                </div><br>





                                <div class="row">

                                  <div class="col-md-4 col-sm-4 col-xs-12">
                                    <h4 class="heading">Formas de Compra</h4>
                                      <p>
                                          Online
                                          <input type="checkbox" class="flat prov" id="cbOnline" value="ONLINE" <?php if(strpos($proveedor->formas_compra, '"ONLINE"')) { echo 'checked'; }?>/>
                                          Presencial
                                          <input type="checkbox" class="flat prov" id="cbPresencial" value="PRESENCIAL" <?php if(strpos($proveedor->formas_compra, '"PRESENCIAL"')) { echo 'checked'; }?>/>
                                          E-Mail
                                          <input type="checkbox" class="flat prov" id="cbEmail" value="EMAIL" <?php if(strpos($proveedor->formas_compra, '"EMAIL"')) { echo 'checked'; }?>/>
                                      </p>
                                  </div>

                                  <div class="col-md-4 col-sm-4 col-xs-12">
                                    <h4 class="heading">Lugar de Entrega</h4>
                                      <p>
                                          México
                                          <input type="radio" class="flat prov" id="cbMexico" name="cbEntrega" value="MEXICO" <?php if($proveedor->entrega == 'MEXICO') { echo 'checked'; }?>/>
                                          USA
                                          <input type="radio" class="flat prov" id="cbUsa" name="cbEntrega" value="USA" <?php if($proveedor->entrega == 'USA') { echo 'checked'; }?>/>
                                      </p>
                                  </div>

                                  <div class="col-md-4 col-sm-4 col-xs-12">
                                    <h4 class="heading">Aprobación</h4>
                                      <p>
                                          Prov. Aprobado
                                          <input type="checkbox" class="flat prov" id="cbAprobado" value="1" <?php if($proveedor->aprobado) { echo 'checked'; }?>/>
                                      </p>
                                  </div>

                                </div><br>







                                <div class="row">
                                  <div class="col-md-4 col-sm-4 col-xs-12">
                                    <h4 class="heading">Tags</h4>
                                    <input id="tags_1" type="text" class="form-control prov" value="<?= $proveedor->tags; ?>" /><br>
                                    <button onclick="guardarProveedor();" style="display: none;" type="button" id="btnGuardarProveedor" class="btn btn-primary"><i class="fa fa-save"></i> Guardar Cambios</button>
                                  </div>

                                  <div class="col-md-4 col-sm-4 col-xs-12">

                                    <h4 style="display: inline;">Proceso de cotización</h4>
                                    <?php if($this->session->privilegios['administrar_empresas_proveedor']){ ?>
                                      <button onclick="modalPasos(1)" class="btn btn-primary btn-xs" type="button"> <i class="fa fa-plus"></i></button>
                                    <?php } ?>
                                    <table id="tblPasosCotizar" class="data table table-striped no-margin">
                                    <tbody>
                                      <?php $pasos = json_decode($proveedor->pasos_cotizacion);
                                      foreach ($pasos as $value) { ?>
                                        <tr>
                                          <td><?= $value ?></td>
                                          <td><?php if($this->session->privilegios['administrar_empresas_proveedor']){ ?><button onclick='eliminarPaso(this)' class='btn btn-danger btn-xs'><i class='fa fa-minus'></i></button><?php } ?></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                    </table>
                                  </div>

                                  <div class="col-md-4 col-sm-4 col-xs-12">

                                    <h4 style="display: inline;" class="heading">Proceso de compra</h4>
                                    <?php if($this->session->privilegios['administrar_empresas_proveedor']){ ?>
                                      <button onclick="modalPasos(2)" class="btn btn-primary btn-xs" type="button"> <i class="fa fa-plus"></i></button>
                                    <?php } ?>
                                    <table id="tblPasosComprar" class="data table table-striped no-margin">                                    
                                    <tbody>
                                        <?php $pasos = json_decode($proveedor->pasos_compra);
                                        foreach ($pasos as $value) { ?>
                                          <tr style="padding: 2px:" >
                                            <td><?= $value ?></td>
                                            <td><?php if($this->session->privilegios['administrar_empresas_proveedor']){ ?><button onclick='eliminarPaso(this)' class='btn btn-danger btn-xs'><i class='fa fa-minus'></i></button><?php } ?></td>
                                          </tr>
                                          <?php } ?>
                                      </tbody>
                                    </table>
                                  </div>

                                </div>

                                <div class="row">
                                    
                                </div>

                              
                              </div>

                            </div>
                          </div>

                          <!-- PLANTAS -->
                          <div role="tabpanel" class="tab-pane fade" id="tab_content8" aria-labelledby="profile-tab">
                            <div class="row">
                              <div class="col-md-12 col-sm-12">
                              <?php if ($this->session->privilegios['administrar_empresas']) { ?>
                                <button onclick="mdlPlanta()" type="button" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i> Agregar Planta</button>
                              <?php } ?> 
                                <table id="tblPlantas" class="table table-striped">
                                  <thead>
                                      <tr class="headings">
                                          <th class="column-title">#</th>
                                          <th class="column-title">Nombre</th>
                                          <th class="column-title">Nombre Corto</th>
                                          <th class="column-title">Dirección</th>
                                          <th class="column-title">Ciudad</th>
                                          <th class="column-title">Comentarios</th>
                                          <th class="column-title">Opciones</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                            
                          </div>
                          
                          <!-- UBICACIÓN -->
                          <div role="tabpanel" class="tab-pane fade" id="tab_content9" aria-labelledby="profile-tab">
                            <div class="row">
                              <div class="col-md-7 col-sm-12">

                                <div class="pac-card" id="pac-card">
                                  <div id="pac-container">
                                    <input class='form-control' style="width: 500px;" id="pac-input" type="text"
                                        placeholder="Ingrese Locación">
                                  </div>
                                </div>

                                <div style="height: 600px; width: 100%;" id="map"></div>

                                <?php if ($this->session->privilegios['administrar_empresas']) { ?>
                                  <button style="margin-top: 10px;" onclick="guardarUbicacion()" class="btn btn-primary btn-sm"><i class="fa fa-map-marker"></i> Guardar Ubicación</button>
                                <?php } ?>

                                

                              </div>

                              <div class="col-md-5 col-sm-12">
                                <div class="profile_img">
                                  <div id="crop-avatar">
                                    <a data-toggle="modal" data-target="#modalFoto">
                                      <img style="width: 100%;" id="imgEmpresa" class="usuario img-responsive avatar-view" src="<?= base_url('data/empresas/fotos/'.$empresa->foto); ?>">
                                    </a>
                                  </div>
                                </div><br>
                                <button style="display: none;" id="btnGuardarFoto" onclick="subirFoto();" type="button" class="btn btn-warning btn-sm"><i class="fa fa-upload"></i> Guardar Foto </button>
                              </div>
                            </div>
                            
                          </div>

                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->

        <!-- MODALS -->
        <!-- EDITAR DATOS DE LA EMPRESA -->
        <div class="modal fade empresa" role="dialog" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="modalEmpresaHeader">Editar Empresa</h4>
              </div>
              <form method="POST" action=<?= base_url('empresas/editar') ?> class="form-horizontal form-label-left" novalidate>
              <div class="modal-body">
              <input name="id" type="hidden" value="<?= $empresa->id ?>">
              <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Nombre</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input maxlength="100" id="nombre" class="form-control col-md-7 col-xs-12" name="nombre" placeholder="" required="required" type="text" value="<?= $empresa->nombre ?>">
                </div>
              </div>
              <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Razón Social</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                      <input maxlength="100" id="razon_social" class="form-control col-md-7 col-xs-12" name="razon_social" placeholder="" required="required" type="text" value="<?= $empresa->razon_social ?>">
                  </div>
              </div>
              <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">RFC</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                      <input maxlength="15" id="rfc" class="form-control col-md-7 col-xs-12" name="rfc" placeholder="" required="required" type="text" value="<?= $empresa->rfc ?>">
                  </div>
              </div>
              <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Calle</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                      <input maxlength="45" id="calle" class="form-control col-md-7 col-xs-12" name="calle" placeholder="" required="required" type="text" value="<?= $empresa->calle ?>">
                  </div>
              </div>
              <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Numero</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                      <input maxlength="20" id="numero" class="form-control col-md-7 col-xs-12" name="numero" placeholder="" required="required" type="text" value="<?= $empresa->numero ?>">
                  </div>
              </div>
              <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Numero Int</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                      <input maxlength="20" id="numero_interior" class="form-control col-md-7 col-xs-12" name="numero_interior" placeholder="" type="text" value="<?= $empresa->numero_interior ?>">
                  </div>
              </div>
              <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Colonia</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                      <input maxlength="45" id="colonia" class="form-control col-md-7 col-xs-12" name="colonia" placeholder="" type="text" value="<?= $empresa->colonia ?>">
                  </div>
              </div>
              <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="calles_aux">Entre Calles</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                      <input maxlength="150" id="calles_aux" class="form-control col-md-7 col-xs-12" name="calles_aux" placeholder="" type="text" value="<?= $empresa->calles_aux ?>">
                  </div>
              </div>
              <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">CP</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                      <input maxlength="10" id="cp" class="form-control col-md-7 col-xs-12" name="cp" placeholder="" type="number" value="<?= $empresa->cp ?>">
                  </div>
              </div>
              <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">País</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select onchange="estados()" required="required" class="select2_single form-control" name="pais" id="pais">
                      <option value="MEXICO" <?= $empresa->pais == "MEXICO" ? "selected" : "" ?> >MEXICO</option>
                      <option value="USA" <?= $empresa->pais == "USA" ? "selected" : "" ?> >USA</option>
                      <option value="CANADA" <?= $empresa->pais == "CANADA" ? "selected" : "" ?> >CANADA</option>
                    </select>
                  </div>
              </div>
              <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Estado</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select required="required" class="select2_single form-control" name="estado" id="estado">
                      <option value="<?= $empresa->estado ?>"><?= $empresa->estado ?></option>
                    </select>
                  </div>
              </div>
              <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Ciudad</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                      <input list="lstCiudades" maxlength="45" id="ciudad" class="form-control col-md-7 col-xs-12" name="ciudad" placeholder="" type="text" value="<?= $empresa->ciudad ?>">
                      <datalist id="lstCiudades">
                      </datalist>
                  </div>
              </div>

              <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="giro">Giro</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="text" maxlength="45" id="txtGiro" class="form-control col-md-7 col-xs-12" name="giro" placeholder="" value="<?= $empresa->giro ?>">
                  </div>
              </div>

              <br>
              <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Tipo</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                      <p>
                          Cliente
                          <input type="checkbox" class="flat" name="cliente" value="1" <?php if($empresa->cliente) { echo 'checked'; }?>/>
                          Proveedor
                          <input type="checkbox" class="flat" name="proveedor" value="1" <?php if($empresa->proveedor) { echo 'checked'; }?>/>
                      </p>
                  </div>
              </div>

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Guardar Datos</button>
              </div>
              </form>
            </div>
          </div>
        </div>

        <div id="modalOtrosDatos" class="modal fade" role="dialog" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="modalEmpresaHeader">Editar Empresa</h4>
              </div>
              <form method="POST" action=<?= base_url('empresas/editar_otros_datos') ?> class="form-horizontal form-label-left" novalidate>
              <div class="modal-body">
              <input name="id" type="hidden" value="<?= $empresa->id ?>">
              
              <div class="item form-group">
                <label class="control-label col-md-4 col-sm-4 col-xs-12" for="name">Días y horarios para recepción de facturas</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input maxlength="100" id="horario_facturas" class="form-control col-md-7 col-xs-12" name="horario_facturas" placeholder="" required="required" type="text" value="<?= $empresa->horario_facturas ?>">
                </div>
              </div>
              <div class="item form-group">
                  <label class="control-label col-md-4 col-sm-4 col-xs-12" for="name">Último dia de recepción de facturas</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                      <input maxlength="100" id="ultimo_dia_facturas" class="form-control col-md-7 col-xs-12" name="ultimo_dia_facturas" placeholder="" required="required" type="text" value="<?= $empresa->ultimo_dia_facturas ?>">
                  </div>
              </div>

              <div class="item form-group">
                  <label class="control-label col-md-4 col-sm-4 col-xs-12" for="name">Requisitos Logísticos</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                      <textarea style="width: 100%;" name="requisitos_logisticos"><?= $empresa->requisitos_logisticos ?></textarea>
                  </div>
              </div>

              <div class="item form-group">
                  <label class="control-label col-md-4 col-sm-4 col-xs-12" for="name">Requisitos de Documento</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                      <textarea style="width: 100%;" name="requisitos_documento"><?= $empresa->requisitos_documento ?></textarea>
                  </div>
              </div>
              
              <div class="item form-group">
                  <label class="control-label col-md-4 col-sm-4 col-xs-12" for="name">Comentarios</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                      <textarea style="width: 100%;" id="comentarios" name="comentarios"><?= $empresa->comentarios ?></textarea>
                  </div>
              </div>

              <div class="item form-group">
                  <label class="control-label col-md-4 col-sm-4 col-xs-12" for="name">Permite dejar factura en recorrido</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                      <input class="flat col-md-7 col-xs-12" value="1" name="dejar_factura" type="checkbox" <?= $empresa->dejar_factura == "1" ? "checked" : "" ?>>
                  </div>
              </div>


              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Guardar Datos</button>
              </div>
              </form>
            </div>
          </div>
        </div>
        
        <!-- DATOS DE CONTACTOS -->
        <div id="modalContacto" class="modal fade contacto" role="dialog" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Contacto</h4>
              </div>
              <form id="formContacto" class="form-horizontal form-label-left">
              <div class="modal-body">
              <input name="empresa" type="hidden" value="<?= $empresa->id ?>">
              <input id="idContacto" type="hidden">
              <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Nombre</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input maxlength="200" id="nombreContacto" class="form-control col-md-7 col-xs-12" name="nombre" placeholder="" required="required" type="text">
                </div>
              </div>
              
              <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Teléfono</label>
                  <div class="col-md-3 col-sm-3 col-xs-12">
                      <input maxlength="14" oninput="phoneMask(this)" onkeypress="return event.charCode >= 48 && event.charCode <= 57" id="telefonoContacto" class="form-control col-md-7 col-xs-12" name="telefono" placeholder="" required="required" type="text">
                  </div>
                  <label class="control-label col-md-1 col-sm-1 col-xs-12" for="name">Ext</label>
                  <div class="col-md-2 col-sm-2 col-xs-12">
                      <input maxlength="5" id="ext" class="form-control col-md-7 col-xs-12" name="ext" onkeypress="return event.charCode >= 48 && event.charCode <= 57" type="text">
                  </div>
              </div>

              <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Celular 1</label>
                  <div class="col-md-3 col-sm-3 col-xs-12">
                      <input maxlength="14" oninput="phoneMask(this)" onkeypress="return event.charCode >= 48 && event.charCode <= 57" id="celularContacto" class="form-control col-md-7 col-xs-12" name="celular" placeholder="" required="required" type="text">
                  </div>
                  <label class="control-label col-md-1 col-sm-1 col-xs-12" for="name">País</label>
                  <div class="col-md-2 col-sm-2 col-xs-12">
                    <img height="40px;"; src=<?= base_url("template/images/flags/". $empresa->pais . ".png") ?>>
                  </div>
              </div>

              <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Celular 2</label>
                  <div class="col-md-3 col-sm-3 col-xs-12">
                      <input maxlength="14" oninput="phoneMask(this)" onkeypress="return event.charCode >= 48 && event.charCode <= 57" id="celularContacto2" class="form-control col-md-7 col-xs-12" name="celular2" type="text">
                  </div>
              </div>

              <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Correo</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                      <input maxlength="100" style="text-transform: lowercase;" id="correoContacto" class="form-control col-md-7 col-xs-12" name="correo" placeholder="" required="required" type="text">
                  </div>
              </div>

              <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Puesto</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                      <input maxlength="80" id="puestoContacto" class="form-control col-md-7 col-xs-12" name="puesto" placeholder="" required="required" type="text">
                  </div>
              </div>

              <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Red Social</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                      <input maxlength="80" id="red_social" class="form-control col-md-7 col-xs-12" name="red_social" type="text">
                  </div>
              </div>

              <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Plantas</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select id="optContactoPlanta" class="select2_single form-control">
                    </select>
                  </div>
              </div>

              <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name"></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <label>Activo</label>
                  <input type="checkbox" class="flat" id="cbContactoActivo" />
                  <label>Cotizar</label>
                  <input type="checkbox" class="flat" id="cbContactoCotizable" />
                </div>
              </div>


              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button id="btnModalContacto" onclick="aceptar()" type="button" class="btn btn-primary" data-dismiss="modal">Agregar Contacto</button>
              </div>
              </form>
            </div>
          </div>
        </div>
        
        <!-- FOTO -->
        <div id="modalFoto" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">

              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel2">Foto de empresa</h4>
              </div>
              <div class="modal-body">
              <form>
                <center>
                  <button onclick="fotoDefault();" type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-trash"></i> Eliminar Foto</button>

                  <form id="formFoto" enctype="multipart/form-data" method="POST">
                    <label class="btn btn-primary" for="iptFoto">
                      <input type="hidden" value="<?= $empresa->id ?>" name="id_empresa">
                      <input onchange="readIMG(this);" type="file" class="sr-only" id="iptFoto" name="iptFoto" accept="image/*">
                      <i class="fa fa-camera"></i> Subir Foto
                    </label>
                  </form>
                </center>
              </form>
              </div>

            </div>
          </div>
        </div>
        
        <!-- ARCHIVO -->
        <div id="modalFile" class="modal fade bs-example-modal-file" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">

              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel2">Comentarios de Archivo</h4>
              </div>
              <div class="modal-body">
              <form>
                <center>
                  <textarea id="fileComments" style="width: 100%"></textarea>
                  
                </center>
              </form>

              </div>

              <div class="modal-footer">
                <button id="btnEditarComentarios" type="button" onclick="editArchivo()" class="btn btn-primary" data-dismiss="modal">Editar Comentarios</button>
                <button id="btnSubirArchivo" type="button" onclick="uploadFile()" class="btn btn-primary" data-dismiss="modal">Subir Archivo</button>
              </div>

            </div>
          </div>
        </div>
        
        <!-- REQUISITOS -->
        <div id="modalRequisitos" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog modal-md">
            <div class="modal-content">

              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel2">Requisitos</h4>
              </div>
              <div class="modal-body">
              <form id="formRequisitos">
                <table id="tablaSelectRequisitos" class="data table table-striped no-margin">
                  <thead>
                    <tr>
                      <th>Requisito</th>
                      <th>Opción</th>
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

        <!-- REQUISITOS -->
        <div id="mdlPasos" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog modal-md">
            <div class="modal-content">

              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="lblPasoTitulo"></h4>
            </div>

            <div class="modal-body">
                <form>
                    <label>Paso a agregar: </label>
                    <div class="input-group">
                        <input id="txtPaso" type="text" class="form-control">
                        <span class="input-group-btn">
                        <button onclick="setPaso(this)" id="btnPaso" class="btn btn-default" type="button">Agregar</button>
                        </span>
                    </div>
                </form>
            </div> 

            </div>
          </div>
        </div>

        <!-- CONTACTOS COTIZACION -->
        <div id="mdlContactosCotizacion" class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog modal-md">
            <div class="modal-content">

              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel2">Contactos</h4>
              </div>
              <div class="modal-body">
              <form>
                <table id="tblSelectContacto" class="table table-striped no-margin">
                  <thead>
                    <tr>
                      <th>Nombre</th>
                      <th>Planta</th>
                      <th>Opción</th>
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

        <div id="mdlPlanta" class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog modal-md">
            <div class="modal-content">

              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Planta</h4>
              </div>
              <div class="modal-body">
                <form>
                    <label>Nombre</Label>
                    <input id="txtNombrePlanta" maxlength="60" class="form-control" type="text">
                    <label style="margin-top:5px;">Nombre Corto</Label>
                    <input id="txtNombreCortoPlanta" maxlength="48" class="form-control" type="text">
                    <label style="margin-top:5px;">Calle</Label>
                    <input id="txtCallePlanta" maxlength="45" class="form-control" type="text">
                    <label style="margin-top:5px;">Colonia</Label>
                    <input id="txtColoniaPlanta" maxlength="45" class="form-control" type="text">
                    <label style="margin-top:5px;">Ciudad</Label>
                    <input id="txtCiudadPlanta" maxlength="45" class="form-control" type="text">
                    <label style="margin-top:5px;">Estado</Label>
                    <input id="txtEstadoPlanta" maxlength="45" class="form-control" type="text">
                    <label style="margin-top:5px;">Comentarios</Label>
                    <textarea id="txtComentariosPlanta" style="resize: none;" class="form-control"></textarea>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button"class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                <button id="btnAgregarPlanta" type="button" onclick="agregarPlanta()" class="btn btn-primary"><i class="fa fa-plus"></i> Agregar</button>
                <button id="btnEditarPlanta" type="button" onclick="editarPlanta()" class="btn btn-warning"><i class="fa fa-pencil"></i> Editar</button>
              </div>

            </div>
          </div>
        </div>

        

        <footer>
          <div class="pull-right">
            Equipo de Desarrollo | MAS Metrología
          </div>
          <div class="clearfix"></div>
        </footer>
      </div>
    </div>

    <!-- jQuery -->
    <script src=<?=base_url("template/vendors/jquery/dist/jquery.min.js"); ?>></script>
    <!-- Bootstrap -->
    <script src=<?=base_url("template/vendors/bootstrap/dist/js/bootstrap.min.js"); ?>></script>
    <!-- FastClick -->
    <script src=<?=base_url("template/vendors/fastclick/lib/fastclick.js"); ?>></script>
    <!-- NProgress -->
    <script src=<?=base_url("template/vendors/nprogress/nprogress.js"); ?>></script>
    <!-- morris.js -->
    <script src=<?=base_url("template/vendors/raphael/raphael.min.js"); ?>></script>
    <script src=<?=base_url("template/vendors/morris.js/morris.min.js"); ?>></script>
    <!-- bootstrap-progressbar -->
    <script src=<?=base_url("template/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"); ?>></script>
    <!-- bootstrap-daterangepicker -->
    <script src=<?=base_url("template/vendors/moment/min/moment.min.js"); ?>></script>
    <script src=<?=base_url("template/vendors/bootstrap-daterangepicker/daterangepicker.js"); ?>></script>

    <!-- icheck -->
    <script src=<?= base_url("template/vendors/iCheck/icheck.min.js"); ?>></script>

    <!-- jQuery Tags Input -->
    <script src=<?= base_url("template/vendors/jquery.tagsinput/src/jquery.tagsinput.js") ?>></script>

    <!-- PNotify -->
    <script src=<?= base_url("template/vendors/pnotify/dist/pnotify.js"); ?>></script>
    <script src=<?= base_url("template/vendors/pnotify/dist/pnotify.buttons.js"); ?>></script>
    <script src=<?= base_url("template/vendors/pnotify/dist/pnotify.nonblock.js"); ?>></script>
    
    <!--<script async defer
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBlE6J6TWRVoQ4PbrMxTr7Y2K8QsVtCuBM&callback=initMap">
    </script>-->
    
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBlE6J6TWRVoQ4PbrMxTr7Y2K8QsVtCuBM&libraries=places&callback=initMap"
        async defer>
    </script>

    <!-- CUSTOM JS FILE -->
    <script src=<?=base_url("template/js/custom/funciones.js"); ?>></script>
    <!-- Custom Theme Scripts -->
    <script src=<?=base_url("template/build/js/custom.js"); ?>></script>
    <!-- JS FILE -->
    <script src=<?= base_url("application/views/empresas/js/ver.js"); ?>></script>

    <script>
    var LST_DOC = JSON.parse('<?= str_replace("'", '"', $empresa->documentos_facturacion) ?>');
    var ID_EMPRESA = '<?= $empresa->id ?>';

    $(function(){
      load();
      eventos();
      notificaciones();
      cargarContactoCotizacion();
      privilegios();

      $('#tags_1').tagsInput({
        width: 'auto',
        defaultText: 'etiquetas',
        onAddTag: chang,
        onRemoveTag: chang,
      });
    });

    function chang(){
      if(PRIVILEGIOS.administrar_empresas_facturacion == "1"){
        $("#btnGuardarProveedor").fadeIn('slow');
      }
    }

    function eventos(){
      credito();
      $("#cbCredito").on('ifChanged', function (e) {
        credito();
      });

      $('.cbDocu').on('ifChanged', function (e){
        $('#btnCodigoImpresion').fadeIn('slow');
      });

      $(".prov").on('ifChanged', function (e) {
        $("#btnGuardarProveedor").fadeIn('slow');
      });

      $(".prov").on('change', function (e) {
        $("#btnGuardarProveedor").fadeIn('slow');
      });

      $(".coti").on('ifChanged', function (e) {
        $("#btnGuardarCotizaciones").fadeIn('slow');
      });

      $(".coti").on('change', function (e) {
        $("#btnGuardarCotizaciones").fadeIn('slow');
      });

      $(".coti").on('keyup', function (e) {
        $("#btnGuardarCotizaciones").fadeIn('slow');
      });

      if($('#credito_cliente').is(':checked'))
      {
          $('#optCreditoClientePlazo').css('display', 'inline');
      }
      $('#credito_cliente').on('ifChanged', function(){
        
          if($('#credito_cliente').is(':checked'))
          {
              $('#optCreditoClientePlazo').css('display', 'inline');
          }
          else
          {
              $('#optCreditoClientePlazo').css('display', 'none');
          }
      });

      $('#txtBuscarArchivos').on('keypress', function( e ) {
          if( e.keyCode === 13 ) {
              cargarArchivos();
          }
      });

      $('#cbServicios').on('ifChanged', function (e) {
        if($('#cbServicios').is(':checked'))
          {
            $('#divRMA').show();
          }
          else
          {
            $('#divRMA').hide();
            $('#cbRMA').iCheck('uncheck');
          }
      });

    }

    function credito(){
      if($("#cbCredito").is(":checked"))
      {
        $("#txtCredito").show();
        $("#optMoneda").show();
        $("#lblTerminosPago").show();
        $("#optTerminosPago").show();
      }
      else{
        $("#lblTerminosPago").hide();
        $("#optTerminosPago").hide();
        $("#optTerminosPago").val('Inmediato');
        $("#txtCredito").hide();
        $("#optMoneda").hide();
      }
    }

    var markers = [];
    var map;    
    /*
    function initMap() {
      var lat = <?= $empresa->lat ?>;
      var lng = <?= $empresa->lng ?>;
      var zoom = <?= $empresa->zoom ?>;
      var ubicacion; var posEmpty = (lat == "0" && lat == "0");
      if(posEmpty)
      {
        ubicacion = {lat: 24.1560629, lng: -102.7119223};
      } else {
        ubicacion = {lat: lat, lng: lng};
      }
      map = new google.maps.Map(document.getElementById('map'), {
        zoom: zoom,
        center: ubicacion
      });

      if(!posEmpty){
        var marker = new google.maps.Marker({
          position: ubicacion,
          map: map,
          title: "<?= $empresa->nombre ?>",
        });
        markers.push(marker);
      }
      
      if(<?= $this->session->privilegios['administrar_empresas'] ?>){
      google.maps.event.addListener(map, 'click', function(e) {
        deleteMarkers();
        placeMarker(e.latLng, map);
      });
      }

    }
*/
function initMap() {
    var lat = <?= $empresa->lat ?>;
    var lng = <?= $empresa->lng ?>;
    var zoom = <?= $empresa->zoom ?>;

    var ubicacion; var posEmpty = (lat == "0" && lat == "0");
    if(posEmpty)
    {
      ubicacion = {lat: 24.1560629, lng: -102.7119223};
    } else {
      ubicacion = {lat: lat, lng: lng};
    }
    map = new google.maps.Map(document.getElementById('map'), {
      zoom: zoom,
      center: ubicacion
    });

    //if(!posEmpty){
    if(true){
      var marker = new google.maps.Marker({
        position: ubicacion,
        map: map,
        title: "<?= $empresa->nombre ?>",
      });
      markers.push(marker);
    }
    
    if(<?= $this->session->privilegios['administrar_empresas'] ?>){
      google.maps.event.addListener(map, 'click', function(e) {
        deleteMarkers();
        placeMarker(e.latLng, map);
      });
    }




    var card = document.getElementById('pac-card');
    var input = document.getElementById('pac-input');
    //var types
    //var strictBounds

    map.controls[google.maps.ControlPosition.TOP_RIGHT].push(card);

    var autocomplete = new google.maps.places.Autocomplete(input);

    autocomplete.bindTo('bounds', map);

    // Set the data fields to return when the user selects a place.
    autocomplete.setFields(
        ['address_components', 'geometry', 'icon', 'name']);

    var infowindow = new google.maps.InfoWindow();
    var infowindowContent = document.getElementById('infowindow-content');
    infowindow.setContent(infowindowContent);


    autocomplete.addListener('place_changed', function() {
      infowindow.close();
      marker.setVisible(false);
      var place = autocomplete.getPlace();
      if (!place.geometry) {
        // User entered the name of a Place that was not suggested and
        // pressed the Enter key, or the Place Details request failed.
        window.alert("No details available for input: '" + place.name + "'");
        return;
      }

      // If the place has a geometry, then present it on a map.
      if (place.geometry.viewport) {
        map.fitBounds(place.geometry.viewport);
      } else {
        map.setCenter(place.geometry.location);
        map.setZoom(17);  // Why 17? Because it looks good.
      }
      marker.setPosition(place.geometry.location);
      marker.setVisible(true);

      var address = '';
      if (place.address_components) {
        address = [
          (place.address_components[0] && place.address_components[0].short_name || ''),
          (place.address_components[1] && place.address_components[1].short_name || ''),
          (place.address_components[2] && place.address_components[2].short_name || '')
        ].join(' ');
      }

      infowindowContent.children['place-icon'].src = place.icon;
      infowindowContent.children['place-name'].textContent = place.name;
      infowindowContent.children['place-address'].textContent = address;
      infowindow.open(map, marker);
    });


  }








    function placeMarker(position, map) {
      var marker = new google.maps.Marker({
        position: position,
        map: map,
        title: "<?= $empresa->nombre ?>",
      });
      markers.push(marker);
    }

    // Removes the markers from the map, but keeps them in the array.
    function clearMarkers() {
      for (var i = 0; i < markers.length; i++) {
        markers[i].setMap(null);
      }
    }

    // Deletes all markers in the array by removing references to them.
    function deleteMarkers() {
      clearMarkers();
      markers = [];
    }

    function guardarUbicacion(){
      var lat = markers[0].getPosition().lat();
      var lng = markers[0].getPosition().lng();
      var zoom = map.getZoom();

      $.ajax({
        type: "POST",
        url: '<?= base_url('empresas/editarUbicacion_ajax') ?>',
        data: { 'id' : '<?= $empresa->id ?>', 'lat' : lat, 'lng' : lng, 'zoom' : zoom },
        success: function(result){
          if(result){
            new PNotify({ title: 'Ubicación', text: 'Se ha editado Ubicación', type: 'success', styling: 'bootstrap3' });
          } else {
            new PNotify({ title: 'ERROR', text: 'Error al editar Ubicación', type: 'error', styling: 'bootstrap3' });
          }
        },
        error: function(data){
          new PNotify({ title: 'ERROR', text: 'Error al editar Ubicación', type: 'error', styling: 'bootstrap3' });
        },
      });
    }

    var Foto = '<?= $empresa->foto; ?>';
    function readIMG(input) {
        if (input.files && input.files[0]) {
          //Foto = input.files[0];
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#imgEmpresa').attr('src', e.target.result);//.width(280).height(220);
            };

            reader.readAsDataURL(input.files[0]);
        }
        $('#modalFoto').modal('hide');
        $('#btnGuardarFoto').fadeIn();
    }

    function fotoDefault() {
        _("iptFoto").value="";
        $('#imgEmpresa').attr('src', '<?= base_url('data/empresas/fotos/default.png') ?>');
        $('#modalFoto').modal('hide');
        $('#btnGuardarFoto').fadeIn();
    }

    function subirFoto(){
      var formdata = new FormData();
      formdata.append("iptFoto", _("iptFoto").files[0]);
      formdata.append("id_empresa", '<?= $empresa->id ?>');
      formdata.append("fotoActual", Foto);

      var ajax = new XMLHttpRequest();
      ajax.addEventListener("load", function(e){ 
        //alert(e.target.responseText)
        if(e.target.responseText)
        {
          Foto = event.target.responseText;
          new PNotify({ title: 'Foto', text: 'Se ha modificado imagen de empresa', type: 'success', styling: 'bootstrap3' });
        }
      }, false);
      ajax.open("POST", "<?= base_url('empresas/subir_foto') ?>");
      ajax.send(formdata);
      _("iptFoto").value="";
      $('#btnGuardarFoto').fadeOut();
    }

    function notificaciones(){
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
    }

    function modalFile(){
      _("fileComments").value = "";
      $("#btnEditarComentarios").css('display','none');
      $("#btnSubirArchivo").css('display','block');
      $('#modalFile').modal();
    }

    function aceptar(){
      if($('#btnModalContacto')[0].innerHTML == "Agregar Contacto"){
        agregarContacto();
      } else {
        editarContacto();
      }
    }

    function numerarTabla(){
      var tab = $('#tablaContactos')[0];
      $(tab.rows).each(function(){
        if(this.rowIndex > 0){
          this.cells[0].innerHTML = this.rowIndex;
        }
      });
    }

    function modalShow() {
      $('#nombreContacto').val("");
      $('#telefonoContacto').val("");
      $('#ext').val("");
      $('#celularContacto').val("");
      $('#celularContacto2').val("");
      $('#correoContacto').val("");
      $('#puestoContacto').val("");
      $('#red_social').val("");
      $('#btnModalContacto')[0].innerHTML = "Agregar Contacto";
      $('#cbContactoActivo').iCheck('check');
      $('#cbContactoCotizable').iCheck('uncheck');
      $('#modalContacto').modal();
    }

    function getContacto(celda){
      currentFileId = celda.parentNode.parentNode.rowIndex;
      $.ajax({
          type: "POST",
          url: '<?= base_url('empresas/getContacto_json') ?>',
          data: { 'id' : celda.value },
          success: function(result){
            if(result) {
              var res = JSON.parse(result);
              $('#idContacto').val(res.id);
              $('#nombreContacto').val(res.nombre);
              $('#telefonoContacto').val(res.telefono);
              $('#ext').val(res.ext);
              $('#celularContacto').val(res.celular);
              $('#celularContacto2').val(res.celular2);
              $('#correoContacto').val(res.correo);
              $('#puestoContacto').val(res.puesto);
              $('#red_social').val(res.red_social);
              $('#btnModalContacto')[0].innerHTML = "Editar Contacto";
              $('#cbContactoActivo').iCheck(res.activo == "1" ? 'check' : 'uncheck');
              $('#cbContactoCotizable').iCheck(res.cotizable == "1" ? 'check' : 'uncheck');
              $('#optContactoPlanta').val(res.planta);
              $('#modalContacto').modal();
            }
          },
          error: function(data){
            console.log(data);
          },
        });
    }

    function agregarContacto(){
      var nombre = $('#nombreContacto').val();
      var telefono = $('#telefonoContacto').val();
      var ext = $('#ext').val();
      var celular = $('#celularContacto').val();
      var celular2 = $('#celularContacto2').val();
      var correo = $('#correoContacto').val();
      var puesto = $('#puestoContacto').val();
      var red_social = $('#red_social').val();
      var activo = $('#cbContactoActivo').is(':checked') ? "1" : "0";
      var cotizable = $('#cbContactoCotizable').is(':checked') ? "1" : "0";
      var planta = $('#optContactoPlanta').val();
      

      $.ajax({
          type: "POST",
          url: '<?= base_url('empresas/agregarContacto') ?>',
          data: { 'empresa' : '<?= $empresa->id ?>', 'nombre' : nombre, 'telefono' : telefono, 'ext' : ext, 'celular' : celular, 'celular2' : celular2, 'correo' : correo, 'puesto' : puesto, 'red_social' : red_social, activo : activo, cotizable : cotizable, planta : planta },
          success: function(result){
            if(result){
              var res = JSON.parse(result);
              var tab = $('#tablaContactos')[0];
              var ren = tab.insertRow(tab.rows.length);
              if(res.activo != "1")
              {
                ren.style = "color: red;";
              }
              ren.insertCell(0).innerHTML = tab.rows.length - 1;
              ren.insertCell(1).innerHTML = res.nombre;
              ren.insertCell(2).innerHTML = res.telefono;
              ren.insertCell(3).innerHTML = res.celular;
              ren.insertCell(4).innerHTML = res.correo;
              ren.insertCell(5).innerHTML = res.puesto;
              ren.insertCell(6).innerHTML = "<button onclick='getContacto(this)' class='btn btn-warning btn-xs' value='" + res.id + "'><i class='fa fa-pencil'></i> Editar</button> <button onclick='deleteContacto(this)' value='" + res.id + "' class='btn btn-danger btn-xs'><i class='fa fa-trash'></i> Eliminar</button>";
              new PNotify({ title: 'Nuevo Contacto', text: 'Se ha agregado Contacto con Éxito', type: 'success', styling: 'bootstrap3' });
            } else {
              new PNotify({ title: 'ERROR', text: 'Error al agregar Contacto', type: 'error', styling: 'bootstrap3' });
            }
          },
          error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error al agregar Contacto', type: 'error', styling: 'bootstrap3' });
            console.log(data);
          },
        });

        
    }

    function editarContacto(){
      var id = $('#idContacto').val(); $('#idContacto').val("");
      var nombre = $('#nombreContacto').val(); $('#nombreContacto').val("");
      var telefono = $('#telefonoContacto').val(); $('#telefonoContacto').val("");
      var ext = $('#ext').val(); $('#ext').val("");
      var celular = $('#celularContacto').val(); $('#celularContacto').val("");
      var celular2 = $('#celularContacto2').val(); $('#celularContacto2').val("");
      var correo = $('#correoContacto').val(); $('#correoContacto').val("");
      var puesto = $('#puestoContacto').val(); $('#puestoContacto').val("");
      var red_social = $('#red_social').val(); $('#red_social').val("");
      var activo = $('#cbContactoActivo').is(':checked') ? "1" : "0";
      var cotizable = $('#cbContactoCotizable').is(':checked') ? "1" : "0";
      var planta = $('#optContactoPlanta').val();
      
      $.ajax({
          type: "POST",
          url: '<?= base_url('empresas/editarContacto') ?>',
          data: { 'id' : id, 'nombre' : nombre, 'telefono' : telefono, 'ext' : ext, 'celular' : celular, 'celular2' : celular2, 'correo' : correo, 'puesto' : puesto, 'red_social' : red_social, activo : activo, cotizable : cotizable, planta : planta },
          success: function(result){
            if(result){
              var res = JSON.parse(result);
              var tab = $('#tablaContactos')[0];
              var ren = currentFileId;
              if(res.activo != "1"){
                tab.rows[ren].style = "color: red;";
              }
              else{
                tab.rows[ren].style = "color: none;";
              }
              tab.rows[ren].cells[1].innerHTML = res.nombre;
              tab.rows[ren].cells[2].innerHTML = res.telefono;
              tab.rows[ren].cells[3].innerHTML = res.celular;
              tab.rows[ren].cells[4].innerHTML = res.correo;
              tab.rows[ren].cells[5].innerHTML = res.puesto;
              new PNotify({ title: 'Contacto', text: 'Se ha editado Contacto con Éxito', type: 'success', styling: 'bootstrap3' });
            } else {
              new PNotify({ title: 'ERROR', text: 'Error al editar Contacto', type: 'error', styling: 'bootstrap3' });
            }
          },
          error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error al editar Contacto', type: 'error', styling: 'bootstrap3' });
            console.log(data);
          },
        });
    }

    function deleteContacto(btn){
      if(confirm("¿Desea eliminar contacto?")){
        $.ajax({
          type: "POST",
          url: '<?= base_url('empresas/deleteContacto_json') ?>',
          data: { 'id' : btn.value },
          success: function(result){
            if(result) {
              var ren = btn.parentNode.parentNode.rowIndex;
              var tab = $('#tablaContactos')[0]; var ren = tab.deleteRow(ren);
              numerarTabla();
              new PNotify({ title: 'Contacto', text: 'Se ha eliminado Contacto con Éxito', type: 'success', styling: 'bootstrap3' });
            } else {
              new PNotify({ title: 'ERROR', text: 'Error al eliminar Contacto', type: 'error', styling: 'bootstrap3' });
            }
          },
          error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error al eliminar Contacto', type: 'error', styling: 'bootstrap3' });
            console.log(data);
          },
        });

        
      }
    }
    

    

    //////////////  UPLOAD  //////////////

    function cargarArchivos(){
        $('#tablaArchivos tbody tr').remove();

        var URL = base_url + "empresas/ajax_getArchivos";

        var txt = $('#txtBuscarArchivos').val().trim();
        
        $.ajax({
            type: "POST",
            url: URL,
            data: { empresa : ID_EMPRESA, texto : txt },
            success: function (response) {
                if(response){
                    var rs = JSON.parse(response);
                    var tabla = $('#tablaArchivos tbody')[0];

                    $.each(rs, function (i, elem) { 
                        var row = tabla.insertRow();

                        row.insertCell().innerHTML = tabla.rows.length;
                        row.insertCell().innerHTML = "<img style='border: 0px;' src='" + File_image(elem.nombre) + "' class='avatar'>";
                        row.insertCell().innerHTML = "<a>" + elem.nombre + "</a><br/><small>Agregado: " + moment(elem.fecha).format('YYYY-MM-D h:mm:ss a') + "</small>";
                        row.insertCell().innerHTML = "<a>" + elem.User + "</a>";
                        row.insertCell().innerHTML = "<a>" + elem.comentarios + "</a>";
                        var op = "<a href='" + base_url + 'data/empresas/archivos/' + ID_EMPRESA + '/' + elem.nombre + "' class='btn btn-primary btn-xs'><i class='fa fa-download'></i> Abrir </a>";
                        if(PRIVILEGIOS.administrar_empresas == "1")
                        {
                          op += "<button onclick='getComentarioArchivo(this)' class='btn btn-info btn-xs' value='" + elem.id + "'><i class='fa fa-pencil'></i> Editar </button>";
                          op += "<button onclick='deleteArchivo(this)' class='btn btn-danger btn-xs' value='" + elem.id + "'><i class='fa fa-trash-o'></i> Borrar </button>";
                        }
                        row.insertCell().innerHTML = op;
                    });
                    


                }
            }
        });
    }

    function _(el){
      return document.getElementById(el);
    }
    
    var currentFileRow; var currentFileName; var currentFileImage;
    function insertFileRow(file, comm){
      var tabla = $('#tablaArchivos tbody')[0];
      var row = tabla.insertRow();
      row.insertCell().innerHTML = tabla.rows.length;
      currentFileImage = row.insertCell();
      currentFileImage.innerHTML = "<img style='border: 0px;' src='<?= base_url('template/images/files/file.png') ?>' class='avatar'>";

      currentFileName = row.insertCell();
      currentFileName.innerHTML = "<a>" + file + "</a><br/><small>Subiendo Archivo...</small><div class='progress progress_sm'><div class='progress-bar bg-green' role='progressbar' data-transitiongoal='0'></div></div>";
      row.insertCell().innerHTML = "<a><?= $this->session->nombre ?></a>";
      row.insertCell().innerHTML = "<a>" + comm + "</a>";
      currentFileButtons = row.insertCell();
      currentFileButtons.innerHTML = "<a href='#' class='btn btn-default btn-xs'><i class='fa fa-clock-o'></i> Subiendo... </a>";
    }

    function uploadFile(){
      //alert(file.name+" | "+file.size+" | "+file.type);
      var file = _("userfile").files[0];
      var comm = _("fileComments");
      insertFileRow(file.name, comm.value);

      var formdata = new FormData();
      formdata.append("userfile", file);
      formdata.append("id", '<?= $empresa->id ?>');
      formdata.append("comentarios", comm.value);
      comm.value = "";

      var ajax = new XMLHttpRequest();
      ajax.upload.addEventListener("progress", progressHandler, false);
      ajax.addEventListener("load", completeHandler, false);
      ajax.addEventListener("error", errorHandler, false);
      ajax.addEventListener("abort", abortHandler, false);
      ajax.open("POST", "<?= base_url('empresas/subir_archivo') ?>");
      ajax.send(formdata);
      _("userfile").value = "";
    }
    function progressHandler(event){
      var percent = (event.loaded / event.total) * 100;
      $(".progress-bar").attr('aria-valuenow', Math.round(percent)).css('width', Math.round(percent)+ '%');
    }
    function completeHandler(event){
      var res = JSON.parse(event.target.responseText);
      $('.progress').fadeOut();
      currentFileImage.innerHTML = "<img style='border: 0px;' src='" + res.icono + "' class='avatar'>";
      currentFileName.innerHTML = "<a>" + res.nombre + "</a><br/><small>Agregado: " + res.fecha + "</small>";
      currentFileButtons.innerHTML = "<a href='<?= base_url('data/empresas/archivos/' . $empresa->id . '/') ?>" + res.nombre + "' class='btn btn-primary btn-xs'><i class='fa fa-download'></i> Abrir </a> <button onclick='getComentarioArchivo(this)' value='" + res.id + "' class='btn btn-info btn-xs'><i class='fa fa-pencil'></i> Editar </a> <button onclick='deleteArchivo(this)' value='" + res.id + "' class='btn btn-danger btn-xs'><i class='fa fa-trash-o'></i> Borrar </button>";
      $(".progress-bar").attr('aria-valuenow', 0).css('width', 0);
    }
    function errorHandler(event){
      alert('ERROR');
    }
    function abortHandler(event){
      alert('ABORT');
    }

    function deleteArchivo(btn){
      if(confirm("¿Desea eliminar archivo?")){

        var ren = btn.parentNode.parentNode.rowIndex;
        var tab = $('#tablaArchivos')[0];
        var nombre_archivo = tab.rows[ren].cells[2].children[0].innerHTML;
        $.ajax({
          type: "POST",
          url: '<?= base_url('empresas/deleteArchivo_json') ?>',
          data: { 'id' : btn.value, 'id_empresa' : '<?= $empresa->id ?>', 'nombre_archivo' : nombre_archivo },
          success: function(result){
            if(result) {
              tab.deleteRow(ren);
              //numerarTabla();
              new PNotify({ title: 'Archivo', text: 'Se ha eliminado Archivo con Éxito', type: 'success', styling: 'bootstrap3' });
            } else {
              new PNotify({ title: 'ERROR', text: 'Error al eliminar Archivo', type: 'error', styling: 'bootstrap3' });
            }
          },
          error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error al eliminar Archivo', type: 'error', styling: 'bootstrap3' });
            console.log(data);
          },
        });
      }
    }

    function editArchivo(){
      var comm = _("fileComments").value;
      var tab = $('#tablaArchivos')[0];
      var idFile = tab.rows[currentFileRow].cells[5].children[2].value;

      $.ajax({
          type: "POST",
          url: '<?= base_url('empresas/editArchivo_json') ?>',
          data: { 'id' : idFile, 'comentarios' : comm },
          success: function(result){
            if(result) {
              tab.rows[currentFileRow].cells[4].children[0].innerHTML = comm;
              new PNotify({ title: 'Archivo', text: 'Se ha editado Archivo con Éxito', type: 'success', styling: 'bootstrap3' });
            } else {
              new PNotify({ title: 'ERROR', text: 'Error al editar Archivo', type: 'error', styling: 'bootstrap3' });
            }
          },
          error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error al editar Archivo', type: 'error', styling: 'bootstrap3' });
            console.log(data);
          },
        });
    }

    function getComentarioArchivo(btn){
      currentFileRow = btn.parentNode.parentNode.rowIndex;
      var tab = $('#tablaArchivos')[0];
      var comments = tab.rows[currentFileRow].cells[4].children[0].innerHTML;
      _("fileComments").value = comments;
      
      $("#btnEditarComentarios").css('display','block');
      $("#btnSubirArchivo").css('display','none');
      $('#modalFile').modal();
    }
    
    ///////// REQUISITOS ////////
    function seleccionarRequisito(btn, detalle){
      //alert(detalle);
      var ren = $(btn).parent().parent()[0];
      $(btn).hide();
      $('#tablaSelectRequisitos tbody tr').not(ren).remove();
      if(detalle) {
        $('#formRequisitos').append('<center><p>Agregar detalles de requisito</p><textarea id="txtDetalles" style="width: 70%"></textarea></center>');
      }
      $('#formRequisitos').append('<br><center><button type="button" data-dismiss="modal" class="btn btn-default">Cancelar</button><button type="button" onclick="subirRequisito(this)" value="' + btn.value + '" class="btn btn-primary">Aceptar</button></center>');
    }

    function subirRequisito(btn){
      var requisito = btn.value;
      var detalles = $('#txtDetalles').val();
      if(detalles == null){
        detalles = "N/A";
      }

      $.ajax({
          type: "POST",
          url: '<?= base_url('empresas/setRequisitos_json') ?>',
          data: { 'id_empresa' : '<?= $empresa->id ?>', 'requisito' : requisito, 'detalles' : detalles, 'tipo' : tipoRequisito },
          success: function(result) {
            if(result) {
              var res = JSON.parse(result);
              var tab = $('#' + tableName + ' tbody')[0];
              
              var ren = tab.insertRow(tab.rows.length);
              ren.insertCell().innerHTML = tab.rows.length;
              ren.insertCell().innerHTML = res.requisito;
              ren.insertCell().innerHTML = res.detalles;
              ren.insertCell().innerHTML = "<button onclick='deleteRequisito(this)' class='btn btn-danger btn-xs' value='" + res.id + "'><i class='fa fa-trash-o'></i> Borrar </button>";

              $('#modalRequisitos').modal('hide');
              new PNotify({ title: 'Nuevo Requisito', text: 'Se ha agregado Requisito de facturación', type: 'success', styling: 'bootstrap3' });
              } else {
                new PNotify({ title: 'ERROR', text: 'Error al agregar Requisito', type: 'error', styling: 'bootstrap3' });
              }
            },
          error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error al editar Contacto', type: 'error', styling: 'bootstrap3' });
            console.log(data);
          },
        });
    }

    function deleteRequisito(btn){
      if(confirm("¿Desea eliminar requisito?")){
        var tab = $(btn).closest('table')[0];
        $.ajax({
          type: "POST",
          url: '<?= base_url('empresas/deleteRequisito_json') ?>',
          data: { 'id' : btn.value },
          success: function(result){
            if(result) {
              var ren = btn.parentNode.parentNode.rowIndex;
              //var tab = $('#tablaRequisitos')[0];
              var ren = tab.deleteRow(ren);
              //numerarTabla();
              new PNotify({ title: 'Requisito', text: 'Se ha eliminado Requisito con Éxito', type: 'success', styling: 'bootstrap3' });
            } else {
              new PNotify({ title: 'ERROR', text: 'Error al eliminar Requisito', type: 'error', styling: 'bootstrap3' });
            }
          },
          error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error al eliminar Requisito', type: 'error', styling: 'bootstrap3' });
            console.log(data);
          },
        });
      }
    }

    var tipoRequisito; var tableName;
    function modalRequisitos(tipo){
      
      tipoRequisito = tipo;
      
      if(tipo == 'LOGISTICA')
      {
        tableName = 'tablaRequisitosLogistica';
        tipo = "LOGISTICA/OPERACIONES";
      }
      if(tipo == 'OPERACIONES')
      {
        tableName = 'tablaRequisitosOperaciones';
        tipo = "LOGISTICA/OPERACIONES";
      }
      if(tipo == 'FACTURACION')
      {
        tableName = 'tablaRequisitos';
      }


      $('#formRequisitos').children().not(':first').remove();
      $('#tablaSelectRequisitos tbody tr').remove();
      $.ajax({
          type: "POST",
          url: '<?= base_url('empresas/getRequisitos_json') ?>',
          data: { 'tipo' : tipo },
          success: function(result) {
            if(result) {
              var res = JSON.parse(result);
              $.each(res, function(i, elem) {
                  var renglon = $('#tablaSelectRequisitos tbody')[0].insertRow();
                  renglon.insertCell().innerHTML = elem.requisito;
                  renglon.insertCell().innerHTML = "<button type='button' onclick=seleccionarRequisito(this," + elem.detalle + ") class='btn btn-primary btn-sm' value='" + elem.requisito + "'><i class='fa fa-plus'></i> Agregar</button>";
              });
            }
          },
        });

      $('#modalRequisitos').modal();
    }

    //////////////////////// P R O V E E D O R ////////////////////////

    function guardarProveedor(){
      $('#btnGuardarProveedor').fadeOut('slow');

      var tipo = [];
      if($("#cbProductos").is(":checked"))
      {
        tipo.push($("#cbProductos").val());
      }
      if($("#cbServicios").is(":checked"))
      {
        tipo.push($("#cbServicios").val());
      }

      var formas_pago = [];
      if($("#cbMC").is(":checked"))
      {
        formas_pago.push($("#cbMC").val());
      }
      if($("#cbVS").is(":checked"))
      {
        formas_pago.push($("#cbVS").val());
      }
      if($("#cbAE").is(":checked"))
      {
        formas_pago.push($("#cbAE").val());
      }
      if($("#cbTR").is(":checked"))
      {
        formas_pago.push($("#cbTR").val());
      }
      if($("#cbCQ").is(":checked"))
      {
        formas_pago.push($("#cbCQ").val());
      }
      if($("#cbEF").is(":checked"))
      {
        formas_pago.push($("#cbEF").val());
      }

      var credito = $("#cbCredito").is(":checked") ? 1 : 0;
      var montoCredito = $('#txtCredito').val();
      var monedaCredito = $("#optMoneda").val();
      var terminosPago = $("#optTerminosPago").val();
      var clasificacion_proveedor = $('#txtClasificacionProveedor').val().trim();

      var rma_requerido = $("#cbRMA").is(":checked") ? 1 : 0;

      var formas_compra = [];
      if($("#cbOnline").is(":checked"))
      {
        formas_compra.push($("#cbOnline").val());
      }
      if($("#cbPresencial").is(":checked"))
      {
        formas_compra.push($("#cbPresencial").val());
      }
      if($("#cbEmail").is(":checked"))
      {
        formas_compra.push($("#cbEmail").val());
      }


      var entrega = $("input[name='cbEntrega']:checked").val();

      /*
      if($("#cbMexico").is(":checked"))
      {
        entrega.push($("#cbMexico").val());
      }
      if($("#cbUsa").is(":checked"))
      {
        entrega.push($("#cbUsa").val());
      }
      */

      var pasos_cotizacion = [];
      var rs = $("#tblPasosCotizar tr");
      $.each(rs, function(i, elem){
        var paso = $(elem).children()[0];
        pasos_cotizacion.push(paso.innerHTML);
      });

      var pasos_compra = [];
      var rs = $("#tblPasosComprar tr");
      $.each(rs, function(i, elem){
        var paso = $(elem).children()[0];
        pasos_compra.push(paso.innerHTML);
      });


      var aprobado = $("#cbAprobado").is(":checked") ? 1 : 0;
      var tags = $("#tags_1").val();


      $.ajax({
          type: "POST",
          url: '<?= base_url('empresas/ajax_setProveedor') ?>',
          data: { 'id_empresa' : '<?= $empresa->id ?>', 'tipo' : JSON.stringify(tipo), 'clasificacion_proveedor' : clasificacion_proveedor, 'formas_pago' : JSON.stringify(formas_pago), 'credito' : credito, 'rma_requerido' : rma_requerido, 'monto_credito' : montoCredito, 'terminos_pago' : terminosPago, 'formas_compra' : JSON.stringify(formas_compra), 'moneda_credito' : monedaCredito, 'entrega' : entrega, 'aprobado' : aprobado, 'tags' : tags, pasos_cotizacion : JSON.stringify(pasos_cotizacion), pasos_compra : JSON.stringify(pasos_compra) },
          success: function(result) {
            
            if(result) {
              new PNotify({ title: 'Proveedor', text: 'Se han guardado cambios', type: 'success', styling: 'bootstrap3' });
            }
            else{
              new PNotify({ title: 'ERROR', text: 'Error al guardar cambios', type: 'error', styling: 'bootstrap3' });
            }
          },
          error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error al guardar cambios', type: 'error', styling: 'bootstrap3' });
            console.log(data);
          },
      });
      


    }  

    function guardarCotizaciones(){
      $('#btnGuardarCotizaciones').fadeOut('slow');

      var cliente = {};
      cliente.moneda = [];
      if($("#cbCotizacionMXN").is(":checked"))
      {
        cliente.moneda.push($("#cbCotizacionMXN").val());
      }
      if($("#cbCotizacionUSD").is(":checked"))
      {
        cliente.moneda.push($("#cbCotizacionUSD").val());
      }

      cliente.iva = {};
      cliente.iva.nombre = $('#opCotizacionIva option:selected').data('nombre');
      cliente.iva.factor = $('#opCotizacionIva').val();

      $.ajax({
          type: "POST",
          url: '<?= base_url('empresas/ajax_setCotizaciones') ?>',
          data: { 'id' : '<?= $empresa->id ?>', 'data' : JSON.stringify(cliente) },
          success: function(result) {
            if(result) {
              new PNotify({ title: 'Proveedor', text: 'Se han guardado cambios', type: 'success', styling: 'bootstrap3' });
            }
            else{
              new PNotify({ title: 'ERROR', text: 'Error al guardar cambios', type: 'error', styling: 'bootstrap3' });
            }
          },
          error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error al guardar cambios', type: 'error', styling: 'bootstrap3' });
            console.log(data);
          },
      });
      


    }

    //////////////////////// C O T I Z A C I O N E S ////////////////////////

    function mdlContactosCotizacion(){
      $('#tblSelectContacto tbody tr').remove();
      
      var conRows = $('#tblContactoCotizacion tbody tr');
      var contactosActuales = [];
      $.each(conRows, function (i, elem) { 
         contactosActuales.push($(elem).data('id'));
      });

      $.ajax({
          type: "POST",
          url: base_url + 'empresas/ajax_getContactosCotizacion',
          data: { empresa : ID_EMPRESA },
          success: function(result)
          {
              var tbl = $('#tblSelectContacto tbody')[0];
              var rs = JSON.parse(result);
              $.each(rs, function(i, elem){
                  var row = tbl.insertRow();
                  row.dataset.id = elem.id;
                  row.dataset.nombre = elem.nombre;
                  row.dataset.planta = elem.planta == 0 ? '(GLOBAL)' : elem.Planta;

                  row.insertCell().innerHTML = elem.nombre;
                  row.insertCell().innerHTML = row.dataset.planta;
                  row.insertCell().innerHTML = contactosActuales.includes(parseInt(elem.id)) ? '<button type="button" class="btn btn-xs btn-success"><i class="fa fa-check"></i> Asignado</button>' : '<button onclick="agregarContactoCotizacion(this)" type="button" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i> Agregar</button>';
              }); 
          },
          error: function(data){
              console.log(data);
          },
      });

      $('#mdlContactosCotizacion').modal();
      
    }

    function agregarContactoCotizacion(btn){
      var tr = $(btn).closest('tr');
      var id = $(tr).data('id');
      var nombre = $(tr).data('nombre');
      var planta = $(tr).data('planta');

      $('#mdlContactosCotizacion').modal('hide');

      var tbl = $('#tblContactoCotizacion tbody')[0];
      var row = tbl.insertRow();
      row.dataset.id = id;
      row.dataset.nombre = nombre;

      row.insertCell().innerHTML = nombre;
      row.insertCell().innerHTML = planta;
      row.insertCell().innerHTML = '<button onclick="eliminarContactoCotizacion(this)" type="button" class="btn btn-xs btn-danger coti"><i class="fa fa-trash"></i> Eliminar</button>';

      $("#btnGuardarCotizaciones").fadeIn('slow');
    }

    function cargarContactoCotizacion(){

      var contactos = JSON.parse('<?= $empresa->contacto_cotizacion ?>');
      var URL = base_url + 'empresas/ajax_getContacto'

      $.each(contactos, function (i, id) { 
         
        $.ajax({
        type: "POST",
        url: URL,
        data: { id : id },
        success: function (response) {
            var rs = JSON.parse(response);
            var tbl = $('#tblContactoCotizacion tbody')[0];
            var row = tbl.insertRow();
            row.dataset.id = rs.id;
            row.dataset.nombre = rs.nombre;
            row.dataset.planta = rs.planta == 0 ? '(GLOBAL)' : rs.Planta;

            row.insertCell().innerHTML = rs.nombre;
            row.insertCell().innerHTML = row.dataset.planta;
            row.insertCell().innerHTML = PRIVILEGIOS.administrar_parametros_cotizacion == 1 ? '<button onclick="eliminarContactoCotizacion(this)" type="button" class="btn btn-xs btn-danger coti"><i class="fa fa-trash"></i> Eliminar</button>' : ''; 
          }
        });
      });
    }

    function eliminarContactoCotizacion(btn){
      $(btn).closest('tr').remove();
      $("#btnGuardarCotizaciones").fadeIn('slow');
    }




    </script>

  </body>
</html>
