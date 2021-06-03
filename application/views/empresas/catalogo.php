<!-- page content -->
<div class="right_col" role="main">
    <div class="">

        <div class="clearfix"></div>

        <div class="row">
            <div class="x_content">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Empresas</h2>
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
                                        Nombre: 
                                        <input type="radio" class="flat" name="rbBusqueda" id="rbNombre" value="nombre" checked />
                                        ID: 
                                        <input type="radio" class="flat" name="rbBusqueda" id="rbId" value="id" />
                                    </p>

                                    <input id="txtBuscar" style="display: inline;" type="text">

                                    <p style="margin-left: 10px; display: inline;">
                                        Cliente:
                                        <input type="checkbox" class="flat cbTipo" id="cbCliente" value="cliente" checked/>
                                        Proveedor:
                                        <input type="checkbox" class="flat cbTipo" id="cbProveedor" value="proveedor" checked/>
                                    </p>

                                    <button id="btnBuscar" onclick="buscar()" style="display: inline;" class="btn btn-success" type="button"><i class="fa fa-search"></i> Buscar</button>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>




        <div class="row">
            <div class="x_content">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_content">
                            <div class="table-responsive">
                                <table id="tabla" class="table table-striped">
                                    <thead>
                                        <tr class="headings">
                                            <th class="column-title">Foto</th>
                                            <th class="column-title">Nombre</th>
                                            <th class="column-title">Razón Social</th>
                                            <th class="column-title">Tipo</th>
                                            <th class="column-title">Colonia</th>
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
<!-- Custom Theme Scripts -->
<script src=<?= base_url("template/build/js/custom.js"); ?>></script>

<!-- PNotify -->
<script src=<?= base_url("template/vendors/pnotify/dist/pnotify.js"); ?>></script>
<script src=<?= base_url("template/vendors/pnotify/dist/pnotify.buttons.js"); ?>></script>
<script src=<?= base_url("template/vendors/pnotify/dist/pnotify.nonblock.js"); ?>></script>
<!-- iCheck -->
<script src=<?= base_url("template/vendors/iCheck/icheck.min.js"); ?>></script>
<!-- JS File -->
<script src=<?= base_url("application/views/empresas/js/catalogo.js"); ?>></script>

<script>

    $(document).ready(function(){
        load();
    });

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
</script>
</body>
</html>
