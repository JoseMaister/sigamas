<!-- page content -->
<div class="right_col" role="main">
    <div class="">

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Equipos de TI</h2>
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
                        <?php if($this->session->privilegios['administrar_equipos_it'] == "1") { ?>
                            <button onclick="mdlAlta()" class="btn btn-primary btn-xs"><i class='fa fa-plus'></i> Nuevo Equipo</button>
                        <?php } ?>
                            <table style="margin-bottom:60px;" id="tabla" class="table table-striped">
                                <thead>
                                    <tr class="headings">
                                        <th class="column-title" style="width: 7%;">Foto</th>
                                        <th class="column-title">ID</th>
                                        <th class="column-title">Tipo</th>
                                        <th class="column-title">Asignado a</th>
                                        <th class="column-title">Opciones</th>
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
<div id="mdlAlta" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="lblCodigo">NOMBRE EQUIPO</h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-xs-6">
                            <div style="margin-top: 5px;">
                                <label>Tipo</label>   
                                <select onchange="campos()" required="required" class="select2_single form-control" id="opTipo">
                                    <option value=""></option>
                                    <option value="Laptop">Laptop</option>
                                    <option value="Desktop">Desktop</option>
                                    <option value="Monitor">Monitor</option>
                                    <option value="Impresora">Impresora</option>
                                    <option value="Bateria">Bateria</option>
                                    <option value="Router">Router</option>
                                    <option value="Switch">Switch</option>
                                    <option value="Celular">Celular</option>
                                </select>
                            </div>

                            <div style="margin-top: 10px;">
                                <label>Foto</label>   
                                <div style="margin-bottom: 10px; class="profile_img">
                                  <div id="crop-avatar">
                                    <img style="width: 70%;" id="imgEquipo" class="usuario img-responsive avatar-view" src='<?= base_url("data/equipos/ti/fotos/default.png") ?>'>
                                  </div>
                                </div>
                                
                                <!--<button class='btn btn-primary btn-xs'><i class="fa fa-upload"></i> Subir Foto</button>-->
                                <label class="btn btn-primary btn-xs btn-foto" for="iptFoto">
                                    <input onchange="readIMG(this);" type="file" class="sr-only" id="iptFoto" name="iptFoto" accept="image/*">
                                    <i class="fa fa-camera"></i> Subir Foto
                                </label>
                                <button type="button" class='btn btn-danger btn-xs btn-foto' onclick="fotoDefault()"><i class="fa fa-trash"></i> Eliminar Foto</button>
                            </div>

                            <div style="margin-top: 10px;">
                                <label>Asignado a:</label>   
                                <table data-user="0" id="tblUsuario" class="table table-striped">
                                    <tbody>
                                        <tr style="cursor: pointer" onclick="catalogoUsuarios()">
                                            <td><img id="imgUser" src='<?= base_url("template/images/avatar.png") ?>' class='avatar' alt='Avatar'></td>
                                            <td id="lblUserName">NO ASIGNADO</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div style="margin-top: 10px;">
                                <p style="margin-left: 10px;">
                                    Activo:
                                    <input type="checkbox" class="flat" id="cbActivo" value="1"/>
                                </p>
                            </div>

                            
                        </div>
                        
                        <!-- -->
                        <div class="col-xs-6">
                            <div id="divCampos">
                            </div>
                        </div>
                    </div>

                    

                    

                    <!--<div class="row">
                        <div class="col-xs-6">
                            <label style="margin-top: 10px; display: block;">Servicio Activo / Inactivo</label>
                            <p style="margin-left: 10px; display: inline;">
                                Activo:
                                <input type="checkbox" class="flat" id="cbActivo" value="1"/>
                            </p>
                        </div>
                    </div>
                    -->

                </form>
            </div>
            <div class="modal-footer">
                <button id="btnCancelar" type="button" data-dismiss="modal" class="btn btn-default pull-left"><i class="fa fa-close"></i> Cancelar</button>
                <button id="btnEditar" style="display: none;" type="button" onclick="editar()" class="btn btn-warning"><i class='fa fa-pencil'></i> Editar</button>
                <button id="btnAgregar" type="button" onclick="agregar()" class="btn btn-primary"><i class='fa fa-plus'></i> Agregar</button>
            </div>
            

        </div>
    </div>
</div>

<div id="mdlUsuarios" class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Usuarios</h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-xs-12">
                            <table id="tblUsuarios" class="table table-striped">
                                <thead>
                                    <tr class="headings">
                                        <th class="column-title" style="width: 7%;">Foto</th>
                                        <th class="column-title">Nombre</th>
                                        <th class="column-title">Seleccionar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
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
<script src=<?= base_url("application/views/equipos/ti/js/catalogo.js"); ?>></script>
<script>
    var uid = '<?= $this->session->id ?>';

    $(function(){
        load();
    });


</script>
</body>
</html>
