<!-- page content -->
<div class="right_col" role="main">
    <div class="">

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Ver Requerimiento</h2>
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
                            <div class="col-md-3 col-sm-6 col-xs-12">

                                <label style="display: inline;">Requerimiento #:</label><h4 id="lblIdRequerimiento"></h4>
                                <label style="display: inline;">Fecha:</label><h4 id="lblFecha"></h4>

                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">

                                <label style="display: inline;">Usuario:</label><h4 id="lblUser"></h4>
                                <label style="display: inline;">Tipo:</label><h4 id="lblTipo"></h4>

                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">

                                <label style="display: inline;">Fabricante:</label><h4 id="lblFabricante"></h4>
                                <label style="display: inline;">Modelo:</label><h4 id="lblModelo"></h4>

                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">

                                <label style="display: inline;">Alcance:</label><h4 id="lblAlcance"></h4>
                                <label style="display: inline;">Resolucion:</label><h4 id="lblResolucion"></h4>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <label style="display: inline;">Descripción:</label><h4 id="lblDescripcion"></h4>
                            </div>

                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <label style="display: inline;">Grado:</label><h4 id="lblGrado"></h4>
                            </div>

                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <label style="display: block;">Estatus:</label> <!--<button type="button" class="btn btn-primary" id="btnEstatus"></button>-->
                                <div class="btn-group" id="divEstatus">
                                <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" aria-expanded="false" id="btnEstatus"></button>
                                    
                                </div>
                            </div>
   
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <label style="display: inline;">Requisitos Especiales:</label><h4 id="lblRequisitosEspeciales"></h4>
                            </div>

                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <label style="display: inline;">Exactitud:</label><h4 id="lblExactitud"></h4>
                            </div>

                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <!-- V A C I O -->
                            </div>
   
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <label style="display: inline;" id="lblCerrado"></label>
                                <h4 id="lblCerradoPor"></h4>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <label style="display: inline;" id="lblServicio"></label>
                                <h4 id="lblServicioCodigo"></h4>
                            </div>
   
                        </div>

                        <div style="margin-top: 50px;" class="row">
                        <div class="col-md-4 col-sm-4 col-xs-12">
                                <h3 style="display: inline; margin-right: 10px;"><i class="fa fa-users"></i> Evaluadores</h3>
                                <table id="tblEvaluadores" class="table table-striped">
                                    <thead>
                                        <tr class="headings">
                                            <th class="column-title">#</th>
                                            <th class="column-title">Foto</th>
                                            <th class="column-title">Nombre</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>

                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <h3 style="display: inline; margin-right: 10px;"><i class="fa fa-file-pdf-o"></i> Archivos</h3>
                                <label class="btn btn-default btn-xs" for="userfile">
                                <input accept="application/pdf" target="_blank" onchange="uploadFile();" type="file" class="sr-only" id="userfile" name="userfile">
                                    <i class="fa fa-file-o"></i> Subir Archivo
                                </label>
                                <table id="tblArchivos" class="table table-striped">
                                    <thead>
                                        <tr class="headings">
                                            <th class="column-title">Fecha</th>
                                            <th class="column-title">Nombre</th>
                                            <th class="column-title">Usuario</th>
                                            <th class="column-title">Comentarios</th>
                                            <th style="width: 20%;" class="column-title">Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>

                        </div>

                        <div style="margin-top: 10px;" class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <h3 style="display: inline; margin-right: 10px;"><i class="fa fa-comments-o"></i> Comentarios</h3>
                                <button class="btn btn-default btn-xs" type="button" onclick='mdlComentarios()'><i class='fa fa-plus'></i> Agregar</button>
                                <ul id='ulComments' class="list-unstyled msg_list">
                                <ul>
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
<div id="mdlArchivo" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Subir Archivo</h4>
            </div>
            <div class="modal-body">
                <form>
                    <label>Nombre</label>
                    <input id="txtNombreArchivo" class="form-control" type="text">

                    <label style="margin-top: 10px;">Comentarios</label>
                    <textarea style="height: 60px; resize: none;" id="txtComentarioArchivo" class="form-control"></textarea>
                </form>
            </div>
            <div class="modal-footer">
                <button id="btnCancelar" type="button" data-dismiss="modal" class="btn btn-default btn-sm pull-left"><i class="fa fa-close"></i> Cancelar</button>
                <button id="btnAgregar" type="button" onclick="subirArchivo()" class="btn btn-primary btn-sm"><i class='fa fa-check'></i> Aceptar</button>
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
                <h4 id="mdlComentarios-title"></h4>
            </div>
            <div class="modal-body">
                <form>
                    <label>Comentario</label>
                    <textarea style="height: 60px; resize: none;" id="txtComentarios" class="form-control"></textarea>
                    <div id="divEvaluadores">
                        <label style="margin-top: 10px;">Canalizar a:</label>
                        <select class="form-control" id="opEvaluadores">

                        </select>
                    </div>

                    <div id="divRespuesta">
                        <label style="margin-top: 10px;">Repuesta:</label>
                        <p>
                            Procede:
                            <input type="radio" class="flat" name="rbRespuesta" id="rbProcede"/>
                            No procede:
                            <input type="radio" class="flat" name="rbRespuesta" id="rbNoProcede"/>
                        </p>
                    </div>

                    <div style="margin-top:20px;" id="divServicios">
                        <center>
                            <button type="button" onclick="mdlServicios()" class="btn btn-success btn-xs"><i class="fa fa-search"></i> Servicios</button>
                        </center>
                        <table id="tblServices" class="table table-striped">
                        <thead>
                            <tr class="headings">
                                <th width="20%" class="column-title">Código</th>
                                <th class="column-title">Descripción</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="btnCancelar" type="button" data-dismiss="modal" class="btn btn-default btn-sm pull-left"><i class="fa fa-close"></i> Cancelar</button>
                <button id="btnRechazar" type="button" onclick="rechazar()" class="btn btn-danger btn-sm"><i class='fa fa-times-circle'></i> Rechazar</button>
                <button id="btnCanalizar" type="button" onclick="canalizar()" class="btn btn-info btn-sm"><i class='fa fa-reply'></i> Canalizar</button>
                <button id="btnResponder" type="button" onclick="responder()" class="btn btn-default btn-sm"><i class='fa fa-check'></i> Responder</button>
                <button id="btnAgregarComentario" type="button" onclick="setComentario()" class="btn btn-primary btn-sm"><i class='fa fa-check'></i> Aceptar</button>
            </div>
            

        </div>
    </div>
