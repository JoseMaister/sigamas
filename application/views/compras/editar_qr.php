<!-- page content -->
<div class="right_col" role="main">
    <div class="">

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Requisición de Cotización</h2>
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
                                <section class="content invoice">
                                    <!-- title row -->
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-12">                                            
                                            <!-- /.col -->

                                            <div class="item form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tipo">Requisitor: </label>
                                                <div class="col-md-9 col-sm-9 col-xs-12">
                                                    <p><?= $this->session->nombre ?></p>
                                                </div>
                                            </div>

                                            <div class="item form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="rbPrioridad">Prioridad: </label>
                                                <div class="col-md-9 col-sm-9 col-xs-12">
                                                    <p>
                                                        Normal:
                                                        <input type="radio" class="flat" name="rbPrioridad" value="NORMAL" <?= $qr->prioridad == "NORMAL" ? "checked" : "" ?>/>
                                                        Urgente:
                                                        <input type="radio" class="flat" name="rbPrioridad" value="URGENTE" <?= $qr->prioridad == "URGENTE" ? "checked" : "" ?>/>
                                                        Info Urgente:
                                                        <input type="radio" class="flat" name="rbPrioridad" value="INFO URGENTE" <?= $qr->prioridad == "INFO URGENTE" ? "checked" : "" ?>/>
                                                    </p>
                                                </div>
                                            </div>
                                            
                                            <div class="item form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="rbTipo">Tipo: </label>
                                                <div class="col-md-9 col-sm-9 col-xs-12">
                                                    <p>
                                                        Producto:
                                                        <input type="radio" class="flat" name="rbTipo" value="PRODUCTO" <?= $qr->tipo == "PRODUCTO" ? "checked" : "" ?>/>
                                                        Servicio:
                                                        <input type="radio" class="flat" name="rbTipo" value="SERVICIO" <?= $qr->tipo == "SERVICIO" ? "checked" : "" ?>/>
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="item form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="opEntrega">Subtipo: </label>
                                                <div class="col-md-9 col-sm-9 col-xs-12">
                                                    <select style="width: 70%;" required="required" class="select2_single form-control" id="opSubtipo" name="opSubtipo">
                                                    </select>
                                                    <br>
                                                </div>
                                            </div>

                                            <div class="item form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="opEntrega">Lugar de Entrega: </label>
                                                <div class="col-md-9 col-sm-9 col-xs-12">
                                                    <select style="width: 70%;" required="required" class="select2_single form-control" id="opEntrega" name="opEntrega">
                                                        <option value="MEXICO" <?= $qr->lugar_entrega == "MEXICO" ? "selected" : "" ?>>MÉXICO</option>
                                                        <option value="USA" <?= $qr->lugar_entrega == "USA" ? "selected" : "" ?>>USA</option>
                                                    </select>
                                                    <br>
                                                </div>
                                            </div>


                                            <div class="item form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="rbDestino">Destino: </label>
                                                <div class="col-md-9 col-sm-9 col-xs-12">
                                                    <p>
                                                        <div style="display: <?= $this->session->privilegios['crear_qr_venta'] == "1" ? "inline" : "none" ?>">
                                                            Venta:
                                                            <input type="radio" class="flat" name="rbDestino" value="VENTA" <?= $qr->destino == "VENTA" ? "checked" : "" ?>/>
                                                        </div>
                                                        <div style="display: <?= $this->session->privilegios['crear_qr_interno'] == "1" ? "inline" : "none" ?>">
                                                            Consumo Interno:
                                                            <input type="radio" class="flat" name="rbDestino" value="CONSUMO INTERNO" <?= $qr->destino == "CONSUMO INTERNO" ? "checked" : "" ?>/>
                                                        </div>
                                                    </p>
                                                </div>
                                            </div>

                                            <?php $display = $this->session->privilegios['qr_critico'] == "1" ? "block" : "none" ?>
                                            <div style="display: <?= $display ?>;" class="item form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="rbPrioridad">Crítico para la Calidad: </label>
                                                <div class="col-md-9 col-sm-9 col-xs-12">
                                                    <p>
                                                        Crítico:
                                                        <input name="critico" id="cbCritico" type="checkbox" class="flat" <?= $qr->critico == "1" ? "checked" : "" ?>/>
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="item form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="rbDestino">Notificaciones: </label>
                                                <div class="col-md-9 col-sm-9 col-xs-12">
                                                    <p>
                                                        <button type="button" id="btnNotificaciones" class="btn btn-primary btn-xs" onclick="buscarUsuarios()"><i class="fa fa-bell"></i> Usuarios</button>
                                                    </p>
                                                    <br>
                                                </div>
                                            </div>


                                            <div class="col-md-3 col-sm-3 col-xs-12">
                                                <div id="btnArchivo">
                                                    <label class="btn btn-default btn-xs" for="userfile">
                                                    <input accept="application/pdf" target="_blank" onchange="uploadFile();" type="file" class="sr-only" id="userfile" name="userfile">
                                                        <i class="fa fa-file"></i> Subir Archivo
                                                    </label>
                                                </div>
                                                <button id="btnEliminarArchivo" style='display: none;' onclick="eliminarArchivo();" type="button" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Eliminar Archivo</button>
                                            </div>

                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <p id="lblArchivo">
                                                </p>
                                            </div>

                                        </div>


                                    </div>

                                    
                                    <!-- TABLA DE CONCEPTOS -->
                                    <!-- Table row -->
                                    <div class="row">
                                        <div id="tabla" class="col-xs-12 table">
                                        
                                        </div>
                                    </div>

                                    <div class="row">
    
                                        <div class="col-xs-6">
                                            <p class="lead">Comentarios</p>
                                            <div>
                                                <textarea id="txtComentarios" style="width:80%"><?= $qr->comentarios ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.row -->

                                    <!-- this row will not appear when printing -->
                                    <div class="row no-print">
                                        <div class="col-xs-12">
                                        <button onclick="aceptar();" class="btn btn-primary pull-right"><i class="fa fa-pencil"></i> Editar QR</button>
                                        <!--<button onclick="agregarRenglon();" class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-plus"></i> Agregar Concepto</button>-->
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->


