<!-- page content -->
<div class="right_col" role="main">
    <div class="">

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Requerimientos</h2>
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

                                <p style="display: inline;">
                                    XXXX:
                                    <input type="radio" class="flat" name="rbBusqueda" id="rbCodigo" value="codigo" checked />
                                    XXXX:
                                    <input type="radio" class="flat" name="rbBusqueda" id="rbContenido" value="contenido" />
                                </p>

                                <input id="txtBusqueda" style="display: inline;" type="text">



                                <button onclick="buscar()" style="display: inline;" class="btn btn-success" type="button"><i class="fa fa-search"></i> Buscar</button>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_content">
                    <div class="table-responsive">
                        <a href=<?= base_url("requerimientos/crear_requerimiento") ?> class="btn btn-primary btn-xs"><i class='fa fa-plus'></i> Nuevo Requerimiento</a>
                        <table id="tabla" class="table table-striped">
                            <thead>
                                <tr class="headings">
                                    <th class="column-title">#</th>
                                    <th class="column-title">Fecha</th>
                                    <th class="column-title">Usuario</th>
                                    <th class="column-title">Tipo</th>
                                    <th class="column-title">Descripción del instrumento</th>
                                    <th class="column-title">Estatus</th>
                                </tr>
                            </thead>
                            <tbody>
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





<!-- MODALS -->
<div id="mdlAlta" class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="lblCodigo"></h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="col-xs-6">
                        <label>Magnitud</label>   
                        <select style="width:90%;" required="required" class="select2_single form-control" id="opMagnitud">
                        </select>
                    </div>
                    
                    <!-- -->
                    <div class="col-xs-6">
                        <label style="margin-top: 10px; display: block;">Sitio</label>
                        <p style="margin-left: 10px; display: inline;">
                            On-Site:
                            <input type="checkbox" class="flat" name="cbSitio" id="cbOS" value="OS" checked/>
                            Laboratorio:
                            <input type="checkbox" class="flat" name="cbSitio" id="cbLab" value="LAB"/>
                        </p>
                    </div>

                    <div style="margin-top: 10px;" class="col-xs-12">
                        <label>Descripción</label>
                        <textarea maxlength="3000" style="height: 60px; resize: none;" id="txtDescripcion" required="required" class="form-control"></textarea>
                    </div>

                    <div style="padding:10px;" class="row">
                        <div style="margin-top: 10px;" class="col-xs-6">
                            <label style="display: block;">Tipo</label>
                            <p style="margin-left: 5px;">
                                Estandar: 
                                <input type="radio" class="flat" name="rbTipo" id="rbEstandar" value="ESTANDAR" checked/>
                                Especial:
                                <input type="radio" class="flat" name="rbTipo" id="rbEspecial" value="ESPECIAL"/>
                            </p>
                        </div>
                        

                        <div id="divServicioLigado" style="margin-top: 10px; display: none;" class="col-xs-6">
                            <label style="display: block;">Servicio estandar de origen: <button type='button' onclick="mdlServiciosEstandar()" class='btn btn-primary btn-xs'> <i class='fa fa-spinner'></i></button></label>
                            <p id="lblServicioLigado">
                                
                            </p>
                        </div>
                    </div>

   
                    <div style="padding:10px;" class="row">
                        <div style="margin-top: 10px;" class="col-xs-6">
                            <label style="display: block;">Interno / Externo</label>
                            <p style="margin-left: 5px;">
                                Interno:
                                <input type="radio" class="flat" name="rbIntExt" id="cbInterno" value="1"/>
                                Externo:
                                <input type="radio" class="flat" name="rbIntExt" id="cbExterno" value="0"/>
                            </p>
                        </div>

                        <div id="divProveedor" style="margin-top: 10px; display: none;" class="col-xs-6">
                            <label style="display: block;">Proveedor Sugerido</label>
                            <input id="txtProveedor" class="form-control" type="text">
                        </div>
                    </div>

                    <div style="margin-top: 10px;" class="col-xs-12">
                        <label>Observaciones</label>
                        <textarea maxlength="3000" style="height: 60px; resize: none;" id="txtObservaciones" required="required" class="form-control"></textarea>
                    </div>

                    

                    <div style="margin-top: 10px;" class="col-xs-6">
                        <label style="display: block;">Tipo de calibración</label>
                        <p style="margin-left: 5px;">
                            Acreditada: 
                            <input type="radio" class="flat" name="rbTipoCal" id="rbCalAcreditada" value="ACREDITADA" checked/>
                            Trazable:
                            <input type="radio" class="flat" name="rbTipoCal" id="rbCalTrazable" value="TRAZABLE"/>
                        </p>
                    </div>

                    

                    
                    <div class="col-xs-6">
                        <label style="margin-top: 10px;">Rango de Precios</label>
                        <select required="required" class="select2_single form-control" id="opPrecios">
                        </select>
                    </div>

                    <div class="col-xs-12">
                        <label style="margin-top: 10px;">Tags</label>
                        <input id="tags_1" type="text" class="form-control"/>
                    </div>

                    <div class="col-xs-6">
                        <label style="margin-top: 10px; display: block;">Servicio Activo / Inactivo</label>
                        <p style="margin-left: 10px; display: inline;">
                            Activo:
                            <input type="checkbox" class="flat" id="cbActivo" value="1"/>
                        </p>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button id="btnCancelar" type="button" data-dismiss="modal" class="btn btn-default pull-left"><i class="fa fa-close"></i> Cancelar</button>
                <button id="btnEditar" type="button" onclick="modificar(this)" class="btn btn-warning"><i class='fa fa-pencil'></i> Editar</button>
                <button id="btnAgregar" type="button" onclick="agregar()" class="btn btn-primary"><i class='fa fa-plus'></i> Agregar</button>
            </div>
            

        </div>
    </div>
</div>

<div id="mdlServiciosEstandar" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title" id="mdlServiciosEstandar-titulo"></h4>
            </div>
            <div class="modal-body">
            <form>
                <table id="tblServiciosEstandar" class="table table-striped">
                    <thead>
                        <tr class="headings">
                            <th class="column-title">Código</th>
                            <th class="column-title">Descripción</th>
                            <th class="column-title">Opciones</th>
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


<div id="mdlObservaciones" class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel2">Observaciones</h4>
            </div>
            <div class="modal-body">
            <form>
                <p id='lblObservaciones'></p>
            </form>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-primary"><i class="fa fa-check"></i> Aceptar</button>
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
<!-- jquery.redirect -->
<script src=<?= base_url("template/vendors/jquery.redirect/jquery.redirect.js"); ?>></script>
<!-- JS FILE -->
<script src=<?= base_url("application/views/requerimientos/js/catalogo.js"); ?>></script>
<script>
    var uid = '<?= $this->session->id ?>';
    var adm_ser = '<?= $this->session->privilegios['administrar_servicios'] ?>';

    $(function(){
        load();
    });


</script>
</body>
</html>