</div>

<div id="mdlServicios" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title" id="mdlServicios-titulo">Servicios</h4>
            </div>
            <div class="modal-body">
            <label>Buscar</label>
            <input id="txtBuscarServicio" class="form-control" type="text">
            <form>
                <table id="tblServicios" class="table table-striped">
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

<div id="mdlServicio" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title" id="mdlServicio-titulo"></h4>
            </div>
            <div class="modal-body">
            <form>
                <table id="tblServicio" class="table table-striped">
                    <thead>
                        <tr class="headings">
                            <th class="column-title">Código</th>
                            <th class="column-title">Magnitud</th>
                            <th style="width: 45%;" class="column-title">Descripción</th>
                            <th class="column-title">Sitio</th>
                            <th class="column-title">Tipo</th>
                            <th class="column-title">Calibración</th>
                            <th class="column-title">Interno</th>
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
<!-- CUSTOM JS FILE -->
<script src=<?=base_url("template/js/custom/funciones.js"); ?>></script>
<!-- JS FILE -->
<script src=<?= base_url("application/views/requerimientos/js/ver.js"); ?>></script>
<script>
    var ID = '<?= $id ?>';
    var IDU = '<?= $this->session->id ?>';
    var adm_evaluador = '<?= $this->session->privilegios['evaluar_requerimientos'] ?>';

    $(function(){
        load();
    });


</script>
</body>
</html>