<!-- MODAL CLIENTES -->
<div id="mdlClientes" class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 id= "mdlBusquedaTitulo" class="modal-title">Catalogo de Clientes</h4>
            </div>

            <div class="modal-body">
                <form>
                    <div id="divBusqueda">
                        <label>Buscar: </label>
                        <div class="input-group">
                            <input id="txtBuscar" type="text" class="form-control" placeholder="Buscar Cliente...">
                            <span class="input-group-btn">
                            <button onclick="buscarClientes()" class="btn btn-default" type="button">Buscar</button>
                            </span>
                        </div>
                    </div>
                    <br>
                    <table id="tblBuscar" class="data table table-striped no-margin">
                        <tbody>
                        </tbody>
                    </table>
                </form>
            </div> 
        </div>
    </div>
</div>

<!-- MODAL USUARIOS -->
<div id="mdlUsuarios" class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Seleccionar Usuarios</h4>
            </div>
            <div class="modal-body">
                <form>
                    <table id="tblUsuarios" class="data table table-striped no-margin">
                        <thead>
                            <tr>
                                <th style="width: 10%">Selecc.</th>
                                <th>Nombre</th>
                                <th>Puesto</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                </form>
            </div>

            <div class="modal-footer">
                <button type="button" onclick="guardarUsuariosNotificaciones(this)" class="btn btn-primary"><i class='fa fa-check'></i> Aceptar</button>
                <button type="button" data-dismiss="modal" class="btn btn-default pull-left"><i class="fa fa-close"></i> Cerrar</button>
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
<!-- Custom Theme Scripts -->
<script src=<?= base_url("template/build/js/custom.js"); ?>></script>
<!-- JS FILE -->
<script src=<?= base_url("application/views/compras/js/editar_qr.js"); ?>></script>

<script>
    var NOTIFICACIONES = JSON.parse('<?= $qr->notificaciones ?>');
    var idqr = JSON.parse('<?= $qr->id ?>');
    var att = JSON.parse('<?= $qr->atributos ?>');

    $(function(){
        load();
        setValores();
    });

    function setValores()
    {
        var subt = '<?= $qr->subtipo ?>';

        $('#opSubtipo').val(subt);
        subtipo();
        //loadSubtipos();
        
        if('<?= $qr->nombre_archivo ?>')
        {
            $('#lblArchivo').html('<u>' + '<?= $qr->nombre_archivo ?>' + '</u>');
            $("#btnArchivo").fadeOut('slow', function(){
                $("#btnEliminarArchivo").fadeIn('slow');
            });
        }

        var cells = $('#tabla tbody tr td');
        $.each(cells, function(i, elem) {
            var campo = elem.children[0].dataset.campo;
            $(elem.children[0]).val(att[campo]);

            if(campo == "cantidad")
            {
                $(elem.children[0]).val('<?= $qr->cantidad ?>');
            }
            else if(campo == "unidad")
            {
                $(elem.children[0]).val('<?= $qr->clave_unidad ?>');
            }
            else if(campo == "descripcion")
            {
                $(elem.children[0]).val('<?= $qr->descripcion ?>');
            }

        });


    }

    function aceptar(){
        var descripcion;
        var cantidad;
        var unidad;
        var clave_unidad;
        var atributos = {};

        var cells = $('#tabla tbody tr td');
        $.each(cells, function(i, elem) {

            var campo = elem.children[0].dataset.campo;
            var valor = $(elem.children[0]).val();

            
            if(!valor)
            {
                alert('Capture todos los campos');
                exit();
            }
            else if(campo == "descripcion")
            {
                descripcion = valor;
            }
            else if(campo == "cantidad")
            {
                cantidad = valor;
            }
            else if(campo == "unidad")
            {
                clave_unidad = valor;
                unidad = $(elem.children[0]).find("option:selected").text();
            }
            else
            {
                atributos[campo] = valor;
            }
        });

        
        var info = {
            id: idqr,
            tipo: $("input[name='rbTipo']:checked").val(),
            subtipo: $( "#opSubtipo").val(),
            cantidad: cantidad,
            unidad: unidad,
            clave_unidad: clave_unidad,
            descripcion: descripcion,
            prioridad: $("input[name='rbPrioridad']:checked").val(),
            lugar_entrega: $( "#opEntrega" ).val(), 
            critico: $("#cbCritico").is(":checked") ? 1 : 0,
            destino: $( "input[name='rbDestino']:checked" ).val(),
            comentarios: $('#txtComentarios').val(),
            notificaciones: JSON.stringify(NOTIFICACIONES),
        };

        info = JSON.stringify(info);
        atributos = JSON.stringify(atributos);
        
        editarQR(info, atributos);
    }

    
</script>

</body>
</html>
